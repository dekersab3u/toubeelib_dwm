<?php

namespace toubeelib\core\services\auth;

use Ramsey\Uuid\Uuid;
use toubeelib\application\providers\AuthnProviderInterface;
use toubeelib\core\domain\entities\User\User;
use toubeelib\core\dto\CredentialDTO;
use toubeelib\core\dto\UserDTO;
use toubeelib\core\repositoryInterfaces\UserRepositoryInterface;

class AuthnService implements AuthnServiceInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    #[\Override] public function createUser(CredentialDTO $c, string $login, int $role): string
    {
        $user = new User($c->getEmail(),$login, $role);
        $user->setID(Uuid::uuid4()->toString());
        $user->setPassword(password_hash($c->getPassword(), PASSWORD_DEFAULT));
        return $this->userRepository->save($user);
    }

    #[\Override] public function byCredentials(CredentialDTO $c): UserDTO
    {
        $user = $this->userRepository->getUserByEmail($c->getEmail());

        if ($user && password_verify($c->getPassword(), $user->getPassword())) {
            return new UserDTO($user);
        } else {
            throw new AuthServiceBadDataException('Erreur 400 : Email ou mot de passe incorrect', 400);
        }
    }
}