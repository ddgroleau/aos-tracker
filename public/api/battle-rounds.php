<?php declare(strict_types=1);

use Core\Models\BattleRound;
use Core\Services\BattleRoundService;
require_once($_SERVER['DOCUMENT_ROOT']."/src/core/services/BattleRoundService.php");
require_once($_SERVER['DOCUMENT_ROOT']."/src/core/models/BattleRound.php");

function returnError($msg,$round):void {
    $error_msg = urlencode($msg);
    $query = http_build_query($round);
    header( "Location: http://{$_SERVER['HTTP_HOST']}?error=$error_msg&$query", true, 303 );
}

// Route: GET /api/battle-rounds/{battle_id}
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["battle_id"])) {
    $round_service = new BattleRoundService();
    $round = $round_service->getLatestRoundByBattleId($_GET["battle_id"]);
    if($round->battle_id === "") {
        returnError("No game with that Battle Id found.", $round);
    }
    $query = http_build_query($round);

    header( "Location: http://{$_SERVER['HTTP_HOST']}?$query", true, 303 );
    exit();
}

// Route: POST /api/battle-rounds
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $completed_round = BattleRound::createInstance($_POST);
    if(!$completed_round->areUniqueNames()) {
        returnError("Player names must be unique.",$completed_round);
        exit();
    }
    $completed_round->advanceRound();

    $round_service = new BattleRoundService();
    $round_created = $round_service->createBattleRound($completed_round);
    
    if(!$round_created) {
        returnError("Could not create battle round. Please try again.",$completed_round);
        exit();
    }

    $query = http_build_query($completed_round);

    header( "Location: http://{$_SERVER['HTTP_HOST']}?$query", true, 303 );
    exit();
} 

// No Matching Routes
else {
    returnError("An error occured. Please use the button at the bottom.",BattleRound::createInstance([]));
    exit();
}

