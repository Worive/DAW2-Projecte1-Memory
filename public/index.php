<?php
session_start();
$displayErrors = false;
$error_messages = [];
if (isset($_SESSION['error-messages'])) {
    error_log('found error messages!');
    $error_messages = $_SESSION['error-messages'];
    unset($_SESSION['error-messages']);
    $displayErrors = true;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Projecte 1</title>
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
          rel="stylesheet">
</head>
<body onload="subscribeUpdateBoardSize()">
<?php require_once('../templates/header.php'); ?>


<div class="toast-container position-fixed p-3 top-0 start-50 translate-middle-x">
    <?php
    if ($displayErrors) {
        $i = 0;
        foreach ($error_messages as $error_message) {
            if (++$i > 10) break;
            echo '<div class="toast toast-danger fade show" role="alert" aria-live="assertive" aria-atomic="true" data>
        <div class="toast-header">
            <span class="material-icons me-2">error</span>
            <strong class="me-auto">Error</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            ' . $error_message . '
        </div>
    </div>';
        }
    }
    ?>
</div>

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
    <div class="container mb-5 game-form-container">
        <h1 class="mt-5">
            Començar una partida
        </h1>
        <form action="memory.php" method="post">
            <div class="form-group mb-3">
                <label class="form-label">Mida del taulell: <span
                            id="sizeBoardLabel">4 x 4</span></label>
                <br>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label class="form-label" for="sizeBoardWidth">
                            Amplada
                        </label>
                        <input type="range" class="form-range" min="2" max="8" step="2" id="sizeBoardWidth"
                               name="size-width" value=4>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="sizeBoardHeight">
                            Altura
                        </label>
                        <input type="range" class="form-range" min="2" max="8" step="2" id="sizeBoardHeight"
                               name="size-height" value=4>

                    </div>
                </div>

            </div>

            <div class="row g-3">
                <div class="col-sm-6">
                    <label for="card-type" class="form-label">Tipus de Carta</label>
                    <select id="card-type" name="card-type" class="form-select">
                        <option value="animals" selected>Animals</option>
                        <option value="transport">Transport</option>
                        <option value="food">Menjar</option>
                        <option value="random">Aleatori</option>
                    </select>
                </div>
                <div class="col-sm-6">
                    <label for="timer" class="form-label">Temps per torn</label>
                    <input type="number" class="form-control" id="timer" placeholder=""
                           name="timer" min="0" required value="0">
                    <small class="text-muted">0 per desactivar-ho</small>
                </div>


                <hr>

                <div>
                    <div class="list-group mx-0 w-auto">
                        <label class="list-group-item d-flex gap-2">
                            <input class="form-check-input flex-shrink-0" type="radio" name="players"
                                   id="players1" value=1 checked onchange="updateRequirements(1)">
                            <span>
        1 Jugador
        <small class="d-block text-muted">Quants moviments faràs per completar-ho?</small>
      </span>
                        </label>
                        <label class="list-group-item d-flex gap-2">
                            <input class="form-check-input flex-shrink-0" type="radio" name="players"
                                   id="players2" value=2 onchange="updateRequirements(2)">
                            <span>
        2 Jugadors
        <small class="d-block text-muted">El que faci més pareilles.</small>
      </span>
                        </label>
                        <label class="list-group-item d-flex gap-2">
                            <input class="form-check-input flex-shrink-0" type="radio" name="players"
                                   id="players3" value=3 onchange="updateRequirements(3)">
                            <span>
        3 Jugadors
        <small class="d-block text-muted">El que faci més pareilles.</small>
      </span>
                        </label>
                        <label class="list-group-item d-flex gap-2">
                            <input class="form-check-input flex-shrink-0" type="radio" name="players"
                                   id="players4" value=4 onchange="updateRequirements(4)">
                            <span>
        4 Jugadors
        <small class="d-block text-muted">El que faci més pareilles.</small>
      </span>
                        </label>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-sm-6" id="group-player1">
                        <label for="player-name-1" class="form-label">Nom del jugador 1</label>
                        <input type="text" class="form-control" id="player-name-1" placeholder="" value=""
                               name="player-name-1" minlength="3" maxlength="16">
                    </div>

                    <div class="col-sm-6" id="group-player2">
                        <label for="player-name-2" class="form-label">Nom del jugador 2</label>
                        <input type="text" class="form-control" id="player-name-2" placeholder="" value=""
                               name="player-name-2" minlength="3" maxlength="16">
                    </div>

                    <div class="col-sm-6" id="group-player3">
                        <label for="player-name-3" class="form-label">Nom del jugador 3</label>
                        <input type="text" class="form-control" id="player-name-3" placeholder="" value=""
                               name="player-name-3" minlength="3" maxlength="16">
                    </div>

                    <div class="col-sm-6" id="group-player4">
                        <label for="player-name-4" class="form-label">Nom del jugador 4</label>
                        <input type="text" class="form-control" id="player-name-4" placeholder="" value=""
                               name="player-name-4" minlength="3" maxlength="16">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-3 ">Jugar</button>
        </form>
    </div>
</div>

<?php require_once('../templates/footer.php'); ?>
<script src="assets/js/index.js"></script>

<script>
    updateRequirements(1);
</script>
</body>
</html>