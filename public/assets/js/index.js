// -------------------------------------------
//             Automations
// -------------------------------------------

window.addEventListener('load', (event) => {
    subscribeUpdateBoardSize();
})

/**
 * Add event listeners to width and height radius to update the display.
 */
function subscribeUpdateBoardSize() {
    const sizeBoardWidth = document.getElementById('sizeBoardWidth');
    const sizeBoardHeight = document.getElementById('sizeBoardHeight');

    sizeBoardWidth.addEventListener('input', () => {
        updateBoardSize();
    })

    sizeBoardHeight.addEventListener('input', () => {
        updateBoardSize();
    })

    sizeBoardHeight.addEventListener('change', () => {
        updateStep();
    })
    sizeBoardWidth.addEventListener('change', () => {
        updateStep();
    })

    updateBoardSize();
}

/**
 * Update steps from 1 to 2 depending on other size board being even.
 */
function updateStep() {
    const sizeBoardWidth = document.getElementById('sizeBoardWidth');
    const sizeBoardHeight = document.getElementById('sizeBoardHeight');

    if (sizeBoardHeight.value % 2 === 0) {
        sizeBoardWidth.step = 1;
    } else {
        sizeBoardWidth.step = 2;
    }

    if (sizeBoardWidth.value % 2 === 0) {
        sizeBoardHeight.step = 1;
    } else {
        sizeBoardHeight.step = 2;
    }

}

/**
 * Update the display with the value of the width and height radius.
 */
function updateBoardSize() {
    let sizeBoardLabel = document.getElementById('sizeBoardLabel');
    let sizeBoardWidth = document.getElementById('sizeBoardWidth').value;
    let sizeBoardHeight = document.getElementById('sizeBoardHeight').value;

    sizeBoardLabel.innerText = sizeBoardWidth + ' x ' + sizeBoardHeight;
}

// -------------------------------------------
//             Form Navigation
// -------------------------------------------


window.addEventListener('load', () => {
    document.getElementById('btn-singleplayer').addEventListener('click', () => {
        changeStatus(Status.SinglePlayerFirst);
    })

    document.getElementById('btn-multiplayer').addEventListener('click', () => {
        changeStatus(Status.MultiplayerPickAmount);
    })

    document.getElementById('btn-multi-2').addEventListener('click', () => {
        changeStatus(Status.MultiplayerSecond, 2);
    })

    document.getElementById('btn-multi-3').addEventListener('click', () => {
        changeStatus(Status.MultiplayerSecond, 3);
    })

    document.getElementById('btn-multi-4').addEventListener('click', () => {
        changeStatus(Status.MultiplayerSecond, 4);
    })

    document.getElementById('btn-return').addEventListener('click', () => {
        returnBack();
    })
})

/**
 * Possibles status of the form page
 *
 * @enum
 * @readonly
 * @type {{MultiplayerSecond: number, SinglePlayerFirst: number, MultiplayerPickAmount: number, Initial: number}}
 */
const Status = {
    Initial: 0,
    SinglePlayerFirst: 1,
    MultiplayerPickAmount: 2,
    MultiplayerSecond: 3,
}

/**
 * Actual status of the form page.
 * @type {Status|number}
 */
let PAGE_STATUS = Status.Initial;

/**
 * Return to the previous status.
 */
function returnBack() {
    switch (PAGE_STATUS) {
        case Status.Initial:
            console.error('Cannot go more behind than initial.')
            break;
        case Status.SinglePlayerFirst:
        case Status.MultiplayerPickAmount:
            changeStatus(Status.Initial);
            break;
        case Status.MultiplayerSecond:
            changeStatus(Status.MultiplayerPickAmount);
            break
        default:
            console.error('Unknown page status: ' + PAGE_STATUS);

    }
}

/**
 * Change the form status and display the correct state.
 *
 * @param {Status} status - New status
 * @param {number} players - Player Amount
 */
function changeStatus(status, players = 1) {

    /**
     * Show player name inputs depending on the amount.
     * @param {number} amount - Amount of inputs needed.
     */
    function showPlayerNames(amount) {
        playerPicker.classList.add('d-none');
        updateRequirements(amount);
        playerNames.classList.remove('d-none');

        if (amount === 1) {
            hideIfNotHidden(label1)
        } else {
            label1.classList.remove('d-none');
        }
    }

    /**
     * Show the multiplayer picker
     */
    function showPicker() {
        subButtons.classList.remove('d-none');
    }

    /**
     * Hide the multiplayer picker
     */
    function hidePicker() {
        hideIfNotHidden(subButtons);
    }

    /**
     * Hide an element if not already having the hidden class.
     *
     * @param {Element} element
     */
    function hideIfNotHidden(element) {
        if (!element.classList.contains('d-none')) {
            element.classList.add('d-none');
        }
    }

    /**
     * Reset the player name inputs and check again the form.
     */
    function resetInputs() {
        for (let i = 1; i <= 4; i++) {
            document.getElementById('player-name-' + i).value = '';
        }

        checkFormValid();
    }

    const playerPicker = document.getElementById('player-picker');
    const playerNames = document.getElementById('player-names');
    const btnMultiplayer = document.getElementById('btn-multiplayer');
    const subButtons = document.getElementById('multiplayer-choice');
    const btnReturn = document.getElementById('btn-return');
    const label1 = document.getElementById('labelPlayer1');


    PAGE_STATUS = status;

    // Display return button if not in initial state.
    if (status !== Status.Initial) {
        btnReturn.classList.remove('d-none')
    } else {
        hideIfNotHidden(btnReturn);
    }

    switch (status) {
        case Status.Initial:
            hideIfNotHidden(playerNames);
            hideIfNotHidden(subButtons)
            btnMultiplayer.classList.remove('d-none');
            playerPicker.classList.remove('d-none');
            resetInputs();
            break;

        case Status.SinglePlayerFirst:
            document.getElementById('labelPlayer1').classList.add('d-none');
            showPlayerNames(1);
            break;

        case Status.MultiplayerPickAmount:
            playerPicker.classList.remove('d-none');
            hideIfNotHidden(playerNames);
            hideIfNotHidden(btnMultiplayer);
            showPicker();
            resetInputs();
            break;

        case Status.MultiplayerSecond:
            hidePicker();
            hideIfNotHidden(playerPicker);
            showPlayerNames(players);
            break;

        default:
            console.error('Unknown status: ' + status);
    }
}


