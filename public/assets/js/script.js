// -------------------------------------------
//             FORM PAGE
// -------------------------------------------

function subscribeUpdateBoardSize() {
    const sizeBoardWidth = document.getElementById('sizeBoardWidth');
    const sizeBoardHeight = document.getElementById('sizeBoardHeight');

    sizeBoardWidth.addEventListener('input', (event) => {
        updateBoardSize();
    })

    sizeBoardHeight.addEventListener('input', (event) => {
        updateBoardSize();
    })

    updateBoardSize();
}

function updateBoardSize() {
    let sizeBoardLabel = document.getElementById('sizeBoardLabel');
    let sizeBoardWidth = document.getElementById('sizeBoardWidth').value;
    let sizeBoardHeight = document.getElementById('sizeBoardHeight').value;

    sizeBoardLabel.innerText = sizeBoardWidth + ' x ' + sizeBoardHeight;
}

function updateRequirements(id) {
    for (let i = 1; i <= 4; i++) {
        if (i <= id) {
            console.log('show ' + i)
            document.getElementById('player-name-' + i).required = true;
            if (i === id && id % 2 !== 0) {
                document.getElementById('group-player' + i).setAttribute('class', 'col-sm-12');
            } else {
                document.getElementById('group-player' + i).setAttribute('class', 'col-sm-6');
            }

        } else {
            document.getElementById('player-name-' + i).required = false;
            document.getElementById('group-player' + i).setAttribute('class', 'col-sm-6 d-none');
        }
    }
}




// -------------------------------------------
//                MEMORY GAME
// -------------------------------------------

function Timer(player) {
    let that = this;
    let expected, timeout;
    this.interval = 1000;
    let seconds = 0;

    this.start = function () {
        // console.log('STARTING TIME FOR PLAYER ' + player)

        expected = Date.now() + this.interval;
        timeout = setTimeout(step, this.interval);
    }

    this.stop = function () {
        // console.log('STOPPING TIME FOR PLAYER ' + player)

        clearTimeout(timeout);
    }

    this.formattedTime = function () {
        return formattedTime(seconds);
    }

    this.seconds = function () {
        return seconds;
    }

    function formattedTime(secs) {
        var sec_num = secs;
        var minutes = Math.floor(sec_num / 60);
        var seconds = sec_num - (minutes * 60);

        if (minutes < 10) {
            minutes = "0" + minutes;
        }
        if (seconds < 10) {
            seconds = "0" + seconds;
        }
        return minutes + ':' + seconds;
    }

    function step() {
        seconds += 1;
        const drift = Date.now() - expected;
        document.getElementById('time-counter-' + player).innerText = formattedTime(seconds);
        expected += that.interval;
        timeout = setTimeout(step, Math.max(0, that.interval - drift));
    }
}

/**
 * Emojis for the game
 **/
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

let TURN_DATA;

/**
 * PlayerData
 * Build with player's username and ID.
 **/
class PlayerData {
    constructor(username, i) {
        this.username = username;
        this.id = i;
        this.moves = 0;
        this.cards = 0;
        this.time = new Timer(i);

        this.selectedCards = {
            first: null,
            second: null
        }

        this.status = Status.idle;

    }

    flipCard(card) {
        switch (this.status) {
            case Status.idle:
                this.flipFirstCard(card)
                break;
            case Status.selected:
                this.flipSecondCard(card)
                nextTurn();
        }

    }

    flipFirstCard(card) {
        card.classList.add('selected');
        this.selectedCards.first = card.getAttribute('id');
        this.status = Status.selected;
    }

    flipSecondCard(card) {
        this.addMove();

        card.classList.add('selected');
        this.selectedCards.second = card.getAttribute('id');

        if (document.getElementById(this.selectedCards.first).getAttribute('card') ===
            document.getElementById(this.selectedCards.second).getAttribute('card')) {
            this.addClassToSelectedCards('found');
            this.addTotalPoints()
        } else {
            this.addClassToSelectedCards('wrong');

            const a = this.selectedCards.first;
            const b = this.selectedCards.second;

            setTimeout(() => resetSelectedCards(a, b), 800);
        }

        this.status = Status.idle;
        this.time.stop();
    }

    addTotalPoints() {
        this.cards += 1;
        TURN_DATA.remainingCards -= 1;
        document.getElementById('remaining-pairs').innerText = '' + TURN_DATA.remainingCards;
        document.getElementById('total-counter-' + this.id).innerText = this.cards;
    }

    addMove() {
        this.moves += 1;
        document.getElementById('moves-counter-' + this.id).innerText = this.moves;
    }

    addClassToSelectedCards(className) {
        document.getElementById(this.selectedCards.first).classList.add(className);
        document.getElementById(this.selectedCards.second).classList.add(className);
    }


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
    time: new Timer(1000)
}

function setupPlayers() {
    let playerData = [];

    for (let i = 0; i < PLAYER_AMOUNT; i++) {
        playerData.push(new PlayerData(PLAYER_NAMES[i], i+1))
    }

    return playerData;
}

function nextTurn() {
    console.log(`NEW TURN`)
    if (TURN_DATA.remainingCards <= 0) {
        console.log(`WON`)
        win();
        return
    }

    if (TURN_DATA.currentPlayer === PLAYER_AMOUNT - 1) {
        TURN_DATA.currentPlayer = 0;
    } else {
        TURN_DATA.currentPlayer += 1;
    }

    document.getElementById('current-player').innerText = getCurrentPlayer().username;

    getCurrentPlayer().time.start()
}

function getCurrentPlayer() {
    return TURN_DATA.players[TURN_DATA.currentPlayer];
}

/*
 Starts the game
 */
