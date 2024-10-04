<?php
include_once("config/config.php");

if($_SESSION['user']['isAdmin'] == 0) {
    unset($_SESSION['user']);
    session_destroy();
}else {
    unset($_SESSION['user']);
    session_destroy();
}

header("LOCATION: " . BASE_URL);
exit;
