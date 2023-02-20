<?php

require_once __DIR__ . '/../../Database/Database.php';
require_once __DIR__ . '/../../Repository/SessionRepository.php';
require_once __DIR__ . '/../../Repository/UserRepository.php';
require_once __DIR__ . '/../../Service/SessionService.php';

use Akmal\LoginSystem\Database\Database;
use Akmal\LoginSystem\Repository\SessionRepository;
use Akmal\LoginSystem\Repository\UserRepository;
use Akmal\LoginSystem\Service\SessionService;

$connection = Database::getConnection();
$userRepository = new UserRepository($connection);
$sessionRepository = new SessionRepository($connection);
$sessionService = new SessionService($sessionRepository, $userRepository);

$user = $sessionService->current();

if ($user == null) {
    header("Location: ../User/login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>

<style>
    html {
        height: 100%;
    }
    body {
        height: 100%;
    }
    .global-container {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    form {
        padding-top: 10px;
        font-size: 14px;
        margin-top: 30px;
    }
    .card-title {
        font-weight: 300;
    }
    .btn {
        font-size: 14px;
        margin-top: 20px;
    }
    .login-form {
        width: 330px;
        margin: 20px;
    }
    .sign-up {
        text-align: center;
        padding: 20px 0 0;
    }
    .alert {
        margin-bottom: -30px;
        font-size: 13px;
        margin-top: 20px;
    }
    .registrasi {
        height: 100vh;
        width: 100vw;

        display: flex;
        align-items: center;
        justify-content: center;
    }
    .login {
        height: 100vh;
        width: 100vw;

        display: flex;
        align-items: center;
        justify-content: center;
    }
    .kanan {
        display: flex;
        justify-content: end;
    }
    .navbar {
        width: 80%;
        margin: auto;
    }
    .logout {
        font-size: 15px;
        padding: 10px;
    }
</style>
<body class="bg-dark">
<header>
    <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
        <a class="navbar-brand" href="#">AselolE</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse kanan" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link" href="index.php">Home</a>
                <a class="nav-link" href="../User/login.php">Login</a>
                <a class="nav-link" href="../User/register.php">Register</a>
            </div>
        </div>
    </nav>
</header>

<main class="mt-4 pt-4">
    <div class="jumbotron jumbotron-fluid mt-5">
        <div class="container">
            <h1 class="display-4">Hello</h1>
            <p class="lead">Selamat datang <strong><?= $user->getName() ?></strong></p>
            <a href="../User/logout.php" class="badge badge-dark logout">Logout</a>
        </div>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>
</html>