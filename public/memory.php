<?php

/**
 * List of emojis
 */
const emojis = [
    "animals" => [
        '🐵', '🐒', '🦍', '🦧', '🐶', '🐕', '🦮', '🐩', '🐺', '🦊', '🦝', '🐱', '🐈', '🦁', '🐯', '🐅', '🐆', '🐴',
        '🐎', '🦄', '🦓', '🦌', '🦬', '🐮', '🐂', '🐃', '🐄', '🐷', '🐖', '🐗', '🐽', '🐏', '🐑', '🐐', '🐪', '🐫',
        '🦙', '🦒', '🦒', '🐘', '🦣', '🦏', '🦛', '🐭', '🐁', '🐀', '🐹', '🐰', '🐇', '🐿', '🦫', '🦔', '🦇', '🐻',
        '🐨', '🐼', '🦥', '🦦', '🦨', '🦘', '🦡',

        '🦃', '🐔', '🐓', '🐣', '🐤', '🐥', '🐦', '🐧', '🕊', '🦅', '🦆', '🦢', '🦉', '🦤', '🦩', '🦚', '🦜',

        '🐸',

        '🐊', '🐢', '🦎', '🐍', '🐲', '🐉', '🦖', '🦕',

        '🐳', '🐋', '🐬', '🦭', '🐟', '🐠', '🐡', '🦈', '🐙', '🐚',

        '🐌', '🦋', '🐛', '🐜', '🐝', '🪲', '🐞', '🦗', '🪳', '🕷', '🕸', '🦂', '🦟', '🪰', '🪱', '🦠'

    ],
    "food" => [
        '🍇', '🍈', '🍉', '🍊', '🍋', '🍌', '🍍', '🥭', '🍎', '🍏',
        '🍐', '🍑', '🍒', '🍓', '🫐', '🥝', '🍅', '🫒', '🥥',

        '🥑', '🍆', '🥔', '🥕', '🌽', '🌶', '🫑', '🥒', '🥬', '🥦',
        '🧄', '🧅', '🍄', '🥜', '🌰',

        '🍞', '🥐', '🥖', '🫓', '🥨', '🥯', '🥞', '🧇', '🧀', '🍖', '🍗', '🥩', '🥓', '🍔', '🍟', '🍕', '🌭', '🥪',
        '🌮', '🌯', '🫔', '🥙', '🧆', '🥚', '🍳', '🥘', '🍲', '🫕', '🥣', '🥗', '🍿', '🧈', '🧂', '🥫',

        '🍱', '🍘', '🍙', '🍚', '🍛', '🍜', '🍝', '🍠', '🍢', '🍣', '🍤', '🍥', '🥮', '🍡', '🥟', '🥠', '🥡',

        '🦀', '🦞', '🦐', '🦑', '🦪',

        '🍦', '🍧', '🍨', '🍩', '🍪', '🎂', '🍰', '🧁', '🥧', '🍫', '🍬', '🍭', '🍮', '🍯',

        '🍼', '🥛', '☕', '🫖', '🫖', '🍵', '🍶', '🍾', '🍷', '🍸', '🍹', '🍺', '🍻', '🥂', '🥃', '🥤', '🧋', '🧃',
        '🧉', '🧊'
    ],
    "transport" => [
        '🚂', '🚃', '🚄', '🚅', '🚆', '🚇', '🚈', '🚉', '🚊', '🚝', '🚞', '🚋', '🚌', '🚍', '🚎', '🚐', '🚑', '🚒',
        '🚓', '🚔', '🚕', '🚖', '🚗', '🚘', '🚙', '🚚', '🚛', '🚜', '🚲', '🛴', '🛵', '🚏', '🛣', '🛤', '⛽', '🚨',
        '🚥', '🚦', '🚧', '🛑', '⚓', '⛵', '🛶', '🚤', '🛳', '⛴', '🛥', '🚢', '✈', '🛩', '🛫', '🛬', '💺', '🚁',
        '🚟', '🚠', '🚡'
    ]
];

/**
 * Get a random emoji depending on the card type.
 *
 * @param $cardType string - Card type
 * @return array
 */
function getRandomEmoji(string $cardType): array
{
    $pos = -1;
    $emoji = 'unknown';
    switch ($cardType) {
        case 'food':
        case 'transport':
        case 'animals':
            $pos = array_rand(range(0, sizeof(emojis[$cardType]) - 1));
            $emoji = emojis[$cardType][$pos];
            break;
        case 'random':
            $foodSize = sizeof(emojis['food']);
            $animalSize = sizeof(emojis['animals']);
            $transportSize = sizeof(emojis['transport']);

            $pos = array_rand(range(0, $foodSize + $animalSize + $transportSize - 1));

            if ($pos < $foodSize) {
                $emoji = emojis['food'][$pos];
            } else if ($pos - $foodSize < $animalSize) {
                $emoji = emojis['animals'][$pos - $foodSize];
            } else if ($pos - $foodSize - $animalSize < $transportSize) {
                $emoji = emojis['transport'][$pos - $foodSize - $animalSize];
            }
            break;
        default:
            error_log('Unknown card type: ' . $cardType);

    }

    return [
        "key" => $pos,
        "value" => $emoji
    ];
}

