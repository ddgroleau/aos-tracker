<?php
use Models\Round;
    require($_SERVER['DOCUMENT_ROOT']."/src/models/Round.php");

    $current_round =  Round::createInstance($_GET);
    $current_winner = $current_round->getCurrentWinner();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/main.css" />
    <title>AoS Battle Tracker</title>
</head>
<body>
    <main>
        <h1>AoS Battle Tracker</h1>
        <span class="error"><?=isset($_GET["error"]) ? urldecode($_GET["error"]) : null?></span>
        <?php if($current_round->round_number<=5) :?>
            <?php if($current_round->round_number !== 1) : ?>
            <h2>Current Winner: <?=$current_winner?></h2>
            <?php endif; ?>
        <h2>Round Number <input class="input-number" type="number" value="<?=$current_round->round_number?>" form="rounds" name="round_number"/></h2>
        <form id="rounds" method="POST" action="api/rounds.php">
            <section class="player-round-data">
                <div class="form-item">
                    <label for="p1_name">Player 1 Name:</label>
                    <input type="text" id="p1_name" name="p1_name" value="<?=$current_round->p1_name?>" required pattern="[a-zA-Z0-9]+"/>
                </div>
                <div class="form-item">
                    <label id="p1_cp">Command Points Player 1</label>
                    <input id="p1_cp" type="number" name="p1_cp" value="<?=$current_round->p1_cp?>" min="0" max="10">
                </div>
                <div class="form-item">
                    <label for="p1_vp">Victory Points Player 1</label>
                    <input id="p1_vp" type="number" name="p1_vp" value="<?=$current_round->p1_vp?>" min="0" max="10">
                </div>
                <h3>Player 1 VP Total: <input class="input-number" type="number" value="<?=$current_round->p1_vp_total?>" name="p1_vp_total" min="0" max="20"/></h3>
            </section>
            <section class="player-round-data">
                <div class="form-item">
                    <label for="p2_name">Player 2 Name:</label>
                    <input type="text" id="p2_name" name="p2_name" value="<?=$current_round->p2_name?>" required pattern="[a-zA-Z0-9]+"/>
                </div>
                <div class="form-item">
                    <label for="p2_cp">Command Points Player 2</label>
                    <input id="p2_cp" type="number" name="p2_cp" value="<?=$current_round->p2_cp?>" min="0" max="10"/>
                </div>
                <div class="form-item">
                    <label for="p2_vp">Victory Points Player 2</label>
                    <input id="p2_vp" type="number" name="p2_vp" value="<?=$current_round->p2_vp?>" min="0" max="10"/>
                </div>
                <h3>Player 2 VP Total: <input class="input-number" type="number" value="<?=$current_round->p2_vp_total?>" name="p2_vp_total" min="0" max="20"/></h3>
            </section>
        </form>
        <button form="rounds" type="submit">Advance to Next Round</button>
        <button form="rounds" type="reset" onclick="window.location.href=window.origin">Reset</button>
        <?php else :?>
            <h2>The winner is: <?=$current_winner?>!</h2>
            <img class="winner-image" src="/assets/media/wizard-hat.svg" height="200" width="200" alt="wizard hat" />
            <a class="link" href="/">Play Again</a>
        <?php endif; ?>
    </main>
</body>
</html>