// -------------------------------------------
//          Form Validation
// -------------------------------------------


window.addEventListener('load', (event) => {
    for (const element of document.querySelectorAll('input')) {
        element.addEventListener('input', () => {
            checkFormValid();
        })
    }
})

/**
 * Display and set as required as many player name input
 * fields as necessary depending on the amount of players chosen.
 *
 * @param {number} playerAmount - Player Amount
 */
function updateRequirements(playerAmount) {
    document.getElementById('playerCount').value = playerAmount;

    for (let i = 1; i <= 4; i++) {
        if (i <= playerAmount) {
            document.getElementById('player-name-' + i).required = true;
            if (i === playerAmount && playerAmount % 2 !== 0) {
                document.getElementById('group-player' + i).setAttribute('class', 'col-sm-12');
            } else {
                document.getElementById('group-player' + i).setAttribute('class', 'col-sm-5');
            }

        } else {
            document.getElementById('player-name-' + i).required = false;
            document.getElementById('group-player' + i).setAttribute('class', 'col-sm-6 d-none');
        }
    }
}

/**
 * Check every required input if they need valid, then allow to submit the form.
 */
function checkFormValid() {
    console.log('checked');
    const elements = document.querySelectorAll('input:required');
    const submit = document.getElementById('btn-submit');

    for (const element of elements) {
        if (!element.checkValidity()) {
            if (!submit.classList.contains('disabled')) {
                submit.classList.add('disabled');
            }
            return;
        }
    }


    submit.classList.remove('disabled');
}


// -------------------------------------------
//                BACKGROUND
// -------------------------------------------

window.addEventListener('load', (event) => {
    generateBackground();

    document.getElementById('card-type').addEventListener('change', () => {
        regenerateBackground();
    })
})


const EmojiPerPixel = 0.0088;

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

    ],
    food: [
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
    transport: [
        '🚂', '🚃', '🚄', '🚅', '🚆', '🚇', '🚈', '🚉', '🚊', '🚝', '🚞', '🚋', '🚌', '🚍', '🚎', '🚐', '🚑', '🚒',
        '🚓', '🚔', '🚕', '🚖', '🚗', '🚘', '🚙', '🚚', '🚛', '🚜', '🚲', '🛴', '🛵', '🚏', '🛣', '🛤', '⛽', '🚨',
        '🚥', '🚦', '🚧', '🛑', '⚓', '⛵', '🛶', '🚤', '🛳', '⛴', '🛥', '🚢', '✈', '🛩', '🛫', '🛬', '💺', '🚁',
        '🚟', '🚠', '🚡'
    ]
}

function getRandomEmoji() {
    let emoji;

    let pos;

    switch (document.getElementById('card-type').value) {
        case 'animals':
            pos = Math.floor(Math.random() * emojis.animals.length);
            emoji = emojis.animals[pos];
            break;
        case 'food':
            pos = Math.floor(Math.random() * emojis.food.length);
            emoji = emojis.food[pos];
            break;
        case 'transport':
            pos = Math.floor(Math.random() * emojis.transport.length);
            emoji = emojis.transport[pos];
            break;
        default:
            pos = Math.floor(Math.random() * (emojis.animals.length + emojis.food.length + emojis.transport.length));

            if (pos < emojis.animals.length) {
                emoji = emojis.animals[pos]
            } else if (pos - emojis.animals.length < emojis.food.length) {
                emoji = emojis.food[pos - emojis.animals.length]
            } else if (pos - emojis.food.length - emojis.animals.length < emojis.transport.length) {
                emoji = emojis.transport[pos - emojis.food.length - emojis.animals.length]
            } else {
                console.error('Position of emoji out of range:' + pos)
            }
    }

    return emoji;
}


function generateBackground() {
    const background = document.getElementById('background');

    const x = screen.width * EmojiPerPixel;
    const y = Math.floor(screen.height / 100);


    for (let i = 0; i < y; i++) {
        for (let j = 0; j < x; j++) {
            let emoji = document.createElement('div');
            emoji.innerText = getRandomEmoji();

            background.appendChild(emoji);
        }
    }
}

function regenerateBackground() {
    const background = document.getElementById('background');

    for (const childNode of background.children) {
        childNode.innerText = getRandomEmoji();
    }
}