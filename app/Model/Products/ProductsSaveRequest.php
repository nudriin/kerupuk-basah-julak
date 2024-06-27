<?php
namespace Devina\KerupukJulak\Model\Products;

class ProductsSaveRequest
{
    public ?string $name = null;
    public ?float $price = null;
    public ?int $quantity = null;
    public ?string $description = null;
    public ?string $images = null;
}