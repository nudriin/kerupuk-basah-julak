<?php
namespace Devina\KerupukJulak\Model\Transactions;

class TransactionsSaveRequest
{
    public ?string $account_id = null;
    public ?float $total_price = null;
    public ?string $payment_confirm = null;
}