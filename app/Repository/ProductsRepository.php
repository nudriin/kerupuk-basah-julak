<?php
namespace Devina\KerupukJulak\Repository;

use Devina\KerupukJulak\Domain\Products;
use PDO;
class ProductsRepository
{
    private PDO $connections;

    public function __construct(PDO $connections)
    {
        $this->connections = $connections;
    }

    public function save(Products $products) : Products
    {
        $stmt = $this->connections->prepare("INSERT INTO products(id, name, price, quantity, description, images) VALUES(?, ?, ?, ?, ?, ?)");
        $stmt->execute([$products->id, $products->name, $products->price, $products->quantity, $products->description, $products->images]);
        
        return $products;
    }
    
    public function findById(string $id) : ?Products
    {
        $stmt = $this->connections->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        if($row = $stmt->fetch()){
            $products = new Products();
            $products->id = $row['id'];
            $products->name = $row['name'];
            $products->price = $row['price'];
            $products->quantity = $row['quantity'];
            $products->description = $row['description'];
            $products->images = $row['images'];

            return $products;
        } else{
            return null;
        }
    }

    public function findAll() : ?array
    {
        $stmt = $this->connections->prepare("SELECT * FROM products");
        $stmt->execute();

        if($stmt->rowCount() > 0){
            return $stmt->fetchAll();
        } else {
            return null;
        }
    }

    public function update(Products $products) : Products
    {
        $sql = <<< SQL
            UPDATE products
            SET name = ?,
                price = ?,
                quantity = ?,
                description = ?,
                images = ?
            WHERE id = ?
        SQL;

        $stmt = $this->connections->prepare($sql);
        $stmt->execute([$products->name, $products->price, $products->quantity, $products->description, $products->images, $products->id]);

        return $products;
    }

    public function deletById(string $id) 
    {
        $stmt = $this->connections->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$id]);
    }
}