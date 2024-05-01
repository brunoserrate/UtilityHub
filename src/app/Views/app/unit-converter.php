<div class="container-fluid">
    <div class="row">
        <div class="col">
            <h1>Unit Converter</h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <p>Convert between different units using the form below.</p>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col">
            <form action="/app/unit-converter" method="post">
                <div class="row mb-3">
                    <div class="col-3">
                        <label for="type" class="form-label">Tipo</label>
                        <select class="form-select bg-accent3-300" id="type" name="type" required style="pointer-events:none;">
                            <option value="temperature" selected>Temperatura</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-2">
                        <label for="from" class="form-label">De</label>
                        <select class="form-select" id="from" name="from" required>
                            <?php foreach ($unitSelectOptions as $unit => $unitLabel ) : ?>
                                <option value="<?= $unit ?>"><?= $unitLabel ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-2">
                        <label for="to" class="form-label">Para</label>
                        <select class="form-select" id="to" name="to" required>
                        <?php foreach ($unitSelectOptions as $unit => $unitLabel ) : ?>
                                <option value="<?= $unit ?>"><?= $unitLabel ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-2">
                        <label for="value" class="form-label">Valor</label>
                        <input type="number" class="form-control" id="value" name="value" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Convert</button>
            </form>
        </div>
    </div>
    <?php if (isset($error)) : ?>
    <div class="row mt-3">
        <div class="col">
            <div class="alert alert-danger" role="alert">
                <?php echo $error, ' - ', (isset($field) ? $field : "") ?>
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

    <?php if (isset($result)) : ?>
    <div class="row mt-3">
        <div class="col">
            <div class="alert alert-success" role="alert">
                <?= $result['from'] . ' => ' . $result['to'] . ' = ' . $result['value'] ?>
            </div>
        </div>
    </div>
    <?php endif; ?>