<?php
require_once __DIR__ . "/../configs/session_check.php";
require_once __DIR__ . "/../configs/web_content_db.php";

// Jab website content form submit ho
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_web_content"])) {

    // website-content.php ke inputs se values get krna
    $hero_headline = trim($_POST["hero_headline"] ?? "");
    $hero_subtitle = trim($_POST["hero_subtitle"] ?? "");
    $hero_lead = trim($_POST["hero_lead"] ?? "");
    $promo_headline = trim($_POST["promo_headline"] ?? "");
    $promo_btn_text = trim($_POST["promo_btn_text"] ?? "");

    // Validation: Koi field khali na ho
    if (empty($hero_headline) || empty($hero_subtitle) || empty($hero_lead) || empty($promo_headline) || empty($promo_btn_text)) {
        $_SESSION["error_msg"] = "Please fill in all website content fields!";
        header("Location: ../website-content.php");
        exit();
    }

    // Check krna ke pehle se row mojood hai ya nahi
    $check_exists = mysqli_query($conn_web, "SELECT id FROM `web_content` WHERE id = 1");

    if (mysqli_num_rows($check_exists) > 0) {
        // Record update krna
        $stmt = mysqli_prepare($conn_web, "UPDATE `web_content` SET 
            `hero_headline` = ?, 
            `hero_subtitle` = ?, 
            `hero_lead` = ?, 
            `promo_headline` = ?, 
            `promo_btn_text` = ? 
            WHERE `id` = 1");
        mysqli_stmt_bind_param($stmt, "sssss", $hero_headline, $hero_subtitle, $hero_lead, $promo_headline, $promo_btn_text);
    } else {
        // Agar pehla record na ho to insert krna
        $stmt = mysqli_prepare($conn_web, "INSERT INTO `web_content` 
            (`id`, `hero_headline`, `hero_subtitle`, `hero_lead`, `promo_headline`, `promo_btn_text`) 
            VALUES (1, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssss", $hero_headline, $hero_subtitle, $hero_lead, $promo_headline, $promo_btn_text);
    }

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION["success_msg"] = "Website content updated successfully in web_content table!";
    } else {
        $_SESSION["error_msg"] = "Failed to update website content: " . mysqli_error($conn_web);
    }

    header("Location: ../website-content.php");
    exit();

} else {
    header("Location: ../website-content.php");
    exit();
}
?>
