<?php

function cmp($a, $b) {
    return strcmp($a->points, $b->points);
}

$content = "";
if (isset($_COOKIE['leaderboard'])) {
    $leaderboard = json_decode($_COOKIE['leaderboard'])->scores;

    usort($leaderboard, "cmp");

    foreach ($leaderboard as $score) {
        $content .= '
            <tr>
                <th>'. $score->points . '</th>
                <th>'. $score->username . '</th>
                <th>'. $score->moves . '</th>
                <th>'. $score->time . '</th>
                <th>'. $score->date . '</th>
            </tr>
            ';
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Projecte 1</title>
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<?php require_once('../templates/header.php'); ?>

<div class="container">
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Score</th>
            <th scope="col">Nom</th>
            <th scope="col">Moviments</th>
            <th scope="col">Temps</th>
            <th scope="col">Data</th>
        </tr>
        </thead>
        <tbody id="leaderboard">
            <?= $content ?>
        </tbody>
    </table>
</div>

<?php require_once('../templates/footer.php'); ?>
</body>
</html>