<?php
require_once __DIR__ . "/configs/session_check.php";
require_once __DIR__ . "/configs/db_con.php";

$error_msg = $_SESSION['error_msg'] ?? "";
$success_msg = $_SESSION['success_msg'] ?? "";
unset($_SESSION['error_msg'], $_SESSION['success_msg']);

// Jab Add Category form submit ho
if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_category"])) {
    $cat_name = trim($_POST["category_name"] ?? "");

    if (empty($cat_name)) {
        $_SESSION['error_msg'] = "Category name is required!";
    } elseif (!isset($_FILES["category_image"]) || $_FILES["category_image"]["error"] !== UPLOAD_ERR_OK) {
        $_SESSION['error_msg'] = "Category image is required!";
    } else {
        $cat_name = mysqli_real_escape_string($connection, $cat_name);

        // Duplication check: kya ye category pehle se database mein hai?
        $check_query = "SELECT * FROM categories WHERE name = '$cat_name'";
        $check_result = mysqli_query($connection, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $_SESSION['error_msg'] = "Category '$cat_name' already exists!";
        } else {
            // Image upload handling
            $target_dir = __DIR__ . "/images/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $img_ext = strtolower(pathinfo($_FILES["category_image"]["name"], PATHINFO_EXTENSION));
            $new_img_name = "cat_" . time() . "_" . rand(100, 999) . "." . $img_ext;
            $target_file = $target_dir . $new_img_name;

            if (move_uploaded_file($_FILES["category_image"]["tmp_name"], $target_file)) {
                $image_path = "images/" . $new_img_name;
                $safe_img = mysqli_real_escape_string($connection, $image_path);

                // Database table mein insert krna
                $insert_query = "INSERT INTO categories (name, image) VALUES ('$cat_name', '$safe_img')";
                if (mysqli_query($connection, $insert_query)) {
                    $_SESSION['success_msg'] = "Category '$cat_name' with image added successfully!";
                } else {
                    $_SESSION['error_msg'] = "Failed to add category: " . mysqli_error($connection);
                }
            } else {
                $_SESSION['error_msg'] = "Failed to upload category image!";
            }
        }
    }

    // Refresh karne par form dubara submit na ho, iske liye redirect
    header("Location: categories.php");
    exit();
}

// Jab Edit Category form submit ho
if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit_category"])) {
    $cat_id = intval($_POST["category_id"] ?? 0);
    $cat_name = trim($_POST["category_name"] ?? "");

    if ($cat_id <= 0 || empty($cat_name)) {
        $_SESSION['error_msg'] = "Category name is required!";
    } else {
        $cat_name = mysqli_real_escape_string($connection, $cat_name);

        // Duplication check: kya ye category name kisi aur category ke pass pehle se mojood hai?
        $check_query = "SELECT id FROM categories WHERE name = '$cat_name' AND id != '$cat_id'";
        $check_result = mysqli_query($connection, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $_SESSION['error_msg'] = "Category '$cat_name' already exists!";
        } else {
            // Check if new image was uploaded
            if (isset($_FILES["category_image"]) && $_FILES["category_image"]["error"] === UPLOAD_ERR_OK) {
                $target_dir = __DIR__ . "/images/";
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }

                $img_ext = strtolower(pathinfo($_FILES["category_image"]["name"], PATHINFO_EXTENSION));
                $new_img_name = "cat_" . time() . "_" . rand(100, 999) . "." . $img_ext;
                $target_file = $target_dir . $new_img_name;

                if (move_uploaded_file($_FILES["category_image"]["tmp_name"], $target_file)) {
                    $image_path = "images/" . $new_img_name;
                    $safe_img = mysqli_real_escape_string($connection, $image_path);
                    $update_query = "UPDATE categories SET name = '$cat_name', image = '$safe_img' WHERE id = '$cat_id'";
                } else {
                    $update_query = "UPDATE categories SET name = '$cat_name' WHERE id = '$cat_id'";
                }
            } else {
                $update_query = "UPDATE categories SET name = '$cat_name' WHERE id = '$cat_id'";
            }

            if (mysqli_query($connection, $update_query)) {
                $_SESSION['success_msg'] = "Category updated successfully!";
            } else {
                $_SESSION['error_msg'] = "Failed to update category: " . mysqli_error($connection);
            }
        }
    }

    header("Location: categories.php");
    exit();
}

// Jab Delete Category pr click ho
if (isset($_GET["delete_id"])) {
    $delete_id = intval($_GET["delete_id"]);

    // Image file delete krna if exists on disk
    $sel_img = mysqli_query($connection, "SELECT image FROM categories WHERE id = '$delete_id'");
    if ($img_row = mysqli_fetch_assoc($sel_img)) {
        if (!empty($img_row['image']) && file_exists(__DIR__ . '/' . $img_row['image'])) {
            @unlink(__DIR__ . '/' . $img_row['image']);
        }
    }

    // Database se category delete krna
    $delete_query = "DELETE FROM categories WHERE id = '$delete_id'";
    if (mysqli_query($connection, $delete_query)) {
        $_SESSION['success_msg'] = "Category deleted successfully!";
    } else {
        $_SESSION['error_msg'] = "Failed to delete category!";
    }

    // URL clean rakhne ke liye redirect
    header("Location: categories.php");
    exit();
}

