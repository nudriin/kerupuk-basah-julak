<?php
namespace Devina\KerupukJulak\Repository;

use Devina\KerupukJulak\Domain\DetailTransactions;
use PDO;

class DetailTransactionsRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(DetailTransactions $detailTransactions) : DetailTransactions
    {
        $stmt = $this->connection->prepare("INSERT INTO detail_transactions (id, transaction_id, quantity, products_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$detailTransactions->id, $detailTransactions->transaction_id, $detailTransactions->quantity, $detailTransactions->products_id]);

        return $detailTransactions;
    }

    public function findByAccountId(string $account_id) : ?array
    {
        $sql = <<< SQL
            SELECT  tr.id as tr_id,
                    tr.account_id,
                    tr.total_price,
                    tr.transaction_time,
                    ac.name as user_name,
                    ac.email,
                    dtr.id as dtr_id,
                    dtr.quantity,
                    dtr.products_id,
                    pr.name as products_name
            FROM detail_transactions as dtr JOIN transactions as tr ON(dtr.transaction_id = tr.id)
            JOIN account as ac ON (ac.id = tr.account_id) 
            JOIN products as pr ON(dtr.products_id = pr.id)
            WHERE ac.id = ?
        SQL;
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$account_id]);
        if($stmt->rowCount() > 0){
            return $stmt->fetch();
        } else{
            return null;
        }
    }

    public function findAllByAccountId(string $account_id, string $status) : ?array
    {
        $sql = <<< SQL
            SELECT  tr.id as tr_id,
                    tr.account_id,
                    tr.total_price,
                    tr.transaction_time,
                    tr.status,
                    ac.name as user_name,
                    ac.email,
                    dtr.id as dtr_id,
                    dtr.quantity,
                    dtr.products_id,
                    pr.name as products_name,
                    pr.price
            FROM detail_transactions as dtr JOIN transactions as tr ON(dtr.transaction_id = tr.id)
            JOIN account as ac ON (ac.id = tr.account_id) 
            JOIN products as pr ON(dtr.products_id = pr.id)
            WHERE ac.id = ? AND tr.status = ?
        SQL;
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$account_id, $status]);
        if($stmt->rowCount() > 0){
            return $stmt->fetchAll();
        } else{
            return null;
        }
    }

    public function findAll() : ?array
    {
        $sql = <<< SQL
            SELECT  tr.id as tr_id,
                    tr.account_id,
                    tr.total_price,
                    tr.transaction_time,
                    tr.status,
                    ac.name as user_name,
                    ac.email
                    -- dtr.id as dtr_id,
                    -- dtr.quantity,
                    -- dtr.products_id,
                    -- pr.name as products_name,
                    -- pr.price
            FROM detail_transactions as dtr JOIN transactions as tr ON(dtr.transaction_id = tr.id)
            JOIN account as ac ON (ac.id = tr.account_id) 
            JOIN products as pr ON(dtr.products_id = pr.id) GROUP BY tr.id ORDER BY tr.transaction_time DESC
        SQL;
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return $stmt->fetchAll();
        } else{
            return null;
        }
    }

    public function findAllByDate(string $start_date, string $end_date) : ?array
    {
        $sql = <<< SQL
            SELECT  tr.id as tr_id,
                    tr.account_id,
                    tr.total_price,
                    tr.transaction_time,
                    tr.status,
                    ac.name as user_name,
                    ac.email
                    -- dtr.id as dtr_id,
                    -- dtr.quantity,
                    -- dtr.products_id,
                    -- pr.name as products_name,
                    -- pr.price
            FROM detail_transactions as dtr JOIN transactions as tr ON(dtr.transaction_id = tr.id)
            JOIN account as ac ON (ac.id = tr.account_id) 
            JOIN products as pr ON(dtr.products_id = pr.id) WHERE tr.transaction_time BETWEEN ? AND ? GROUP BY tr.id ORDER BY tr.transaction_time DESC
        SQL;
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$start_date, $end_date]);
        if($stmt->rowCount() > 0){
            return $stmt->fetchAll();
        } else{
            return null;
        }
    }

    public function findAllHistoryByDate(string $start_date, string $end_date) : ?array
    {
        $sql = <<< SQL
            SELECT  tr.id as tr_id,
                    tr.account_id,
                    tr.total_price,
                    tr.transaction_time,
                    tr.status,
                    ac.name as user_name,
                    ac.email,
                    dtr.id as dtr_id,
                    dtr.quantity,
                    dtr.products_id,
                    pr.name as products_name,
                    pr.price
            FROM detail_transactions as dtr JOIN transactions as tr ON(dtr.transaction_id = tr.id)
            JOIN account as ac ON (ac.id = tr.account_id) 
            JOIN products as pr ON(dtr.products_id = pr.id) WHERE tr.transaction_time BETWEEN ? AND ? ORDER BY tr.transaction_time DESC
        SQL;
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$start_date, $end_date]);
        if($stmt->rowCount() > 0){
            return $stmt->fetchAll();
        } else{
            return null;
        }
    }

    public function findAllHistory() : ?array
    {
        $sql = <<< SQL
            SELECT  tr.id as tr_id,
                    tr.account_id,
                    tr.total_price,
                    tr.transaction_time,
                    tr.status,
                    ac.name as user_name,
                    ac.email,
                    dtr.id as dtr_id,
                    dtr.quantity,
                    dtr.products_id,
                    pr.name as products_name,
                    pr.price
            FROM detail_transactions as dtr JOIN transactions as tr ON(dtr.transaction_id = tr.id)
            JOIN account as ac ON (ac.id = tr.account_id) 
            JOIN products as pr ON(dtr.products_id = pr.id) ORDER BY tr.transaction_time DESC
        SQL;
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return $stmt->fetchAll();
        } else{
            return null;
        }
    }

    public function findAllDetail(string $id) : ?array
    {
        $sql = <<< SQL
            SELECT  tr.id as tr_id,
                    tr.account_id,
                    tr.total_price,
                    tr.transaction_time,
                    tr.payment_confirm,
                    tr.status,
                    ac.name as user_name,
                    ac.email,
                    dtr.id as dtr_id,
                    dtr.quantity,
                    dtr.products_id,
                    pr.name as products_name,
                    pr.price
            FROM detail_transactions as dtr JOIN transactions as tr ON(dtr.transaction_id = tr.id)
            JOIN account as ac ON (ac.id = tr.account_id) 
            JOIN products as pr ON(dtr.products_id = pr.id)
            WHERE tr.id = ? ORDER BY tr.transaction_time DESC
        SQL;
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$id]);
        if($stmt->rowCount() > 0){
            return $stmt->fetchAll();
        } else{
            return null;
        }
    }
}