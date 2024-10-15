<?php

namespace toubeelib\core\services\auth;

use Exception;
use PDO;

class AuthService
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function authenticate(string $email, string $password){

        $sql = $this->pdo->prepare('SELECT uuid, email, password, role FROM users where email = :email');
        $sql->execute([':email' => $email]);

        $user = $sql->fetch();

        if($user && password_verify($password, $user['password'])){
            return [
                'uuid' => $user['uuid'],
                'email' => $user['email'],
                'role' => $user['role']
            ];
        }

        throw new Exception('Invalid credentials');
    }


}