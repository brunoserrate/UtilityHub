<?php
session_start();

$_SESSION["requested_via_browser"] = true;
?>

<!-- Registrar -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utility Hub API - Registrar</title>

    <!-- Import css -->
    <link rel="stylesheet" href="../../public/css/default.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alumni+Sans:wght@100;200;300;400;500;600;700;800;900&family=Poppins:wght@100;300;600&display=swap" rel="stylesheet">
</head>

<script>
    function validateRegisterForm() {
        var nome = document.getElementById("name").value;
        var email = document.getElementById("email").value;
        var password = document.getElementById("password").value;
        var confirm_password = document.getElementById("confirm_password").value;

        if (nome == "" || email == "" || password == "" || confirm_password == "") {
            alert("Preencha todos os campos!");
            return false;
        }

        if (password != confirm_password) {
            alert("As senhas não coincidem!");
            return false;
        }

        return true;
    }
</script>

<body>
    <div class="container">
        <h1 class="titulos">Registrar</h1>
        <p>Parar criar uma nova conta, preencha todos os campos a seguir</p>
        <br>

        <form method="post" action="../../api/users/register/" onsubmit="return validateRegistrarForm()">
            <input class="input" type="text" placeholder="Nome completo" name="name" required>
            <input class="input" type="text" placeholder="E-mail" name="email" required>
            <input class="input" type="password" placeholder="Senha" name="password" required>
            <input class="input" type="password" placeholder="Confirmar senha" name="confirm_password" required>
            <button type="submit" class="btn">Registrar</button>
        </form>
    </div>
</body>

</html>