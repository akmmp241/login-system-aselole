<?php

namespace Akmal\LoginSystem\Repository;

require_once __DIR__ . '/../Database/Database.php';

use Akmal\LoginSystem\Data\Session;
use PDO;

class SessionRepository
{
    private PDO $connection;

    /**
     * @param PDO $connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(Session $session): Session
    {
        $statement = $this->connection->prepare("INSERT INTO sessions VALUES (?, ?)");
        $statement->execute([
            $session->getId(),
            $session->getUserUsername()
        ]);
        return $session;
    }

    public function findById(string $id): ?Session
    {
        $statement = $this->connection->prepare("SELECT id, user_username FROM sessions WHERE id = ?");
        $statement->execute([$id]);
        if ($row = $statement->fetch()) {
            $session = new Session();
            $session->setId($row['id']);
            $session->setUserUsername($row['user_username']);
            return $session;
        } else {
            return null;
        }
    }

    public function deleteById(string $id): void
    {
        $statment = $this->connection->prepare("DELETE FROM sessions WHERE id = ?");
        $statment->execute([$id]);
    }
}