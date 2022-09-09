// -------------------------------------------
// UPDATE BOARD SIZE
// -------------------------------------------
if (document.getElementById('pageIndex') != null) {
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
// MEMORY GAME
// -------------------------------------------

function initGame() {
    if (typeof BOARD_SIZE != "number" || typeof PLAYER_AMOUNT != "number") {
        console.error("couldn't start the game!");
        console.log(typeof BOARD_SIZE)
        console.log(typeof PLAYER_AMOUNT)
        return;
    }

    console.log("STARTING GAME")

    const boardElement = document.getElementById('board');

    const images = getImageList(BOARD_SIZE * BOARD_SIZE / 2)

    for (let i = 0; i < BOARD_SIZE; i++) {
        boardElement.innerHTML += getRow(images)
    }
}

function getRow(images) {
    let output = '<div class="row">';

    for (let i = 0; i < BOARD_SIZE; i++) {
        output += getImage(images);
    }

    output += '</div>'

    return output;

}

function getImage(images) {
    let pos = Math.random() * images.size;

    console.log(images)

    let content = images[pos];
    images.splice(pos, 1);

    return content;
}

function getImageList(amountImages) {
    let arr = [];

    for (let i = 0; i < amountImages; i++) {
        arr.push('<div>' +
            '<img src="https://via.placeholder.com/100" alt="100x100" id="image' + i + '"/>' +
            '</div>')
    }

    return arr;

}

