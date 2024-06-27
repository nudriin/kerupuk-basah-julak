<?php

namespace Devina\KerupukJulak\Controller;
require_once __DIR__ . "/../Helper/ImageHelper.php";
use Devina\KerupukJulak\App\ViewRender;
use Devina\KerupukJulak\Config\Database;
use Devina\KerupukJulak\Exception\ValidationException;
use Devina\KerupukJulak\Model\Cart\CartSaveRequest;
use Devina\KerupukJulak\Model\CartDetail\CartDetailDisplayRequest;
use Devina\KerupukJulak\Model\DetailTransactions\DetailTransactionsDisplayByDateRequest;
use Devina\KerupukJulak\Model\DetailTransactions\DetailTransactionsDisplayByIdRequest;
use Devina\KerupukJulak\Model\DetailTransactions\DetailTransactionsDisplayByUserRequest;
use Devina\KerupukJulak\Model\DetailTransactions\DetailTransactionsSaveRequest;
use Devina\KerupukJulak\Model\Products\ProductsEditRequest;
use Devina\KerupukJulak\Model\Products\ProductsViewRequest;
use Devina\KerupukJulak\Model\Transactions\TransactionsSaveRequest;
use Devina\KerupukJulak\Model\Transactions\TransactionsUpdateRequest;
use Devina\KerupukJulak\Repository\AccountRepository;
use Devina\KerupukJulak\Repository\CartDetailRepository;
use Devina\KerupukJulak\Repository\CartRepository;
use Devina\KerupukJulak\Repository\DetailTransactionsRepository;
use Devina\KerupukJulak\Repository\ProductsRepository;
use Devina\KerupukJulak\Repository\SessionsRepository;
use Devina\KerupukJulak\Repository\TransactionsRepository;
use Devina\KerupukJulak\Service\CartDetailService;
use Devina\KerupukJulak\Service\CartService;
use Devina\KerupukJulak\Service\DetailTransactionsService;
use Devina\KerupukJulak\Service\ProductsService;
use Devina\KerupukJulak\Service\SessionsService;
use Devina\KerupukJulak\Service\TransactionsService;

class TransactionsController
{
    private TransactionsService $transactionsService;
    private DetailTransactionsService $detailTransactionsService;
    private SessionsService $sessionsService;
    private ProductsService $productsService;
    private CartService $cartService;
    private CartDetailService $cartDetailService;

    public function __construct()
    {
        $connection = Database::getConnect();
        $transactionsRepository = new TransactionsRepository($connection);
        $detailTransactionsRepository = new DetailTransactionsRepository($connection);
        $accountRepository = new AccountRepository($connection);
        $sessionsRepository = new SessionsRepository($connection);
        $productsRepository = new ProductsRepository($connection);
        $cartRepository = new CartRepository($connection);
        $cartDetailRepository = new CartDetailRepository($connection);
        $this->transactionsService = new TransactionsService($transactionsRepository);
        $this->detailTransactionsService = new DetailTransactionsService($detailTransactionsRepository);
        $this->sessionsService = new SessionsService($sessionsRepository, $accountRepository);
        $this->productsService = new ProductsService($productsRepository);
        $this->cartService = new CartService($cartRepository);
        $this->cartDetailService = new CartDetailService($cartDetailRepository);
    }

    public function makeTransactions()
    {
        try {
            $user = $this->sessionsService->current("User");
            if ($user != null) {
                $profile = $user->profile_pic;
            }
            $transactionsRequest = new TransactionsSaveRequest();
            $transactionsRequest->account_id = $user->id;
            $transactionsRequest->total_price = htmlspecialchars((float)$_POST['total_price']);
            $transactionsRequest->payment_confirm = htmlspecialchars($_FILES['payment']['name']);

            $transactions = $this->transactionsService->addTransactions($transactionsRequest);
            moveImage($_FILES['payment']['tmp_name'], $transactionsRequest->payment_confirm, "payment");

            $cartDetailRequest = new CartDetailDisplayRequest();
            $cartDetailRequest->account_id = $user->id;
            $cart = $this->cartDetailService->displayCardDetail($cartDetailRequest);
            foreach ($cart->cartDetail as $row) {
                $detailTransactionsRequest = new DetailTransactionsSaveRequest();
                $detailTransactionsRequest->transaction_id = $transactions->transactions->id;
                $detailTransactionsRequest->products_id = $row['products_id'];
                $detailTransactionsRequest->quantity = $row['quantity'];
                $this->detailTransactionsService->addDetailTransaction($detailTransactionsRequest);

                $requestView = new ProductsViewRequest();
                $requestView->id = $row['products_id'];
                $products = $this->productsService->viewProducts($requestView);

                $productsEditRequest = new ProductsEditRequest();
                $productsEditRequest->id = $products->products->id;
                $productsEditRequest->name = $products->products->name;
                $productsEditRequest->price = $products->products->price;
                $productsEditRequest->quantity = ($products->products->quantity - $row['quantity']);
                $productsEditRequest->description = $products->products->description;
                $productsEditRequest->images = $products->products->images;

                $this->productsService->editProducts($productsEditRequest);
            }

            $this->cartDetailService->deleteAllCartDetail();
            $this->cartService->deleteAllCart();
            ViewRender::redirect("/user/cart");
        } catch (ValidationException $e) {
            ViewRender::userRender("Cart/cart", [
                "title" => "Keranjang",
                "user_profile" => $profile,
                "error" => $e->getMessage()
            ]);
        }
    }

