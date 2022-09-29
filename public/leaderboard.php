<?php
require_once('../config/config.php');
require_once('../templates/top-left-link.php');


/**
 * Compares two scores.
 *
 * @param $a - Score A
 * @param $b - Score B
 * @return int - Score Comparison result
 */
function compareScores($a, $b): int
{
    $pointsA = $a->points;
    $pointsB = $b->points;
    if ($pointsA > $pointsB) {
        return -1;
    }

    if ($pointsA == $pointsB) {
        return 0;
    }

    if ($pointsB > $pointsA) {
        return 1;
    }
}

$content = "";
if (isset($_COOKIE['leaderboard'])) {
    $leaderboard = json_decode($_COOKIE['leaderboard'])->scores;

    usort($leaderboard, "compareScores");

    $content .= '<table class="table table-dark table-striped">
        <thead>
        <tr>
            <th scope="col">Punts</th>
            <th scope="col">Nom</th>
            <th scope="col">Moviments</th>
            <th scope="col">Temps</th>
            <th scope="col">Taulell</th>
            <th scope="col">Data</th>
        </tr>
        </thead>
        <tbody id="leaderboard">';

    foreach ($leaderboard as $score) {
        $content .= '
            <tr>
                <th>' . $score->points . '</th>
                <th>' . $score->username . '</th>
                <th>' . $score->moves . '</th>
                <th>' . $score->time . '</th>
                <th>' . $score->boardSize . '</th>
                <th>' . $score->date . '</th>
            </tr>
            ';
    }

    $content .= '</tbody></table>';
} else {
    $content = '<div class="container">
        <div class="px-4 py-5 my-5 text-center">
            <h1 class="display-5 fw-bold">Ninguna partida trobada</h1>
            <div class="col-lg-6 mx-auto">
                <p class="lead mb-4">Siguis el primer en jugar!</p>
            </div>
        </div>
    </div>';
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Projecte 1</title>
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-darker p-3">

<?= topLeftLink\get('Inici', WEB_DIRECTORY) ?>

<div class="container">
    <?= $content ?>
</div>

<?php require_once('../templates/footer.php'); ?>
</body>
</html>