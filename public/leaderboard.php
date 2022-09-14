<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Projecte 1</title>
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body onload="fillTable()">
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
        <tbody id="leaderboard"></tbody>
    </table>
</div>

<?php require_once('../templates/footer.php'); ?>
</body>
</html>