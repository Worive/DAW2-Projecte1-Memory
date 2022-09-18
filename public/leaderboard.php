<?php

/**
 * Compares two scores.
 *
 * @param $a
 * @param $b
 * @return int
 */
function cmp($a, $b): int
{
    return strcmp($a->points, $b->points);
}

$content = "";
if (isset($_COOKIE['leaderboard'])) {
    $leaderboard = json_decode($_COOKIE['leaderboard'])->scores;

    usort($leaderboard, "cmp");

    $content .= '<table class="table">
        <thead>
        <tr>
            <th scope="col">Punts</th>
            <th scope="col">Nom</th>
            <th scope="col">Moviments</th>
            <th scope="col">Temps</th>
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
                <th>' . $score->date . '</th>
            </tr>
            ';
    }

    $content .= '</tbody></table>';
} else {
    $content = '<div class="container">
        <div class="px-4 py-5 my-5 text-center">
            <h1 class="display-5 fw-bold">No record found</h1>
            <div class="col-lg-6 mx-auto">
                <p class="lead mb-4">Be the first to play!</p>
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
<body>
<?php require_once('../templates/header.php'); ?>

<div class="container">
    <?= $content ?>
</div>

<?php require_once('../templates/footer.php'); ?>
</body>
</html>