/**
 * Get a random list of emojis
 *
 * @param int $size - Amount of emojis needed
 * @param string $cardType - Emoji's type
 * @return array
 */
function getRandomList(int $size, string $cardType): array
{
    $arr = [];

    for ($i = 0; $i < $size; $i++) {
        $emoji = getRandomEmoji($cardType);

        while (in_array($emoji, $arr)) {
            $emoji = getRandomEmoji($cardType);
        }

        $arr[] = $emoji;
        $arr[] = $emoji;
    }

    return $arr;

}

/**
 * Generate cards with the random emojis.
 *
 * @param int $size - Amount of cards.
 * @param string $cardType - Cards type
 * @return string
 */
function generateCards(int $size, string $cardType): string
{
    function generateCardElement($id, $emojiKey, $emojiValue): string {
        return '<div class="memory-card" id="card-' . $id . '" card="' . $emojiKey . '">
            <div class="card-inner">
                <div class="card-front">' . $emojiValue . '</div>
                <div class="card-back"></div>
            </div>
        </div>';
    }

    $emojis = getRandomList($size / 2, $cardType);
    shuffle($emojis);
    $content = "";
    
    for ($i = 0; $i < $size; $i++) {
        $content .= generateCardElement($i, $emojis[$i]['key'], $emojis[$i]['value']);
    }

    return $content;
}

