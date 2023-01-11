<?php
    use Models\Round;
    require($_SERVER['DOCUMENT_ROOT']."/src/models/Round.php");

    function returnError($msg,$round) {
        $error_msg = urlencode($msg);
        $query = http_build_query($round);
        header( "Location: http://{$_SERVER['HTTP_HOST']}?error=$error_msg&$query", true, 303 );
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $completed_round = Round::createInstance($_POST);

        if(!$completed_round->areUniqueNames()) {
            returnError("Player names must be unique.",$completed_round);
            exit();
        }

        $completed_round->advanceRound();

        $query = http_build_query($completed_round);

        header( "Location: http://{$_SERVER['HTTP_HOST']}?$query", true, 303 );
        exit();
    } else {
        returnError("An error occured. Please use the button at the bottom.",Round::createInstance([]));
        exit();
    }

