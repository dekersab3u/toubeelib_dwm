<?php

namespace toubeelib\core\repositoryInterfaces;

use toubeelib\core\domain\entities\User\User;

interface UserRepositoryInterface
{
    public function getUsers(): array;
    public function save(User $user): string;
    public function getUserByEmail(string $email): User;

    public function getUserByID(string $id): User;
}