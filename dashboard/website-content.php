<?php
require_once __DIR__ . "/configs/session_check.php";
require_once __DIR__ . "/configs/web_content_db.php";

$error_msg = $_SESSION['error_msg'] ?? "";
$success_msg = $_SESSION['success_msg'] ?? "";
unset($_SESSION['error_msg'], $_SESSION['success_msg']);

// Database se content nikalna
$get_content = mysqli_query($conn_web, "SELECT * FROM `web_content` WHERE id = 1");
$content = ($get_content && mysqli_num_rows($get_content) > 0) ? mysqli_fetch_assoc($get_content) : null;

$hero_headline = $content['hero_headline'] ?? 'Step Into Uncompromising Refinement.';
$hero_subtitle = $content['hero_subtitle'] ?? 'Autumn / Winter 2026 Collection';
$hero_lead = $content['hero_lead'] ?? 'Handcrafted from full-grain Italian calfskin and Goodyear-welted for generations of distinction. Engineered for the modern Pakistani gentleman.';
$promo_headline = $content['promo_headline'] ?? 'The Goodyear Welted Oxford Experience';
$promo_btn_text = $content['promo_btn_text'] ?? 'Discover The Oxford';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Website Content | NOVA FORM Admin Dashboard</title>
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
        
        <div class="d-flex justify-content-between align-items-center mb-4">
          <div>
            <h1 class="page-title">Website Content Editor (CMS)</h1>
            <p class="page-subtitle">Configure editorial headlines, hero imagery, and brand promotional text.</p>
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

        <form action="actions_handle/website_content_handle.php" method="POST">
          <div class="row g-4">
            
            <div class="col-lg-8">
              
              <!-- Hero Section CMS -->
              <div class="admin-card mb-4">
                <div class="admin-card-header"><h5 class="admin-card-title">Homepage Hero Banner</h5></div>
                <div class="admin-card-body">
                  <div class="mb-3">
                    <label class="form-label small fw-bold">Main Headline</label>
                    <input type="text" name="hero_headline" class="form-control" value="<?= htmlspecialchars($hero_headline) ?>" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label small fw-bold">Subtitle</label>
                    <input type="text" name="hero_subtitle" class="form-control" value="<?= htmlspecialchars($hero_subtitle) ?>" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label small fw-bold">Lead Paragraph</label>
                    <textarea name="hero_lead" class="form-control" rows="3" required><?= htmlspecialchars($hero_lead) ?></textarea>
                  </div>
                </div>
              </div>

              <!-- Promo Section CMS -->
              <div class="admin-card mb-4">
                <div class="admin-card-header"><h5 class="admin-card-title">Mid-Season Promotional Banner</h5></div>
                <div class="admin-card-body">
                  <div class="mb-3">
                    <label class="form-label small fw-bold">Banner Headline</label>
                    <input type="text" name="promo_headline" class="form-control" value="<?= htmlspecialchars($promo_headline) ?>" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label small fw-bold">Call to Action Button</label>
                    <input type="text" name="promo_btn_text" class="form-control" value="<?= htmlspecialchars($promo_btn_text) ?>" required>
                  </div>
                </div>
              </div>

              <button type="submit" name="update_web_content" class="btn btn-dark px-4 py-2">
                <i class="bi bi-check-lg me-1"></i> Save Content Revisions
              </button>

            </div>

            <div class="col-lg-4">
              <div class="admin-card mb-4">
                <div class="admin-card-header"><h5 class="admin-card-title">Database Status</h5></div>
                <div class="admin-card-body small text-muted">
                  <div class="mb-2"><strong>Database:</strong> <code>web_content_db</code></div>
                  <div class="mb-2"><strong>Table:</strong> <code>web_content</code></div>
                  <div><strong>Last Updated:</strong> <?= !empty($content['updated_at']) ? $content['updated_at'] : 'Recently' ?></div>
                </div>
              </div>
              <div class="admin-card">
                <div class="admin-card-header"><h5 class="admin-card-title">Notice</h5></div>
                <div class="admin-card-body small text-muted">
                  Content revisions update directly in the <code>web_content</code> database table immediately upon saving.
                </div>
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
