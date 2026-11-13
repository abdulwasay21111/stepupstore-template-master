<?php
require_once __DIR__ . "/configs/session_check.php";
require_once __DIR__ . "/configs/db_con.php";

$error_msg = $_SESSION['error_msg'] ?? "";
$success_msg = $_SESSION['success_msg'] ?? "";
unset($_SESSION['error_msg'], $_SESSION['success_msg']);

// Agar delete product ki request ho
if (isset($_GET["delete_id"])) {
    $delete_id = intval($_GET["delete_id"]);
    if (mysqli_query($connection, "DELETE FROM products WHERE id = '$delete_id'")) {
        $_SESSION['success_msg'] = "Product deleted successfully!";
    } else {
        $_SESSION['error_msg'] = "Failed to delete product: " . mysqli_error($connection);
    }
    header("Location: products.php");
    exit();
}

// Database se products, categories aur brands nikalna (JOIN ke sath)
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$category_filter = isset($_GET['category']) ? trim($_GET['category']) : '';
$brand_filter = isset($_GET['brand']) ? trim($_GET['brand']) : '';

// Base query
$query = "SELECT products.*, categories.name AS category_name, brands.name AS brand_name 
          FROM products 
          LEFT JOIN categories ON products.category_id = categories.id 
          LEFT JOIN brands ON products.brand_id = brands.id 
          WHERE 1=1";

// Search bar filter (Name ya SKU ke mutabiq)
if (!empty($search)) {
    $safe_search = mysqli_real_escape_string($connection, $search);
    $query .= " AND (products.name LIKE '%$safe_search%' OR products.sku LIKE '%$safe_search%')";
}

// Category filter
if (!empty($category_filter)) {
    $safe_category = mysqli_real_escape_string($connection, $category_filter);
    $query .= " AND categories.id = '$safe_category'";
}

// Brand filter
if (!empty($brand_filter)) {
    $safe_brand = mysqli_real_escape_string($connection, $brand_filter);
    $query .= " AND brands.id = '$safe_brand'";
}

$query .= " ORDER BY products.id DESC";
$get_products = mysqli_query($connection, $query);

$products_list = [];
if ($get_products) {
    while ($p = mysqli_fetch_assoc($get_products)) {
        $products_list[] = $p;
    }
}
$total_products = count($products_list);

// Product variants table se fetch krna
$all_pv_res = mysqli_query($connection, "SELECT * FROM product_variants ORDER BY id ASC");
$pv_by_product = [];
if ($all_pv_res) {
    while ($pv_row = mysqli_fetch_assoc($all_pv_res)) {
        $pv_by_product[$pv_row['product_id']][] = $pv_row;
    }
}

