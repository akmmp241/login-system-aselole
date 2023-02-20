<?php

require_once __DIR__ . '/../../Database/Database.php';
require_once __DIR__ . '/../../Exception/ValidationException.php';
require_once __DIR__ . '/../../Model/LoginRequest.php';
require_once __DIR__ . '/../../Repository/UserRepository.php';
require_once __DIR__ . '/../../Repository/SessionRepository.php';
require_once __DIR__ . '/../../Service/UserService.php';
require_once __DIR__ . '/../../Service/SessionService.php';

use Akmal\LoginSystem\Database\Database;
use Akmal\LoginSystem\Exception\ValidationException;
use Akmal\LoginSystem\Model\LoginRequest;
use Akmal\LoginSystem\Repository\SessionRepository;
use Akmal\LoginSystem\Repository\UserRepository;
use Akmal\LoginSystem\Service\SessionService;
use Akmal\LoginSystem\Service\UserService;

$connection = Database::getConnection();
$userRepository = new UserRepository($connection);
$userService = new UserService($userRepository);
$sessionRepository = new SessionRepository($connection);
$sessionService = new SessionService($sessionRepository, $userRepository);

$user = $sessionService->current();
if ($user != null) {
    header("Location: ../Home/dashboard.php");
    exit();
}

if (isset($_POST['submit'])) {
    $request = new LoginRequest();
    $request->setUsername($_POST['username']);
    $request->setPassword($_POST['password']);

    try {
        $response = $userService->login($request);
        $sessionService->create($response->getUser()->getUsername());
        header("Location: ../Home/dashboard.php");
        exit();
    } catch (ValidationException $exception) {
        $error = $exception->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>Login</title>
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
                <a class="nav-link" href="../Home/index.php">Home</a>
                <a class="nav-link" href="login.php">Login</a>
                <a class="nav-link" href="register.php">Register</a>
            </div>
        </div>
    </nav>
</header>

<main class="login">
    <?php if (isset($error)) { ?>
        <div class="row">
            <div class="alert alert-danger" role="alert">
                <?= $error ?>
            </div>
        </div>
    <?php } ?>
    <div class="bg-dark">
        <div class="global-container">
            <div class="card login-form">
                <div class="card-body">
                    <h3 class="card-title text-center">Login AselolE</h3>
                    <div class="card-text">
                        <form method="post">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" autocomplete="off" value="<?= $_POST['username'] ?? '' ?>" class="form-control form-control-sm" id="username">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" value="<?= $_POST['password'] ?? '' ?>" class="form-control form-control-sm" id="password">
                            </div>
                            <button type="submit" name="submit" id="submit" class="btn btn-primary btn-block">Login</button>

                            <div class="sign-up">
                                Belum punya akun?<a href="register.php"> Register</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>
</html>