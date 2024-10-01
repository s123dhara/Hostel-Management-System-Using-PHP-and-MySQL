<?php
include_once("config/config.php");
unset($_SESSION['user']);
session_destroy();
header("LOCATION: " . BASE_URL);
exit;
