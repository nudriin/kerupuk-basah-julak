<?php
namespace Devina\KerupukJulak\Repository;

use Devina\KerupukJulak\Domain\Transactions;
use PDO;

class TransactionsRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(Transactions $transactions) : Transactions
    {
        $stmt = $this->connection->prepare("INSERT INTO transactions(id, account_id, total_price, payment_confirm, status) VALUES(?, ?, ?, ?, ?)");
        $stmt->execute([$transactions->id, $transactions->account_id, $transactions->total_price, $transactions->payment_confirm, $transactions->status]);

        return $transactions;
    }

    public function update(Transactions $transactions) : Transactions
    {
        $stmt = $this->connection->prepare("UPDATE transactions SET status = ? WHERE id = ?");
        $stmt->execute([$transactions->status, $transactions->id]);

        return $transactions;
    }

    public function findById(string $id) : ?Transactions
    {
        $stmt = $this->connection->prepare("SELECT * FROM transactions WHERE id = ?");
        $stmt->execute([$id]);

        if($row = $stmt->fetch()){
            $transactions = new Transactions();
            $transactions->id = $row['id'];
            $transactions->account_id = $row['account_id'];
            $transactions->total_price = $row['total_price'];
            $transactions->transaction_time = $row['transaction_time'];
            $transactions->payment_confirm = $row['payment_confirm'];
            $transactions->status = $row['status'];

            return $transactions;
        } else {
            return null;
        }
    }

    public function findByAccountId(string $account_id) : ?Transactions
    {
        $stmt = $this->connection->prepare("SELECT * FROM transactions WHERE account_id = ?");
        $stmt->execute([$account_id]);

        if($row = $stmt->fetch()){
            $transactions = new Transactions();
            $transactions->id = $row['id'];
            $transactions->account_id = $row['account_id'];
            $transactions->total_price = $row['total_price'];
            $transactions->transaction_time = $row['transaction_time'];
            $transactions->payment_confirm = $row['payment_confirm'];
            $transactions->status = $row['status'];

            return $transactions;
        } else {
            return null;
        }
    }

    public function findAllByAccountId(string $account_id) : ?array
    {
        $stmt = $this->connection->prepare("SELECT * FROM transactions WHERE account_id = ?");
        $stmt->execute([$account_id]);
        if($stmt->rowCount() > 0){
            return $stmt->fetchAll();
        } else{
            return null;
        }
    }

    public function findAll() : ?array
    {  
        $stmt = $this->connection->prepare("SELECT * FROM transactions");
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return $stmt->fetchAll();
        } else{
            return null;
        }
    }
}