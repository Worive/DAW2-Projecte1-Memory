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
            $pos = array_rand(range(0, sizeof(emojis['food'])+sizeof(emojis['transport'])+sizeof(emojis['animals']) - 1));

            if ($pos < sizeof(emojis['food']))
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
    $emojis = getRandomList($size / 2, $cardType);

    shuffle($emojis);

    $content = "";
    for ($i = 0; $i < $size; $i++) {
        $content .=
            '<div class="memory-card" id="card-' . $i . '" card="' . $emojis[$i]['key'] . '">
            <div class="card-inner">
                <div class="card-front">' . $emojis[$i]['value'] . '</div>
                <div class="card-back"></div>
            </div>
        </div>';
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
    return $length <= 16 && $length >= 3;
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

                $playerStats .= '
                              <h1 class="card-title">' . $playerName . '</h1>
        
        
                             <ul class="list-group list-group-flush">
                                <li class="list-group-item">Moviments: <span id="moves-counter-' . $i . '">0</span></li>
                                <li class="list-group-item">Punts: <span id="total-counter-' . $i . '">0</span></li>
                                <li class="list-group-item">Temps: <span id="time-counter-' . $i . '">00:00</span></li>
                            </ul>
                            ';

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
    <link href="assets/css/style.css" rel="stylesheet">

    <style>
        #board {
            min-width: <?= $sizeWidth ?>00px;
            width: <?= $sizeWidth ?>00px;
            height: <?= $sizeHeight ?>00px;
            min-height: <?= $sizeHeight ?>00px;
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
<?php require_once('../templates/header.php'); ?>

<div class="d-flex justify-content-center my-3 gap-3">
    <div class="card">
        <div class="card-body">
            Torn Actual: <span id="current-player"><?= $playerNames[$firstPlayer] ?></span>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            Temps: <span id="timer"><?= $timerValue ?></span>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            Parelles restant: <span id="remaining-pairs"><?= $sizeWidth * $sizeHeight / 2 ?></span>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center my-3">
    <div class="card" style="width: 18rem;">
        <?= $playerStats ?>
    </div>
    <div id="board">
        <?= $cards ?>
    </div>
</div>

<div class="modal" tabindex="-1" id="win-recap">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Victoria!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Modal body text goes here.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary">Return to Home</button>
                <button type="button" class="btn btn-primary">Replay</button>
            </div>
        </div>
    </div>
</div>

<?php require_once('../templates/footer.php'); ?>
<script src="assets/js/memory.js"></script>
</body>
</html>