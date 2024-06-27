<?php
namespace Devina\KerupukJulak\Model\Products;

class ProductsEditRequest
{
    public ?string $id = null;
    public ?string $name = null;
    public ?float $price = null;
    public ?int $quantity = null;
    public ?string $description = null;
    public ?string $images = null;
}