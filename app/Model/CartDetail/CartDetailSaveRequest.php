<?php
namespace Devina\KerupukJulak\Model\CartDetail;

class CartDetailSaveRequest
{
    public ?string $cart_id = null; 
    public ?string $products_id = null; 
    public ?int $quantity = null; 
}