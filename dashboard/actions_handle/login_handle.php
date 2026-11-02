<?php

require_once __DIR__ . "/../configs/session_check.php";
require_once __DIR__ . "/../configs/db_con.php";

$register_errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $accMail = trim($_POST["Email"] ?? "");
    $accPass = $_POST["password"] ?? "";

    if (empty($accMail) || empty($accPass)) {
        $register_errors[] = "Email and Password are Required";
    }

    if (!filter_var($accMail, FILTER_VALIDATE_EMAIL)) {
        $register_errors[] = "Entered Email is Incorrect";
    }

    if (!empty($register_errors)) {
        $_SESSION["registration_errors"] = $register_errors;
        header("Location: ../login.php");
        exit;
    }

    $query = mysqli_prepare($connection, "SELECT * FROM admins WHERE email = ?");
    mysqli_stmt_bind_param($query, 's', $accMail);
    mysqli_stmt_execute($query);
    $query_result = mysqli_stmt_get_result($query);

    if (mysqli_num_rows($query_result) == 0) {
        $register_errors[] = "This Email is not registered";
        $_SESSION["registration_errors"] = $register_errors;
        header("Location: ../login.php");
        exit;
    }

    $user = mysqli_fetch_assoc($query_result);

    // Database column is 'password_hash'
    $password_hash = $user["password_hash"] ?? $user["Pass"] ?? "";

    if (!password_verify($accPass, $password_hash)) {
        $register_errors[] = "Wrong Credentials";
        $_SESSION["registration_errors"] = $register_errors;
        header("Location: ../login.php");
        exit;
    }

    // Set session details
   $_SESSION["id"] = $user["id"];
header("Location: /../index.php");
exit;
}
?>
