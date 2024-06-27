<?php
namespace Devina\KerupukJulak\Domain;

class Transactions
{
    public string $id;
    public string $account_id;
    public float $total_price;
    public string $transaction_time;
    public string $payment_confirm;
    public string $status;
}