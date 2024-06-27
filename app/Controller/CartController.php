<?php
namespace Devina\KerupukJulak\Controller;

use Devina\KerupukJulak\App\ViewRender;
use Devina\KerupukJulak\Config\Database;
use Devina\KerupukJulak\Exception\ValidationException;
use Devina\KerupukJulak\Model\Cart\CartDeleteIdRequest;
use Devina\KerupukJulak\Model\Cart\CartSaveRequest;
use Devina\KerupukJulak\Model\CartDetail\CartDetailDeleteIdRequest;
use Devina\KerupukJulak\Model\CartDetail\CartDetailDisplayRequest;
use Devina\KerupukJulak\Model\CartDetail\CartDetailSaveRequest;
use Devina\KerupukJulak\Model\Products\ProductsViewRequest;
use Devina\KerupukJulak\Repository\AccountRepository;
use Devina\KerupukJulak\Repository\CartDetailRepository;
use Devina\KerupukJulak\Repository\CartRepository;
use Devina\KerupukJulak\Repository\ProductsRepository;
use Devina\KerupukJulak\Repository\SessionsRepository;
use Devina\KerupukJulak\Service\CartDetailService;
use Devina\KerupukJulak\Service\CartService;
use Devina\KerupukJulak\Service\ProductsService;
use Devina\KerupukJulak\Service\SessionsService;

class CartController
{
    private CartService $cartService;
    private CartDetailService $cartDetailService;
    private SessionsService $sessionsService;
    private ProductsService $productsService;

    public function __construct()
    {
        $connection = Database::getConnect();
        $cartRepository = new CartRepository($connection);
        $cartDetailRepository = new CartDetailRepository($connection);
        $accountRepository = new AccountRepository($connection);
        $sessionsRepository = new SessionsRepository($connection);
        $productsRepository = new ProductsRepository($connection);
        $this->cartService = new CartService($cartRepository);
        $this->cartDetailService = new CartDetailService($cartDetailRepository);
        $this->sessionsService = new SessionsService($sessionsRepository, $accountRepository);
        $this->productsService = new ProductsService($productsRepository);
    }

    public function addToCart(string $products_id)
    {
        try {
            $requestView = new ProductsViewRequest();
            $requestView->id = $products_id;
            $products = $this->productsService->viewProducts($requestView);
            
            $user = $this->sessionsService->current("User");
            if($user != null){
                $profile = $user->profile_pic;
            }

            $request = new CartSaveRequest();
            $request->account_id = $user->id ?? null;
            $cart = $this->cartService->addcart($request);

            $requestDetail = new CartDetailSaveRequest();
            $requestDetail->cart_id = $cart->cart->id;
            $requestDetail->products_id = htmlspecialchars($_POST['products_id']);
            $requestDetail->quantity = htmlspecialchars($_POST['quantity']);
            $this->cartDetailService->addCartDetail($requestDetail);

            ViewRender::redirect("/products/$requestDetail->products_id");
        } catch (ValidationException $e) {
            if ($user != null && $user->role == "User") {
                ViewRender::userRender("Products/products-view", [
                    "title" => "Produk",
                    "user" => $user,
                    "products"=>$products->products,
                    "user_profile" => $profile,
                    "error"=>$e->getMessage()
                ]);
            } else {
                ViewRender::render("Products/products-view", [
                    "title" => "Produk",
                    "products"=>$products->products,
                    "error"=>$e->getMessage()
                ]);
            }
        }
    }

    public function displayCart()
    {
        try {
            $user = $this->sessionsService->current("User");
            if($user != null){
                $profile = $user->profile_pic;
            }

            $request = new CartDetailDisplayRequest();
            $request->account_id = $user->id;

            $cart = $this->cartDetailService->displayCardDetail($request);
            ViewRender::userRender("Cart/cart",[
                "title"=>"Keranjang",
                "cart"=>$cart->cartDetail,
                "user_profile" => $profile,
            ]);
        } catch (ValidationException $e) {
            ViewRender::userRender("Cart/cart",[
                "title"=>"Keranjang",
                "user_profile" => $profile,
                "error"=>$e->getMessage()
            ]);
        }
    }

    public function deleteCartById(string $cart_id)
    {
        try {
            $requestDetail = new CartDetailDeleteIdRequest();
            $requestDetail->cart_id = $cart_id;
            $this->cartDetailService->deleteCartDetailById($requestDetail);

            $request = new CartDeleteIdRequest();
            $request->id = $cart_id;
            $this->cartService->deleteCartById($request);

            ViewRender::redirect("/user/cart");
        } catch (ValidationException $e) {
            ViewRender::redirect("/user/cart");
        }
    }
    
}