<?php
namespace Devina\KerupukJulak\Service;

use Devina\KerupukJulak\Config\Database;
use Devina\KerupukJulak\Domain\CartDetail;
use Devina\KerupukJulak\Exception\ValidationException;
use Devina\KerupukJulak\Model\CartDetail\CartDetailDeleteIdRequest;
use Devina\KerupukJulak\Model\CartDetail\CartDetailDisplayRequest;
use Devina\KerupukJulak\Model\CartDetail\CartDetailDisplayResponse;
use Devina\KerupukJulak\Model\CartDetail\CartDetailSaveRequest;
use Devina\KerupukJulak\Model\CartDetail\CartDetailSaveResponse;
use Devina\KerupukJulak\Repository\CartDetailRepository;

class CartDetailService
{
    private CartDetailRepository $cartDetailRepository;

    public function __construct(CartDetailRepository $cartDetailRepository)
    {
        $this->cartDetailRepository = $cartDetailRepository;
    }

    public function addCartDetail(CartDetailSaveRequest $request) : CartDetailSaveResponse
    {
        $this->validateAddCartDetail($request);
        try {
            Database::beginTransaction();
            $cartDetail = new CartDetail();
            $cartDetail->id = "CRTD" . uniqid();
            $cartDetail->cart_id = $request->cart_id;
            $cartDetail->products_id = $request->products_id;
            $cartDetail->quantity = $request->quantity;

            $this->cartDetailRepository->save($cartDetail);
            Database::commitTransaction();

            $response = new CartDetailSaveResponse();
            $response->cartDetail = $cartDetail;

            return $response;
        } catch (ValidationException $e) {
            Database::rollbackTransaction();
            throw $e;
        }
    }

    public function validateAddCartDetail(CartDetailSaveRequest $request)
    {
        if($request->cart_id == null || $request->products_id == null || trim($request->cart_id) == "" ||
            trim($request->products_id) == "" ){
                throw new ValidationException("Gagal menambah ke keranjang");
        }
    }
    
    public function displayCardDetail(CartDetailDisplayRequest $request) : CartDetailDisplayResponse
    {
        $this->validateDisplayCartDetail($request);
        try {
            $cartDetail = $this->cartDetailRepository->findAll($request->account_id);
            if($cartDetail == null){
                throw new ValidationException("Keranjangmu masih kosong");
            }
            $response = new CartDetailDisplayResponse();
            $response->cartDetail = $cartDetail;

            return $response;
        } catch (ValidationException $e) {
            throw $e;
        }
    }

    public function validateDisplayCartDetail(CartDetailDisplayRequest $request)
    {
        if($request->account_id == null || trim($request->account_id) == "" ){
                throw new ValidationException("Gagal memuat keranjang");
        }
    }

    public function deleteCartDetailById(CartDetailDeleteIdRequest $request) 
    {
        $this->validateDeleteCartDetailById($request);
        try {
            Database::beginTransaction();
            $cart = $this->cartDetailRepository->findByCartId($request->cart_id);
            if($cart == null){
                throw new ValidationException("Gagal menghapus produk dari keranjang");
            }
            $this->cartDetailRepository->deleteByCartId($request->cart_id);
            Database::commitTransaction();
        } catch (ValidationException $e) {
            Database::rollbackTransaction();
            throw $e;
        }
    }

    public function validateDeleteCartDetailById(CartDetailDeleteIdRequest $request) 
    {
        if($request->cart_id == null || trim($request->cart_id) == ""){
            throw new ValidationException("Gagal menghapus produk dari keranjang");
        }
    }

    public function deleteAllCartDetail()
    {
        try{
            Database::beginTransaction();
            $this->cartDetailRepository->deleteAll();
            Database::commitTransaction();
        } catch(ValidationException $e){
            Database::rollbackTransaction();
            throw $e;
        }
    }

}