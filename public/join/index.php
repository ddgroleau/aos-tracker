<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/main.css" />
    <title>Join a Battle | AoS Battle Tracker</title>
</head>
<body>
    <main>
        <h1>Join a Battle</h1>
        <form method="GET" action="/api/battle-rounds.php">
            <div class="form-item">
                    <label for="battle_id">Battle ID:</label>
                    <input type="text" id="battle_id" name="battle_id" required pattern="[a-zA-Z0-9]+"/>
            </div>
            <button type="submit">Join Game</button>
        </form>
        <a href="/">Go to Home</a>
    </main>
</body>
</html>
