<?php
function checkSize($value): bool
{
    if (is_numeric($value)) {
        return ($value % 2 == 0 && $value > 1 && $value < 23);
    }

    return false;
}

function checkPlayer($value): bool
{
    if (is_numeric($value)) {
        return (in_array($value, [1, 2]));
    }

    return false;
}

$sizeWidth = -1;
$sizeHeight = -1;
$players = -1;
if (isset($_POST['size-width']) && isset($_POST['size-height']) && isset($_POST['players'])) {
    $sizeWidth = htmlspecialchars($_POST["size-width"]);
    $sizeHeight = htmlspecialchars($_POST["size-height"]);
    $players = htmlspecialchars($_POST["players"]);

    if (!checkSize($sizeWidth)) {
        printf('INVALID SIZE WIDTH VALUE');
    }

    if (!checkSize($sizeHeight)) {
        printf('INVALID SIZE HEIGHT VALUE');
    }

    if (!checkPlayer($players)) {
        printf('INVALID PLAYER VALUE');
        return;
    }

} else {
    printf('MISSING POST VALUES!');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Projecte 1</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

    <script>
        const BOARD_SIZE_WIDTH = <?php echo $sizeWidth?>;
        const BOARD_SIZE_HEIGHT = <?php echo $sizeHeight?>;
        const PLAYER_AMOUNT = <?php echo $players?>;
    </script>
</head>
<body onload="initGame()">
<?php require_once('../templates/header.php'); ?>

<div class="d-flex justify-content-center my-3">
    <div id="board"></div>
</div>

<?php require_once('../templates/footer.php'); ?>

<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/script.js"></script>
</body>
</html>