<?php

namespace toubeelib\application\providers;

use PhpParser\Token;
use toubeelib\core\domain\entities\User\User;
use toubeelib\core\dto\CredentialDTO;
use toubeelib\core\dto\UserDTO;

class JWTAuthnProvider
{
    private $jwtManager;
    private $authService;

    public function __construct(JWTManager $jwtManager, AuthnProviderInterface $authService)
    {
        $this->jwtManager = $jwtManager;
        $this->authService = $authService;
    }



    #[\Override] public function register(CredentialDTO $c, string $login,int $role)
    {
        $this->authService->createUser($c, $login, $role);
    }

    #[\Override] public function signin(CredentialDTO $c): UserDTO
    {

        $userDTO = $this->authService->ByCredentials($c);
        $userDTO->setToken($this->jwtManager->createAccessToken([
            'id' => $userDTO->getID(),
            'email' => $userDTO->getEmail(),
            'login' => $userDTO->getLogin(),
            'role' => $userDTO->getRole()
        ]));

        return $userDTO;
    }

    #[\Override] public function refresh(Token $token): UserDTO
    {
        // TODO: Implement refresh() method.
    }

    #[\Override] public function getSignedInUser(string $token): UserDTO
    {
        $decodedToken = $this->jwtManager->decodeToken($token);
        $email = $decodedToken['email'];
        $login = $decodedToken['login'];
        $role = $decodedToken['role'];
        $user = new User($email,$login,$role);
        $user->setID($decodedToken['id']);

        return new UserDTO($user);
    }
}