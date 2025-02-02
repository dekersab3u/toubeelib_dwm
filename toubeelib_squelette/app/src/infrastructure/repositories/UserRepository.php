<?php

namespace toubeelib\infrastructure\repositories;

use PDO;
use toubeelib\core\domain\entities\User\User;
use toubeelib\core\repositoryInterfaces\RepositoryEntityNotFoundException;

class UserRepository
{
    private PDO $pdo;

    private array $users;

    public function __construct(PDO $p)
    {
        $this->pdo = $p;
        $users = $this->pdo->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($users as $u){
            $this->users[$u['id']] = new User($u['login'], $u['email'], $u['role']);
            $this->users[$u['id']]->setID($u['id']);
            $this->users[$u['id']]->setPassword($u['password']);
        }
    }

    #[\Override] public function getUsers(): array
    {
        return $this->users;
    }

    #[\Override] public function save(User $user): string
    {
        $this->users[$user->getID()] = $user;
        $insert = $this->pdo->prepare('INSERT INTO USERS(id, login, email, password, role) VALUES (:id,:login, :email, :password, :role)');
        $insert->execute([
            'id' => $user->getID(),
            'login' =>$user->getLogin(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'role' => $user->getRole()
        ]);
        return $user->getID();
    }

    #[\Override] public function getUserByEmail(string $email): User
    {
        foreach ($this->users as $user) {
            if ($user->getLogin() === $email) {
                return $user;
            }
        }
        throw new RepositoryEntityNotFoundException('User not found ');    }

    #[\Override] public function getUserByID(string $id): User
    {
        foreach ($this->users as $user) {
            if ($user->getID() === $id) {
                return $user;
            }
        }
        throw new RepositoryEntityNotFoundException('User not found');
    }
}