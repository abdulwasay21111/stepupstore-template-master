<?php
require_once __DIR__ . "/../configs/session_check.php";
require_once __DIR__ . "/../configs/db_con.php";

// Jab Edit Product form submit ho
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_product"])) {

    $product_id = intval($_POST["product_id"] ?? 0);
    if ($product_id <= 0) {
        $_SESSION['error_msg'] = "Invalid Product ID!";
        header("Location: ../products.php");
        exit();
    }

    // 1. Form fields get krna
    $name = trim($_POST["name"] ?? "");
    $sku = trim($_POST["sku"] ?? "");
    $category_id = intval($_POST["category_id"] ?? 0);
    $brand_id = intval($_POST["brand_id"] ?? 0);
    $short_description = trim($_POST["short_description"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $price_pkr = floatval($_POST["price_pkr"] ?? 0);
    $original_price_pkr = !empty($_POST["original_price_pkr"]) ? floatval($_POST["original_price_pkr"]) : "NULL";
    $cost_price_pkr = !empty($_POST["cost_price_pkr"]) ? floatval($_POST["cost_price_pkr"]) : "NULL";
    $stock_quantity = intval($_POST["stock_quantity"] ?? 0);
    $material = trim($_POST["material"] ?? "");
    $sole_type = trim($_POST["sole_type"] ?? "");
    $occasion = trim($_POST["occasion"] ?? "");
    $status = $_POST["status"] ?? "Active";
    $is_sale = isset($_POST["is_sale"]) ? 1 : 0;
    $is_new = isset($_POST["is_new"]) ? 1 : 0;
    $existing_image = trim($_POST["existing_image"] ?? "");

    // Required fields check
    if (empty($name) || empty($sku) || $category_id <= 0 || $brand_id <= 0 || $price_pkr <= 0) {
        $_SESSION['error_msg'] = "Please fill all required fields (Product Name, SKU, Category, Brand, Price)!";
        header("Location: ../product-edit.php?id=" . $product_id);
        exit();
    }

    // SKU duplication check (exclude current product)
    $safe_sku = mysqli_real_escape_string($connection, $sku);
    $check_sku = mysqli_query($connection, "SELECT id FROM products WHERE sku = '$safe_sku' AND id != '$product_id'");
    if (mysqli_num_rows($check_sku) > 0) {
        $_SESSION['error_msg'] = "SKU Code '$sku' is already used by another product!";
        header("Location: ../product-edit.php?id=" . $product_id);
        exit();
    }

    // 2. Image handling (agar nayi image upload ki ho to save karo, warna purani rakho)
    $image_url = $existing_image;
    if (isset($_FILES["product_image"]) && $_FILES["product_image"]["error"] == 0) {
        $target_dir = __DIR__ . "/../images/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $image_name = time() . "_" . basename($_FILES["product_image"]["name"]);
        $target_file = $target_dir . $image_name;

        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
            $image_url = "images/" . $image_name;
        } else {
            $_SESSION['error_msg'] = "Failed to upload new product image!";
            header("Location: ../product-edit.php?id=" . $product_id);
            exit();
        }
    }

    // 3. Slug update
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
    $check_slug = mysqli_query($connection, "SELECT id FROM products WHERE slug = '$slug' AND id != '$product_id'");
    if (mysqli_num_rows($check_slug) > 0) {
        $slug = $slug . "-" . time();
    }

    // SQL escaping
    $name = mysqli_real_escape_string($connection, $name);
    $short_description = mysqli_real_escape_string($connection, $short_description);
    $description = mysqli_real_escape_string($connection, $description);
    $material = mysqli_real_escape_string($connection, $material);
    $sole_type = mysqli_real_escape_string($connection, $sole_type);
    $occasion = mysqli_real_escape_string($connection, $occasion);
    $status = mysqli_real_escape_string($connection, $status);
    $image_url = mysqli_real_escape_string($connection, $image_url);

    $orig_price_val = ($original_price_pkr === "NULL") ? "NULL" : "'$original_price_pkr'";
    $cost_price_val = ($cost_price_pkr === "NULL") ? "NULL" : "'$cost_price_pkr'";

    // 4. Update query
    $update_query = "UPDATE products SET 
        sku = '$safe_sku',
        name = '$name',
        slug = '$slug',
        brand_id = '$brand_id',
        category_id = '$category_id',
        price_pkr = '$price_pkr',
        original_price_pkr = $orig_price_val,
        cost_price_pkr = $cost_price_val,
        stock_quantity = '$stock_quantity',
        material = '$material',
        sole_type = '$sole_type',
        occasion = '$occasion',
        short_description = '$short_description',
        description = '$description',
        image_url = '$image_url',
        is_sale = '$is_sale',
        is_new = '$is_new',
        status = '$status'
        WHERE id = '$product_id'";

    if (mysqli_query($connection, $update_query)) {
        $_SESSION['success_msg'] = "Product '$name' updated successfully!";
        header("Location: ../products.php");
        exit();
    } else {
        $_SESSION['error_msg'] = "Database error: " . mysqli_error($connection);
        header("Location: ../product-edit.php?id=" . $product_id);
        exit();
    }

} else {
    header("Location: ../products.php");
    exit();
}
?>