function checkSize($n, $m): bool
{
    if (is_numeric($n) && is_numeric($m)) {
        return ($n * $m % 2 == 0);
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
    return $length <= 16 && $length >= 1;
}

function checkCardType($value): bool
{
    return in_array($value, ['animals', 'food', 'random', 'transport']);
}

function checkTimer($value): bool
{
    return is_numeric($value) && $value >= 0;
}

function logError($message): void
{

    if (!isset($_SESSION['error-messages'])) {
        $_SESSION['error-messages'] = [];
    }

    error_log($message);

    $_SESSION['error-messages'][] = $message;
}


function getPlayerStatElement(int $id, string $playerName): string
{
    return '<div id="player-stats-' . $id . '" class="player-stats fancy-card text-center">
            <div class="fancy-card-header">Jugant</div>
            <div class="fancy-card-content pt-2">
                <h4 class="px-2">' . $playerName . '</h4>
                <hr>

                <div class="d-flex">
                    <div class="col-4 d-flex flex-column">
                        <span class="material-icons">touch_app</span>
                        <span id="moves-counter-' . $id . '">0</span>
                    </div>

                    <div class="col-4 d-flex flex-column">
                        <span class="material-icons">star</span>
                        <span id="total-counter-' . $id . '">0</span>
                    </div>

                    <div class="col-4 d-flex flex-column">
                        <span class="material-icons">timelapse</span>
                        <span id="time-counter-' . $id . '">00:00</span>
                    </div>
                </div>

            </div>
        </div>';
}

session_start();

$sizeWidth = -1;
$sizeHeight = -1;
$players = -1;
$cardType = 'random';
$playerNames = [];
$cards = "";
$timer = 0;
$firstPlayer = 0;
$error_found = false;
$timerValue = '∞';

$playerStats = "";
if (isset($_POST['size-width']) && isset($_POST['size-height']) && isset($_POST['players']) && isset($_POST['card-type']) && isset($_POST['timer'])) {
    $sizeWidth = htmlspecialchars($_POST["size-width"]);
    $sizeHeight = htmlspecialchars($_POST["size-height"]);
    $players = htmlspecialchars($_POST["players"]);
    $cardType = htmlspecialchars($_POST["card-type"]);
    $timer = htmlspecialchars($_POST["timer"]);

    for ($i = 1; $i <= $players; $i++) {
        if (isset($_POST['player-name-' . $i])) {
            $playerName = htmlspecialchars($_POST['player-name-' . $i]);

            if (checkPlayerName($playerName)) {
                $playerNames[] = $playerName;
                $playerStats .= getPlayerStatElement($i, $playerName);

            } else {
                error_log("Invalid username provided for player " . $i . " :" . $playerName);
                $error_found = true;
            }
        } else {
            error_log("Username not provided for player " . $i);
            $error_found = true;
        }
    }


    if (!checkSize($sizeWidth, $sizeHeight)) {
        logError('INVALID SIZE VALUE: ' . $sizeHeight . ' ' . $sizeWidth);
        $error_found = true;
    }

    if (!checkPlayer($players)) {
        logError('INVALID PLAYER VALUE:' . $players);
        $error_found = true;
    }

    if (!checkCardType($cardType)) {
        logError("INVALID CARD TYPE");
        $error_found = true;

    }

    if (!checkTimer($timer)) {
        logError("INVALID TIMER VALUE: " . $timer);
        $error_found = true;
    }

} else {
    $error_found = true;
}

if ($error_found) {
    header('Location: index.php');
} else {
    $firstPlayer = rand(0, $players - 1);
    $cards = generateCards($sizeHeight * $sizeWidth, $cardType);

    if ($timer > 0) {
        $timerValue = '00:00';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Projecte 1</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

    <style>
        #board {
            min-width: <?= $sizeWidth * (80 + 12) + 16?>px;
            width: <?= $sizeWidth * (80 + 12) + 16 ?>px;
        }
    </style>

    <script>
        const BOARD_SIZE_WIDTH = <?= $sizeWidth?>;
        const BOARD_SIZE_HEIGHT = <?= $sizeHeight?>;
        const PLAYER_AMOUNT = <?= $players?>;
        const CARD_TYPE = '<?= $cardType ?>';
        const PLAYER_NAMES = JSON.parse('<?= json_encode($playerNames); ?>');
        const TIMER = <?= $timer ?>;
        const FIRST_PLAYER = <?= $firstPlayer ?>
    </script>
</head>
<body onload="initGame()">

<div class="game-container d-flex align-items-center justify-content-center p-3 gap-3">
    <div class="d-flex flex-column justify-content-start gap-3 align-items-start mb-auto">
        <?= $playerStats ?>
    </div>

    <div class="d-flex flex-column justify-content-center align-items-center gap-3">
        <div class="d-flex flex-row justify-content-between gap-3">
            <div class="fancy-card text-center">
                <div class="fancy-card-header px-2">Jugador</div>
                <div class="fancy-card-content py-1 px-4">
                    <h4 id="current-player"><?= $playerNames[$firstPlayer] ?></h4>
                </div>
            </div>
            <div class="fancy-card text-center">
                <div class="fancy-card-header px-2">Temps Torn</div>
                <div class="fancy-card-content py-1 px-4">
                    <h4 id="timer"><?= $timerValue ?></h4>
                </div>
            </div>
            <div class="fancy-card text-center">
                <div class="fancy-card-header px-2">Parelles restants</div>
                <div class="fancy-card-content py-1 px-4">
                    <h4 id="remaining-pairs"><?= $sizeWidth * $sizeHeight / 2 ?></h4>
                </div>
            </div>
        </div>
        <div id="board" class="d-flex flex-wrap justify-content-around align-content-around gap-2 p-3">
            <?= $cards ?>
        </div>
    </div>

    <div class="mb-auto">
        <div class="fancy-card text-center ms-auto">
            <div class="fancy-card-header">Temps Partida</div>
            <div class="fancy-card-content py-2 px-4">
                <h4 id="timer">00:00:00</h4>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" id="win-recap">
    <div class="modal-dialog">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h4 class="modal-title">Victoria!</h4>
            </div>
            <div class="modal-body">
                <h4>Resultats</h4>
                <p>Puntuació: <b><span>22.6</span> punts</b></p>
                <p>Mida Taulell: <b><span>2</span> x <span>2</span></b></p>
                <p>Temps Limit per Torn: <b><span>5</span> segons</b></p>
                <hr>
                <h4>Detalls</h4>
                <p>Difficultat: <b><span>2.5</span>%</b> (<span>-64.4</span> punts)</p>
                <p>Temps per torn: <b><span>10 segons</span></b> (<span>-8</span> punts)</p>
                <p>Cartes girades més d'un cop: <b><span>4</span> cartes</b> (<span>-4</span> punts)</p>
                <p>Encertades de seguida: <b><span>4</span> cartes</b> (<span>+4</span> punts)</p>
                <p>Moviments perfectes: <b><span>47</span>%</b> (<span>-5</span> punts)</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary text-white me-auto">Tornar al Inici</button>
                <button type="button" class="btn btn-secondary text-white">Hall Of Fame</button>
                <button type="button" class="btn btn-primary text-white">Tornar a començar</button>
            </div>
        </div>
    </div>
</div>

<?php require_once('../templates/footer.php'); ?>
<script src="assets/js/background.js"></script>
<script src="assets/js/memory.js"></script>
</body>
</html>