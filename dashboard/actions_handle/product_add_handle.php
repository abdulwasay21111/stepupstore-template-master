<?php
require_once __DIR__ . "/../configs/session_check.php";
require_once __DIR__ . "/../configs/db_con.php";

// Jab Add Product form submit ho
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_product"])) {

    // 1. Form se sari fields get krna
    $name = trim($_POST["name"] ?? "");
    $sku = trim($_POST["sku"] ?? "");
    $category_id = intval($_POST["category_id"] ?? 0);
    $brand_id = intval($_POST["brand_id"] ?? 0);
    $short_description = trim($_POST["short_description"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $price_pkr = floatval($_POST["price_pkr"] ?? 0);
    $original_price_pkr = !empty($_POST["original_price_pkr"]) ? floatval($_POST["original_price_pkr"]) : "NULL";
    $cost_price_pkr = !empty($_POST["cost_price_pkr"]) ? floatval($_POST["cost_price_pkr"]) : "NULL";
    $material = trim($_POST["material"] ?? "");
    $sole_type = trim($_POST["sole_type"] ?? "");
    $occasion = trim($_POST["occasion"] ?? "");
    $status = $_POST["status"] ?? "Active";
    $is_sale = isset($_POST["is_sale"]) ? 1 : 0;
    $is_new = isset($_POST["is_new"]) ? 1 : 0;

    // Required fields check
    if (empty($name) || empty($sku) || $category_id <= 0 || $brand_id <= 0 || $price_pkr <= 0) {
        $_SESSION['error_msg'] = "Please fill all required fields (Product Name, SKU, Category, Brand, Price)!";
        header("Location: ../product-add.php");
        exit();
    }

    // SKU duplication check
    $sku = mysqli_real_escape_string($connection, $sku);
    $check_sku = mysqli_query($connection, "SELECT id FROM products WHERE sku = '$sku'");
    if (mysqli_num_rows($check_sku) > 0) {
        $_SESSION['error_msg'] = "SKU Code '$sku' already exists!";
        header("Location: ../product-add.php");
        exit();
    }

    // 2. Images ka folder banana aur image save krna
    $image_url = "";
    if (isset($_FILES["product_image"]) && $_FILES["product_image"]["error"] == 0) {

        // dashboard/images directory
        $target_dir = __DIR__ . "/../images/";

        // Agar images folder mojood nahi to bnao
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Image ka unique naam
        $image_name = time() . "_" . basename($_FILES["product_image"]["name"]);
        $target_file = $target_dir . $image_name;

        // Image ko folder mein move krna
        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
            $image_url = "images/" . $image_name;
        } else {
            $_SESSION['error_msg'] = "Failed to upload product image!";
            header("Location: ../product-add.php");
            exit();
        }
    } else {
        $_SESSION['error_msg'] = "Please select a product image!";
        header("Location: ../product-add.php");
        exit();
    }

    // 3. Simple Slug banana
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
    $check_slug = mysqli_query($connection, "SELECT id FROM products WHERE slug = '$slug'");
    if (mysqli_num_rows($check_slug) > 0) {
        $slug = $slug . "-" . time();
    }

    // Basic SQL escaping
    $name = mysqli_real_escape_string($connection, $name);
    $short_description = mysqli_real_escape_string($connection, $short_description);
    $description = mysqli_real_escape_string($connection, $description);
    $material = mysqli_real_escape_string($connection, $material);
    $sole_type = mysqli_real_escape_string($connection, $sole_type);
    $occasion = mysqli_real_escape_string($connection, $occasion);
    $status = mysqli_real_escape_string($connection, $status);

    $orig_price_val = ($original_price_pkr === "NULL") ? "NULL" : "'$original_price_pkr'";
    $cost_price_val = ($cost_price_pkr === "NULL") ? "NULL" : "'$cost_price_pkr'";

    // 4. Products table mein sari fields store krna (with Foreign Keys category_id, brand_id)
    $insert_query = "INSERT INTO products (
        sku, name, slug, brand_id, category_id, price_pkr, original_price_pkr, cost_price_pkr, 
        material, sole_type, occasion, short_description, description, image_url, is_sale, is_new, status
    ) VALUES (
        '$sku', '$name', '$slug', '$brand_id', '$category_id', '$price_pkr', $orig_price_val, $cost_price_val, 
        '$material', '$sole_type', '$occasion', '$short_description', '$description', '$image_url', '$is_sale', '$is_new', '$status'
    )";

    if (mysqli_query($connection, $insert_query)) {
        $_SESSION['success_msg'] = "Product '$name' added successfully and image saved in images folder!";
        header("Location: ../product-add.php");
        exit();
    } else {
        $_SESSION['error_msg'] = "Database error: " . mysqli_error($connection);
        header("Location: ../product-add.php");
        exit();
    }

} else {
    header("Location: ../product-add.php");
    exit();
}
?>

