<?php

require_once __DIR__ . '/../../Database/Database.php';
require_once __DIR__ . '/../../Repository/SessionRepository.php';
require_once __DIR__ . '/../../Repository/UserRepository.php';
require_once __DIR__ . '/../../Service/SessionService.php';

use Akmal\LoginSystem\Database\Database;
use Akmal\LoginSystem\Repository\SessionRepository;
use Akmal\LoginSystem\Repository\UserRepository;
use Akmal\LoginSystem\Service\SessionService;

$userRepository = new UserRepository(Database::getConnection());
$sessionRepository = new SessionRepository(Database::getConnection());
$sessionService = new SessionService($sessionRepository, $userRepository);

$user = $sessionService->current();
if ($user == null) {
    header("Location: login.php");
    exit();
}

$sessionService->destroy();
header("Location: ../Home/index.php");