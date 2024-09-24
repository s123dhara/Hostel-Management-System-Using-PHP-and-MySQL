<?php
session_start();
if ($_SERVER['HTTP_HOST'] == 'localhost') {
    define("BASE_URL", "http://localhost/hms/");
    define("DIR_URL", $_SERVER['DOCUMENT_ROOT'] . "/hms/");

    define("SERVER_NAME", "localhost");
    define("USERNAME", "root");
    define("PASSWORD", "");
    define("DATABASE", "hms");
} else {
    define("BASE_URL", "https://lms.com");
    define("DIR_URL", $_SERVER['DOCUMENT_ROOT']);

    define("SERVER_NAME", "");
    define("USERNAME", "");
    define("PASSWORD", "");
    define("DATABASE", "");
}
