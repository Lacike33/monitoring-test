<?php

// ********************************************
//                MAIN SCRIPT
// ********************************************

// Nastav timezonu pre Europu
setTimezone('Europe/Bratislava');

// Nastav konstanty
setConst($argv);

// ********************************************
//                FUNCTIONS
// ********************************************
function setTimezone($timezone)
{
    date_default_timezone_set($timezone);
    logToConsole('info', "Timezone je nastavena pre lokaciu : " . $timezone);
}

function logToConsole($level, $message)
{
    $timestamp = date('Y-m-d H:i:s', time());

    echo "\n[" . $timestamp . '] [' . strtoupper($level) . '] :: ' . $message;
}

function setConst($argv)
{
    $email = "ladislav.valient@gmail.com";
    isset($argv[2]) ? define('ERROR_NOTIFY_EMAIL', $argv[2]) : define('ERROR_NOTIFY_EMAIL', $email);

    // Mailova adresa odosielatela
    define('ERROR_NOTIFY_FROM_EMAIL', 'sender@domain.com');
    // Meno odosielatela
    define('ERROR_NOTIFY_FROM_NAME', 'PHP Error Log Monitor');
    // Subject emailu
    define('ERROR_NOTIFY_SUBJECT', 'PHP error log report');
    // Nazov scriptu 'monitoring.php'
    define('SCRIPT_NAME', $argv[0]);
    // Cesta k log suboru nacitana z parametra
    define('ERROR_LOG_FILE', $argv[1]);

    logToConsole('info', "Vsetky konstanty su uspesne nastavene. Error log monitor moze pokracovat v behu.");
}