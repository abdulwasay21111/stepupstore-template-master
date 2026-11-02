<?php
require_once __DIR__ . "/../configs/session_check.php";
require_once __DIR__ . "/../configs/db_con.php";

$register_errors = [];

if($_SERVER["REQUEST_METHOD"] == "POST"){

// Details Variables
$accName = trim($_POST["fullName"]);
$accMail = trim($_POST["Email"]);
$accPass = ($_POST["password"]);
$accRole = trim($_POST["role"]);

if(empty($accMail) || empty($accPass)){
    $register_errors[] = "Email and Password are Required";
}
if(filter_var($accMail, FILTER_VALIDATE_EMAIL) == false){
    $register_errors[] = "Entered Email is Incorrect";
}

if(!empty($register_errors)){
    $_SESSION["registration_errors"] = $register_errors;
    header("Location: /../register.php");
    exit;
}

$query = mysqli_prepare($connection, "SELECT * from admins WHERE email = ?") ;
mysqli_stmt_bind_param($query, 's', $accMail);
mysqli_stmt_execute($query);

$query_result = mysqli_stmt_get_result($query);
// echo "<pre>";
// print_r( $query_result);
// echo "</pre>";
// exit;
if(mysqli_num_rows($query_result) > 0){
        $register_errors[] = "THis Email is already registered";
        $_SESSION["registration_errors"] = $register_errors;
       header("Location: /../register.php");
       exit;
}
 $safe_pass = password_hash($accPass, PASSWORD_DEFAULT);

 
$insertion_query = mysqli_prepare($connection, "INSERT INTO admins(name, email, password_hash) VALUES (?, ?, ?)");
mysqli_stmt_bind_param($insertion_query, 'sss', $accName, $accMail, $safe_pass);
mysqli_stmt_execute($insertion_query);

$_SESSION['success'] = "Email has been registered";
    header("Location: /../login.php");

  exit;
}