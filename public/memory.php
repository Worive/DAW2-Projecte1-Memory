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
        case 'animals' || 'food' || 'transport':
            $pos = array_rand(range(0, sizeof(emojis[$cardType]) - 1));
            $emoji = emojis[$cardType][$pos];
            break;
        case 'random':

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
function generateCards(int $size,string $cardType): string
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

function checkTimer($value): bool {
    return is_numeric($value) && $value >= 0;
}

$sizeWidth = -1;
$sizeHeight = -1;
$players = -1;
$cardType = 'random';
$playerNames = [];
$cards = "";
$timer = 0;
$firstPlayer = 0;

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
                                <li class="list-group-item">Moves: <span id="moves-counter-' . $i . '">0</span></li>
                                <li class="list-group-item">Cards Found: <span id="total-counter-' . $i . '">0</span></li>
                                <li class="list-group-item">Time: <span id="time-counter-' . $i . '">00:00</span></li>
                            </ul>
                            ';

            } else {
                error_log("Invalid username provided for player " . $i . " :" . $playerName);
            }
        } else {
            error_log("Username not provided for player " . $i);
        }
    }


    if (!checkSize($sizeWidth, $sizeHeight)) {
        printf('INVALID SIZE VALUE: ' . $sizeHeight . ' ' . $sizeWidth);
    }

    if (!checkPlayer($players)) {
        printf('INVALID PLAYER VALUE:' . $players);
        return;
    }

    if (!checkCardType($cardType)) {
        printf("INVALID CARD TYPE");
        return;
    }

    if (!checkTimer($timer)) {
        printf("INVALID TIMER VALUE: " . $timer);
    }

    $firstPlayer = rand(0, $players - 1);

    $cards = generateCards($sizeHeight * $sizeWidth, $cardType);


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
            Temps: <span id="timer">00:00</span>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            Remaining pairs: <span id="remaining-pairs"><?= $sizeWidth * $sizeHeight / 2 ?></span>
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

<?php require_once('../templates/footer.php'); ?>
<script src="assets/js/memory.js"></script>
</body>
</html>