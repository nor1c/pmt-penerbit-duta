<?php

// format from dd/mm/yyyy to yyyy-mm-dd
function convertDateFormat($date) {
    $explodedDate = explode('/', $date);

    $date = "$explodedDate[2]-$explodedDate[1]-$explodedDate[0]";

    return $date;
}

function catchQueryResult($errorMessage) {
    if (!$errorMessage && $errorMessage == '') {
        return array(
            "error" => false,
            "message" => "Operation success!",
        );
    }
    
    return errorResponse(($errorMessage));
}

function errorResponse($errorMessage) {
    return array(
        "error" => true,
        "message" => $errorMessage != '' ? $errorMessage : 'Operation failed, please try again later.'
    );
}

function getNextDay($date, $plusDayCount = 1) {
    $currentDate = new DateTime($date);

    $currentDate->modify("+$plusDayCount day");

    $nextDay = $currentDate->format('Y-m-d');

    return $nextDay;
}