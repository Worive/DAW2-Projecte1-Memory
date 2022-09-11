// -------------------------------------------
//             UPDATE BOARD SIZE
// -------------------------------------------

function subscribeUpdateBoardSize() {
    const sizeBoard = document.getElementById('sizeBoard');

    sizeBoard.addEventListener('input', (event) => {
        updateBoardSize();
    })

    updateBoardSize();
}

function updateBoardSize() {
    let sizeBoardLabel = document.getElementById('sizeBoardLabel');
    let sizeBoardValue = document.getElementById('sizeBoard').value;

    sizeBoardLabel.innerText = sizeBoardValue + ' x ' + sizeBoardValue;
}


// -------------------------------------------
//                MEMORY GAME
// -------------------------------------------

/*
 Emojis for the game
 */
const emojis = {
    animals: [
        '🐵', '🐒', '🦍', '🦧', '🐶', '🐕', '🦮', '🐩', '🐺', '🦊', '🦝', '🐱', '🐈', '🦁', '🐯', '🐅', '🐆', '🐴',
        '🐎', '🦄', '🦓', '🦌', '🦬', '🐮', '🐂', '🐃', '🐄', '🐷', '🐖', '🐗', '🐽', '🐏', '🐑', '🐐', '🐪', '🐫',
        '🦙', '🦒', '🦒', '🐘', '🦣', '🦏', '🦛', '🐭', '🐁', '🐀', '🐹', '🐰', '🐇', '🐿', '🦫', '🦔', '🦇', '🐻',
        '🐨', '🐼', '🦥', '🦦', '🦨', '🦘', '🦡',

        '🦃', '🐔', '🐓', '🐣', '🐤', '🐥', '🐦', '🐧', '🕊', '🦅', '🦆', '🦢', '🦉', '🦤', '🦩', '🦚', '🦜',
        '🐸',
        '🐊', '🐢', '🦎', '🐍', '🐲', '🐉', '🦖', '🦕',
        '🐳', '🐋', '🐬', '🦭', '🐟', '🐠', '🐡', '🦈', '🐙', '🐚',
        '🐌', '🦋', '🐛', '🐜', '🐝', '🪲', '🐞', '🦗', '🪳', '🕷', '🕸', '🦂', '🦟', '🪰', '🪱', '🦠'
    ]
}

/*
 Different game status
 */
const Status = {
    idle: 0,
    selected: 1,
    compare: 2
}

/*
 Game Data
 */
const data = {
    status: Status.idle,
    selectedA: null,
    selectedB: null,
    moves: 0,
    total: 0,
    time: 0,
}

const BOARD_SIZE = 8;
const PLAYER_AMOUNT = 1;

/*
 Starts the game
 */
function initGame() {
    if (!validateData()) {
        console.error("[MEMORY] Invalid data provided. Game cannot start!")
        return;
    }
}

/*
 Validate game setup data.
 */
function validateData() {
    let isValid = true;

    if (typeof BOARD_SIZE != "number") {
        console.warn("[DATA VALIDATION] BOARD_SIZE is not a number: " + typeof BOARD_SIZE);
        isValid = false;
    } else if (BOARD_SIZE < 2 || BOARD_SIZE > 8) {
        console.warn("[DATA VALIDATION] BOARD_SIZE is out of allowed range (2-8): " + BOARD_SIZE);
        isValid = false;
    }

    if (typeof PLAYER_AMOUNT != "number") {
        console.warn("[DATA VALIDATION] PLAYER_AMOUNT is not a number: " + typeof PLAYER_AMOUNT);
        isValid = false;
    } else if (PLAYER_AMOUNT < 1 || PLAYER_AMOUNT > 2) {
        console.warn("[DATA VALIDATION] PLAYER AMOUNT is out of allowed range (1-2): " + PLAYER_AMOUNT);
        isValid = false;
    }

    return isValid;
}
