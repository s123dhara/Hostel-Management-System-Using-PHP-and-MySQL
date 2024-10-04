<?php
if (isset($_SESSION['is_admin_login'])) {
    return true;
} else {
    // unset($_SESSION['is_admin_login']);
    // // session_destroy();
    header("LOCATION:" . "/hms/error/403.php" );
    exit;
}
