<?php
use App\Utils\Utils;
?>

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

<div class="container">
    <h1 class="titulos">Login</h1>
    <p>Para acessar o painel de controle, faça login.</p>
    <p>Se você não tem uma conta, <a class="a_link" href="<?= Utils::mountPath(['.', 'register.php']) ?>">clique aqui</a> para criar uma.</p>
    <br>

    <form method="post" action="<?= Utils::mountPath(['..', '..', 'api', 'users', 'login']) ?>" onsubmit="return validateLoginForm()">
        <input class="input" type="text" placeholder="E-mail" name="email" id="email" required>
        <input class="input" type="password" placeholder="Senha" name="password" id="password" required>
        <button type="submit" class="btn">Entrar</button>
    </form>
</div>