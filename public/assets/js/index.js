// -------------------------------------------
//             FORM PAGE
// -------------------------------------------

/**
 * Add event listeners to width and height radius to update the display.
 */
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

/**
 * Update the display with the value of the width and height radius.
 */
function updateBoardSize() {
    let sizeBoardLabel = document.getElementById('sizeBoardLabel');
    let sizeBoardWidth = document.getElementById('sizeBoardWidth').value;
    let sizeBoardHeight = document.getElementById('sizeBoardHeight').value;

    sizeBoardLabel.innerText = sizeBoardWidth + ' x ' + sizeBoardHeight;
}

/**
 * Display and set as required as many player name input
 * fields as necessary depending on the amount of players chosen.
 *
 * @param {number} playerAmount - Player Amount
 */
function updateRequirements(playerAmount) {
    for (let i = 1; i <= 4; i++) {
        if (i <= playerAmount) {
            console.log('show ' + i)
            document.getElementById('player-name-' + i).required = true;
            if (i === playerAmount && playerAmount % 2 !== 0) {
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