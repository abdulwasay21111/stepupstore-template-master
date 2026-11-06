<?php
require_once __DIR__ . "/configs/session_check.php";
require_once __DIR__ . "/configs/db_con.php";

$error_msg = $_SESSION['error_msg'] ?? "";
$success_msg = $_SESSION['success_msg'] ?? "";
unset($_SESSION['error_msg'], $_SESSION['success_msg']);

// Product ID check
$product_id = intval($_GET['id'] ?? 0);
if ($product_id <= 0) {
    $_SESSION['error_msg'] = "Invalid Product ID!";
    header("Location: products.php");
    exit();
}

// Database se product data nikalna
$stmt = mysqli_prepare($connection, "SELECT * FROM products WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $product_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    $_SESSION['error_msg'] = "Product with ID #$product_id not found!";
    header("Location: products.php");
    exit();
}

// Categories aur Brands list
$get_categories = mysqli_query($connection, "SELECT * FROM categories ORDER BY name ASC");
$get_brands = mysqli_query($connection, "SELECT * FROM brands ORDER BY name ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Product | NOVA FORM Admin Dashboard</title>
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
            <h1 class="page-title">Edit Footwear: <?= htmlspecialchars($product['name']) ?></h1>
            <p class="page-subtitle">Product ID: #<?= $product['id'] ?> &bull; SKU: <code><?= htmlspecialchars($product['sku']) ?></code> &bull; Last updated: <?= $product['updated_at'] ?></p>
          </div>
          <div class="d-flex gap-2">
            <a href="products.php" class="btn btn-sm btn-outline-secondary">
              <i class="bi bi-arrow-left me-1"></i> Back to Products
            </a>
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

        <form action="actions_handle/product_edit_handle.php" method="POST" enctype="multipart/form-data">
          <!-- Hidden Inputs -->
          <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
          <input type="hidden" name="existing_image" value="<?= htmlspecialchars($product['image_url']) ?>">

          <div class="row g-4">
            
            <!-- Left Column: Primary Details -->
            <div class="col-lg-8">
              
              <!-- Basic Information -->
              <div class="admin-card mb-4">
                <div class="admin-card-header"><h5 class="admin-card-title">1. Basic Information</h5></div>
                <div class="admin-card-body">
                  <div class="row g-3">
                    <div class="col-md-8">
                      <label class="form-label small fw-bold">Product Name *</label>
                      <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($product['name']) ?>" required>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label small fw-bold">SKU Code *</label>
                      <input type="text" name="sku" class="form-control" value="<?= htmlspecialchars($product['sku']) ?>" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label small fw-bold">Category *</label>
                      <select name="category_id" class="form-select" required>
                        <option value="">Select Category</option>
                        <?php if ($get_categories) { foreach ($get_categories as $cat) { ?>
                          <option value="<?= $cat['id'] ?>" <?= ($cat['id'] == $product['category_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                          </option>
                        <?php }} ?>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label small fw-bold">Atelier Brand *</label>
                      <select name="brand_id" class="form-select" required>
                        <option value="">Select Brand</option>
                        <?php if ($get_brands) { foreach ($get_brands as $brand) { ?>
                          <option value="<?= $brand['id'] ?>" <?= ($brand['id'] == $product['brand_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($brand['name']) ?>
                          </option>
                        <?php }} ?>
                      </select>
                    </div>
                    <div class="col-12">
                      <label class="form-label small fw-bold">Short Silhouette Description</label>
                      <textarea name="short_description" class="form-control" rows="2"><?= htmlspecialchars($product['short_description'] ?? '') ?></textarea>
                    </div>
                    <div class="col-12">
                      <label class="form-label small fw-bold">Full Craftsmanship Description</label>
                      <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Pricing & Inventory -->
              <div class="admin-card mb-4">
                <div class="admin-card-header"><h5 class="admin-card-title">2. Pricing & Stock in Pakistani Rupee (PKR)</h5></div>
                <div class="admin-card-body">
                  <div class="row g-3">
                    <div class="col-md-4">
                      <label class="form-label small fw-bold">Selling Price (PKR) *</label>
                      <input type="number" step="0.01" name="price_pkr" class="form-control" value="<?= htmlspecialchars($product['price_pkr']) ?>" required>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label small fw-bold">Original / Retail Price (PKR)</label>
                      <input type="number" step="0.01" name="original_price_pkr" class="form-control" value="<?= htmlspecialchars($product['original_price_pkr'] ?? '') ?>">
                    </div>
                    <div class="col-md-4">
                      <label class="form-label small fw-bold">Cost of Goods (Internal PKR)</label>
                      <input type="number" step="0.01" name="cost_price_pkr" class="form-control" value="<?= htmlspecialchars($product['cost_price_pkr'] ?? '') ?>">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label small fw-bold">Current Stock Quantity (Pairs)</label>
                      <input type="number" name="stock_quantity" class="form-control" value="<?= htmlspecialchars($product['stock_quantity'] ?? 0) ?>">
                    </div>
                  </div>
                </div>
              </div>

            </div>

            <!-- Right Column: Images & Meta -->
            <div class="col-lg-4">
              
              <!-- Image Upload & Preview Box -->
              <div class="admin-card mb-4">
                <div class="admin-card-header"><h5 class="admin-card-title">Product Imagery</h5></div>
                <div class="admin-card-body text-center">
                  
                  <!-- Current Image Display -->
                  <div class="mb-3">
                    <div class="small fw-bold text-muted mb-1">Current Image:</div>
                    <?php if (!empty($product['image_url'])) { ?>
                      <img src="<?= htmlspecialchars($product['image_url']) ?>" class="img-thumbnail rounded" style="width: 140px; height: 140px; object-fit: cover;" alt="<?= htmlspecialchars($product['name']) ?>">
                    <?php } else { ?>
                      <div class="rounded bg-light border d-inline-flex flex-column align-items-center justify-content-center text-muted" style="width: 140px; height: 140px;">
                        <i class="bi bi-image fs-1 opacity-50"></i>
                        <small>No Image</small>
                      </div>
                    <?php } ?>
                  </div>

                  <!-- Change Image Area -->
                  <div class="img-upload-box mb-3" onclick="document.getElementById('fileInputEdit').click();" style="cursor: pointer;">
                    <i class="bi bi-cloud-arrow-up display-6 text-muted mb-1 d-inline-block"></i>
                    <div class="fw-semibold small">Click to change/replace image</div>
                    <div class="text-muted" style="font-size: 0.72rem;">PNG, JPG up to 5MB (Leaves current image if empty)</div>
                    <input type="file" name="product_image" id="fileInputEdit" class="d-none product-image-input" data-preview-target="editImagePreviewContainer" accept="image/*">
                  </div>

                  <!-- Preview container for new upload -->
                  <div id="editImagePreviewContainer" class="d-flex flex-wrap gap-2 justify-content-center"></div>

                </div>
              </div>

              <!-- Product Specifications -->
              <div class="admin-card mb-4">
                <div class="admin-card-header"><h5 class="admin-card-title">Footwear Attributes</h5></div>
                <div class="admin-card-body">
                  <div class="mb-3">
                    <label class="form-label small fw-bold">Upper Material</label>
                    <input type="text" name="material" class="form-control form-control-sm" value="<?= htmlspecialchars($product['material'] ?? '') ?>">
                  </div>
                  <div class="mb-3">
                    <label class="form-label small fw-bold">Sole Construction</label>
                    <input type="text" name="sole_type" class="form-control form-control-sm" value="<?= htmlspecialchars($product['sole_type'] ?? '') ?>">
                  </div>
                  <div class="mb-3">
                    <label class="form-label small fw-bold">Occasion</label>
                    <input type="text" name="occasion" class="form-control form-control-sm" value="<?= htmlspecialchars($product['occasion'] ?? '') ?>">
                  </div>
                </div>
              </div>

              <!-- Status & Badges -->
              <div class="admin-card mb-4">
                <div class="admin-card-header"><h5 class="admin-card-title">Publishing Flags</h5></div>
                <div class="admin-card-body">
                  <div class="mb-3">
                    <label class="form-label small fw-bold">Status</label>
                    <select name="status" class="form-select form-select-sm">
                      <option value="Active" <?= ($product['status'] == 'Active') ? 'selected' : '' ?>>Active (Visible in Store)</option>
                      <option value="Draft" <?= ($product['status'] == 'Draft') ? 'selected' : '' ?>>Draft</option>
                      <option value="Archived" <?= ($product['status'] == 'Archived') ? 'selected' : '' ?>>Archived</option>
                      <option value="Out of Stock" <?= ($product['status'] == 'Out of Stock') ? 'selected' : '' ?>>Out of Stock</option>
                    </select>
                  </div>

                  <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="is_sale" value="1" id="flagOnSale" <?= (!empty($product['is_sale'])) ? 'checked' : '' ?>>
                    <label class="form-check-label small" for="flagOnSale">Show On Sale Tag</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="is_new" value="1" id="flagNewArrival" <?= (!empty($product['is_new'])) ? 'checked' : '' ?>>
                    <label class="form-check-label small" for="flagNewArrival">New Arrival Tag</label>
                  </div>
                </div>
              </div>

              <!-- Action Buttons -->
              <div class="d-flex flex-column gap-2">
                <button type="submit" name="update_product" class="btn btn-dark w-100 py-2"><i class="bi bi-check-lg me-1"></i> Update Footwear Model</button>
                <a href="products.php" class="btn btn-outline-secondary w-100">Cancel & Return</a>
              </div>

            </div>

          </div>
        </form>
      
      </main>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/dashboard.js"></script>
</body>
</html>
