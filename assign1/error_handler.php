<?php
// Set custom error handler
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    $error_message = date('Y-m-d H:i:s') . " | Error [$errno] in $errfile on line $errline: $errstr" . PHP_EOL;
    error_log($error_message, 3, __DIR__ . '/error.log');
});

// ...existing code...
?>