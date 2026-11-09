<?php
require_once __DIR__ . "/configs/session_check.php";
require_once __DIR__ . "/configs/db_con.php";

$success_msg = $_SESSION['success_msg'] ?? "";
$error_msg = $_SESSION['error_msg'] ?? "";
unset($_SESSION['success_msg'], $_SESSION['error_msg']);

// Stock Adjustment Form Handle (Simple & Generic PHP)
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adjust_stock'])) {
    $product_id  = intval($_POST['product_id'] ?? 0);
    $variant_id  = intval($_POST['variant_id'] ?? 0);
    $adjust_type = $_POST['adjust_type'] ?? 'add';
    $quantity    = max(1, intval($_POST['quantity'] ?? 0));
    $reason      = mysqli_real_escape_string($connection, trim($_POST['reason'] ?? ''));

    if ($product_id > 0) {
        if ($variant_id > 0) {
            // Specific variant stock adjustment
            $v_row = mysqli_fetch_assoc(mysqli_query($connection, "SELECT stock_quantity FROM product_variants WHERE id = '$variant_id' AND product_id = '$product_id'"));
            $cur_v_stock = $v_row ? intval($v_row['stock_quantity']) : 0;
            $new_v_stock = ($adjust_type === 'add') ? ($cur_v_stock + $quantity) : max(0, $cur_v_stock - $quantity);
            $v_status = ($new_v_stock <= 0) ? 'Out of Stock' : (($new_v_stock < 5) ? 'Low Stock' : 'In Stock');
            mysqli_query($connection, "UPDATE product_variants SET stock_quantity = '$new_v_stock', status = '$v_status' WHERE id = '$variant_id'");

            // Update total stock on products table
            $sum_res = mysqli_fetch_assoc(mysqli_query($connection, "SELECT SUM(stock_quantity) as total FROM product_variants WHERE product_id = '$product_id'"));
            $new_total = intval($sum_res['total'] ?? 0);
            mysqli_query($connection, "UPDATE products SET stock_quantity = '$new_total' WHERE id = '$product_id'");
        } else {
            // Base product stock adjustment
            $p_row = mysqli_fetch_assoc(mysqli_query($connection, "SELECT stock_quantity FROM products WHERE id = '$product_id'"));
            $cur_p_stock = $p_row ? intval($p_row['stock_quantity']) : 0;
            $new_p_stock = ($adjust_type === 'add') ? ($cur_p_stock + $quantity) : max(0, $cur_p_stock - $quantity);
            mysqli_query($connection, "UPDATE products SET stock_quantity = '$new_p_stock' WHERE id = '$product_id'");
        }

        $_SESSION['success_msg'] = "Stock adjustment successfully recorded!";
        header("Location: inventory.php");
        exit();
    }
}

// Search & Filter Inputs
$search        = isset($_GET['search']) ? trim($_GET['search']) : '';
$status_filter = isset($_GET['status_filter']) ? trim($_GET['status_filter']) : '';

// Base query joining products, categories and brands
$sql = "SELECT p.*, c.name AS category_name, b.name AS brand_name 
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        LEFT JOIN brands b ON p.brand_id = b.id
        WHERE 1=1";

if (!empty($search)) {
    $safe_s = mysqli_real_escape_string($connection, $search);
    $sql .= " AND (p.name LIKE '%$safe_s%' OR p.sku LIKE '%$safe_s%')";
}

if ($status_filter === 'in') {
    $sql .= " AND p.stock_quantity > p.low_stock_threshold";
} elseif ($status_filter === 'low') {
    $sql .= " AND p.stock_quantity <= p.low_stock_threshold AND p.stock_quantity > 0";
} elseif ($status_filter === 'out') {
    $sql .= " AND p.stock_quantity <= 0";
}

$sql .= " ORDER BY p.id DESC";
$products_res = mysqli_query($connection, $sql);
$products_list = $products_res ? mysqli_fetch_all($products_res, MYSQLI_ASSOC) : [];

// Fetch all variants grouped by product_id from product_variants table
$all_variants_res = mysqli_query($connection, "SELECT * FROM product_variants ORDER BY id ASC");
$variants_by_prod = [];
if ($all_variants_res) {
    while ($vr = mysqli_fetch_assoc($all_variants_res)) {
        $variants_by_prod[$vr['product_id']][] = $vr;
    }
}

