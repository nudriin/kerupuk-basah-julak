<?php
namespace Devina\KerupukJulak\Repository;

use Devina\KerupukJulak\Domain\Cart;
use PDO;

class CartRepository
{
    private PDO $connection;

    public function __construct(PDO $connection) {
        $this->connection = $connection;
    }

    public function save(Cart $cart) : Cart
    {
        $stmt = $this->connection->prepare("INSERT INTO cart(id, account_id) VALUES (?, ?)");
        $stmt->execute([$cart->id, $cart->account_id]);

        return $cart;
    }

    public function findById(string $id) : ?Cart
    {
        $stmt = $this->connection->prepare("SELECT * FROM cart WHERE id = ?");
        $stmt->execute([$id]);

        if($row = $stmt->fetch()){
            $cart = new Cart();
            $cart->id = $row['id'];
            $cart->account_id = $row['account_id'];

            return $cart;
        } else {
            return null;
        }
    }

    public function findByAccountId(string $account_id) : ?Cart
    {
        $stmt = $this->connection->prepare("SELECT * FROM cart WHERE account_id = ?");
        $stmt->execute([$account_id]);

        if($row = $stmt->fetch()){
            $cart = new Cart();
            $cart->id = $row['id'];
            $cart->account_id = $row['account_id'];

            return $cart;
        } else {
            return null;
        }
    }

    public function findAll(string $account_id) : ?array
    {
        $stmt = $this->connection->prepare("SELECT * FROM cart WHERE account_id = ?");
        $stmt->execute([$account_id]);

        if($stmt->rowCount() > 0){
            return $stmt->fetchAll();
        } else {
            return null;
        }
    }

    public function deleteById(string $id)
    {
        $stmt= $this->connection->prepare("DELETE FROM cart WHERE id = ?");
        $stmt->execute([$id]);
    }
    
    public function deleteByAccountId(string $account_id)
    {
        $stmt= $this->connection->prepare("DELETE FROM cart WHERE account_id = ?");
        $stmt->execute([$account_id]);
    }

    public function deleteAll()
    {
        $stmt= $this->connection->prepare("DELETE FROM cart");
        $stmt->execute();
    }

}