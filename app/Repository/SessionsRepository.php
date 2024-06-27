<?php
namespace Devina\KerupukJulak\Repository;

use Devina\KerupukJulak\Domain\Sessions;
use Devina\KerupukJulak\Config\Database;
use Devina\KerupukJulak\Exception\ValidateException;
use PDO;

class SessionsRepository
{

    private PDO $connection;
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function addSessions(Sessions $sessions) : Sessions
    {
        $statement = $this->connection->prepare("INSERT INTO sessions(id, account_id) VALUES(?, ?)");
        $statement->execute([$sessions->id, $sessions->account_id]);
        return $sessions;
    }


    public function findById(string $id) : ?Sessions
    {
        $statement = $this->connection->prepare("SELECT id, account_id FROM sessions WHERE id = ?");
        $statement->execute([$id]);

        try {
            if($row = $statement->fetch()){
                $sessions = new Sessions();
                $sessions->id = $row['id'];
                $sessions->account_id = $row['account_id'];
                return $sessions;
            } else{
                return null;
            }
        } finally{
            $statement->closeCursor();
        }
    }

    public function deleteById(string $id) : void
    {
        $statement = $this->connection->prepare("DELETE FROM sessions WHERE id = ?");
        $statement->execute([$id]);
    }
    
    public function deleteAll() : void
    {
        $statement = $this->connection->prepare("DELETE FROM sessions");
        $statement->execute();
    }
}