// Database se sari categories get krna
$get_categories = mysqli_query($connection, "SELECT * FROM categories ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Categories | NOVA FORM Admin Dashboard</title>
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
        
        <div class="d-flex justify-content-between align-items-center mb-4">
          <div>
            <h1 class="page-title">Footwear Categories</h1>
            <p class="page-subtitle">Organize shoe silhouettes, product counts, and homepage showcase slots.</p>
          </div>
          <!-- Add Category Button -->
          <button class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#addCatModal">
            <i class="bi bi-plus-lg me-1"></i> Add Category
          </button>
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

        <div class="admin-card">
          <div class="admin-table-wrap">
            <table class="admin-table">
              <thead>
                <tr>
                  <th style="width: 80px;">#ID</th>
                  <th style="width: 80px;">Image</th>
                  <th>Category Name</th>
                  <th>Created At</th>
                  <th style="width: 160px;">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                if ($get_categories && mysqli_num_rows($get_categories) > 0) {
                   foreach ($get_categories as $row) { 
                ?>
                    <tr>
                      <td><span class="badge bg-light text-dark border">#<?= $row['id'] ?></span></td>
                      <td>
                        <?php if (!empty($row['image'])) { ?>
                          <img src="<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" class="rounded border" style="width: 44px; height: 44px; object-fit: cover;">
                        <?php } else { ?>
                          <div class="rounded bg-light border d-flex align-items-center justify-content-center text-muted" style="width: 44px; height: 44px;">
                            <i class="bi bi-image fs-5 opacity-50"></i>
                          </div>
                        <?php } ?>
                      </td>
                      <td>
                        <div class="d-flex align-items-center gap-2">
                          <i class="bi bi-tag text-muted"></i>
                          <strong class="text-dark"><?= htmlspecialchars($row['name']) ?></strong>
                        </div>
                      </td>
                      <td class="text-muted small">
                        <?= !empty($row['created_at']) ? $row['created_at'] : '—' ?>
                      </td>
                      <td>
                        <div class="d-flex gap-1">
                          <!-- Edit Button: Opens Edit Modal -->
                          <button type="button" class="btn btn-sm btn-outline-dark py-1 px-2" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id'] ?>" title="Edit Category">
                            <i class="bi bi-pencil"></i> Edit
                          </button>

                          <!-- Delete Button: Opens Delete Modal -->
                          <button type="button" class="btn btn-sm btn-outline-danger py-1 px-2" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $row['id'] ?>" title="Delete Category">
                            <i class="bi bi-trash"></i> Delete
                          </button>
                        </div>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content text-start">
                              <form action="categories.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="category_id" value="<?= $row['id'] ?>">
                                <div class="modal-header">
                                  <h5 class="modal-title fs-6 fw-bold">Edit Category</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                  <div class="mb-3">
                                    <label class="form-label small fw-bold">Category Name</label>
                                    <input type="text" name="category_name" class="form-control" value="<?= htmlspecialchars($row['name']) ?>" required>
                                  </div>
                                  <div class="mb-3">
                                    <label class="form-label small fw-bold">Category Image</label>
                                    <?php if (!empty($row['image'])) { ?>
                                      <div class="mb-2 d-flex align-items-center gap-2">
                                        <img src="<?= htmlspecialchars($row['image']) ?>" class="rounded border" style="width: 50px; height: 50px; object-fit: cover;" alt="Current Image">
                                        <span class="text-muted small">Current image on file</span>
                                      </div>
                                    <?php } ?>
                                    <input type="file" name="category_image" class="form-control" accept="image/*">
                                    <div class="form-text small">Select new image only if you want to replace existing.</div>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                  <button type="submit" name="edit_category" class="btn btn-sm btn-dark">Update Category</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>

                        <!-- Delete Confirmation Modal -->
                        <div class="modal fade" id="deleteModal<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered modal-sm">
                            <div class="modal-content text-center p-3">
                              <div class="modal-body">
                                <div class="text-danger fs-1 mb-2">
                                  <i class="bi bi-exclamation-circle"></i>
                                </div>
                                <h6 class="fw-bold mb-2">Delete Category?</h6>
                                <p class="text-muted small mb-3">
                                  Are you sure you want to delete <strong><?= htmlspecialchars($row['name']) ?></strong>?
                                </p>
                                <div class="d-flex justify-content-center gap-2">
                                  <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                  <a href="categories.php?delete_id=<?= $row['id'] ?>" class="btn btn-sm btn-danger">Yes, Delete</a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                <?php 
                    } 
                } else { 
                ?>
                    <tr>
                      <td colspan="5" class="text-center py-4 text-muted">
                        No categories found in database. Click <strong>"Add Category"</strong> above to add one.
                      </td>
                    </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Add Category Modal -->
        <div class="modal fade" id="addCatModal" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <form action="categories.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                  <h5 class="modal-title fs-6 fw-bold">Add Category</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                  <div class="mb-3">
                    <label class="form-label small fw-bold">Category Name *</label>
                    <input type="text" name="category_name" class="form-control" placeholder="Enter Category Name (e.g. Formal Shoes)" required autofocus>
                  </div>
                  <div class="mb-3">
                    <label class="form-label small fw-bold">Category Image *</label>
                    <input type="file" name="category_image" class="form-control" accept="image/*" required>
                    <div class="form-text small">Select an image banner or thumbnail for this category (JPG, PNG, WebP).</div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" name="add_category" class="btn btn-sm btn-dark">Save Category</button>
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
</body>
</html>
