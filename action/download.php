<?php

    session_start();

    $jsonData = $_SESSION['jsonData'];
    $jsonData = json_encode($jsonData, true);

    echo $jsonData;
?>