// Inventory Metrics
$total_products = count($products_list);
$stat_units_res = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COALESCE(SUM(stock_quantity), 0) AS total_units FROM products"));
$total_units = intval($stat_units_res['total_units'] ?? 0);

$low_stock_res = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) AS total FROM products WHERE stock_quantity <= low_stock_threshold AND stock_quantity > 0"));
$low_stock_count = intval($low_stock_res['total'] ?? 0);

$out_stock_res = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) AS total FROM products WHERE stock_quantity <= 0"));
$out_stock_count = intval($out_stock_res['total'] ?? 0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventory Tracking | NOVA FORM Admin Dashboard</title>
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
              <li><a class="dropdown-item small py-2" href="inventory.php"><i class="bi bi-exclamation-triangle text-warning me-2"></i> Low stock: <?= $low_stock_count ?> items need reorder</a></li>
              <li><a class="dropdown-item small py-2" href="products.php"><i class="bi bi-box-seam text-primary me-2"></i> Total active catalog: <?= $total_products ?> products</a></li>
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
              <li><a class="dropdown-item text-danger" href="login.php"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
            </ul>
          </div>
        </div>
      </header>

      <main class="admin-content">
        
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
          <div>
            <h1 class="page-title">Warehouse Inventory Tracking</h1>
            <p class="page-subtitle">Real-time stock ledger & size variants inventory from database.</p>
          </div>
          <div class="d-flex gap-2">
            <button class="btn btn-sm btn-dark" onclick="openAdjustForProduct('')">
              <i class="bi bi-arrow-down-up me-1"></i> Quick Stock Adjustment
            </button>
          </div>
        </div>

        <!-- Flash Notifications -->
        <?php if (!empty($success_msg)) { ?>
          <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle me-2"></i> <?= htmlspecialchars($success_msg) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        <?php } ?>

        <?php if (!empty($error_msg)) { ?>
          <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i> <?= htmlspecialchars($error_msg) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        <?php } ?>

        <!-- Inventory Metrics Cards -->
        <div class="row g-3 mb-4">
          <div class="col-6 col-md-3">
            <div class="admin-card p-3">
              <div class="text-muted small fw-bold">Tracked Footwear</div>
              <div class="fs-4 fw-bold text-dark mt-1"><?= number_format($total_products) ?></div>
              <small class="text-secondary" style="font-size: 0.72rem;">Catalog models</small>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="admin-card p-3">
              <div class="text-muted small fw-bold">Total Stock Units</div>
              <div class="fs-4 fw-bold text-success mt-1"><?= number_format($total_units) ?> <span class="fs-6 text-muted">pairs</span></div>
              <small class="text-secondary" style="font-size: 0.72rem;">Physical warehouse units</small>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="admin-card p-3 <?= ($low_stock_count > 0) ? 'border-warning' : '' ?>">
              <div class="text-warning small fw-bold">Low Stock Warning (&le; 5)</div>
              <div class="fs-4 fw-bold text-warning mt-1"><?= number_format($low_stock_count) ?></div>
              <small class="text-secondary" style="font-size: 0.72rem;">Reorder recommended</small>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="admin-card p-3 <?= ($out_stock_count > 0) ? 'border-danger' : '' ?>">
              <div class="text-danger small fw-bold">Out of Stock (0 pairs)</div>
              <div class="fs-4 fw-bold text-danger mt-1"><?= number_format($out_stock_count) ?></div>
              <small class="text-secondary" style="font-size: 0.72rem;">Completely depleted</small>
            </div>
          </div>
        </div>

        <!-- Search & Filter Toolbar -->
        <div class="admin-card mb-4">
          <div class="admin-card-body p-3">
            <form method="GET" action="inventory.php">
              <div class="row g-2 align-items-center">
                <div class="col-md-6">
                  <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search footwear model or SKU..." value="<?= htmlspecialchars($search) ?>">
                  </div>
                </div>
                <div class="col-md-4">
                  <select name="status_filter" class="form-select">
                    <option value="">All Stock Levels</option>
                    <option value="in" <?= ($status_filter === 'in') ? 'selected' : '' ?>>In Stock (Good)</option>
                    <option value="low" <?= ($status_filter === 'low') ? 'selected' : '' ?>>Low Stock Warning (&le; 5)</option>
                    <option value="out" <?= ($status_filter === 'out') ? 'selected' : '' ?>>Out of Stock (0 pairs)</option>
                  </select>
                </div>
                <div class="col-md-2 d-flex gap-1">
                  <button type="submit" class="btn btn-dark btn-sm flex-grow-1">Filter</button>
                  <?php if (!empty($search) || !empty($status_filter)) { ?>
                    <a href="inventory.php" class="btn btn-outline-secondary btn-sm" title="Clear Filters"><i class="bi bi-arrow-counterclockwise"></i></a>
                  <?php } ?>
                </div>
              </div>
            </form>
          </div>
        </div>

        <!-- Inventory Products Table -->
        <div class="admin-card">
          <div class="admin-table-wrap">
            <table class="admin-table">
              <thead>
                <tr>
                  <th>Footwear Model</th>
                  <th>SKU</th>
                  <th>Available Stock</th>
                  <th>Variants / Sizes & Colors</th>
                  <th>Reorder Level</th>
                  <th>Stock Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody class="filterable-table-body">
                <?php if (!empty($products_list)) { ?>
                  <?php foreach ($products_list as $prod) { 
                    $pid = $prod['id'];
                    $prod_variants = $variants_by_prod[$pid] ?? [];
                    $total_stock = intval($prod['stock_quantity']);
                    $reorder_level = intval($prod['low_stock_threshold'] ?? 5);

                    if ($total_stock <= 0) {
                        $status_badge = '<span class="badge bg-danger">Out of Stock</span>';
                    } elseif ($total_stock <= $reorder_level) {
                        $status_badge = '<span class="badge bg-warning text-dark">Low Stock</span>';
                    } else {
                        $status_badge = '<span class="badge bg-success">In Stock</span>';
                    }
                  ?>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center gap-3">
                          <?php if (!empty($prod['image_url'])) { ?>
                            <img src="<?= htmlspecialchars($prod['image_url']) ?>" class="rounded-1" style="width: 44px; height: 44px; object-fit: cover;" alt="<?= htmlspecialchars($prod['name']) ?>">
                          <?php } else { ?>
                            <div class="rounded-1 bg-light d-flex align-items-center justify-content-center text-muted border" style="width: 44px; height: 44px;">
                              <i class="bi bi-image fs-5"></i>
                            </div>
                          <?php } ?>
                          <div>
                            <strong class="text-dark"><?= htmlspecialchars($prod['name']) ?></strong>
                            <div class="text-muted small">
                              <?= htmlspecialchars($prod['category_name'] ?? 'Footwear') ?> &bull; <?= htmlspecialchars($prod['brand_name'] ?? 'Atelier') ?>
                            </div>
                          </div>
                        </div>
                      </td>
                      <td><code><?= htmlspecialchars($prod['sku']) ?></code></td>
                      <td class="fw-bold <?= ($total_stock <= 0) ? 'text-danger' : (($total_stock <= $reorder_level) ? 'text-warning' : 'text-dark') ?>">
                        <?= $total_stock ?> pairs
                      </td>
                      <td>
                        <?php if (!empty($prod_variants)) { ?>
                          <div class="d-flex flex-wrap gap-1" style="max-width: 280px;">
                            <?php foreach ($prod_variants as $pv) { 
                              $pv_stk = intval($pv['stock_quantity']);
                              $pv_badge = ($pv_stk <= 0) ? 'bg-danger text-white' : (($pv_stk < 5) ? 'bg-warning-subtle text-dark border border-warning' : 'bg-light text-dark border');
                            ?>
                              <span class="badge <?= $pv_badge ?>" style="font-size: 0.72rem;" title="SKU: <?= htmlspecialchars($pv['sku_variant']) ?> | Color: <?= htmlspecialchars($pv['color_name']) ?>">
                                <?= htmlspecialchars($pv['size_eu']) ?>: <strong><?= $pv_stk ?></strong>
                              </span>
                            <?php } ?>
                          </div>
                        <?php } else { ?>
                          <span class="text-muted small">Single / No Variants</span>
                        <?php } ?>
                      </td>
                      <td><?= $reorder_level ?> pairs</td>
                      <td><?= $status_badge ?></td>
                      <td>
                        <button class="btn btn-sm btn-outline-dark py-1 px-2" onclick="openAdjustForProduct('<?= $pid ?>')" title="Adjust Stock">
                          <i class="bi bi-pencil-square me-1"></i> Adjust
                        </button>
                      </td>
                    </tr>
                  <?php } ?>
                <?php } else { ?>
                  <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                      <i class="bi bi-boxes fs-1 d-block mb-2 text-secondary opacity-50"></i>
                      <p class="mb-2 fw-semibold">No products found in inventory.</p>
                      <a href="product-add.php" class="btn btn-sm btn-dark">
                        <i class="bi bi-plus-lg me-1"></i> Add New Product
                      </a>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          
          <div class="p-3 border-top d-flex justify-content-between align-items-center">
            <span class="small text-muted">Showing <strong><?= $total_products ?></strong> products with inventory ledger</span>
          </div>
        </div>

        <!-- Quick Stock Adjustment Modal -->
        <div class="modal fade" id="stockAdjustModal" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title fs-6 fw-bold">Stock Adjustment Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <form action="inventory.php" method="POST">
                <input type="hidden" name="adjust_stock" value="1">
                <div class="modal-body">
                  <div class="mb-3">
                    <label class="form-label small fw-bold">Select Footwear Model *</label>
                    <select name="product_id" id="modalProductSelect" class="form-select" required onchange="updateVariantOptions(this.value)">
                      <option value="">-- Choose Product --</option>
                      <?php foreach ($products_list as $p) { ?>
                        <option value="<?= $p['id'] ?>">
                          <?= htmlspecialchars($p['name']) ?> (<?= htmlspecialchars($p['sku']) ?>) - Current Stock: <?= $p['stock_quantity'] ?>
                        </option>
                      <?php } ?>
                    </select>
                  </div>
                  
                  <div class="mb-3" id="variantSelectContainer" style="display:none;">
                    <label class="form-label small fw-bold">Select Specific Variant (Optional)</label>
                    <select name="variant_id" id="modalVariantSelect" class="form-select">
                      <option value="0">All Variants / Base Product Stock</option>
                    </select>
                    <small class="text-muted" style="font-size: 0.72rem;">Specific variant select karne par sirf us variant ka stock update hoga.</small>
                  </div>

                  <div class="row g-2 mb-3">
                    <div class="col-6">
                      <label class="form-label small fw-bold">Adjustment Type</label>
                      <select name="adjust_type" class="form-select">
                        <option value="add">Add Inventory (+ Received)</option>
                        <option value="subtract">Subtract (- Damaged / Returned)</option>
                      </select>
                    </div>
                    <div class="col-6">
                      <label class="form-label small fw-bold">Quantity (Pairs)</label>
                      <input type="number" name="quantity" class="form-control" value="5" min="1" required>
                    </div>
                  </div>

                  <div class="mb-3">
                    <label class="form-label small fw-bold">Reason Note (Optional)</label>
                    <input type="text" name="reason" class="form-control" placeholder="e.g. Sialkot workshop shipment batch #4">
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-sm btn-dark">Record Adjustment</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      
      </main>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/dashboard.js"></script>
  <script>
    var productVariantsMap = <?= json_encode($variants_by_prod, JSON_UNESCAPED_UNICODE) ?>;

    function updateVariantOptions(prodId) {
      var vSelect = document.getElementById('modalVariantSelect');
      var vContainer = document.getElementById('variantSelectContainer');
      vSelect.innerHTML = '<option value="0">All Variants / Base Product Stock</option>';

      if (prodId && productVariantsMap[prodId] && productVariantsMap[prodId].length > 0) {
        productVariantsMap[prodId].forEach(function(v) {
          var opt = document.createElement('option');
          opt.value = v.id;
          opt.textContent = v.size_eu + ' (' + v.color_name + ') - Current: ' + v.stock_quantity + ' pairs';
          vSelect.appendChild(opt);
        });
        vContainer.style.display = 'block';
      } else {
        vContainer.style.display = 'none';
      }
    }

    function openAdjustForProduct(prodId) {
      var select = document.getElementById('modalProductSelect');
      if (select) {
        select.value = prodId;
        updateVariantOptions(prodId);
      }
      var modal = new bootstrap.Modal(document.getElementById('stockAdjustModal'));
      modal.show();
    }
  </script>
</body>
</html>
