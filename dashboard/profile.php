<?php
require_once __DIR__ . "/configs/session_check.php";
require_once __DIR__ . "/configs/db_con.php";

$error_msg = $_SESSION['error_msg'] ?? "";
$success_msg = $_SESSION['success_msg'] ?? "";
unset($_SESSION['error_msg'], $_SESSION['success_msg']);

// Table check: Agar admins table mein phone ya avatar_url ka column na ho to auto-add krna
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
ensure_admin_columns($connection);

// Logged-in admin ka data nikalna
$admin_id = $_SESSION['id'] ?? 0;
$admin = null;

if ($admin_id > 0) {
    $stmt = mysqli_prepare($connection, "SELECT * FROM `admins` WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $admin_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $admin = mysqli_fetch_assoc($res);
}

// Fallback: Agar session na ho to table se pehla admin uthao
if (!$admin) {
    $res = mysqli_query($connection, "SELECT * FROM `admins` ORDER BY id ASC LIMIT 1");
    if ($res && mysqli_num_rows($res) > 0) {
        $admin = mysqli_fetch_assoc($res);
        $_SESSION['id'] = $admin['id'];
    }
}

$avatar_src = (!empty($admin['avatar_url'])) ? htmlspecialchars($admin['avatar_url']) : "https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=200&auto=format&fit=crop";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile | NOVA FORM Admin Dashboard</title>
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
            <li><a class="dropdown-item small py-2" href="orders.php"><i class="bi bi-bag-check text-success me-2"></i> New Order #NF-88291 received (PKR 14,999)</a></li>
            <li><a class="dropdown-item small py-2" href="inventory.php"><i class="bi bi-exclamation-triangle text-warning me-2"></i> Low stock: Sahara Suede Chukka (9 left)</a></li>
            <li><a class="dropdown-item small py-2" href="reviews.php"><i class="bi bi-star text-primary me-2"></i> New 5-star review pending approval</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-center small text-primary fw-semibold" href="orders.php">View All Notifications</a></li>
          </ul>
        </div>

        <div class="topbar-actions">
          <a href="../front-site/index.html" target="_blank" class="btn btn-sm btn-outline-secondary d-none d-md-inline-flex align-items-center gap-1">
            <i class="bi bi-eye"></i> View Site
          </a>
          <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
            <li><a class="dropdown-item" href="profile.php"><i class="bi bi-person me-2 text-muted"></i> My Profile</a></li>
            <li><a class="dropdown-item" href="settings.php"><i class="bi bi-gear me-2 text-muted"></i> Store Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="login.php"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
          </ul>
        </div>
      </header>

      <main class="admin-content">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
          <div>
            <h1 class="page-title">Administrator Profile</h1>
            <p class="page-subtitle">Manage personal credentials and security access.</p>
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

        <?php if ($admin) { ?>
          <form action="actions_handle/profile_handle.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="admin_id" value="<?= $admin['id'] ?>">

            <div class="row g-4">
              
              <!-- Left Column: Details & Password -->
              <div class="col-lg-8">
                
                <!-- Account Details -->
                <div class="admin-card mb-4">
                  <div class="admin-card-header"><h5 class="admin-card-title">Account Details</h5></div>
                  <div class="admin-card-body">
                    <div class="row g-3">
                      <div class="col-md-6">
                        <label class="form-label small fw-bold">Full Name *</label>
                        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($admin['name'] ?? '') ?>" required>
                      </div>
                      <div class="col-md-6">
                        <label class="form-label small fw-bold">Administrative Role</label>
                        <input type="text" name="role" class="form-control bg-light" value="<?= htmlspecialchars($admin['role'] ?? 'Manager') ?>" readonly>
                      </div>
                      <div class="col-md-6">
                        <label class="form-label small fw-bold">Email Address *</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($admin['email'] ?? '') ?>" required>
                      </div>
                      <div class="col-md-6">
                        <label class="form-label small fw-bold">Phone Number</label>
                        <input type="tel" name="phone" class="form-control" value="<?= htmlspecialchars($admin['phone'] ?? '') ?>" placeholder="+92 300 8472911">
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Security & Password -->
                <div class="admin-card mb-4">
                  <div class="admin-card-header"><h5 class="admin-card-title">Security & Password</h5></div>
                  <div class="admin-card-body">
                    <p class="text-muted small mb-3">Leave password fields blank if you do not wish to change your current password.</p>
                    <div class="row g-3">
                      <div class="col-md-6">
                        <label class="form-label small fw-bold">New Password</label>
                        <input type="password" name="new_password" class="form-control" placeholder="Enter new password">
                      </div>
                      <div class="col-md-6">
                        <label class="form-label small fw-bold">Confirm New Password</label>
                        <input type="password" name="confirm_password" class="form-control" placeholder="Re-enter new password">
                      </div>
                    </div>
                  </div>
                </div>

                <button type="submit" name="update_profile" class="btn btn-dark px-4 py-2">
                  <i class="bi bi-check-lg me-1"></i> Update Profile
                </button>
              </div>

              <!-- Right Column: Avatar Photo -->
              <div class="col-lg-4">
                <div class="admin-card p-4 text-center">
                  <img src="<?= $avatar_src ?>" id="avatarPreview" class="admin-avatar mb-3 rounded-circle shadow-sm" style="width: 110px; height: 110px; object-fit: cover;" alt="Admin Avatar">
                  <h5 class="fw-bold mb-1"><?= htmlspecialchars($admin['name'] ?? 'Admin') ?></h5>
                  <div class="text-muted small mb-3"><?= htmlspecialchars($admin['role'] ?? 'Staff') ?></div>
                  
                  <input type="file" name="avatar" id="avatarInput" class="d-none" accept="image/*" onchange="previewAvatar(this);">
                  <button type="button" class="btn btn-sm btn-outline-dark" onclick="document.getElementById('avatarInput').click();">
                    <i class="bi bi-camera me-1"></i> Upload New Photo
                  </button>
                  <div class="text-muted mt-2" style="font-size: 0.72rem;">JPG, PNG, or WEBP up to 5MB</div>
                </div>

                <div class="admin-card mt-4 p-3 text-muted small">
                  <div class="d-flex justify-content-between mb-1">
                    <span>Account ID:</span>
                    <strong>#<?= $admin['id'] ?></strong>
                  </div>
                  <div class="d-flex justify-content-between mb-1">
                    <span>Registered:</span>
                    <span><?= !empty($admin['created_at']) ? $admin['created_at'] : 'Recently' ?></span>
                  </div>
                  <div class="d-flex justify-content-between">
                    <span>Status:</span>
                    <span class="badge bg-success">Active</span>
                  </div>
                </div>
              </div>

            </div>
          </form>
        <?php } else { ?>
          <div class="alert alert-warning">
            No administrator profile found in the database. Please <a href="register.php">register a staff account</a> first.
          </div>
        <?php } ?>
      
      </main>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/dashboard.js"></script>
  <script>
    function previewAvatar(input) {
      if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
          const preview = document.getElementById('avatarPreview');
          if (preview) {
            preview.src = e.target.result;
          }
        };
        reader.readAsDataURL(input.files[0]);
      }
    }
  </script>
</body>
</html>
