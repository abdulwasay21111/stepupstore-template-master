<?php
require_once __DIR__ . "/configs/session_check.php";
require_once __DIR__ . "/configs/db_con.php";


$register_errors = $_SESSION['registration_errors'] ?? [];
unset($_SESSION['registration_errors']);

$success =$_SESSION['success'] ?? "";
unset($_SESSION["success"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Registration | NOVA FORM</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body style="background: #0f172a;">
  <div class="container">
    <div class="admin-auth-box">
      <div class="text-center mb-4">
        <h2 class="fw-bold mb-1">NOVA FORM</h2>
        <span class="badge bg-dark border text-white px-3 py-1">STAFF REGISTRATION</span>
      </div>
       <?php if (!empty($register_errors)) { ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($register_errors as $error) { ?>
                            <li><?= $error ?></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
            <?php if ($success) { ?>
                <div class="alert alert-success">
                    <?php  echo $success; ?>
                </div>
            <?php } ?>
      <form action="./actions_handle/register_handle.php" method="POST">
        <div class="mb-3">
          <label class="form-label small fw-bold">Full Name</label>
          <input type="text" name="fullName" class="form-control" placeholder="Johny" required>
        </div>
        <div class="mb-3">
          <label class="form-label small fw-bold">Official Email</label>
          <input type="email" name="Email" class="form-control" placeholder="staff@novaformshoes.pk" required>
        </div>
        <div class="mb-3">
          <label class="form-label small fw-bold">Role</label>
          <select name="role" class="form-select">
            <option>Store Manager</option>
            <option>Inventory Specialist</option>
            <option>Customer Concierge</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label small fw-bold">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-dark w-100 py-2 mb-3">Create Staff Account</button>
        <div class="text-center small"><a href="login.php" class="text-muted">Already have access? Log in</a></div>
      </form>
    </div>
  </div>
</body>
</html>