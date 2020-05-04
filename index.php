<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8" />
    <title>Gamedev Canvas Workshop</title>
    <style>
    	canvas { background: #eee; }
    </style>
</head>
<body>

<canvas id="myCanvas" width="480" height="320"></canvas>

<script>
	
	var canvas = document.getElementById("myCanvas");
	var ctx = canvas.getContext("2d");
	
	//defining default point and direction
	var x = canvas.width/2;
	var y = canvas.height/2;
	var dx = 2;
	var dy = -2;
	
	//defining ball size
	var ballRadius = 10;
	
	//defining paddle size
	var paddleHeight = 10;
	var paddleWidth = 75;
	var paddleX = (canvas.width-paddleWidth) / 2;
	
	//score counting, starting at zero
	var score = 0;
	
	//life counting
	var lives = 3;
	
	//vars to store keys status (pressed / unpressed)
	var rightPressed = false;
	var leftPressed = false;
	
	//bricks configuration
	var brickRowCount = 3;
	var brickColumnCount = 5;
	var brickWidth = 75;
	var brickHeight = 20;
	var brickPadding = 10;
	var brickOffsetTop = 30;
	var brickOffsetLeft = 30;
	
	//making a brick array
	var bricks = [];
	for(var c=0; c<brickColumnCount; c++) {
		bricks[c] = [];
		for(var r=0; r<brickRowCount; r++) {
			bricks[c][r] = { x: 0, y: 0, status: 1 };
		}
	}
	
	//Creating an event listener
	document.addEventListener("keydown", keyDownHandler, false);
	document.addEventListener("keyup", keyUpHandler, false);
	document.addEventListener("mousemove", mouseMoveHandler, false);
	
	//function to check if keys are pressed
	function keyDownHandler(e) {
		if(e.key == "Right" || e.key == "ArrowRight") {
			rightPressed = true;
		}
		else if(e.key == "Left" || e.key == "ArrowLeft") {
			leftPressed = true;
		}
	}

	//function to check if keys are being Unpressed
	function keyUpHandler(e) {
		if(e.key == "Right" || e.key == "ArrowRight") {
			rightPressed = false;
		}
		else if(e.key == "Left" || e.key == "ArrowLeft") {
			leftPressed = false;
		}
	}
	
	//function to check if mouse is moving
	function mouseMoveHandler(e) {
		var relativeX = e.clientX - canvas.offsetLeft;
		if(relativeX > 0 && relativeX < canvas.width) {
			paddleX = relativeX - paddleWidth/2;
		}
	}
	
	//if the ball colide on a brick
	function collisionDetection() {
		for(var c=0; c<brickColumnCount; c++) {
			for(var r=0; r<brickRowCount; r++) {
				var b = bricks[c][r];
				if(b.status == 1) {
					if(x > b.x && x < b.x+brickWidth && y > b.y && y < b.y+brickHeight) {
						dy = -dy;
						b.status = 0;
						score++;
						if(score == brickRowCount*brickColumnCount) {
							alert("YOU WIN, CONGRATULATIONS!");
							document.location.reload();
						}
					}
				}
			}
		}
	}
	
	//function to draw de ball on screen
	function drawBall() {
		ctx.beginPath();
		ctx.arc(x, y, ballRadius, 0, Math.PI*2);
		ctx.fillStyle = "#0095DD";
		ctx.fill();
		ctx.closePath();
	}
	
	//function do draw the paddle on screen
	function drawPaddle() {
		ctx.beginPath();
		ctx.rect(paddleX, canvas.height-paddleHeight, paddleWidth, paddleHeight);
		ctx.fillStyle = "#0095DD";
		ctx.fill();
		ctx.closePath();
	}
	
	//function to draw the bricks on screen
	function drawBricks() {
		for(var c=0; c<brickColumnCount; c++) {
			for(var r=0; r<brickRowCount; r++) {
				if(bricks[c][r].status == 1) {
					var brickX = (c*(brickWidth+brickPadding))+brickOffsetLeft;
					var brickY = (r*(brickHeight+brickPadding))+brickOffsetTop;
					bricks[c][r].x = brickX;
					bricks[c][r].y = brickY;
					ctx.beginPath();
					ctx.rect(brickX, brickY, brickWidth, brickHeight);
					ctx.fillStyle = "#0095DD";
					ctx.fill();
					ctx.closePath();
				}
			}
		}
	}
	
	//function to draw score on screen
	function drawScore() {
		ctx.font = "16px Arial";
		ctx.fillStyle = "#0095DD";
		ctx.fillText("Score: "+score, 8, 20);
	}
	
	//function to draw player's life on screen
	function drawLives() {
		ctx.font = "16px Arial";
		ctx.fillStyle = "#0095DD";
		ctx.fillText("Lives: "+lives, canvas.width-65, 20);
	}
	
	function draw() {
		ctx.clearRect(0, 0, canvas.width, canvas.height);
		drawBricks();
		drawBall();
		drawPaddle();
		drawScore();
		drawLives();
		collisionDetection();
		
		if(x + dx > canvas.width-ballRadius || x + dx < ballRadius) {
			dx = -dx;
		}
		if(y + dy < ballRadius) {
			dy = -dy;
		} else if(y + dy > canvas.height-ballRadius) {
			if(x > paddleX && x < paddleX + paddleWidth) {
				dy = -dy;
			}
			else {
				lives--;
				if(!lives) {
					alert("GAME OVER");
					document.location.reload();
				}
				else {
					x = canvas.width/2;
					y = canvas.height-30;
					dx = 2;
					dy = -2;
					paddleX = (canvas.width-paddleWidth)/2;
				}
			}
		}
		
		if(rightPressed && paddleX < canvas.width-paddleWidth) {
			paddleX += 7;
		}
		else if(leftPressed && paddleX > 0) {
			paddleX -= 7;
		}
		
		x += dx;
		y += dy;
		
		requestAnimationFrame(draw);
		
	}
	
	draw();
	
	
	
	
</script>

</body>
</html>