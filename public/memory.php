<?php
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


function getRandomEmoji($cardType): array
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

function getRandomList($size, $cardType): array
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

function generateCards($size, $cardType): string
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

function checkTimer($value): bool {
    return is_numeric($value) && $value >= 0;
}

$sizeWidth = -1;
$sizeHeight = -1;
$players = -1;
$cardType = 'random';
$playerNames = [];
$boardClass = "";
$cards = "";
$timer = 0;

$playerStats = "";
if (isset($_POST['size-width']) && isset($_POST['size-height']) && isset($_POST['players']) && isset($_POST['card-type']) && isset($_POST['timer'])) {
    $sizeWidth = htmlspecialchars($_POST["size-width"]);
    $sizeHeight = htmlspecialchars($_POST["size-height"]);
    $players = htmlspecialchars($_POST["players"]);
    $cardType = htmlspecialchars($_POST["card-type"]);
    $timer = htmlspecialchars($_POST["timer"]);

    $boardClass = 'board-width-' . $sizeWidth . ' board-height-' . $sizeHeight;

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

    if (!checkTimer($timer)) {
        printf("INVALID TIMER VALUE: " . $timer);
    }

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

    <script>
        const BOARD_SIZE_WIDTH = <?= $sizeWidth?>;
        const BOARD_SIZE_HEIGHT = <?= $sizeHeight?>;
        const PLAYER_AMOUNT = <?= $players?>;
        const CARD_TYPE = '<?= $cardType ?>';
        const PLAYER_NAMES = JSON.parse('<?= json_encode($playerNames); ?>');
        const TIMER = <?= $timer ?>;
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
    <div id="board" class="<?= $boardClass ?>">
        <?= $cards ?>
    </div>
</div>

<?php require_once('../templates/footer.php'); ?>
</body>
</html>