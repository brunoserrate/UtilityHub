<?php
session_start();
require_once join(DIRECTORY_SEPARATOR, ['..', '..', 'autoloader.php']);

use App\Utils\Utils;

$_SESSION["requested_via_browser"] = true;
?>

<!-- LOGIN -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utility Hub API - Login</title>

    <!-- Import css -->
    <link rel="stylesheet" href="<?= join(DIRECTORY_SEPARATOR, ['..', 'css', '']) . 'default.css' ?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alumni+Sans:wght@100;200;300;400;500;600;700;800;900&family=Poppins:wght@100;300;600&display=swap" rel="stylesheet">
</head>

<script>
    function validateLoginForm() {
        var email = document.getElementById("email").value;
        var password = document.getElementById("password").value;

        if (email == "" || password == "") {
            alert("Preencha todos os campos!");
            return false;
        }

        return true;
    }
</script>

<body>
    <div class="container">
        <h1 class="titulos">Login</h1>
        <p>Para acessar o painel de controle, faça login.</p>
        <p>Se você não tem uma conta, <a class="a_link" href="<?= Utils::mountPath(['.','register.php']) ?>">clique aqui</a> para criar uma.</p>
        <br>

        <form method="post" action="<?= Utils::mountPath(['..', '..', 'api', 'users', 'login']) ?>" onsubmit="return validateLoginForm()">
            <input class="input" type="text" placeholder="E-mail" name="email" required>
            <input class="input" type="password" placeholder="Senha" name="password" required>
            <button type="submit" class="btn">Entrar</button>
        </form>
    </div>
</body>

</html>