$get_categories = mysqli_query($connection, "SELECT * FROM categories ORDER BY name ASC");
$get_brands = mysqli_query($connection, "SELECT * FROM brands ORDER BY name ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products | NOVA FORM Admin Dashboard</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="assets/css/dashboard.css">
  <link rel="stylesheet" href="assets/css/responsive.css">
</head>
<body>

  <div class="admin-wrapper">
    
    <!-- Admin Sidebar -->
   <?php require_once __DIR__ . '/parts/asidebar.php'; ?>

    <div class="admin-main">
      
      <!-- Topbar -->
      <header class="admin-topbar">
        <div class="d-flex align-items-center gap-3">
          <button class="btn btn-link text-dark p-0 d-lg-none" id="sidebarToggleBtn" aria-label="Toggle Navigation">
            <i class="bi bi-list fs-3"></i>
          </button>
          <div class="topbar-search">
            <i class="bi bi-search search-icon"></i>
            <input type="text" class="form-control" id="tableSearchInput" placeholder="Quick search inventory, orders...">
          </div>
        </div>

        <div class="topbar-actions">
          <a href="../front-site/index.php" target="_blank" class="btn btn-sm btn-outline-secondary d-none d-md-inline-flex align-items-center gap-1">
            <i class="bi bi-eye"></i> View Site
          </a>
          
          <div class="dropdown">
            <a href="#" class="topbar-icon-btn" data-bs-toggle="dropdown" aria-expanded="false" title="Notifications">
              <i class="bi bi-bell"></i>
              <span class="topbar-badge-dot"></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="min-width: 280px;">
              <li><h6 class="dropdown-header text-uppercase small fw-bold">Recent Alerts</h6></li>
              <li><a class="dropdown-item small py-2" href="orders.php"><i class="bi bi-bag-check text-success me-2"></i> New Order received</a></li>
              <li><a class="dropdown-item small py-2" href="inventory.php"><i class="bi bi-exclamation-triangle text-warning me-2"></i> Low stock alerts</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-center small text-primary fw-semibold" href="orders.php">View All Notifications</a></li>
            </ul>
          </div>

          <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-dark" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=200&auto=format&fit=crop" class="admin-avatar me-2" alt="Admin">
              <div class="d-none d-sm-block text-start">
                <div class="fw-semibold small leading-none">M. Asif</div>
                <div class="text-muted" style="font-size: 0.7rem;">Store Director</div>
              </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
              <li><a class="dropdown-item" href="profile.php"><i class="bi bi-person me-2 text-muted"></i> My Profile</a></li>
              <li><a class="dropdown-item" href="settings.php"><i class="bi bi-gear me-2 text-muted"></i> Store Settings</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger" href="actions_handle/logout_handle.php"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
            </ul>
          </div>
        </div>
      </header>

      <main class="admin-content">
        
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
          <div>
            <h1 class="page-title">Footwear Inventory Catalog</h1>
            <p class="page-subtitle">Manage <strong><?= $total_products ?></strong> active footwear models, pricing in PKR, sizes, and stock availability.</p>
          </div>
          <div class="d-flex gap-2">
            <a href="product-add.php" class="btn btn-sm btn-dark">
              <i class="bi bi-plus-lg me-1"></i> Add New Product
            </a>
          </div>
        </div>

        <!-- Alerts -->
        <?php if (!empty($success_msg)) { ?>
          <div class="alert alert-success py-2 mb-3">
            <i class="bi bi-check-circle me-1"></i> <?= $success_msg ?>
          </div>
        <?php } ?>

        <?php if (!empty($error_msg)) { ?>
          <div class="alert alert-danger py-2 mb-3">
            <i class="bi bi-exclamation-triangle me-1"></i> <?= $error_msg ?>
          </div>
        <?php } ?>

        <!-- Filters & Search Toolbar -->
        <div class="admin-card mb-4">
          <div class="admin-card-body p-3">
            <form method="GET" action="products.php">
              <div class="row g-2 align-items-center">
                <div class="col-md-4">
                  <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search by name, SKU or model..." value="<?= htmlspecialchars($search) ?>">
                  </div>
                </div>
                <div class="col-md-3">
                  <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    <?php if ($get_categories) { foreach ($get_categories as $cat) { ?>
                      <option value="<?= $cat['id'] ?>" <?= ($category_filter == $cat['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['name']) ?>
                      </option>
                    <?php }} ?>
                  </select>
                </div>
                <div class="col-md-3">
                  <select name="brand" class="form-select">
                    <option value="">All Brands</option>
                    <?php if ($get_brands) { foreach ($get_brands as $brand) { ?>
                      <option value="<?= $brand['id'] ?>" <?= ($brand_filter == $brand['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($brand['name']) ?>
                      </option>
                    <?php }} ?>
                  </select>
                </div>
                <div class="col-md-2 d-flex gap-1">
                  <button type="submit" class="btn btn-dark btn-sm flex-grow-1">Filter</button>
                  <?php if (!empty($search) || !empty($category_filter) || !empty($brand_filter)) { ?>
                    <a href="products.php" class="btn btn-outline-secondary btn-sm" title="Clear Filters"><i class="bi bi-arrow-counterclockwise"></i></a>
                  <?php } ?>
                </div>
              </div>
            </form>
          </div>
        </div>

        <!-- Products Table -->
        <div class="admin-card">
          <div class="admin-table-wrap">
            <table class="admin-table">
              <thead>
                <tr>
                  <th width="40"><input type="checkbox" id="selectAllRows" class="form-check-input"></th>
                  <th>Product</th>
                  <th>SKU</th>
                  <th>Category</th>
                  <th>Brand</th>
                  <th>Selling Price</th>
                  <th>Variants (Sizes)</th>
                  <th>Stock</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody class="filterable-table-body">
                <?php if ($total_products > 0) { ?>
                  <?php foreach ($products_list as $row) { ?>
                    <tr>
                      <td><input type="checkbox" class="form-check-input row-select-check"></td>
                      <td>
                        <div class="d-flex align-items-center gap-3">
                          <?php if (!empty($row['image_url'])) { ?>
                            <img src="<?= htmlspecialchars($row['image_url']) ?>" class="rounded-1" style="width: 44px; height: 44px; object-fit: cover;" alt="<?= htmlspecialchars($row['name']) ?>">
                          <?php } else { ?>
                            <div class="rounded-1 bg-light d-flex align-items-center justify-content-center text-muted border" style="width: 44px; height: 44px;">
                              <i class="bi bi-image fs-5"></i>
                            </div>
                          <?php } ?>
                          <div>
                            <div class="fw-semibold text-dark"><?= htmlspecialchars($row['name']) ?></div>
                            <small class="text-muted"><?= htmlspecialchars($row['brand_name'] ?? 'No Brand') ?></small>
                          </div>
                        </div>
                      </td>
                      <td><code><?= htmlspecialchars($row['sku']) ?></code></td>
                      <td><?= htmlspecialchars($row['category_name'] ?? 'Uncategorized') ?></td>
                      <td><span class="badge bg-light text-dark border"><?= htmlspecialchars($row['brand_name'] ?? 'No Brand') ?></span></td>
                      <td class="fw-bold">PKR <?= number_format($row['price_pkr']) ?></td>
                      <td>
                        <?php 
                        $db_vars = $pv_by_product[$row['id']] ?? [];
                        if (!empty($db_vars)) {
                            echo '<div class="d-flex flex-wrap gap-1" style="max-width: 220px;">';
                            foreach ($db_vars as $v) {
                                $v_size = htmlspecialchars($v['size_eu']);
                                $v_stock = intval($v['stock_quantity']);
                                $v_color = htmlspecialchars($v['color_name']);
                                echo "<span class='badge bg-light text-dark border' style='font-size: 0.72rem;' title='Color: {$v_color} | Stock: {$v_stock} pairs'>{$v_size} <span class='text-muted'>({$v_stock})</span></span>";
                            }
                            echo '</div>';
                        } else {
                            $v_list = !empty($row['variants']) ? json_decode($row['variants'], true) : [];
                            if (!empty($v_list) && is_array($v_list)) {
                                echo '<div class="d-flex flex-wrap gap-1" style="max-width: 220px;">';
                                foreach ($v_list as $v) {
                                    $v_size = htmlspecialchars($v['size'] ?? '');
                                    $v_stock = intval($v['stock'] ?? 0);
                                    $v_color = htmlspecialchars($v['color'] ?? '');
                                    echo "<span class='badge bg-light text-dark border' style='font-size: 0.72rem;' title='Color: {$v_color} | Stock: {$v_stock} pairs'>{$v_size} <span class='text-muted'>({$v_stock})</span></span>";
                                }
                                echo '</div>';
                            } else {
                                echo "<span class='text-muted small'>Standard</span>";
                            }
                        }
                        ?>
                      </td>
                      <td>
                        <span class="badge bg-light text-dark border">
                          <?= $row['stock_quantity'] ?> pairs
                        </span>
                      </td>
                      <td>
                        <span class="badge-status badge-status-success"><?= htmlspecialchars($row['status']) ?></span>
                      </td>
                      <td>
                        <div class="d-flex gap-1">
                          <!-- View Button (Modal Trigger) -->
                          <button type="button" class="btn btn-sm btn-outline-primary py-1 px-2" data-bs-toggle="modal" data-bs-target="#viewProductModal<?= $row['id'] ?>" title="View Product Details">
                            <i class="bi bi-eye"></i>
                          </button>
                          <!-- Edit Button -->
                          <a href="product-edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-dark py-1 px-2" title="Edit Product">
                            <i class="bi bi-pencil"></i>
                          </a>
                          <!-- Delete Button -->
                          <a href="products.php?delete_id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger py-1 px-2" onclick="return confirm('Are you sure you want to delete this product: <?= htmlspecialchars(addslashes($row['name'])) ?>?');" title="Delete product">
                            <i class="bi bi-trash"></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                  <?php } ?>
                <?php } else { ?>
                  <tr>
                    <td colspan="10" class="text-center py-5 text-muted">
                      <i class="bi bi-box-seam fs-1 d-block mb-2 text-secondary opacity-50"></i>
                      <p class="mb-2 fw-semibold">No products found in database.</p>
                      <a href="product-add.php" class="btn btn-sm btn-dark">
                        <i class="bi bi-plus-lg me-1"></i> Add Your First Product
                      </a>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>

          <!-- Table Footer -->
          <div class="p-3 border-top d-flex justify-content-between align-items-center">
            <span class="small text-muted">Showing <strong><?= $total_products ?></strong> products</span>
          </div>
        </div>

        <!-- Product View Modals -->
        <?php if ($total_products > 0) { ?>
          <?php foreach ($products_list as $row) { ?>
            <div class="modal fade" id="viewProductModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="viewModalLabel<?= $row['id'] ?>" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 shadow">
                  <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title fs-6 fw-bold" id="viewModalLabel<?= $row['id'] ?>">
                      <i class="bi bi-box-seam me-2"></i><?= htmlspecialchars($row['name']) ?>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body p-4">
                    <div class="row g-4">
                      <!-- Product Image & Quick Badges -->
                      <div class="col-md-5 text-center">
                        <?php if (!empty($row['image_url'])) { ?>
                          <img src="<?= htmlspecialchars($row['image_url']) ?>" class="img-fluid rounded border shadow-sm w-100 mb-3" style="max-height: 280px; object-fit: cover;" alt="<?= htmlspecialchars($row['name']) ?>">
                        <?php } else { ?>
                          <div class="rounded bg-light border d-flex flex-column align-items-center justify-content-center text-muted mb-3" style="height: 250px;">
                            <i class="bi bi-image fs-1 mb-2 opacity-50"></i>
                            <small>No image uploaded</small>
                          </div>
                        <?php } ?>
                        
                        <div class="d-flex flex-wrap gap-1 justify-content-center">
                          <span class="badge bg-dark">SKU: <?= htmlspecialchars($row['sku']) ?></span>
                          <span class="badge bg-secondary"><?= htmlspecialchars($row['status']) ?></span>
                          <?php if (!empty($row['is_sale'])) { ?>
                            <span class="badge bg-danger">ON SALE</span>
                          <?php } ?>
                          <?php if (!empty($row['is_new'])) { ?>
                            <span class="badge bg-success">NEW ARRIVAL</span>
                          <?php } ?>
                        </div>
                      </div>
                      
                      <!-- Product Specs & Details -->
                      <div class="col-md-7">
                        <h4 class="fw-bold mb-1"><?= htmlspecialchars($row['name']) ?></h4>
                        <div class="text-muted small mb-3">
                          <span><strong>Brand:</strong> <?= htmlspecialchars($row['brand_name'] ?? 'No Brand') ?></span> &bull; 
                          <span><strong>Category:</strong> <?= htmlspecialchars($row['category_name'] ?? 'Uncategorized') ?></span>
                        </div>

                        <!-- Price & Stock Highlights -->
                        <div class="p-3 bg-light rounded border mb-3">
                          <div class="row text-center">
                            <div class="col-4 border-end">
                              <div class="text-muted small">Selling Price</div>
                              <div class="fw-bold text-dark fs-6">PKR <?= number_format($row['price_pkr']) ?></div>
                            </div>
                            <div class="col-4 border-end">
                              <div class="text-muted small">Retail Price</div>
                              <div class="text-muted small"><?= !empty($row['original_price_pkr']) ? 'PKR ' . number_format($row['original_price_pkr']) : '-' ?></div>
                            </div>
                            <div class="col-4">
                              <div class="text-muted small">Stock Level</div>
                              <div class="fw-bold text-success fs-6"><?= $row['stock_quantity'] ?> pairs</div>
                            </div>
                          </div>
                        </div>

                        <!-- Attributes Table -->
                        <table class="table table-sm table-bordered small mb-3">
                          <tbody>
                            <tr>
                              <th class="bg-light" style="width: 38%;">Upper Material</th>
                              <td><?= !empty($row['material']) ? htmlspecialchars($row['material']) : '<span class="text-muted">Not specified</span>' ?></td>
                            </tr>
                            <tr>
                              <th class="bg-light">Sole Construction</th>
                              <td><?= !empty($row['sole_type']) ? htmlspecialchars($row['sole_type']) : '<span class="text-muted">Not specified</span>' ?></td>
                            </tr>
                            <tr>
                              <th class="bg-light">Occasion</th>
                              <td><?= !empty($row['occasion']) ? htmlspecialchars($row['occasion']) : '<span class="text-muted">Not specified</span>' ?></td>
                            </tr>
                            <?php if (!empty($row['cost_price_pkr'])) { ?>
                            <tr>
                              <th class="bg-light">Cost Price (Internal)</th>
                              <td>PKR <?= number_format($row['cost_price_pkr']) ?></td>
                            </tr>
                            <?php } ?>
                          </tbody>
                        </table>

                        <!-- Variants Breakdown -->
                        <?php 
                        $db_modal_variants = $pv_by_product[$row['id']] ?? [];
                        if (!empty($db_modal_variants)) {
                        ?>
                          <div class="mb-3">
                            <div class="fw-bold small text-muted mb-2">Variant Sizes & Stock Breakdown:</div>
                            <div class="table-responsive">
                              <table class="table table-sm table-bordered small text-center mb-0">
                                <thead class="table-light">
                                  <tr>
                                    <th>Size</th>
                                    <th>Color</th>
                                    <th>Variant SKU</th>
                                    <th>Stock</th>
                                    <th>Status</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php foreach ($db_modal_variants as $mv) { ?>
                                    <tr>
                                      <td class="fw-bold"><?= htmlspecialchars($mv['size_eu'] ?? '') ?></td>
                                      <td><?= htmlspecialchars($mv['color_name'] ?? '-') ?></td>
                                      <td><code><?= htmlspecialchars($mv['sku_variant'] ?? '-') ?></code></td>
                                      <td class="fw-bold text-success"><?= intval($mv['stock_quantity'] ?? 0) ?> pairs</td>
                                      <td><span class="badge bg-light text-dark border"><?= htmlspecialchars($mv['status'] ?? 'In Stock') ?></span></td>
                                    </tr>
                                  <?php } ?>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        <?php } elseif (!empty($row['variants'])) { 
                          $modal_variants = json_decode($row['variants'], true);
                          if (!empty($modal_variants) && is_array($modal_variants)) {
                        ?>
                          <div class="mb-3">
                            <div class="fw-bold small text-muted mb-2">Variant Sizes & Stock Breakdown:</div>
                            <div class="table-responsive">
                              <table class="table table-sm table-bordered small text-center mb-0">
                                <thead class="table-light">
                                  <tr>
                                    <th>Size</th>
                                    <th>Color</th>
                                    <th>Variant SKU</th>
                                    <th>Stock</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php foreach ($modal_variants as $mv) { ?>
                                    <tr>
                                      <td class="fw-bold"><?= htmlspecialchars($mv['size'] ?? '') ?></td>
                                      <td><?= htmlspecialchars($mv['color'] ?? '-') ?></td>
                                      <td><code><?= htmlspecialchars($mv['sku'] ?? '-') ?></code></td>
                                      <td class="fw-bold text-success"><?= intval($mv['stock'] ?? 0) ?> pairs</td>
                                    </tr>
                                  <?php } ?>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        <?php } } ?>

                        <?php if (!empty($row['short_description'])) { ?>
                          <div class="mb-2">
                            <div class="fw-bold small text-muted">Short Description:</div>
                            <p class="small text-secondary mb-0"><?= nl2br(htmlspecialchars($row['short_description'])) ?></p>
                          </div>
                        <?php } ?>

                        <?php if (!empty($row['description'])) { ?>
                          <div class="mb-2">
                            <div class="fw-bold small text-muted">Craftsmanship Details:</div>
                            <p class="small text-secondary mb-0" style="max-height: 100px; overflow-y: auto;"><?= nl2br(htmlspecialchars($row['description'])) ?></p>
                          </div>
                        <?php } ?>

                      </div>
                    </div>
                  </div>
                  <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="product-edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-dark">
                      <i class="bi bi-pencil me-1"></i> Edit Product
                    </a>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
        <?php } ?>
      
      </main>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/dashboard.js"></script>
</body>
</html>