    public function transactions()
    {
        try {
            $admin = $this->sessionsService->current("Admin");
            if ($admin != null) {
                $profile = $admin->profile_pic;
            }
            $detailTransactions = $this->detailTransactionsService->displayAllTransactions("Transactions");

            ViewRender::adminRender("Admin/admin-transactions", [
                "title" => "Pesanan",
                "transactions" => $detailTransactions->detailTransactions,
                "admin_profile" => $profile,
            ]);
        } catch (ValidationException $e) {
            ViewRender::adminRender("Admin/admin-transactions", [
                "title" => "Pesanan",
                "admin_profile" => $profile,
                "error" => $e->getMessage()
            ]);
        }
    }

    public function postTransactionsByDate()
    {
        try {
            $admin = $this->sessionsService->current("Admin");
            if ($admin != null) {
                $profile = $admin->profile_pic;
            }
            $request = new DetailTransactionsDisplayByDateRequest();
            $request->start_date = htmlspecialchars($_POST['start_date']);
            $request->end_date = htmlspecialchars($_POST['end_date']); 
            $detailTransactions = $this->detailTransactionsService->displayByDate($request);

            ViewRender::adminRender("Admin/admin-transactions", [
                "title" => "Pesanan",
                "transactions" => $detailTransactions->detailTransactions,
                "admin_profile" => $profile,
            ]);
        } catch (ValidationException $e) {
            ViewRender::adminRender("Admin/admin-transactions", [
                "title" => "Pesanan",
                "admin_profile" => $profile,
                "error" => $e->getMessage()
            ]);
        }
    }

    public function transactionStatistics()
    {
        try {
            $admin = $this->sessionsService->current("Admin");
            if ($admin != null) {
                $profile = $admin->profile_pic;
            }
            $detailTransactions = $this->detailTransactionsService->displayAllTransactions("Report");

            ViewRender::adminRender("Admin/admin-statistics", [
                "title" => "Laporan bulanan",
                "transactions" => $detailTransactions->detailTransactions,
                "admin_profile" => $profile,
            ]);
        } catch (ValidationException $e) {
            ViewRender::adminRender("Admin/admin-statistics", [
                "title" => "Laporan bulanan",
                "admin_profile" => $profile,
                "error" => $e->getMessage()
            ]);
        }
    }

    public function postStatisticsByDate()
    {
        try {
            $admin = $this->sessionsService->current("Admin");
            if ($admin != null) {
                $profile = $admin->profile_pic;
            }
            $request = new DetailTransactionsDisplayByDateRequest();
            $request->start_date = htmlspecialchars($_POST['start_date']);
            $request->end_date = htmlspecialchars($_POST['end_date']); 
            $detailTransactions = $this->detailTransactionsService->displayAllByDate($request);

            ViewRender::adminRender("Admin/admin-statistics", [
                "title" => "Pesanan",
                "transactions" => $detailTransactions->detailTransactions,
                "admin_profile" => $profile,
            ]);
        } catch (ValidationException $e) {
            ViewRender::adminRender("Admin/admin-statistics", [
                "title" => "Pesanan",
                "admin_profile" => $profile,
                "error" => $e->getMessage()
            ]);
        }
    }

    public function transactionStatisticsUser()
    {
        try {
            $user = $this->sessionsService->current("User");
            if ($user != null) {
                $profile = $user->profile_pic;
            }
            $status = htmlspecialchars($_GET['status']);
            $request = new DetailTransactionsDisplayByUserRequest();
            $request->account_id = $user->id;
            $detailTransactions = $this->detailTransactionsService->displayAllByUserTransactions($request, $status);

            ViewRender::userRender("User/user-statistics", [
                "title" => "Laporan",
                "transactions" => $detailTransactions->detailTransactions,
                "user_profile" => $profile,
            ]);
        } catch (ValidationException $e) {
            ViewRender::userRender("User/user-statistics", [
                "title" => "Laporan",
                "user_profile" => $profile,
                "error" => $e->getMessage()
            ]);
        }
    }



    public function displayDetail(string $id)
    {
        $request = new DetailTransactionsDisplayByIdRequest();
        $request->id = $id;
        try {
            $admin = $this->sessionsService->current("Admin");
            if ($admin != null) {
                $profile = $admin->profile_pic;
            }
            $detailTransactions = $this->detailTransactionsService->displayDetail($request);
            ViewRender::adminRender("Admin/admin-transactions-details", [
                "title" => "Detail transaksi",
                "detail_transactions" => $detailTransactions->detailTransactions,
                "admin_profile" => $profile,
            ]);
        } catch (ValidationException $e) {
            ViewRender::adminRender("Admin/admin-transactions-details", [
                "title" => "Detail transaksi",
                "admin_profile" => $profile,
                "error" => $e->getMessage()
            ]);
        }
    }

    public function updateStatusTransaction(string $id)
    {
        try {
            $request = new TransactionsUpdateRequest();
            $request->id = $id;
            $request->status = htmlspecialchars($_POST['status']);

            $this->transactionsService->updateStatus($request);

            ViewRender::redirect("/admin/transactions/$id");
        } catch (ValidationException $e) {
            ViewRender::redirect("/admin/transactions/$id");
        }
    }

    public function updateStatusUserTransaction()
    {
        try {
            $request = new TransactionsUpdateRequest();
            $request->id = htmlspecialchars($_POST['transaction_id']);
            $request->status = htmlspecialchars($_POST['status']);

            $this->transactionsService->updateStatus($request);

            ViewRender::redirect("/user/statistics?status=Selesai");
        } catch (ValidationException $e) {
            ViewRender::redirect("/user/statistics?status=Diproses");
        }
    }
}
