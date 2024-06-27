<?php
namespace Devina\KerupukJulak\Model\DetailTransactions;

class DetailTransactionsSaveRequest
{
    public ?string $transaction_id = null;
    public ?string $products_id = null;
    public ?int $quantity = null;
}