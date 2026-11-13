<?php
require_once __DIR__ . "/../configs/session_check.php";
require_once __DIR__ . "/../configs/db_con.php";

// Agar admins table mein phone ya avatar_url ka column na ho to auto-add krna
function ensure_admin_columns($connection) {
    $needed_columns = [
        'phone'      => "VARCHAR(30) NULL",
        'avatar_url' => "VARCHAR(255) NULL"
    ];

    $existing_cols = [];
    $col_query = mysqli_query($connection, "SHOW COLUMNS FROM `admins`");
    if ($col_query) {
        while ($col = mysqli_fetch_assoc($col_query)) {
            $existing_cols[] = strtolower($col['Field']);
        }
    }

    foreach ($needed_columns as $col_name => $col_def) {
        if (!in_array(strtolower($col_name), $existing_cols)) {
            mysqli_query($connection, "ALTER TABLE `admins` ADD COLUMN `$col_name` $col_def");
        }
    }
}

// Jab Profile Update form submit ho
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_profile"])) {

    ensure_admin_columns($connection);

    $admin_id = intval($_POST["admin_id"] ?? 0);
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $new_password = $_POST["new_password"] ?? "";
    $confirm_password = $_POST["confirm_password"] ?? "";

    // Validation
    if ($admin_id <= 0) {
        $_SESSION['error_msg'] = "Invalid administrator session!";
        header("Location: ../profile.php");
        exit();
    }

    if (empty($name) || empty($email)) {
        $_SESSION['error_msg'] = "Full Name and Email Address are required!";
        header("Location: ../profile.php");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_msg'] = "Please provide a valid email address!";
        header("Location: ../profile.php");
        exit();
    }

    // Email duplication check: kisi doosre admin ka ye email to nahi hai?
    $check_email = mysqli_prepare($connection, "SELECT id FROM `admins` WHERE email = ? AND id != ?");
    mysqli_stmt_bind_param($check_email, "si", $email, $admin_id);
    mysqli_stmt_execute($check_email);
    $check_res = mysqli_stmt_get_result($check_email);

    if (mysqli_num_rows($check_res) > 0) {
        $_SESSION['error_msg'] = "This email is already registered to another account!";
        header("Location: ../profile.php");
        exit();
    }

    // Password check (agar new password diya ho)
    $password_hash = null;
    if (!empty($new_password)) {
        if (strlen($new_password) < 6) {
            $_SESSION['error_msg'] = "Password must be at least 6 characters long!";
            header("Location: ../profile.php");
            exit();
        }

        if ($new_password !== $confirm_password) {
            $_SESSION['error_msg'] = "New password and Confirm password do not match!";
            header("Location: ../profile.php");
            exit();
        }

        $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
    }

    // Avatar upload handling
    $avatar_url = null;
    if (isset($_FILES["avatar"]) && $_FILES["avatar"]["error"] === 0) {
        $target_dir = __DIR__ . "/../images/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $extension = strtolower(pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

        if (in_array($extension, $allowed_extensions)) {
            $avatar_filename = "avatar_" . $admin_id . "_" . time() . "." . $extension;
            $target_file = $target_dir . $avatar_filename;

            if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
                $avatar_url = "images/" . $avatar_filename;
            } else {
                $_SESSION['error_msg'] = "Failed to upload avatar photo!";
                header("Location: ../profile.php");
                exit();
            }
        } else {
            $_SESSION['error_msg'] = "Invalid image format! Only JPG, PNG, WEBP, and GIF are allowed.";
            header("Location: ../profile.php");
            exit();
        }
    }

    // Dynamic UPDATE query build krna
    $sql = "UPDATE `admins` SET name = ?, email = ?, phone = ?";
    $params = [$name, $email, $phone];
    $types = "sss";

    if (!empty($avatar_url)) {
        $sql .= ", avatar_url = ?";
        $params[] = $avatar_url;
        $types .= "s";
    }

    if (!empty($password_hash)) {
        $sql .= ", password_hash = ?";
        $params[] = $password_hash;
        $types .= "s";
    }

    $sql .= " WHERE id = ?";
    $params[] = $admin_id;
    $types .= "i";

    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, $types, ...$params);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success_msg'] = "Admin profile updated successfully!";
    } else {
        $_SESSION['error_msg'] = "Database error: " . mysqli_error($connection);
    }

    header("Location: ../profile.php");
    exit();

} else {
    header("Location: ../profile.php");
    exit();
}
?>
