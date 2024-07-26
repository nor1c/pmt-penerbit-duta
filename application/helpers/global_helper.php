<?php

// format from dd/mm/yyyy to yyyy-mm-dd
function convertDateFormat($date) {
    $explodedDate = explode('/', $date);

    $date = "$explodedDate[2]-$explodedDate[1]-$explodedDate[0]";

    return $date;
}

function getIndoDate($date) {
    return $date != '' ? date('d/m/Y', strtotime($date)) : '-';
}

function getIndoDateWithDay($date) {
    $formatter = new IntlDateFormatter(
        'id_ID',
        IntlDateFormatter::SHORT,
        IntlDateFormatter::NONE,
        null,
        null,
        'EEEE, dd/MM/yyyy'
    );
    
    // Format date
    return $date != '' ? $formatter->format(new DateTime($date)) : '-';
}

function catchQueryResult($errorMessage, $errorCode = 0) {
    if ($errorCode == '1451') {
        return errorResponse('Data tidak dapat dihapus karena sedang digunakan atau direferensikan oleh data pada modul lain. Harap melepas referensi terlebih dahulu jika ingin menghapus data ini.');
    }

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