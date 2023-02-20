<?php

namespace Akmal\LoginSystem\Service;

require_once __DIR__ . '/../Repository/SessionRepository.php';
require_once __DIR__ . '/../Data/User.php';
require_once __DIR__ . '/../Data/Session.php';
require_once __DIR__ . '/../Repository/UserRepository.php';

use Akmal\LoginSystem\Data\Session;
use Akmal\LoginSystem\Data\User;
use Akmal\LoginSystem\Repository\SessionRepository;
use Akmal\LoginSystem\Repository\UserRepository;

class SessionService
{
    private static string $COOKIE_NAME = "AKM-SESSION-CODE";
    private SessionRepository $sessionRepository;
    private UserRepository $userRepository;

    /**
     * @param SessionRepository $sessionRepository
     */
    public function __construct(SessionRepository $sessionRepository, UserRepository $userRepository)
    {
        $this->sessionRepository = $sessionRepository;
        $this->userRepository = $userRepository;
    }

    public static function getCOOKIENAME(): string
    {
        return self::$COOKIE_NAME;
    }

    public function create(string $username): Session
    {
        $session = new Session();
        $session->setId(uniqid());
        $session->setUserUsername($username);

        $this->sessionRepository->save($session);

        setcookie(self::$COOKIE_NAME, $session->getId(), time() + (60 * 60 * 24 * 1), "/");

        return $session;
    }

    public function destroy()
    {
        $sessionId = $_COOKIE[self::$COOKIE_NAME] ?? '';
        $this->sessionRepository->deleteById($sessionId);
        setcookie(self::$COOKIE_NAME, '', 1, "/");
    }

    public function current(): ?User
    {
        $sessionId = $_COOKIE[self::$COOKIE_NAME] ?? '';
        $session = $this->sessionRepository->findById($sessionId);
        if ($session == null) {
            return null;
        }

        return $this->userRepository->findByUsername($session->getUserUsername());
    }
}