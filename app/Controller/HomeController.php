<?php

namespace Devina\KerupukJulak\Controller;

use Devina\KerupukJulak\App\ViewRender;
use Devina\KerupukJulak\Config\Database;
use Devina\KerupukJulak\Exception\ValidationException;
use Devina\KerupukJulak\Repository\AccountRepository;
use Devina\KerupukJulak\Repository\ProductsRepository;
use Devina\KerupukJulak\Repository\SessionsRepository;
use Devina\KerupukJulak\Service\ProductsService;
use Devina\KerupukJulak\Service\SessionsService;

class HomeController
{
    private SessionsService $sessionsService;
    private ProductsService $productsService;
    public function __construct()
    {
        $connection = Database::getConnect();
        $sessionsRepository = new SessionsRepository($connection);
        $productsRepository = new ProductsRepository($connection);
        $accountRepository = new AccountRepository($connection);
        $this->sessionsService = new SessionsService($sessionsRepository, $accountRepository);
        $this->productsService = new ProductsService($productsRepository);
    }

    public function index()
    {
        try{
            $user = $this->sessionsService->current("User");
            if($user != null){
                $profile = $user->profile_pic;
            }
            $products = $this->productsService->displayProducts();
            if ($user != null && $user->role == "User") {
                ViewRender::userRender("Home/index", [
                    "title" => "KerupukBasahJulak",
                    "user" => $user,
                    "products"=>$products->products,
                    "user_profile" => $profile,
                ]);
            } else {
                ViewRender::render("Home/index", [
                    "title" => "KerupukBasahJulak",
                    "products"=>$products->products
                ]);
            }
        } catch(ValidationException $e){
            if ($user != null && $user->role == "User") {
                ViewRender::userRender("Home/index", [
                    "title" => "KerupukBasahJulak",
                    "user" => $user,
                    "error" => $e->getMessage(),
                    "user_profile" => $profile,
                ]);
            } else {
                ViewRender::render("Home/index", [
                    "title" => "KerupukBasahJulak",
                    "products"=> 0,
                    "error" => $e->getMessage()
                ]);
            }
        }
    }

    public function shop()
    {
        try{
            $user = $this->sessionsService->current("User");
            if($user != null){
                $profile = $user->profile_pic;
            }
            $products = $this->productsService->displayProducts();
            if ($user != null && $user->role == "User") {
                ViewRender::userRender("Home/shop", [
                    "title" => "KerupukBasahJulak",
                    "user" => $user,
                    "products"=>$products->products,
                    "user_profile" => $profile,
                ]);
            } else {
                ViewRender::render("Home/shop", [
                    "title" => "KerupukBasahJulak",
                    "products"=>$products->products,
                ]);
            }
        } catch(ValidationException $e){
            if ($user != null && $user->role == "User") {
                ViewRender::userRender("Home/shop", [
                    "title" => "KerupukBasahJulak",
                    "user" => $user,
                    "error" => $e->getMessage(),
                    "user_profile" => $profile,

                ]);
            } else {
                ViewRender::render("Home/shop", [
                    "title" => "KerupukBasahJulak",
                    "products"=> 0,
                    "error" => $e->getMessage()
                ]);
            }
        }
    }
}
