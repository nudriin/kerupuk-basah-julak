<?php
namespace Devina\KerupukJulak\Repository;

use Devina\KerupukJulak\Domain\Account;
use PDO;

class AccountRepository
{
    private PDO $connection;

    public function __construct(PDO $connection) {
        $this->connection = $connection;
    }

    public function save(Account $account) : Account
    {
        $stmt = $this->connection->prepare("INSERT INTO account(id, username, name, email, password, role, profile_pic, phone) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$account->id, $account->username, $account->name, $account->email, $account->password, $account->role, $account->profile_pic, $account->phone]);

        return $account;
    }

    public function findById(string $id) : ?Account
    {
        $stmt = $this->connection->prepare("SELECT * FROM account WHERE id = ?");
        $stmt->execute([$id]);

        if ($row = $stmt->fetch()){
            $account = new Account();
            $account->id = $row['id'];
            $account->username = $row['username'];
            $account->name = $row['name'];
            $account->email = $row['email'];
            $account->password = $row['password'];
            $account->role = $row['role'];
            $account->profile_pic = $row['profile_pic'];
            $account->phone = $row['phone'];

            return $account;
        } else {
            return null;
        }
    }

    public function findByEmail(string $email) : ?Account
    {
        $stmt = $this->connection->prepare("SELECT * FROM account WHERE email = ?");
        $stmt->execute([$email]);

        if ($row = $stmt->fetch()){
            $account = new Account();
            $account->id = $row['id'];
            $account->username = $row['username'];
            $account->name = $row['name'];
            $account->email = $row['email'];
            $account->password = $row['password'];
            $account->role = $row['role'];
            $account->profile_pic = $row['profile_pic'];
            $account->phone = $row['phone'];

            return $account;
        } else {
            return null;
        }
    }

    public function findAll() : ?array
    {
        $stmt = $this->connection->prepare('SELECT * FROM account');
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return $stmt->fetchAll();
        } else {
            return null;
        }
    }

    public function update(Account $account) : Account
    {
        $stmt = $this->connection->prepare("UPDATE account SET name = ?, password = ?, profile_pic = ? WHERE id = ?");
        $stmt->execute([$account->name, $account->password, $account->profile_pic, $account->id]);

        return $account;
    }

    public function deleteById(string $id)
    {
        $stmt = $this->connection->prepare("DELETE FROM account WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function deleteAll()
    {
        $stmt = $this->connection->prepare("DELETE FROM account");
        $stmt->execute();
    }
}