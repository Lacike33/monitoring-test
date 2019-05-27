<?php

// ********************************************
//                MAIN SCRIPT
// ********************************************

// Nastav timezonu pre Europu
setTimezone('Europe/Bratislava');

// Nastav konstanty
setConst($argv);

// Skontroluj ci uz nebezi script
checkRunningScript();

// len pre test aby som odchytil beziaci script
sleep(10);

// Skontroluj ci existuje subor
checkLogPath();

// koniec scriptu bez najdenej chyby
logToConsole('success', "Script '" . SCRIPT_NAME . "' uspesne dobehol. V logoch sa nenasla ziadna chyba.");

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

function checkRunningScript() {
    $runningCount = 0;
    exec("ps -af",$ps);
    foreach ($ps as $process) {
        mb_strpos($process, SCRIPT_NAME) ? $runningCount++ : null;
        if ($runningCount > 1) {
            // TODO: dorobit funkciu sendMail($message)
            logToConsole('error', "Script " . SCRIPT_NAME . " uz bezi. Error log monitor nemoze pokracovat v behu.");
            exit;
        }
    }
}

function checkLogPath()
{
    if (!file_exists(ERROR_LOG_FILE)) {
        logToConsole('error', "Subor s logmi " . ERROR_LOG_FILE . " neexistuje. Error log monitor nemoze pokracovat v behu.");
        exit;
    } else if (!is_readable(ERROR_LOG_FILE)) {
        logToConsole('error', "Subor s logmi " . ERROR_LOG_FILE . " nie je citatelny. Error log monitor nemoze pokracovat v behu.");
        exit;
    } else if (!is_writable(ERROR_LOG_FILE)) {
        logToConsole('error', "Subor s logmi " . ERROR_LOG_FILE . " nie je zapisovatelny. Error log monitor nemoze pokracovat v behu.");
        exit;
    } else {
        logToConsole('info', "Subor s logmi " . ERROR_LOG_FILE . " existuje. Error log monitor moze pokracovat v behu.");
    }
}