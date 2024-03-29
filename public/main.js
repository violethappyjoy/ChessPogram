class Square {
	constructor(x, y, width, color) {
		this.x = x;
		this.y = y;
		this.width  = width;
		this.color  = color;
	}
	draw(ctx) {
		ctx.fillStyle = this.color;
		ctx.fillRect(this.x, this.y, this.width, this.width);
	}
}

class Piece {
	constructor(x, y, width, height, type) {
		this.x = x;
		this.y = y;
		this.width  = width;
		this.height  = height;
		this.type  = type;
		this.active = false;
		this.img = document.getElementById("piece_" + this.type);
	}
	draw(ctx) {
		ctx.drawImage(
			this.img,
			this.x,
			this.y, 
			this.width, 
			this.height
		);
	}
}

mouse = {
	x: undefined,
	y: undefined,
	isdown: undefined
}

const canvas = document.getElementById('game-canvas');

canvas.width = 0.8 * Math.min(innerHeight, innerWidth);
canvas.height = 0.8 * Math.min(innerHeight, innerWidth);

squares = [];
for (let i = 0; i < 8; i++) {
	for (let j = 0; j < 8; j++) {
		squares.push(new Square(
			i * canvas.width / 8,
			j * canvas.width / 8, 
			canvas.width / 8,
			(i + j) % 2 === 0 ? "white" : "green"
		))
	}
}

function handleMouseMove(e) {
	var rect = e.target.getBoundingClientRect();
    var x = e.clientX - rect.left; //x position within the element.
    var y = e.clientY - rect.top;  //y position within the element.
    mouse.x = x;
    mouse.y = y;
}

function handleMouseDown(event) {
	mouse.isdown = true;
	pieces.push(new Piece(currentSquare.x, currentSquare.y, currentSquare.width, currentSquare.width, "king_b"))
}

function handleMouseUp(event) {
	mouse.isdown = false;
}

var currentSquare = undefined;

function updCurrentSquare() {
	for (var i = squares.length - 1; i >= 0; i--) {
		if (
			squares[i].x < mouse.x &&
			squares[i].y < mouse.y &&
			squares[i].x + squares[i].width >= mouse.x &&
			squares[i].y + squares[i].width >= mouse.y
		) {
			// console.log("ho")
			return squares[i];
		}
	}
	// console.log("hey")
}

canvas.addEventListener('mousemove', handleMouseMove)
canvas.addEventListener('mousedown', handleMouseDown)
canvas.addEventListener('mouseup', handleMouseUp)


pieces = [];

const ctx = canvas.getContext('2d');

function animationLoop() {
    currentSquare = updCurrentSquare();
    // console.log(currentSquare)
	for (var i = squares.length - 1; i >= 0; i--) {
		squares[i].draw(ctx);
	}
	for (var i = pieces.length - 1; i >= 0; i--) {
		pieces[i].draw(ctx);
	}
	requestAnimationFrame(animationLoop);
}

animationLoop()