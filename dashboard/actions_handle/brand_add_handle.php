<?php
require_once __DIR__ . "/../configs/session_check.php";
require_once __DIR__ . "/../configs/db_con.php";

// Jab Add Brand form submit ho
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_brand"])) {
    $brand_name = trim($_POST["brand_name"]);

    if (empty($brand_name)) {
        $_SESSION['error_msg'] = "Brand name is required!";
    } else {
        $brand_name = mysqli_real_escape_string($connection, $brand_name);

        // Duplication check: kya ye brand pehle se database mein hai?
        $check_query = "SELECT * FROM brands WHERE name = '$brand_name'";
        $check_result = mysqli_query($connection, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $_SESSION['error_msg'] = "Brand '$brand_name' already exists!";
        } else {
            // Database table mein insert krna
            $insert_query = "INSERT INTO brands (name) VALUES ('$brand_name')";
            if (mysqli_query($connection, $insert_query)) {
                $_SESSION['success_msg'] = "Brand '$brand_name' added successfully!";
            } else {
                $_SESSION['error_msg'] = "Failed to add brand!";
            }
        }
    }

    // Wapis brands.php page par redirect krna
    header("Location: ../brands.php");
    exit();
} else {
    header("Location: ../brands.php");
    exit();
}
?>

