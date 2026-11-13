<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Account | NOVA FORM</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/responsive.css">
</head>
<body>

  
  <!-- Annoucment and nav bar -->
   
  <?php require_once __DIR__ . "/partials/header.php"?>

  <!-- Mobile Offcanvas Menu -->
  <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileNavOffcanvas" aria-labelledby="mobileNavLabel">
    <div class="offcanvas-header border-bottom">
      <h5 class="offcanvas-title brand-logo" id="mobileNavLabel">NOVA FORM<span class="dot"></span></h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-4">
      <div class="mb-4">
        <form action="shop.php" method="GET">
          <div class="input-group">
            <input type="text" name="q" class="form-control form-control-nova" placeholder="Search shoes, loafers, boots...">
            <button class="btn btn-dark" type="submit"><i class="bi bi-search"></i></button>
          </div>
        </form>
      </div>

      <ul class="list-unstyled mb-4">
        <li class="mb-2"><a href="index.php" class="d-block py-2 text-decoration-none fw-semibold border-bottom">Home</a></li>
        <li class="mb-2"><a href="shop.php" class="d-block py-2 text-decoration-none fw-semibold border-bottom">Shop All Footwear</a></li>
        <li class="mb-2"><a href="category.php" class="d-block py-2 text-decoration-none fw-semibold border-bottom">Formal Shoes</a></li>
        <li class="mb-2"><a href="category.php" class="d-block py-2 text-decoration-none fw-semibold border-bottom">Loafers & Slip-ons</a></li>
        <li class="mb-2"><a href="category.php" class="d-block py-2 text-decoration-none fw-semibold border-bottom">Traditional Peshawari</a></li>
        <li class="mb-2"><a href="category.php" class="d-block py-2 text-decoration-none fw-semibold border-bottom">Sneakers & Trainers</a></li>
        <li class="mb-2"><a href="size-guide.php" class="d-block py-2 text-decoration-none fw-semibold border-bottom">Shoe Size Guide (EU 39-46)</a></li>
        <li class="mb-2"><a href="about.php" class="d-block py-2 text-decoration-none fw-semibold border-bottom">About NOVA FORM</a></li>
        <li class="mb-2"><a href="contact.php" class="d-block py-2 text-decoration-none fw-semibold border-bottom">Contact & Stores</a></li>
      </ul>

      <div class="border-top pt-3">
        <div class="d-flex flex-column gap-2">
          <a href="account.php" class="btn btn-outline-dark w-100 py-2"><i class="bi bi-person me-2"></i> Customer Account</a>
          <a href="../dashboard/index.php" class="btn btn-dark w-100 py-2"><i class="bi bi-shield-lock me-2"></i> Admin Dashboard</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Search Modal -->
  <div class="modal fade" id="searchModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content border-0 shadow-lg">
        <div class="modal-body p-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="text-uppercase fw-bold text-muted small mb-0">Search NOVA FORM Catalog</h6>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="shop.php" method="GET">
            <div class="input-group input-group-lg border rounded-1 overflow-hidden">
              <span class="input-group-text bg-white border-0"><i class="bi bi-search text-muted"></i></span>
              <input type="text" name="search" class="form-control border-0 shadow-none ps-0" placeholder="Type shoe style (e.g., Oxford, Loafer, Chelsea, Chappal)..." autofocus>
              <button class="btn btn-nova-dark rounded-0 px-4" type="submit">Search</button>
            </div>
          </form>
          <div class="mt-3">
            <span class="text-muted small me-2">Trending Searches:</span>
            <a href="shop.php" class="badge bg-light text-dark text-decoration-none me-1">Oxford Shoes</a>
            <a href="shop.php" class="badge bg-light text-dark text-decoration-none me-1">Penny Loafers</a>
            <a href="shop.php" class="badge bg-light text-dark text-decoration-none me-1">Kaptaan Chappal</a>
            <a href="shop.php" class="badge bg-light text-dark text-decoration-none">Chelsea Boots</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  

  <main class="py-5">
    <div class="container">
      
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center border-bottom pb-4 mb-4">
        <div>
          <span class="text-muted text-uppercase small fw-bold">Patron Portal</span>
          <h1 class="h2 fw-bold font-editorial mb-0">Welcome, Hamza Tariq</h1>
        </div>
        <div class="mt-3 mt-md-0">
          <a href="login.php" class="btn btn-sm btn-outline-danger"><i class="bi bi-box-arrow-right me-1"></i> Sign Out</a>
        </div>
      </div>

      <div class="row g-4">
        <!-- Sidebar Navigation -->
        <div class="col-lg-3">
          <div class="list-group list-group-flush border rounded-1 shadow-sm">
            <a href="account.php" class="list-group-item list-group-item-action active bg-dark text-white border-0 fw-semibold"><i class="bi bi-person me-2"></i> Account Overview</a>
            <a href="orders.php" class="list-group-item list-group-item-action"><i class="bi bi-bag-check me-2"></i> My Orders (4)</a>
            <a href="wishlist.php" class="list-group-item list-group-item-action"><i class="bi bi-heart me-2"></i> Saved Wishlist (3)</a>
            <a href="size-guide.php" class="list-group-item list-group-item-action"><i class="bi bi-rulers me-2"></i> Shoe Size Profile (EU 42)</a>
            <a href="contact.php" class="list-group-item list-group-item-action"><i class="bi bi-chat-dots me-2"></i> Customer Concierge</a>
          </div>
        </div>

        <!-- Account Main Details -->
        <div class="col-lg-9">
          
          <div class="row g-4 mb-4">
            <div class="col-md-4">
              <div class="bg-light p-3 border rounded-1">
                <div class="text-muted small text-uppercase">Total Footwear Orders</div>
                <div class="h3 fw-bold mb-0">4 Orders</div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="bg-light p-3 border rounded-1">
                <div class="text-muted small text-uppercase">Lifetime Spend</div>
                <div class="h3 fw-bold mb-0">PKR 58,996</div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="bg-light p-3 border rounded-1">
                <div class="text-muted small text-uppercase">Membership Tier</div>
                <div class="h3 fw-bold mb-0 text-warning">Gold Patron</div>
              </div>
            </div>
          </div>

          <!-- Personal Information Card -->
          <div class="bg-white p-4 border rounded-1 shadow-sm mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h5 class="fs-6 fw-bold text-uppercase mb-0">Personal Profile</h5>
              <button class="btn btn-sm btn-link text-dark" onclick="alert('Demo profile edit dialog');">Edit Profile</button>
            </div>
            <div class="row g-3 small">
              <div class="col-md-6">
                <span class="text-muted d-block">Full Name:</span>
                <strong>Hamza Tariq</strong>
              </div>
              <div class="col-md-6">
                <span class="text-muted d-block">Email Address:</span>
                <strong>hamza.tariq@gmail.com</strong>
              </div>
              <div class="col-md-6">
                <span class="text-muted d-block">Phone:</span>
                <strong>+92 300 8472911</strong>
              </div>
              <div class="col-md-6">
                <span class="text-muted d-block">Preferred Footwear Size:</span>
                <strong>EU 42 (Standard F Width)</strong>
              </div>
            </div>
          </div>

          <!-- Saved Address Card -->
          <div class="bg-white p-4 border rounded-1 shadow-sm mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h5 class="fs-6 fw-bold text-uppercase mb-0">Default Delivery Address</h5>
              <span class="badge bg-dark">Default</span>
            </div>
            <p class="small text-muted mb-0">
              House 42, Street 8, Sector J, Phase 5, DHA<br>
              Lahore, Punjab, 54000, Pakistan<br>
              Mobile: +92 300 8472911
            </p>
          </div>

          <!-- Recent Order Snippet -->
          <div class="bg-white p-4 border rounded-1 shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h5 class="fs-6 fw-bold text-uppercase mb-0">Most Recent Order</h5>
              <a href="orders.php" class="small text-dark fw-bold">View All &rarr;</a>
            </div>
            <div class="table-responsive">
              <table class="table table-sm align-middle mb-0 small">
                <thead>
                  <tr class="text-muted text-uppercase">
                    <th>Order #</th>
                    <th>Date</th>
                    <th>Product</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><strong>#NF-88291</strong></td>
                    <td>28 Oct 2026</td>
                    <td>Regal Wholecut Oxford (EU 42)</td>
                    <td>PKR 14,999</td>
                    <td><span class="badge bg-warning text-dark">Processing</span></td>
                    <td><a href="order-details.php" class="btn btn-sm btn-outline-dark py-0">Details</a></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

        </div>
      </div>

    </div>
  </main>

  
  <!-- Shared Luxe Footer -->
   <?php require_once __DIR__ . "/partials/footer.php"; ?>

  <!-- Bootstrap 5 JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Custom Minimal Frontend Script -->
  <script src="assets/js/main.js"></script>
  

</body>
</html>