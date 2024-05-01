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

<body class="bg-light">
    <?php $controller->renderChild($view, $data); ?>

    <?php foreach ($cdns['js'] as $js) : ?>
        <script src="<?= $js ?>"></script>
    <?php endforeach; ?>
</body>

</html>