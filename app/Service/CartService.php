<?php
namespace Devina\KerupukJulak\Service;

use Devina\KerupukJulak\Config\Database;
use Devina\KerupukJulak\Domain\Cart;
use Devina\KerupukJulak\Exception\ValidationException;
use Devina\KerupukJulak\Model\Cart\CartDeleteIdRequest;
use Devina\KerupukJulak\Model\Cart\CartSaveRequest;
use Devina\KerupukJulak\Model\Cart\CartSaveResponse;
use Devina\KerupukJulak\Repository\CartRepository;

class CartService
{
    private CartRepository $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function addcart(CartSaveRequest $request) : CartSaveResponse
    {
        $this->validateAddCart($request);
        try{
            Database::beginTransaction();
            $cart = new Cart();
            $cart->id = "CRT" . uniqid();
            $cart->account_id = $request->account_id;

            $this->cartRepository->save($cart);
            Database::commitTransaction();

            $response = new CartSaveResponse();
            $response->cart = $cart;

            return $response;
        } catch (ValidationException $e){
            Database::rollbackTransaction();
            throw $e;   
        }
    }

    public function validateAddCart(CartSaveRequest $request) 
    {
        if($request->account_id == null || trim($request->account_id) == ""){
            throw new ValidationException("Gagal menambah ke keranjang");
        }
    }

    public function deleteCartById(CartDeleteIdRequest $request) 
    {
        $this->validateDeleteCartById($request);
        try {
            Database::beginTransaction();
            $cart = $this->cartRepository->findById($request->id);
            if($cart == null){
                throw new ValidationException("Gagal menghapus produk dari keranjang");
            }
            $this->cartRepository->deleteById($request->id);
            Database::commitTransaction();
        } catch (ValidationException $e) {
            Database::rollbackTransaction();
            throw $e;
        }
    }

    public function validateDeleteCartById(CartDeleteIdRequest $request) 
    {
        if($request->id == null || trim($request->id) == ""){
            throw new ValidationException("Gagal menghapus produk dari keranjang");
        }
    }

    public function deleteAllCart()
    {
        try{
            Database::beginTransaction();
            $this->cartRepository->deleteAll();
            Database::commitTransaction();
        } catch(ValidationException $e){
            Database::rollbackTransaction();
            throw $e;
        }
    }
}

