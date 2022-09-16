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

const TURN_DATA = {
    currentPlayer: 0,
    players: null,
    remainingCards: BOARD_SIZE_HEIGHT * BOARD_SIZE_WIDTH / 2,
    turn: null
}

function TurnTime(timeInSeconds) {
    let that = this;
    this.remaining = timeInSeconds;
    this.enabled = timeInSeconds > 0;

    this.start = function () {
        if (this.enabled) {
            console.log("Started timer: " + timeInSeconds)
            this.remainingTime = timeInSeconds;
            this.timeout = setInterval(step, 25)
        }
    }

    this.stop = function () {
        if (this.enabled) {
            clearTimeout(this.timeout);
        }
    }

    function step() {
        that.remainingTime -= 0.025

        if (that.remainingTime <= 0) {
            nextTurn();
        }

        document.getElementById('timer').innerText = that.remainingTime.toFixed(2);

    }
}


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
        function delay(milliseconds){
            return new Promise(resolve => {
                setTimeout(resolve, milliseconds);
            });
        }

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

function setupPlayers() {
    let playerData = [];

    for (let i = 0; i < PLAYER_AMOUNT; i++) {
        playerData.push(new PlayerData(PLAYER_NAMES[i], i + 1))
    }

    return playerData;
}

function nextTurn() {
    TURN_DATA.turn.stop();
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
    TURN_DATA.turn.start();
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

    TURN_DATA.players = setupPlayers();
    TURN_DATA.turn = new TurnTime(TIMER)

    for (let elementKey of document.querySelectorAll('div.memory-card')) {
        elementKey.addEventListener('click', (event) => {
            onClickCard(event.target);
        })
    }

    getCurrentPlayer().time.start();
    TURN_DATA.turn.start();
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

function resetSelectedCards(selectedCardA, selectedCardB) {
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
            const points = getCurrentPlayer().time.seconds() + getCurrentPlayer().moves * 3;
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
        for (let i = 0; i < ca.length; i++) {
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
        let expires = "expires=" + d.toUTCString();
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