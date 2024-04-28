<?php
session_start();

$_SESSION["requested_via_browser"] = true;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $title ?></title>

    <?php foreach ($cdns['css'] as $css): ?>
        <link rel="stylesheet" href="<?= $css ?>">
    <?php endforeach; ?>


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alumni+Sans:wght@100;200;300;400;500;600;700;800;900&family=Poppins:wght@100;300;600&display=swap" rel="stylesheet">
</head>

<body>
    <?= $content ?>

    <?php foreach ($cdns['js'] as $js): ?>
        <script src="<?= $js ?>"></script>
    <?php endforeach; ?>
</body>

</html>
