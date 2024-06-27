<?php
namespace Devina\KerupukJulak\Controller;

use Devina\KerupukJulak\App\ViewRender;
use Devina\KerupukJulak\Config\Database;
use Devina\KerupukJulak\Exception\ValidationException;
use Devina\KerupukJulak\Repository\AccountRepository;
use Devina\KerupukJulak\Repository\DetailTransactionsRepository;
use Devina\KerupukJulak\Repository\ProductsRepository;
use Devina\KerupukJulak\Repository\SessionsRepository;
use Devina\KerupukJulak\Service\AccountService;
use Devina\KerupukJulak\Service\DetailTransactionsService;
use Devina\KerupukJulak\Service\ProductsService;
use Devina\KerupukJulak\Service\SessionsService;

class AdminHomeController
{
    private AccountService $accountService;
    private AccountRepository $accountRepository;
    private SessionsService $sessionsService;
    private ProductsService $productsService;
    private DetailTransactionsService $detailTransactionsService;
    public function __construct()
    {
        $connection = Database::getConnect();
        $sessionsRepository = new SessionsRepository($connection);
        $this->accountRepository = new AccountRepository($connection);
        $this->accountService = new AccountService($this->accountRepository);
        $this->sessionsService = new SessionsService($sessionsRepository, $this->accountRepository);
        $productsRepository = new ProductsRepository($connection);
        $this->productsService = new ProductsService($productsRepository);
        $detailTransactionsRepository = new DetailTransactionsRepository($connection);
        $this->detailTransactionsService = new DetailTransactionsService($detailTransactionsRepository);

    }

    public function index()
    {
        try{
            $admin = $this->sessionsService->current("Admin");
            if($admin != null){
                $profile = $admin->profile_pic;
            }
            $account = $this->accountRepository->findAll();
            $adminAccount = [];
            foreach($account as $row){
                if($row['role'] == "Admin"){
                    $adminAccount[] = $account;
                }
            }
            $countAdmin = sizeof($adminAccount);

            $transactions = $this->detailTransactionsService->displayAllTransactions("Transactions");
            $countTransactions = sizeof($transactions->detailTransactions);

            $products = $this->productsService->displayProducts();
            $countProducts = sizeof($products->products);
            ViewRender::adminRender("Admin/admin-dashboard",[
                "title"=>"Dashboard",
                "admin"=>$admin,
                "count_admin"=>$countAdmin,
                "count_products" => $countProducts,
                "admin_profile" => $profile,
                "count_transactions"=>$countTransactions
            ]); 
        } catch(ValidationException $e){
            ViewRender::adminRender("Admin/admin-dashboard",[
                "title"=>"Dashboard",
                "admin"=>$admin,
                "count_admin"=>$countAdmin,
                "count_products" => 0,
                "admin_profile" => $profile,
                "count_transactions"=>0
            ]); 

        }   
    }
}