function initGame() {

    if (!validateData()) {
        console.error("[MEMORY] Invalid data provided. Game cannot start!");
        return;
    }

    TURN_DATA = {
        currentPlayer: 0,
        players: setupPlayers(),
        remainingCards: BOARD_SIZE_HEIGHT * BOARD_SIZE_WIDTH / 2
    }

    setBoardSize();
    addCards();

    getCurrentPlayer().time.start();
}

/*
 Validate game setup data.
 */
function validateData() {
    function verifyNumberAndRange(size, name, minRange, maxRange) {
        if (typeof size != "number") {
            console.warn(`[DATA VALIDATION] ${name} is not a number: ${typeof size}`);
            return false;
        } else if (size < minRange || size > maxRange) {
            console.warn(`[DATA VALIDATION] ${name} is out of allowed range (${minRange}-${maxRange}): ${size}`);
            return false;
        }

        return true;
    }

    let isValid = true;

    isValid = isValid && verifyNumberAndRange(BOARD_SIZE_HEIGHT, "BOARD_SIZE_HEIGHT", 2, 8);
    isValid = isValid && verifyNumberAndRange(BOARD_SIZE_WIDTH, "BOARD_SIZE_WIDTH", 2, 8);
    isValid = isValid && verifyNumberAndRange(PLAYER_AMOUNT, "PLAYER_AMOUNT", 1, 4);

    return isValid;
}

/*
Apply the correct size to the board
 */
function setBoardSize() {
    console.log(`[MEMORY] Setting Board's Size: ${BOARD_SIZE_WIDTH}x${BOARD_SIZE_HEIGHT}`)
    const board = document.getElementById('board');

    board.classList.add('board-width-' + BOARD_SIZE_WIDTH)
    board.classList.add('board-height-' + BOARD_SIZE_HEIGHT)
}

/*
 Add cards to the board.
 */
function addCards() {

    // Fisher-Yates Shuffle
    function shuffle(array) {
        let currentIndex = array.length, randomIndex;

        while (currentIndex != 0) {
            randomIndex = Math.floor(Math.random() * currentIndex);
            currentIndex--;

            [array[currentIndex], array[randomIndex]] = [
                array[randomIndex], array[currentIndex]];
        }

        return array;
    }


    const cardAmount = BOARD_SIZE_HEIGHT * BOARD_SIZE_WIDTH;

    let emojiList = getRandomList(cardAmount);
    shuffle(emojiList);

    emojiList = emojiList.sort(() => Math.random() - 0.5);


    const board = document.getElementById('board');
    for (let i = 0; i < cardAmount; i++) {
        const square = document.createElement('div');
        square.setAttribute('class', 'memory-card');
        square.setAttribute('id', ('card-' + i));
        square.setAttribute('card', emojiList[i].key);

        const inner = document.createElement('div');
        inner.setAttribute('class', 'card-inner')
        square.appendChild(inner)

        const value = document.createElement('div');
        value.setAttribute('class', 'card-front');
        value.innerText = emojiList[i].value;
        inner.appendChild(value);

        const back = document.createElement('div');
        back.setAttribute('class', 'card-back');
        inner.appendChild(back);

        square.addEventListener('click', (event) => {
            onClickCard(event.target);
        })


        board.appendChild(square);
    }
}

/*
Generates a list of emojis
 */
function getRandomList(size) {
    const arr = []

    for (let i = 0; i < size / 2; i++) {
        let emoji = getRandomEmoji();

        while (arr.filter(e => e.key === emoji.key).length > 0) {
            emoji = getRandomEmoji();
        }

        arr.push(...[emoji, emoji]);

    }

    return arr;
}

/*
Return a random emoji
 */
function getRandomEmoji() {
    let emoji;

    let pos;

    switch (CARD_TYPE) {
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

    if (emoji === undefined) {
        console.log('UNDEFINED EMOJI FOUND:')
        console.log(pos);
        console.log(emoji);
        console.log('----------------')
    }

    return {key: pos, value: emoji}
}


/*
Handle card click
 */
function onClickCard(target) {
    //Ignore already selected cards
    if (target.classList.contains('selected')) {
        return;
    }

    //In case you click on child retrieve the parent.
    if (target.classList.contains('memory-card')) {
        getCurrentPlayer().flipCard(target);
    } else {
        onClickCard(target.parentElement)
    }
}

async function resetSelectedCards(selectedCardA, selectedCardB) {
    document.getElementById(selectedCardA).setAttribute('class', 'memory-card')
    document.getElementById(selectedCardB).setAttribute('class', 'memory-card')
}

function win() {
    for (const player of TURN_DATA.players) {
        player.time.stop();

        console.log(player)
    }

    switch (PLAYER_AMOUNT) {
        case 1:
            const points = data.time.seconds() + data.moves * 3;
            addScore(points, getCurrentPlayer().username, getCurrentPlayer().moves, getCurrentPlayer().time.formattedTime())
            break;
    }
}

// -------------------------------------------
//                LEADER SCORE
// -------------------------------------------

const LEADER_BOARD = loadLeaderBoard();

function loadLeaderBoard() {
    function getCookie(cname) {
        let name = cname + "=";
        let ca = document.cookie.split(';');
        for(let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) === ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) === 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    let leaderBoard = getCookie('leaderboard')

    if (leaderBoard) {
        return JSON.parse(leaderBoard);
    } else {
        return {
            scores: []
        }
    }
}

function addScore(points, username, moves, time) {
    function setCookie(cname, cvalue, exdays) {
        const d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        let expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    const dateOptions = {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'};

    LEADER_BOARD.scores.push({
        points: points,
        username: username,
        moves: moves,
        time: time,
        date: new Date().toLocaleDateString('es-es', dateOptions),
    })

    setCookie('leaderboard', JSON.stringify(LEADER_BOARD), 365);
}