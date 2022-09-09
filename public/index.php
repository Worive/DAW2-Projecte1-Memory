<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Projecte 1</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body id="pageIndex">
<?php require_once('../templates/header.php'); ?>

<div>
    <div class="container">
        <div class="px-4 py-5 my-5 text-center">
            <h1 class="display-5 fw-bold">Projecte 1: Memograma</h1>
            <div class="col-lg-6 mx-auto">
                <p class="lead mb-4">Primer projecte de 2n de DAW</p>
            </div>
        </div>
    </div>
    <hr>
    <div class="container">
        <h1 class="mt-5">
            Començar una partida
        </h1>
        <form action="memory.php" method="post">
            <div class="form-group mb-3">
                <label for="sizeBoard" class="form-label">Mida del taulell: <span id="sizeBoardLabel">? x ?</span></label>
                <input type="range" class="form-range" min="2" max="20" step="2" id="sizeBoard" name="size" value=6>
            </div>

            <div>
                <div class="list-group mx-0 w-auto">
                    <label class="list-group-item d-flex gap-2">
                        <input class="form-check-input flex-shrink-0" type="radio" name="players"
                               id="players1" value=1 checked="">
                        <span>
        1 Jugador
        <small class="d-block text-muted">Quantes actions faràs per completar-ho?</small>
      </span>
                    </label>
                    <label class="list-group-item d-flex gap-2">
                        <input class="form-check-input flex-shrink-0" type="radio" name="players"
                               id="players2" value=2>
                        <span>
        2 Jugadors
        <small class="d-block text-muted">El que faci més pareilles.</small>
      </span>
                    </label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Jugar</button>
        </form>
    </div>
</div>


<?php require_once('../templates/footer.php'); ?>

<script src="assets/js/bootstrap.bundle.js"></script>
<script src="assets/js/script.js"></script>
</body>
</html>
