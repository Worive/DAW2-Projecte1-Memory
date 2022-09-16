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
        return (in_array($value, [1, 2, 3, 4]));
    }

    return false;
}

function checkPlayerName($value): bool
{
    $length = strlen($value);
    return $length <= 16 && $length >= 3;
}

function checkCardType($value): bool
{
    return in_array($value, ['animals', 'food', 'random', 'transport']);
}

$sizeWidth = -1;
$sizeHeight = -1;
$players = -1;
$cardType = 'random';
$playerNames = [];

$playerStats = "";
if (isset($_POST['size-width']) && isset($_POST['size-height']) && isset($_POST['players']) && isset($_POST['card-type'])) {
    $sizeWidth = htmlspecialchars($_POST["size-width"]);
    $sizeHeight = htmlspecialchars($_POST["size-height"]);
    $players = htmlspecialchars($_POST["players"]);
    $cardType = htmlspecialchars($_POST["card-type"]);

    for ($i = 1; $i <= $players; $i++) {
        if (isset($_POST['player-name-' . $i])) {
            $playerName = htmlspecialchars($_POST['player-name-' . $i]);

            if (checkPlayerName($playerName)) {
                $playerNames[] = $playerName;

                $playerStats .= '
                              <h1 class="card-title">'. $playerName . '</h1>
        
        
                             <ul class="list-group list-group-flush">
                                <li class="list-group-item">Moves: <span id="moves-counter-'.$i.'">0</span></li>
                                <li class="list-group-item">Cards Found: <span id="total-counter-'.$i.'">0</span></li>
                                <li class="list-group-item">Time: <span id="time-counter-'.$i.'">00:00</span></li>
                            </ul>
                            ';

            } else {
                error_log("Invalid username provided for player " . $i . " :" . $playerName);
            }
        } else {
            error_log("Username not provided for player " . $i);
        }
    }


    if (!checkSize($sizeWidth)) {
        printf('INVALID SIZE WIDTH VALUE');
    }

    if (!checkSize($sizeHeight)) {
        printf('INVALID SIZE HEIGHT VALUE');
    }

    if (!checkPlayer($players)) {
        printf('INVALID PLAYER VALUE:' . $players);
        return;
    }

    if (!checkCardType($cardType)) {
        printf("INVALID CARD TYPE");
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
    <link href="assets/css/style.css" rel="stylesheet">

    <script>
        const BOARD_SIZE_WIDTH = <?= $sizeWidth?>;
        const BOARD_SIZE_HEIGHT = <?= $sizeHeight?>;
        const PLAYER_AMOUNT = <?= $players?>;
        const CARD_TYPE = '<?= $cardType ?>';
        const PLAYER_NAMES = JSON.parse('<?= json_encode($playerNames); ?>');
    </script>
</head>
<body onload="initGame()">
<?php require_once('../templates/header.php'); ?>

<div class="d-flex justify-content-center my-3 gap-3">
    <div class="card">
        <div class="card-body">
            Torn Actual: <span id="current-player"><?= $playerNames[0] ?></span>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            Temps: <span id="total-time">00:00</span>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            Remaining pairs: <span id="remaining-pairs"><?= $sizeWidth * $sizeHeight / 2?></span>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center my-3">
    <div class="card" style="width: 18rem;">
        <?= $playerStats ?>
    </div>
    <div id="board"></div>
</div>

<?php require_once('../templates/footer.php'); ?>
</body>
</html>