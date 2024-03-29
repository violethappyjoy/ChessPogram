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
			((i + j) % 2 === 0) ? ("white") : ("green")
		))
		console.log()
	}
}

for (var i = squares.length - 1; i >= 0; i--) {
	squares[i].draw(canvas.getContext('2d'))
}