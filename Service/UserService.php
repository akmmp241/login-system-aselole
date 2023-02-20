<?php

namespace Akmal\LoginSystem\Service;

require_once __DIR__ . '/../Data/User.php';
require_once __DIR__ . '/../Exception/ValidationException.php';
require_once __DIR__ . '/../Model/RegisterRequest.php';
require_once __DIR__ . '/../Model/RegisterResponse.php';
require_once __DIR__ . '/../Model/LoginRequest.php';
require_once __DIR__ . '/../Model/LoginResponse.php';
require_once __DIR__ . '/../Repository/UserRepository.php';

use Akmal\LoginSystem\Data\User;
use Akmal\LoginSystem\Exception\ValidationException;
use Akmal\LoginSystem\Model\LoginRequest;
use Akmal\LoginSystem\Model\LoginResponse;
use Akmal\LoginSystem\Model\RegisterRequest;
use Akmal\LoginSystem\Model\RegisterResponse;
use Akmal\LoginSystem\Repository\UserRepository;
use Exception;

class UserService
{
    private UserRepository $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(RegisterRequest $request): RegisterResponse
    {
        try {
            $this->validateRegisterRequest($request);
            $user = $this->userRepository->findByUsername($request->getUsername());
            if ($user != null) {
                throw new ValidationException("Username already exist");
            }

            $user = new User();
            $user->setUsername($request->getUsername());
            $user->setName($request->getName());
            $user->setPassword(password_hash($request->getPassword(), PASSWORD_BCRYPT));

            $this->userRepository->save($user);

            $response = new RegisterResponse();
            $response->setUser($user);
            return $response;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    private function validateRegisterRequest(RegisterRequest $request): void {
        if ($request->getUsername() == null || $request->getName() == null || $request->getPassword() == null ||
            trim($request->getUsername()) == "" || trim($request->getName()) == "" || trim($request->getPassword()) == "") {
            throw new ValidationException("Id, Name, Password can not blank");
        }

        if (strlen($request->getPassword()) < 8) {
            throw new ValidationException("Password at least must be 8 character");
        }
    }

    public function login(LoginRequest $request): LoginResponse
    {
        $this->validateLoginRequest($request);

        $user = $this->userRepository->findByUsername($request->getUsername());
        if ($user == null) {
            throw new ValidationException("Id or Password is wrong");
        }

        if (password_verify($request->getPassword(), $user->getPassword())) {
            $response = new LoginResponse();
            $response->setUser($user);
            return $response;
        } else {
            throw new ValidationException("Id or Password is wrong");
        }
    }

    private function validateLoginRequest(LoginRequest $request): void
    {
        if ($request->getUsername() == null || $request->getPassword() == null ||
            trim($request->getUsername()) == "" || trim($request->getPassword()) == "") {
            throw new ValidationException("Id, Name, Password can not blank");
        }

        if (strlen($request->getPassword()) < 8) {
            throw new ValidationException("Password at least must be 8 character");
        }
    }
}