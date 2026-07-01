<?php
require __DIR__ . "/config.php";

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized Access");
}
?>
