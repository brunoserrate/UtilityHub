<?php
session_start();

$_SESSION["requested_via_browser"] = true;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utility Hub API - Logado</title>

    <!-- Import css -->
    <link rel="stylesheet" href="../../../public/css/default.css">
</head>


<body>
    <div class="container">
        <h1 class="titleUserRegister">Logado com sucesso!</h1>
        <p>Utilize o token abaixo para acessar a API.</p>
        <br>
        <p class="p_token">{%token%}</p>
    </div>
</body>

</html>