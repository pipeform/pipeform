
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>King of Coins</title>
    <style>
        body { margin: 0; overflow: hidden; background: #2b2b2b; }
        canvas { display: block; margin: 0 auto; background: #1e1e1e; }
    </style>
</head>
<body>
<canvas id="gameCanvas" width="800" height="600"></canvas>
<script>
    const canvas = document.getElementById('gameCanvas');
    const ctx = canvas.getContext('2d');

    const player = { x: 400, y: 500, width: 40, height: 40, speed: 5 };
    const bullets = [];
    const enemies = [];

    document.addEventListener('keydown', e => {
        if (e.key === 'ArrowLeft') player.x -= player.speed;
        if (e.key === 'ArrowRight') player.x += player.speed;
        if (e.key === ' ') bullets.push({ x: player.x + 17, y: player.y, speed: 7 });
    });

    function spawnEnemy() {
        enemies.push({ x: Math.random() * 760, y: 0, width: 40, height: 40, speed: 2 });
    }

    function update() {
        bullets.forEach(b => b.y -= b.speed);
        enemies.forEach(e => e.y += e.speed);

        // Collision detection
        for (let i = enemies.length - 1; i >= 0; i--) {
            const enemy = enemies[i];
            for (let j = bullets.length - 1; j >= 0; j--) {
                const bullet = bullets[j];
                if (
                    bullet.x < enemy.x + enemy.width &&
                    bullet.x + 6 > enemy.x &&
                    bullet.y < enemy.y + enemy.height &&
                    bullet.y + 12 > enemy.y
                ) {
                    enemies.splice(i, 1);
                    bullets.splice(j, 1);
                    break;
                }
            }
        }

        enemies.filter(e => e.y < canvas.height);
        bullets.filter(b => b.y > 0);
    }

    function draw() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.fillStyle = '#0f0';
        ctx.fillRect(player.x, player.y, player.width, player.height);

        ctx.fillStyle = '#ff0';
        bullets.forEach(b => ctx.fillRect(b.x, b.y, 6, 12));

        ctx.fillStyle = '#f00';
        enemies.forEach(e => ctx.fillRect(e.x, e.y, e.width, e.height));
    }

    function gameLoop() {
        update();
        draw();
        requestAnimationFrame(gameLoop);
    }

    setInterval(spawnEnemy, 1000);
    gameLoop();
</script>
</body>
</html>
