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
        <div class="dropdown pe-5">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://github.com/mdo.png" alt="hugenerd" width="28" height="28" class="rounded-circle">
                <span class="d-none d-sm-inline mx-1">Joe</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                <li><a class="dropdown-item" href="#">New project...</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Sign out</a></li>
            </ul>
        </div>
    </nav>
    </div>
    <div class="row overflow-auto" style="height: calc(100vh - 56px);">
        <div class="col-12 col-sm-3 col-xl-2 px-sm-2 px-0 bg-dark d-flex sticky-top">
            <div class="d-flex flex-sm-column flex-row flex-grow-1 align-items-center align-items-sm-start px-3 pt-4 text-white">
                <ul class="nav nav-pills flex-sm-column flex-row flex-nowrap flex-shrink-1 flex-sm-grow-0 flex-grow-1 mb-sm-auto mb-0 justify-content-center align-items-center align-items-sm-start" id="menu">
                    <li class="nav-item">
                        <a href="/app" class="nav-link px-sm-0 px-2">
                            <i class="fs-5 bi-house"></i><span class="ms-1 d-none d-sm-inline">Dashboard</span>
                        </a>
                    </li>
                    <!-- TODO: Add for loop to generate menu items -->
                    <!-- <li>
                        <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-sm-0 px-2">
                            <i class="fs-5 bi-speedometer2"></i><span class="ms-1 d-none d-sm-inline">Dashboard</span> </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link px-sm-0 px-2">
                            <i class="fs-5 bi-table"></i><span class="ms-1 d-none d-sm-inline">Orders</span></a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="nav-link dropdown-toggle px-sm-0 px-1" id="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fs-5 bi-bootstrap"></i><span class="ms-1 d-none d-sm-inline">Bootstrap</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdown">
                            <li><a class="dropdown-item" href="#">New project...</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Sign out</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="nav-link px-sm-0 px-2">
                            <i class="fs-5 bi-grid"></i><span class="ms-1 d-none d-sm-inline">Products</span></a>
                    </li>
                    <li>
                        <a href="#" class="nav-link px-sm-0 px-2">
                            <i class="fs-5 bi-people"></i><span class="ms-1 d-none d-sm-inline">Customers</span> </a>
                    </li> -->
                </ul>
                <div class="dropdown py-sm-4 mt-sm-auto ms-auto ms-sm-0 flex-shrink-1">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://github.com/mdo.png" alt="hugenerd" width="28" height="28" class="rounded-circle">
                        <span class="d-none d-sm-inline mx-1">Joe</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                        <li><a class="dropdown-item" href="#">New project...</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Sign out</a></li>
                    </ul>
                </div>
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