<?php
session_start();

$_SESSION["requested_via_browser"] = true;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utility Hub API - Registrado</title>

    <!-- Import css -->
    <link rel="stylesheet" href="../../../public/css/default.css">
</head>


<body>
    <div class="container">
        <h1 class="titleUserRegister">Usuário registrado com sucesso!</h1>
        <p>Retorne para a página de login para utilizar a API!</p>
        <br>
        <a class="a_button" href="../../../painel_controle/login/">
            Login
        </a>
    </div>
</body>

</html>