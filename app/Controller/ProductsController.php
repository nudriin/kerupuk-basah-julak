<?php

namespace Devina\KerupukJulak\Controller;

require_once __DIR__ . "/../Helper/ImageHelper.php";

use Devina\KerupukJulak\App\ViewRender;
use Devina\KerupukJulak\Config\Database;
use Devina\KerupukJulak\Exception\ValidationException;
use Devina\KerupukJulak\Model\Products\ProductsDeleteRequest;
use Devina\KerupukJulak\Model\Products\ProductsEditRequest;
use Devina\KerupukJulak\Model\Products\ProductsSaveRequest;
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

class ProductsController
{
    private ProductsService $productsService;
    private SessionsService $sessionsService;
    private CartDetailService $cartDetailService;
    private CartService $cartService;

    public function __construct()
    {
        $connection = Database::getConnect();
        $productsRepository = new ProductsRepository($connection);
        $cartRepository = new CartRepository($connection);
        $cartDetailRepository = new CartDetailRepository($connection);
        $this->productsService = new ProductsService($productsRepository);
        $sessionsRepository = new SessionsRepository($connection);
        $accountRepository = new AccountRepository($connection);
        $this->sessionsService = new SessionsService($sessionsRepository, $accountRepository);
        $this->cartService = new CartService($cartRepository);
        $this->cartDetailService = new CartDetailService($cartDetailRepository);
    }

    public function addProducts()
    {
        try {
            $admin = $this->sessionsService->current("Admin");
            $profile = $admin->profile_pic;
            ViewRender::adminRender("Products/products-add", [
                "title" => "Tambah produk",
                "admin" => $admin,
                "admin_profile" => $profile,
            ]);
        } catch (ValidationException $e) {
        }
    }

    public function postAddProducts()
    {
        try {
            $admin = $this->sessionsService->current("Admin");
            $profile = $admin->profile_pic;
            $request = new ProductsSaveRequest();
            $request->name = htmlspecialchars($_POST['products_name']);
            $request->price = htmlspecialchars($_POST['products_price']);
            $request->quantity = htmlspecialchars($_POST['products_quantity']);
            $request->description = htmlspecialchars($_POST['products_description']);
            $request->images = htmlspecialchars($_FILES['products_images']['name']);
            $this->productsService->saveProducts($request);
            moveImage($_FILES['products_images']['tmp_name'], $request->images, "products");
            ViewRender::redirect("/admin/add-products");
        } catch (ValidationException $e) {
            ViewRender::adminRender("Products/products-add", [
                "title" => "Tambah produk",
                "admin" => $admin,
                "error" => $e->getMessage(),
                "admin_profile" => $profile,
            ]);
        }
    }

    public function products()
    {
        try {
            $admin = $this->sessionsService->current("Admin");
            $profile = $admin->profile_pic;
            $products = $this->productsService->displayProducts();
            ViewRender::adminRender("Products/products", [
                "title" => "Produk",
                "admin" => $admin,
                "products" => $products->products,
                "admin_profile" => $profile,
            ]);
        } catch (ValidationException $e) {
            ViewRender::adminRender("Products/products", [
                "title" => "Produk",
                "admin" => $admin,
                "error" => $e->getMessage(),
                "admin_profile" => $profile,
            ]);
        }
    }

    public function detailProducts(string $id)
    {
        try {
            $request = new ProductsViewRequest();
            $request->id = $id;
            $products = $this->productsService->viewProducts($request);

            $user = $this->sessionsService->current("User");
            if ($user != null) {
                $profile = $user->profile_pic;
            }
            if ($user != null && $user->role == "User") {
                ViewRender::userRender("Products/products-view", [
                    "title" => "Produk",
                    "user" => $user,
                    "products" => $products->products,
                    "user_profile" => $profile,
                ]);
            } else {
                ViewRender::render("Products/products-view", [
                    "title" => "Produk",
                    "products" => $products->products
                ]);
            }
        } catch (ValidationException $e) {
            if ($user != null && $user->role == "User") {
                ViewRender::userRender("Products/products-view", [
                    "title" => "Produk",
                    "user" => $user,
                    "error" => $e->getMessage(),
                    "user_profile" => $profile,
                ]);
            } else {
                ViewRender::render("Products/products-view", [
                    "title" => "Produk",
                    "error" => $e->getMessage()
                ]);
            }
        }
    }

    public function editProducts(string $id)
    {
        try {
            $admin = $this->sessionsService->current("Admin");
            $profile = $admin->profile_pic;
            $request = new ProductsViewRequest();
            $request->id = $id;
            $products = $this->productsService->viewProducts($request);
            ViewRender::adminRender("Products/products-edit", [
                "title" => "Edit produk",
                "admin" => $admin,
                "products" => $products->products,
                "admin_profile" => $profile,
            ]);
        } catch (ValidationException $e) {
        }
    }

    public function postEditProducts(string $id)
    {
        try {
            $admin = $this->sessionsService->current("Admin");
            if($admin != null){
                $profile = $admin->profile_pic;
            }

            $requestView = new ProductsViewRequest();
            $requestView->id = $id;
            $products = $this->productsService->viewProducts($requestView);

            $request = new ProductsEditRequest();
            $request->id = $id;
            $request->name = htmlspecialchars($_POST['products_name']);
            $request->price = htmlspecialchars($_POST['products_price']);
            $request->quantity = htmlspecialchars($_POST['products_quantity']);
            $request->description = htmlspecialchars($_POST['products_description']);
            $request->images = htmlspecialchars($_FILES['products_images']['name']);
            $this->productsService->editProducts($request);
            deleteImage($products->products->images, "products");
            moveImage($_FILES['products_images']['tmp_name'], $request->images, "products");
            ViewRender::redirect("/admin/products");
        } catch (ValidationException $e) {
            ViewRender::adminRender("Products/products-edit", [
                "title" => "Edit produk",
                "admin" => $admin,
                "error" => $e->getMessage(),
                "admin_profile" => $profile,
            ]);
        }
    }

    public function deleteProducts(string $id)
    {
        try {
            $request = new ProductsDeleteRequest();
            $request->id = $id;


            $requestView = new ProductsViewRequest();
            $requestView->id = $id;
            $products = $this->productsService->viewProducts($requestView);

            $this->cartDetailService->deleteAllCartDetail();
            $this->cartService->deleteAllCart();

            deleteImage($products->products->images, "products");

            $this->productsService->deleteProducts($request);
            ViewRender::redirect("/admin/products");
        } catch (ValidationException $e) {
            ViewRender::redirect("/admin/products");
        }
    }
}
