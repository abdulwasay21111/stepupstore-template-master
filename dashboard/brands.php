<?php
require_once __DIR__ . "/configs/session_check.php";
require_once __DIR__ . "/configs/db_con.php";

$error_msg = $_SESSION['error_msg'] ?? "";
$success_msg = $_SESSION['success_msg'] ?? "";
unset($_SESSION['error_msg'], $_SESSION['success_msg']);

// Database se sare brands get krna
$get_brands = mysqli_query($connection, "SELECT * FROM brands ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Brands | NOVA FORM Admin Dashboard</title>
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
        
        <div class="d-flex justify-content-between align-items-center mb-4">
          <div>
            <h1 class="page-title">Footwear Brands & Labels</h1>
            <p class="page-subtitle">Manage proprietary atelier labels within NOVA FORM.</p>
          </div>
          <!-- Add Brand Label Button -->
          <button class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#addBrandModal">
            <i class="bi bi-plus-lg me-1"></i> Add Brand Label
          </button>
        </div>

        <!-- Alerts -->
        <?php if (!empty($success_msg)) { ?>
          <div class="alert alert-success py-2 mb-3">
            <i class="bi bi-check-circle me-1"></i> <?= $success_msg ?>
          </div>
          <?php unset($success_msg); ?>
        <?php } ?>

        <?php if (!empty($error_msg)) { ?>
          <div class="alert alert-danger py-2 mb-3">
            <i class="bi bi-exclamation-triangle me-1"></i> <?= $error_msg ?>
          </div>
          <?php unset($error_msg); ?>
        <?php } ?>

        <div class="row g-4">
          <?php 
          if ($get_brands && mysqli_num_rows($get_brands) > 0) {
              foreach ($get_brands as $brand) { 
          ?>
              <div class="col-md-6 col-lg-3">
                <div class="admin-card h-100 p-4 text-center">
                  <div class="rounded-circle bg-dark text-white d-inline-flex align-items-center justify-content-center fw-bold fs-5 mb-3" style="width: 64px; height: 64px;">
                    <i class="bi bi-award fs-3"></i>
                  </div>
                  <h5 class="fw-bold fs-6 mb-1"><?= htmlspecialchars($brand['name']) ?></h5>
                  <span class="badge bg-light text-dark border mb-3">Brand #<?= $brand['id'] ?></span>
                  <p class="text-muted small mb-0">Added: <?= !empty($brand['created_at']) ? $brand['created_at'] : 'Recently' ?></p>
                </div>
              </div>
          <?php 
              }
          } else { 
          ?>
              <div class="col-12">
                <div class="text-center py-5 text-muted bg-white rounded border">
                  <i class="bi bi-award fs-1 d-block mb-2 text-secondary opacity-50"></i>
                  <p class="mb-2 fw-semibold">No brand labels found in the database.</p>
                  <button class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#addBrandModal">
                    <i class="bi bi-plus-lg me-1"></i> Add Your First Brand
                  </button>
                </div>
              </div>
          <?php } ?>
        </div>
      
      </main>
    </div>
  </div>

  <!-- Add Brand Modal (Sirf Brand Name) -->
  <div class="modal fade" id="addBrandModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form action="actions_handle/brand_add_handle.php" method="POST">
          <div class="modal-header">
            <h5 class="modal-title fs-6 fw-bold">Add Brand Label</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label small fw-bold">Brand Name</label>
              <input type="text" name="brand_name" class="form-control" placeholder="e.g. NOVA FORM Black Label" required autofocus>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" name="add_brand" class="btn btn-sm btn-dark">Save Brand</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/dashboard.js"></script>
</body>
</html>
