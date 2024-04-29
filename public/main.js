var board = null
var game = new Chess()
var $status = $('#status')
var $fen = $('#fen')
var $pgn = $('#pgn')

function onDragStart (source, piece, position, orientation) {
  // do not pick up pieces if the game is over
  if (game.game_over()) return false

  // only pick up pieces for the side to move
  if ((game.turn() === 'w' && piece.search(/^b/) !== -1) ||
      (game.turn() === 'b' && piece.search(/^w/) !== -1)) {
    return false
  }
}

function onDrop (source, target) {
  // see if the move is legal
  var move = game.move({
    from: source,
    to: target,
    promotion: 'q' // NOTE: always promote to a queen for example simplicity
  })

  // illegal move
  if (move === null) return 'snapback'

  updateStatus()
}

// update the board position after the piece snap
// for castling, en passant, pawn promotion
function onSnapEnd () {
  board.position(game.fen())
}

function pgnToHtmlTable(pgn) {
    // Split the PGN string into individual moves
    const moves = pgn.split(/\d+\./).filter(move => move.trim() !== '');

    // Initialize the HTML table
    let html = '<table border="1"><tr><th>#</th><th>White</th><th>Black</th></tr>';

    // Loop through each move and generate table rows
    moves.forEach((move, index) => {
        const moveNumber = index + 1;
        const movePairs = move.trim().split(/\s+/);

        // Extract white and black moves
        const whiteMove = movePairs[0];
        const blackMove = movePairs[1] || '';

        // Append row to HTML table
        html += `<tr><td>${moveNumber}</td><td>${whiteMove}</td><td>${blackMove}</td></tr>`;
    });

    // Close the HTML table
    html += '</table>';

    return html;
}


function updateStatus () {
  var status = ''

  var moveColor = 'White'
  if (game.turn() === 'b') {
    moveColor = 'Black'
  }

  // checkmate?
  if (game.in_checkmate()) {
    status = 'Game over, ' + moveColor + ' is in checkmate.'
  }

  // draw?
  else if (game.in_draw()) {
    status = 'Game over, drawn position'
  }

  // game still on
  else {
    status = moveColor + ' to move'

    // check?
    if (game.in_check()) {
      status += ', ' + moveColor + ' is in check'
    }
  }

  $status.html(status)
  // $fen.html(game.fen())
  $pgn.html(pgnToHtmlTable(game.pgn()))
}

var config = {
  draggable: true,
  position: 'start',
  onDragStart: onDragStart,
  onDrop: onDrop,
  onSnapEnd: onSnapEnd
}
board = Chessboard('myBoard', config)

updateStatus()
