<?php
require_once __DIR__ . "/../configs/session_check.php";
require_once __DIR__ . "/../configs/db_con.php";

$register_errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $accName = trim($_POST["fullName"] ?? "");
    $accMail = trim($_POST["Email"] ?? "");
    $accPass = $_POST["password"] ?? "";
    $accRole = trim($_POST["role"] ?? "Manager");

    if (empty($accMail) || empty($accPass)) {
        $register_errors[] = "Email and Password are Required";
    }
    if (!filter_var($accMail, FILTER_VALIDATE_EMAIL)) {
        $register_errors[] = "Entered Email is Incorrect";
    }

    if (!empty($register_errors)) {
        $_SESSION["registration_errors"] = $register_errors;
        header("Location: ../register.php");
        exit;
    }

    $query = mysqli_prepare($connection, "SELECT * FROM admins WHERE email = ?");
    mysqli_stmt_bind_param($query, 's', $accMail);
    mysqli_stmt_execute($query);
    $query_result = mysqli_stmt_get_result($query);

    if (mysqli_num_rows($query_result) > 0) {
        $register_errors[] = "This Email is already registered";
        $_SESSION["registration_errors"] = $register_errors;
        header("Location: ../register.php");
        exit;
    }

    $safe_pass = password_hash($accPass, PASSWORD_DEFAULT);

    $insertion_query = mysqli_prepare($connection, "INSERT INTO admins(name, email, password_hash, role) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($insertion_query, 'ssss', $accName, $accMail, $safe_pass, $accRole);
    mysqli_stmt_execute($insertion_query);

    $_SESSION['success'] = "Account has been registered successfully";
    header("Location: ../login.php");
    exit;
}
?>
