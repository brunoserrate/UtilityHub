<?php
session_start();

$_SESSION["requested_via_browser"] = true;

use App\Controller;

$controller = new Controller();

?>

<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="auto">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $title ?></title>

    <?php foreach ($cdns['css'] as $css) : ?>
        <link rel="stylesheet" href="<?= $css ?>">
    <?php endforeach; ?>
</head>

<body class="bg-light p-0">
    <div class="container-fluid overflow-hidden">
        <div class="row overflow-auto">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <a class="navbar-brand ps-4" href="/app">Utility Hub</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">

                    </ul>
                </div>
            </nav>
        </div>
        <div class="row overflow-auto" style="height: calc(100vh - 56px);">
            <div class="col-12 col-sm-3 col-xl-2 px-sm-2 px-0 bg-dark d-flex sticky-top">
                <div class="flex-sm-column flex-row flex-grow-1 align-items-center align-items-sm-start px-3 pt-4 text-white">

                    <div class="dropdown py-sm-4 mt-sm-auto ms-auto ms-sm-0 flex-shrink-1">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://api.dicebear.com/8.x/initials/svg?seed=<?= $_SESSION['user']['name'] ?>" alt="<?= $_SESSION['user']['name']?>" width="28" height="28" class="rounded-circle">
                            <span class="d-none d-sm-inline mx-1"><?= $_SESSION['user']['name']?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                            <li><a class="dropdown-item" href="#">Sign out</a></li>
                        </ul>
                    </div>

                    <ul class="nav nav-pills flex-sm-column flex-row flex-nowrap flex-shrink-1 flex-sm-grow-0 flex-grow-1 mb-sm-auto mb-0 justify-content-center align-items-center align-items-sm-start" id="menu">
                        <li class="nav-item">
                            <a href="/app" class="nav-link px-sm-0 px-2">
                                <i class="fs-5 bi-house"></i><span class="ms-1 d-none d-sm-inline">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/app/password-generator" class="nav-link px-sm-0 px-2">
                                <i class="fs-5 bi-lock"></i><span class="ms-1 d-none d-sm-inline">Gerador de Senhas</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/app/unit-converter" class="nav-link px-sm-0 px-2">
                                <i class="fs-5 bi-arrow-repeat"></i><span class="ms-1 d-none d-sm-inline">Conversor de Unidades</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/app/random-number-generator" class="nav-link px-sm-0 px-2">
                                <i class="fs-5 bi-patch-question"></i><span class="ms-1 d-none d-sm-inline">Gerador de número aleatórios</span>
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
            <div class="col d-flex flex-column h-sm-100">
                <main class="row overflow-auto">
                    <div class="col p-5">
                        <?php $controller->renderChild($view, $data); ?>
                    </div>
                </main>
                <?php if (isset($data['footer'])) : ?>
                    <footer class="row bg-light py-4 mt-auto">
                        <div class="col">
                            <?= $data['footer'] ?>
                        </div>
                    </footer>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php foreach ($cdns['js'] as $js) : ?>
        <script src="<?= $js ?>"></script>
    <?php endforeach; ?>
</body>

</html>