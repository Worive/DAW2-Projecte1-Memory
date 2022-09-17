// -------------------------------------------
//                MEMORY GAME
// -------------------------------------------

/**
 * Possibles Player Status.
 * @readonly
 * @enum
 * @type {{idle: (Status|number), selected: (Status|number)}}
 */
const Status = {
    idle: 0,
    selected: 1,
}

/**
 * Self adjusting timer automatically updating the timer display.
 *
 * @param {number} player - Player ID to select which timer display to edit.
 */
function SelfAdjustingTimer(player) {
    let that = this;
    let expected, timeout;
    this.interval = 1000;
    let seconds = 0;

    /**
     * Starts the timer and define the expected time of end.
     */
    this.start = function () {
        expected = Date.now() + this.interval;
        timeout = setTimeout(step, this.interval);
    }

    /**
     * Clears the timeout.
     */
    this.stop = function () {
        clearTimeout(timeout);
    }

    /**
     * Returns the seconds formatted.
     *
     * @returns {string} - Time format in MM:SS
     */
    this.formattedTime = function () {
        return formattedTime(seconds);
    }

    /**
     * Return the actual seconds.
     *
     * @returns {number} Seconds elapsed
     */
    this.seconds = function () {
        return seconds;
    }

    /**
     * Format a number (in seconds) and format it MM:SS
     *
     * @param {number} secs - Seconds elapsed.
     * @returns {string} Time formatted in MM:SS.
     */
    function formattedTime(secs) {
        const sec_num = secs;
        let minutes = Math.floor(sec_num / 60);
        let seconds = sec_num - (minutes * 60);

        if (minutes < 10) {
            minutes = "0" + minutes;
        }
        if (seconds < 10) {
            seconds = "0" + seconds;
        }
        return minutes + ':' + seconds;
    }

    /**
     * Increase the time and self adjust the timeout to not be delayed/forward due of latency.
     * Also updates the time counter with the formattedTime.
     */
    function step() {
        seconds += 1;
        const drift = Date.now() - expected;
        document.getElementById('time-counter-' + player).innerText = formattedTime(seconds);
        expected += that.interval;
        timeout = setTimeout(step, Math.max(0, that.interval - drift));
    }
}

/**
 * A class representing the Player Data.
 *
 * @property {string} username - Username of the player
 * @property {number} id - ID of the player
 * @property {number} moves - Moves done by the player
 * @property {number} cards - Pair of cards found.
 * @property {SelfAdjustingTimer} time - Time taken by each player during their turns.
 * @property {{first: string, second: string}} selectedCards - Object containing the 2 possible selected cards of a player.
 */
class PlayerData {
    /**
     * PlayerData's constructor
     *
     * @constructor
     * @param {string} username - Username of the player.
     * @param {number} id - ID of the player.
     */
    constructor(username, id) {
        this.username = username;
        this.id = id;
        this.moves = 0;
        this.cards = 0;
        this.time = new SelfAdjustingTimer(id);

        this.selectedCards = {
            first: null,
            second: null
        }

        this.status = Status.idle;

    }

    /**
     * Handle the flip card action.
     *
     * @param {Element} card - Card Element
     */
    flipCard(card) {
        switch (this.status) {
            case Status.idle:
                this.flipFirstCard(card)
                break;
            case Status.selected:
                this.flipSecondCard(card)
                changeTurn();
        }

    }

    /**
     * Select the first card and change the status.
     *
     * @param {Element} card - Card Element
     */
    flipFirstCard(card) {
        card.classList.add('selected');
        this.selectedCards.first = card.getAttribute('id');
        this.status = Status.selected;
    }

    /**
     * Selects the second card and compare the 2 cards.
     *
     * @param {Element} card - Card Element
     */
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

    /**
     * Update total cards and the game reasoning's cards.
     */
    addTotalPoints() {
        this.cards += 1;
        GAME_DATA.remainingCards -= 1;
        document.getElementById('remaining-pairs').innerText = '' + GAME_DATA.remainingCards;
        document.getElementById('total-counter-' + this.id).innerText = this.cards;
    }


    /**
     * Add moves to the counter and player data.
     */
    addMove() {
        this.moves += 1;
        document.getElementById('moves-counter-' + this.id).innerText = this.moves;
    }


    /**
     * Add a specific class to the selected cards.
     *
     * @param {string} className - Class Name to be added.
     */
    addClassToSelectedCards(className) {
        document.getElementById(this.selectedCards.first).classList.add(className);
        document.getElementById(this.selectedCards.second).classList.add(className);
    }


}

/**
 * Game data
 *
 * @type {{currentPlayer: number, players: PlayerData[], turn: Timer, remainingCards: number}}
 */
const GAME_DATA = {
    currentPlayer: FIRST_PLAYER,
    players: setupPlayers(),
    remainingCards: BOARD_SIZE_HEIGHT * BOARD_SIZE_WIDTH / 2,
    turn: new Timer(TIMER)
}

