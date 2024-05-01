<div class="container-fluid">
    <div class="row">
        <div class="col">
            <h1>Gerador de Senhas</h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <p>Utilize o formulário abaixo para gerar uma senha segura.</p>
        </div>
    </div>
    </hr>
    <div class="row">
        <div class="col">
            <form action="/app/password-generator" method="post">
            <div class="row mb-3">
                    <div class="col-2">
                        <label for="length" class="form-label">Comprimento da Senha</label>
                        <input type="number" class="form-control" id="length" name="length" value="12" min="1" max="50" required>
                    </div>
                    <div class="col-2">
                        <label for="length" class="form-label">Número de Senhas</label>
                        <input type="number" class="form-control" id="samples" name="samples" value="3" min="1" max="100" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-2">
                        <input type="checkbox" class="form-check-input" id="useUpperCase" name="useUpperCase" checked>
                        <label for="useUpperCase" class="form-label">Incluir Letras Maiúsculas</label>
                    </div>
                    <div class="col-2">
                        <input type="checkbox" class="form-check-input" id="useLowerCase" name="useLowerCase" checked>
                        <label for="useLowerCase" class="form-label">Incluir Letras Minúsculas</label>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-2">
                        <input type="checkbox" class="form-check-input" id="useNumbers" name="useNumbers" checked>
                        <label for="useNumbers" class="form-label">Incluir Números</label>
                    </div>
                    <div class="col-2">
                        <input type="checkbox" class="form-check-input" id="useSymbols" name="useSymbols">
                        <label for="useSymbols" class="form-label">Incluir Símbolos</label>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-2">
                        <input type="checkbox" class="form-check-input" id="useSimilarCharacters" name="useSimilarCharacters" >
                        <label for="useSimilarCharacters" class="form-label">Usar Caracteres Similares</label>
                    </div>
                    <div class="col-2">
                        <input type="checkbox" class="form-check-input" id="uniqueCharacters" name="uniqueCharacters">
                        <label for="uniqueCharacters" class="form-label">Caracteres Únicos</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Gerar Senha</button>
            </form>
        </div>
    </div>
    <?php if (isset($error)) : ?>
    <div class="row">
        <div class="col">
            <div class="alert alert-danger" role="alert">
                <?= $error ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if (isset($success)) : ?>
    <div class="row mt-3">
        <div class="col">
            <div class="alert alert-success" role="alert">
                <?= $success ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if (isset($passwords)) : ?>
    <div class="row">
        <div class="col">
            <h2>Senhas Geradas</h2>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table">
                <thead>
                    <tr>
                        <th>Senha</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($passwords as $password) : ?>
                    <tr>
                        <td><?= $password ?></td>
                        <td class="text-end" style="width: 100px;">
                            <button onclick="copyToClipboard('<?= $password ?>')">Copiar</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
    function copyToClipboard(text) {
        var input = document.createElement('input');
        input.setAttribute('value', text);
        document.body.appendChild(input);
        input.select();
        var result = document.execCommand('copy');
        document.body.removeChild(input);
        return result;
    }
</script>