<?php
    include($_SERVER['DOCUMENT_ROOT']."/src/models/round.php");

    function returnError($msg,$round) {
        $error_msg = urlencode($msg);
        $query = http_build_query($round);
        header( "Location: http://{$_SERVER['HTTP_HOST']}?error=$error_msg&$query", true, 303 );
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $completedRound = Round::createInstance($_POST);

        if(!$completedRound->areUniqueNames()) {
            returnError("Player names must be unique.",$completedRound);
            exit();
        }

        $completedRound->advanceRound();

        $query = http_build_query($completedRound);

        header( "Location: http://{$_SERVER['HTTP_HOST']}?$query", true, 303 );
        exit();
    } else {
        returnError("An error occured. Please use the button at the bottom.",Round::createInstance([]));
        exit();
    }

