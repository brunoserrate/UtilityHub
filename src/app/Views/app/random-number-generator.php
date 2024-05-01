<div class="container-fluid">
    <div class="row">
        <div class="col">
            <h1><?= __("Random Number Generator") ?></h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <p><?= __("Use the form below to generate random numbers.")?></p>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col">
            <form action="/app/random-number-generator" method="post">
                <div class="row mb-3">
                    <div class="col-2">
                        <label for="min" class="form-label">Valor mínimo</label>
                        <input type="number" class="form-control" id="min" name="min" value="0" required>
                    </div>
                    <div class="col-2">
                        <label for="max" class="form-label">Valor máximo</label>
                        <input type="number" class="form-control" id="max" name="max" value="100" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-2">
                        <label for="samples" class="form-label">Numeros a gerar</label>
                        <input type="number" class="form-control" id="samples" name="samples" value="10" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-2">
                        <input type="checkbox" class="form-check-input" id="unique" name="unique">
                        <label for="unique" class="form-label">Valores únicos?</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Gerar</button>
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

    <?php if (isset($values)) : ?>
        <div class="row">
            <div class="col">
                <h2>Generated Numbers</h2>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="alert alert-success d-flex flex-wrap">
                    <?php foreach ($values as $value) : ?>
                        <div class="p-2"><?= $value ?></div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- 

array(4) { ["min_output"]=> int(3) ["max_output"]=> int(94) ["average_output"]=> int(51) ["data"]=> array(10) { [66]=> int(1) [94]=> int(1) [12]=> int(1) [3]=> int(1) [65]=> int(1) [7]=> int(1) [84]=> int(1) [5]=> int(1) [86]=> int(1) [88]=> int(1) } }
     -->
    <?php if (isset($statistic)) : ?>
        <div class="row">
            <div class="col">
                <h2>Statistic</h2>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="alert alert-info">
                    <ul>
                        <li>Minimum: <?= $statistic['min_output'] ?></li>
                        <li>Maximum: <?= $statistic['max_output'] ?></li>
                        <li>Average: <?= $statistic['average_output'] ?></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h2>Data</h2>
            </div>
        </div>
        <div class="row">
            <div class="col">
            <table class="table">
                <thead>
                <tr>
                    <th>Number</th>
                    <th>Count</th>
                </tr>
                </thead>
                <tbody>
                <?php $dataInOrder = $statistic['data']; ksort($dataInOrder); ?>
                <?php foreach ($dataInOrder as $value => $count) : ?>
                    <tr>
                    <td><?= $value ?></td>
                    <td><?= $count ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            </div>
        </div>
    <?php endif; ?>
</div>