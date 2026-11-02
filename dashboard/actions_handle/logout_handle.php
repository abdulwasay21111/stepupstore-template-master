<?php
require_once __DIR__ . "/../configs/session_check.php";

$_SESSION = [];
session_destroy();
header("Location: ../login.php");
exit;
?>
