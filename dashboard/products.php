<?php
require_once __DIR__ . "/configs/db_con.php";

// Agar delete product ki request ho
if (isset($_GET["delete_id"])) {
    $delete_id = intval($_GET["delete_id"]);
    mysqli_query($connection, "DELETE FROM products WHERE id = '$delete_id'");
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
$total_products = $get_products ? mysqli_num_rows($get_products) : 0;

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
          <a href="../front-site/index.html" target="_blank" class="btn btn-sm btn-outline-secondary d-none d-md-inline-flex align-items-center gap-1">
            <i class="bi bi-eye"></i> View Site
          </a>
          
          <div class="dropdown">
            <a href="#" class="topbar-icon-btn" data-bs-toggle="dropdown" aria-expanded="false" title="Notifications">
              <i class="bi bi-bell"></i>
              <span class="topbar-badge-dot"></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="min-width: 280px;">
              <li><h6 class="dropdown-header text-uppercase small fw-bold">Recent Alerts</h6></li>
              <li><a class="dropdown-item small py-2" href="orders.html"><i class="bi bi-bag-check text-success me-2"></i> New Order #NF-88291 received (PKR 14,999)</a></li>
              <li><a class="dropdown-item small py-2" href="inventory.html"><i class="bi bi-exclamation-triangle text-warning me-2"></i> Low stock: Sahara Suede Chukka (9 left)</a></li>
              <li><a class="dropdown-item small py-2" href="reviews.html"><i class="bi bi-star text-primary me-2"></i> New 5-star review pending approval</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-center small text-primary fw-semibold" href="orders.html">View All Notifications</a></li>
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
              <li><a class="dropdown-item" href="profile.html"><i class="bi bi-person me-2 text-muted"></i> My Profile</a></li>
              <li><a class="dropdown-item" href="settings.html"><i class="bi bi-gear me-2 text-muted"></i> Store Settings</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger" href="login.html"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
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
                  <th>Stock</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody class="filterable-table-body">
                <?php if ($get_products && mysqli_num_rows($get_products) > 0) { ?>
                  <?php foreach ($get_products as $row) { ?>
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
                        <span class="badge bg-light text-dark border">
                          <?= $row['stock_quantity'] ?> pairs
                        </span>
                      </td>
                      <td>
                        <span class="badge-status badge-status-success"><?= htmlspecialchars($row['status']) ?></span>
                      </td>
                      <td>
                        <div class="d-flex gap-1">
                          <a href="products.php?delete_id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger py-1 px-2" onclick="return confirm('Are you sure you want to delete this product?');" title="Delete product">
                            <i class="bi bi-trash"></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                  <?php } ?>
                <?php } else { ?>
                  <tr>
                    <td colspan="9" class="text-center py-5 text-muted">
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
      
      </main>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/dashboard.js"></script>
</body>
</html>
