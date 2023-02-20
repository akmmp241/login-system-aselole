<?php

namespace Akmal\LoginSystem\Repository;

use Akmal\LoginSystem\Data\User;
use PDO;

class UserRepository
{
    private PDO $connection;

    /**
     * @param PDO $connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }


    public function save(User $user): User
    {
        $statement = $this->connection->prepare("INSERT INTO users VALUES (?, ?, ?)");
        $statement->execute([
            $user->getUsername(),
            $user->getName(),
            $user->getPassword()
        ]);
        return $user;
    }

    public function findByUsername(string $username): ?User
    {
        $statment = $this->connection->prepare("SELECT username, nama, password FROM users WHERE username = ?");
        $statment->execute([$username]);
        if ($row = $statment->fetch()) {
            $user = new User();
            $user->setUsername($row['username']);
            $user->setName($row['nama']);
            $user->setPassword($row['password']);
            return $user;
        } else {
            return null;
        }
    }
}