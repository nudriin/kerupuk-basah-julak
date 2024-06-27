<?php
namespace Devina\KerupukJulak\Service;

use Devina\KerupukJulak\Config\Database;
use Devina\KerupukJulak\Domain\Products;
use Devina\KerupukJulak\Exception\ValidationException;
use Devina\KerupukJulak\Model\Products\ProductsDeleteRequest;
use Devina\KerupukJulak\Model\Products\ProductsDisplayResponse;
use Devina\KerupukJulak\Model\Products\ProductsEditRequest;
use Devina\KerupukJulak\Model\Products\ProductsEditResponse;
use Devina\KerupukJulak\Model\Products\ProductsSaveRequest;
use Devina\KerupukJulak\Model\Products\ProductsSaveResponse;
use Devina\KerupukJulak\Model\Products\ProductsViewRequest;
use Devina\KerupukJulak\Model\Products\ProductsViewResponse;
use Devina\KerupukJulak\Repository\ProductsRepository;

class ProductsService
{
    private ProductsRepository $productsRepository;

    public function __construct(ProductsRepository $productsRepository)
    {
        $this->productsRepository = $productsRepository;
    }

    public function saveProducts(ProductsSaveRequest $request) : ProductsSaveResponse
    {
        try {
            Database::beginTransaction();
            $products = new Products();
            $products->id = "PR" . uniqid();
            $products->name = $request->name;
            $products->price = $request->price;
            $products->quantity = $request->quantity;
            $products->description = $request->description;
            $products->images = $request->images;
            $this->productsRepository->save($products);
            Database::commitTransaction();

            $response = new ProductsSaveResponse();
            $response->products = $products;

            return $response;
        } catch (ValidationException $e) {
            Database::rollbackTransaction();
            throw $e;
        }
    }

    public function displayProducts() : ProductsDisplayResponse
    {
        try{
            $products = $this->productsRepository->findAll();
            if($products == null){
                throw new ValidationException("Belum ada produk apapun");
            }

            $response = new ProductsDisplayResponse();
            $response->products = $products;

            return $response;
        } catch(ValidationException $e){
            throw $e;
        }
    }

    public function viewProducts(ProductsViewRequest $request) : ProductsViewResponse
    {
        try{    
            $products = $this->productsRepository->findById($request->id);
            if($products == null){
                throw new ValidationException("Produk tidak ditemukan");
            }

            $response = new ProductsViewResponse();
            $response->products = $products;

            return $response;
        } catch(ValidationException $e){
            throw $e;
        }
    }

    public function editProducts(ProductsEditRequest $request) : ProductsEditResponse
    {
        try{
            Database::beginTransaction();
            $products = $this->productsRepository->findById($request->id);
            if($products == null){
                throw new ValidationException("Produk tidak ditemukan");
            }
            $products->name = $request->name;
            $products->price = $request->price;
            $products->quantity = $request->quantity;
            $products->description = $request->description;
            $products->images = $request->images;

            $this->productsRepository->update($products);
            Database::commitTransaction();

            $response = new ProductsEditResponse();
            $response->products = $products;
            return $response;
        } catch(ValidationException  $e){
            Database::rollbackTransaction();
            throw $e;
        }
    }

    public function deleteProducts(ProductsDeleteRequest $request)
    {
        try {
            Database::beginTransaction();
            $products = $this->productsRepository->findById($request->id);
            if($products == null){
                throw new ValidationException("Gagal menghapus produk");
            }
            $this->productsRepository->deletById($request->id);
            Database::commitTransaction();
        } catch (ValidationException $e) {
            Database::rollbackTransaction();
            throw $e;
        }
    }
}