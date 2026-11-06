<?php
$host_name = "localhost";
$user = "root";
$pass = "";
$database = "web_content_db";

// Connect to MySQL server
$conn_web = mysqli_connect($host_name, $user, $pass);
if (!$conn_web) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Alag se database create krna agar mojood na ho
mysqli_query($conn_web, "CREATE DATABASE IF NOT EXISTS `$database`");
mysqli_select_db($conn_web, $database);

// Table web_content create krna (sirf website-content.php ke inputs ke mutabiq)
$create_table = "CREATE TABLE IF NOT EXISTS `web_content` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `hero_headline` VARCHAR(255) NOT NULL,
    `hero_subtitle` VARCHAR(255) NOT NULL,
    `hero_lead` TEXT NOT NULL,
    `promo_headline` VARCHAR(255) NOT NULL,
    `promo_btn_text` VARCHAR(255) NOT NULL,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
mysqli_query($conn_web, $create_table);

// Pehli dafa default row insert krna agar table khali ho
$check_row = mysqli_query($conn_web, "SELECT * FROM `web_content` WHERE id = 1");
if ($check_row && mysqli_num_rows($check_row) == 0) {
    $insert_default = "INSERT INTO `web_content` (`id`, `hero_headline`, `hero_subtitle`, `hero_lead`, `promo_headline`, `promo_btn_text`) VALUES (
        1,
        'Step Into Uncompromising Refinement.',
        'Autumn / Winter 2026 Collection',
        'Handcrafted from full-grain Italian calfskin and Goodyear-welted for generations of distinction. Engineered for the modern Pakistani gentleman.',
        'The Goodyear Welted Oxford Experience',
        'Discover The Oxford'
    )";
    mysqli_query($conn_web, $insert_default);
}
?>
