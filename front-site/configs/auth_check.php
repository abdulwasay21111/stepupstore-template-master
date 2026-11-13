<?php
require_once __DIR__ . "/session_check.php";

if (!isset($_SESSION['id'])) {
    $register_errors = ["You are not logged in"];
    $_SESSION['registration_errors'] = $register_errors;
    header("Location: login.php");
    exit();
}
?>
