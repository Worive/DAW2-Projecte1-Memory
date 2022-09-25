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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

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

<div class="m-auto">
    <div class="header text-center p-3">
        <h1>Projecte 1: Memograma</h1>
    </div>

    <div class="body">
        <form class="text-center" action="memory.php" method="POST">
            <input type="text" class="d-none" name="players" id="playerCount">

            <div class="d-flex flex-column align-items-center justify-content-center">
                <button type="button" class="btn btn-primary text-white me-auto mb-3 d-none" id="btn-return">
                    <span class="material-icons">arrow_back</span>
                </button>


                <div id="player-picker" class="text-center">
                    <button type="button" id="btn-singleplayer" class="btn btn-primary text-white btn-lg mb-3">Un Jugador</button>
                    <button type="button" id="btn-multiplayer" class="btn btn-primary text-white btn-lg">Multi Jugador</button>
                    <div id="multiplayer-choice" class="d-none">
                        <button id="btn-multi-2" type="button" class="btn btn-primary btn-sm text-white">2 Jugadors</button>
                        <button id="btn-multi-3" type="button" class="btn btn-primary btn-sm text-white">3 Jugadors</button>
                        <button id="btn-multi-4" type="button" class="btn btn-primary btn-sm text-white">4 Jugadors</button>
                    </div>
                </div>
                <div id="player-names" class="d-none w-100">
                    <h2 class="position-relative">Jugadors</h2>
                    <div class="d-flex flex-wrap align-items-center justify-content-around gap-2">
                        <div class="col-sm-12" id="group-player1">
                            <label id="labelPlayer1" for="player-name-1" class="form-label">Jugador 1</label>
                            <input type="text" class="form-control" id="player-name-1" placeholder="Nom del jugador 1"
                                   value=""
                                   name="player-name-1" maxlength="16" required="">
                        </div>
                        <div class="col-sm-5 d-none" id="group-player2">
                            <label for="player-name-2" class="form-label">Jugador 2</label>
                            <input type="text" class="form-control" id="player-name-2" placeholder="Nom del jugador 2"
                                   value=""
                                   name="player-name-2" maxlength="16">
                        </div>

                        <div class="col-sm-5 d-none" id="group-player3">
                            <label for="player-name-3" class="form-label">Jugador 3</label>
                            <input type="text" class="form-control" id="player-name-3" placeholder="Nom del jugador 3"
                                   value=""
                                   name="player-name-3" maxlength="16">
                        </div>

                        <div class="col-sm-5 d-none" id="group-player4">
                            <label for="player-name-4" class="form-label">Jugador 4</label>
                            <input type="text" class="form-control" id="player-name-4" placeholder="Nom del jugador 4"
                                   value=""
                                   name="player-name-4" minlength="3" maxlength="16">
                        </div>
                    </div>

                </div>
            </div>


            <hr>

            <div class="d-inline mb-3">
                <h2 class="text-start">Parametres</h2>
                <div class="text-center position-relative start-50 top-0 translate-middle">
                    <h4>Mida Taulell<br><span id="sizeBoardLabel">4 x 4</span></h4>
                </div>
            </div>


            <div class="row text-start mb-3">
                <div class="col-sm-6">
                    <label class="form-label" for="sizeBoardWidth">
                        Amplada
                    </label>
                    <input type="range" class="form-range" min="2" max="8" step="1" id="sizeBoardWidth"
                           name="size-width" value=4>
                </div>
                <div class="col-sm-6">
                    <label class="form-label" for="sizeBoardHeight">
                        Altura
                    </label>
                    <input type="range" class="form-range" min="2" max="8" step="1" id="sizeBoardHeight"
                           name="size-height" value=4>

                </div>
            </div>
            <div class="row text-start">
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
            </div>


            <hr>
            <button id="btn-submit" type="submit" class="btn btn-primary btn-lg text-white disabled">Jugar</button>

        </form>
    </div>
</div>

<?php require_once('../templates/footer.php'); ?>

<script src="assets/js/background.js"></script>
<script src="assets/js/index.js"></script>

</body>
</html>