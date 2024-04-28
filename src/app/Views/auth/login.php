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
<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="card">
        <div class="card-header bg-primary text-white text-center">
            <h1>Login</h1>
        </div>
        <div class="card-body">
            <p>Para acessar o painel de controle, faça login</br>
            Se você não tem uma conta, <a class="a_link" href="/register">clique aqui</a> para criar uma.</p>

            <form method="post" action="<?= Utils::mountPath(['..', '..', 'api', 'users', 'login']) ?>" onsubmit="return validateLoginForm()">
                <div class="row mb-3">
                    <div class="col">
                        <input class="form-control" type="text" placeholder="E-mail" name="email" id="email" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <input class="form-control" type="password" placeholder="Senha" name="password" id="password" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <button type="submit" class="btn btn-primary">Entrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>