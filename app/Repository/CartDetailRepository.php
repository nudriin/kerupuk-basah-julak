<?php
namespace Devina\KerupukJulak\Repository;

use Devina\KerupukJulak\Domain\CartDetail;
use PDO;

class CartDetailRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(CartDetail $cartDetail) : CartDetail
    {
        $stmt = $this->connection->prepare("INSERT INTO cart_detail(id, cart_id, products_id, quantity) VALUES (?, ?, ?, ?)");
        $stmt->execute([$cartDetail->id, $cartDetail->cart_id, $cartDetail->products_id, $cartDetail->quantity]);

        return $cartDetail;
    }

    public function update(CartDetail $cartDetail) : CartDetail
    {
        $stmt = $this->connection->prepare("UPDATE cart_detail SET cart_id = ?, products_id = ?, quantity = ? WHERE id = ?");
        $stmt->execute([$cartDetail->cart_id, $cartDetail->products_id, $cartDetail->quantity, $cartDetail->id]);

        return $cartDetail;
    }

    public function findById(string $id) : ?CartDetail
    {
        $stmt = $this->connection->prepare("SELECT * FROM cart_detail WHERE id = ?");
        $stmt->execute([$id]);

        if($row = $stmt->fetch()){
            $cartDetail = new CartDetail();
            $cartDetail->id = $row['id'];
            $cartDetail->cart_id = $row['cart_id'];
            $cartDetail->products_id = $row['products_id'];
            $cartDetail->quantity = $row['quantity'];

            return $cartDetail;
        } else {
            return null;
        }
    }

    public function findByCartId(string $cart_id) : ?CartDetail
    {
        $stmt = $this->connection->prepare("SELECT * FROM cart_detail WHERE cart_id = ?");
        $stmt->execute([$cart_id]);

        if($row = $stmt->fetch()){
            $cartDetail = new CartDetail();
            $cartDetail->id = $row['id'];
            $cartDetail->cart_id = $row['cart_id'];
            $cartDetail->products_id = $row['products_id'];
            $cartDetail->quantity = $row['quantity'];

            return $cartDetail;
        } else {
            return null;
        }
    }

    public function findAll(string $account_id) : ?array
    {
        $sql = <<< SQL
            SELECT 
                    ct.id as cart_id,
                    ct.account_id,
                    ac.name as account_name,
                    cd.id as cart_detail_id,
                    cd.products_id,
                    cd.quantity,
                    pr.name as products_name,
                    pr.price,
                    pr.images
            FROM cart as ct JOIN account as ac ON(ct.account_id = ac.id)
            JOIN cart_detail as cd ON (ct.id = cd.cart_id)
            JOIN products as pr ON(cd.products_id = pr.id) 
            WHERE ac.id = ?
        SQL;
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$account_id]);
        if($stmt->rowCount() > 0){
            return $stmt->fetchAll();
        } else{
            return null;
        }
    }

    public function deleteById(string $id)
    {
        $stmt = $this->connection->prepare("DELETE FROM cart_detail WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function deleteByCartId(string $cart_id)
    {
        $stmt = $this->connection->prepare("DELETE FROM cart_detail WHERE cart_id = ?");
        $stmt->execute([$cart_id]);
    }

    public function deleteAll()
    {
        $stmt= $this->connection->prepare("DELETE FROM cart_detail");
        $stmt->execute();
    }

}