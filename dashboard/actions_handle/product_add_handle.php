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

    // 4. Variants form se get krna aur JSON banana
    $variant_sizes  = $_POST["variant_size"] ?? [];
    $variant_colors = $_POST["variant_color"] ?? [];
    $variant_skus   = $_POST["variant_sku"] ?? [];
    $variant_stocks = $_POST["variant_stock"] ?? [];

    $variants_array = [];
    $total_stock_qty = 0;

    for ($i = 0; $i < count($variant_sizes); $i++) {
        $v_size  = trim($variant_sizes[$i] ?? '');
        $v_color = trim($variant_colors[$i] ?? '');
        $v_sku   = trim($variant_skus[$i] ?? '');
        $v_stock = max(0, intval($variant_stocks[$i] ?? 0));

        if (!empty($v_size)) {
            $variants_array[] = [
                'size'  => $v_size,
                'color' => $v_color,
                'sku'   => $v_sku,
                'stock' => $v_stock
            ];
            $total_stock_qty += $v_stock;
        }
    }

    $variants_json = !empty($variants_array) ? json_encode($variants_array, JSON_UNESCAPED_UNICODE) : null;
    $variants_val = ($variants_json !== null) ? "'" . mysqli_real_escape_string($connection, $variants_json) . "'" : "NULL";

    // 5. Products table mein sari fields store krna (including variants and total stock)
    $insert_query = "INSERT INTO products (
        sku, name, slug, brand_id, category_id, price_pkr, original_price_pkr, cost_price_pkr, 
        stock_quantity, material, sole_type, occasion, short_description, description, variants, image_url, is_sale, is_new, status
    ) VALUES (
        '$sku', '$name', '$slug', '$brand_id', '$category_id', '$price_pkr', $orig_price_val, $cost_price_val, 
        '$total_stock_qty', '$material', '$sole_type', '$occasion', '$short_description', '$description', $variants_val, '$image_url', '$is_sale', '$is_new', '$status'
    )";

    if (mysqli_query($connection, $insert_query)) {
        $new_product_id = mysqli_insert_id($connection);

        // 6. Har variant ko product_variants table mein store krna
        if (!empty($variants_array)) {
            foreach ($variants_array as $v) {
                $v_size  = mysqli_real_escape_string($connection, $v['size']);
                $v_color = mysqli_real_escape_string($connection, $v['color']);
                $v_sku   = !empty($v['sku']) ? $v['sku'] : ($sku . '-' . $v['size']);
                $v_sku   = mysqli_real_escape_string($connection, $v_sku);
                $v_stock = intval($v['stock']);

                // Status check
                if ($v_stock <= 0) {
                    $v_status = 'Out of Stock';
                } elseif ($v_stock < 5) {
                    $v_status = 'Low Stock';
                } else {
                    $v_status = 'In Stock';
                }

                $var_query = "INSERT INTO product_variants 
                    (product_id, sku_variant, size_eu, color_name, stock_quantity, status)
                    VALUES 
                    ('$new_product_id', '$v_sku', '$v_size', '$v_color', '$v_stock', '$v_status')
                    ON DUPLICATE KEY UPDATE 
                    stock_quantity = VALUES(stock_quantity), 
                    status = VALUES(status)";
                mysqli_query($connection, $var_query);
            }
        }

        $_SESSION['success_msg'] = "Product '$name' added successfully with variants saved in product_variants table!";
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

