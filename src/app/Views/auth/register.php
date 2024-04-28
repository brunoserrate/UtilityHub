<?php

use App\Utils\Utils;
?>

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
<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="card">
        <div class="card-header bg-primary text-white text-center">
            <h1>Registrar</h1>
        </div>
        <div class="card-body">
            <p>Parar criar uma nova conta, preencha todos os campos a seguir</p>

            <form method="post" action="<?= Utils::mountPath(['..', '..', 'api', 'users', 'login']) ?>" onsubmit="return validateLoginForm()">
                <div class="row mb-3">
                    <div class="col">
                        <input class="form-control" type="text" placeholder="Nome completo" name="nome" id="nome" required>
                    </div>
                </div>
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
                <div class="row mb-3">
                    <div class="col">
                        <input class="form-control" type="password" placeholder="Confirmar senha" name="confirm_password" id="confirm_password" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>