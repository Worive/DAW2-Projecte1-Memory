// -------------------------------------------
//             UPDATE BOARD SIZE
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


// -------------------------------------------
//                MEMORY GAME
// -------------------------------------------

function Timer(interval) {
    let that = this;
    let expected, timeout;
    this.interval = interval;
    let seconds = 0;

    this.start = function() {
        expected = Date.now() + this.interval;
        timeout = setTimeout(step, this.interval);
    }

    this.stop = function() {
        clearTimeout(timeout);
    }

    this.formattedTime = formattedTime(seconds);

    function formattedTime(secs) {
        var sec_num = secs;
        var minutes = Math.floor(sec_num / 60);
        var seconds = sec_num - (minutes * 60);

        if (minutes < 10) {minutes = "0"+minutes;}
        if (seconds < 10) {seconds = "0"+seconds;}
        return minutes+':'+seconds;
    }

    function step() {
        seconds += 1;
        const drift = Date.now() - expected;
        timer.innerText = formattedTime(seconds);
        expected += that.interval;
        timeout = setTimeout(step, Math.max(0, that.interval-drift));
    }
}

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
    time: new Timer(1000)
}

/*
 Starts the game
 */
function initGame() {
    if (!validateData()) {
        console.error("[MEMORY] Invalid data provided. Game cannot start!");
        return;
    }

    setBoardSize();
    addCards();
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
    isValid = isValid && verifyNumberAndRange(PLAYER_AMOUNT, "PLAYER_AMOUNT", 1, 2);

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
        let currentIndex = array.length,  randomIndex;
        
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
    const pos = Math.floor(Math.random() * emojis.animals.length);

    let emoji = emojis.animals[pos];

    if (emoji === undefined) {
        console.log(pos);
        console.log(emoji);
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
        flipCard(target);
    } else {
        onClickCard(target.parentElement)
    }
}

/*
Flips card
 */
function flipCard(element) {
    function addClassToSelectedCards(className) {
        document.getElementById(data.selectedA).classList.add(className);
        document.getElementById(data.selectedB).classList.add(className);
    }

    const isSelected = element.classList.contains('selected');

    if (isSelected) {
        return;
    }

    switch (data.status) {
        case Status.idle:
            element.classList.add('selected');
            data.selectedA = element.getAttribute('id')
            data.status = Status.selected;
            break;
        case Status.selected:

            if (data.moves === 0) {
                data.time.start();
            }

            addMove()

            element.classList.add('selected');
            data.selectedB = element.getAttribute('id');

            if (document.getElementById(data.selectedA).getAttribute('card') === document.getElementById(data.selectedB).getAttribute('card')) {
                addClassToSelectedCards('found');
                addTotalPoint()
            } else {
                addClassToSelectedCards('wrong');

                const a = data.selectedA;
                const b = data.selectedB;

                setTimeout(() => resetSelectedCards(a, b), 800);
            }
            data.status = Status.idle;
            break;
    }
}

async function resetSelectedCards(selectedCardA, selectedCardB) {
    document.getElementById(selectedCardA).setAttribute('class', 'memory-card')
    document.getElementById(selectedCardB).setAttribute('class', 'memory-card')
}

function addTotalPoint() {
    data.total += 1;
    document.getElementById('total-counter').innerText = data.total;

    if (data.total === BOARD_SIZE_WIDTH * BOARD_SIZE_HEIGHT / 2) {
        win();
    }
}

function addMove() {
    data.moves += 1;
    document.getElementById('moves-counter').innerText = data.moves;
}

const timer = document.getElementById('time-counter');


function win() {
    data.time.stop();

    switch (PLAYER_AMOUNT) {
        case 1:
            addScore('guest', data.moves, data.time.formattedTime)
            break;
    }
}
// -------------------------------------------
//                LEADER SCORE
// -------------------------------------------

const LEADER_BOARD = loadLeaderBoard();

function loadLeaderBoard() {
    let leaderBoard = window.localStorage.getItem('leaderBoard');

    if (leaderBoard) {
        return leaderBoard;
    } else {
        return {
            scores: []
        }
    }
}

function addScore(username, moves, time) {
    LEADER_BOARD.scores.push({
        username: username,
        moves: moves,
        time: time,
        date: Date.now(),
    })
}