/**
 * Timer of time remaining for each player's turn.
 *
 * @param {number} timeInSeconds - Time in seconds.
 */
function Timer(timeInSeconds) {
    let that = this;

    this.enabled = timeInSeconds > 0; // disable the timer if the time is 0 or less.

    /**
     * Start the timer if enabled.
     */
    this.start = function () {
        if (this.enabled) {
            this.remainingTime = timeInSeconds;
            this.timeout = setInterval(step, 25)
        }
    }

    /**
     * Stops the timer if enabled
     */
    this.stop = function () {
        if (this.enabled) {
            clearTimeout(this.timeout);
        }
    }

    /**
     * Reduce the remaining time and proceed with next turn. Updating the timer display.
     */
    function step() {
        that.remainingTime -= 0.025

        if (that.remainingTime <= 0) {
            changeTurn();
        }

        document.getElementById('timer').innerText = that.remainingTime.toFixed(2);
    }
}

/**
 * Setup player data with their name.
 *
 * @returns {PlayerData[]}
 */
function setupPlayers() {
    let playerData = [];

    for (let i = 0; i < PLAYER_AMOUNT; i++) {
        playerData.push(new PlayerData(PLAYER_NAMES[i], i + 1))
    }

    return playerData;
}

/**
 * Change the turn.
 */
function changeTurn() {
    GAME_DATA.turn.stop();
    console.log(`NEW TURN`)
    if (GAME_DATA.remainingCards <= 0) {
        console.log(`WON`)
        win();
        return
    }

    if (GAME_DATA.currentPlayer === PLAYER_AMOUNT - 1) {
        GAME_DATA.currentPlayer = 0;
    } else {
        GAME_DATA.currentPlayer += 1;
    }

    document.getElementById('current-player').innerText = getCurrentPlayer().username;

    getCurrentPlayer().time.start()
    GAME_DATA.turn.start();
}


/**
 * Returns the currents turn's player.
 *
 * @returns {PlayerData}
 */
function getCurrentPlayer() {
    return GAME_DATA.players[GAME_DATA.currentPlayer];
}

/**
 * Start the game.
 *
 * 1. Validate data
 * 2. Add events listeners to cards.
 * 3. Start player's timer and turn.
 */
function initGame() {
    if (!validateData()) {
        console.error("[MEMORY] Invalid data provided. Game cannot start!");
        return;
    }

    for (let elementKey of document.querySelectorAll('div.memory-card')) {
        elementKey.addEventListener('click', (event) => {
            onClickCard(event.target);
        })
    }

    getCurrentPlayer().time.start();
    GAME_DATA.turn.start();
}

/**
 * Validate if the provided data is valid.
 *
 * @returns {boolean}
 */
function validateData() {

    /**
     * Validate if a specific num is between the minRange and maxRange.
     *
     * @param {number} num - Number checked
     * @param {string} name - Name in case of error.
     * @param {number} minRange - Minimum range of number, included.
     * @param {number} maxRange - Maximum range of number, included
     * @returns {boolean} If every data is valid.
     */
    function verifyNumberAndRange(num, name, minRange, maxRange) {
        if (typeof num != "number") {
            console.warn(`[DATA VALIDATION] ${name} is not a number: ${typeof num}`);
            return false;
        } else if (num < minRange || num > maxRange) {
            console.warn(`[DATA VALIDATION] ${name} is out of allowed range (${minRange}-${maxRange}): ${num}`);
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

/**
 * Handle click event on cards.
 *
 * @param {Element} target Card element
 */
function onClickCard(target) {
    // Ignore already selected cards
    if (target.classList.contains('selected')) {
        return;
    }

    // In case you click on child retrieve the parent.
    if (target.classList.contains('memory-card')) {
        getCurrentPlayer().flipCard(target);
    } else {
        onClickCard(target.parentElement)
    }
}

/**
 * Reset the classes of the selected cards.
 *
 * @param {string} selectedCardA - First Selected Card
 * @param {string} selectedCardB - Second Selected Card
 */
function resetSelectedCards(selectedCardA, selectedCardB) {
    document.getElementById(selectedCardA).setAttribute('class', 'memory-card')
    document.getElementById(selectedCardB).setAttribute('class', 'memory-card')
}

/**
 * Handle the win.
 */
function win() {
    for (const player of GAME_DATA.players) {
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

/**
 * LeaderBoard of scores.
 *
 * @type {{scores: {points: number, username: string, moves: number, time: string, date: string}}}
 */
const LEADER_BOARD = loadLeaderBoard();

/**
 * Load the leaderboard from cookies
 *
 * @returns {{scores: {
 *     points: number,
 *     username: string,
 *     moves: number,
 *     time: string,
 *     date: string
 * }}}
 */
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

/**
 * Add score to leaderboard and save it in cookies.
 *
 * @param {number} points - Score of player
 * @param {string} username - Player's username
 * @param {number} moves - Total of player's moves
 * @param {string} time - Time taken to win.
 */
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