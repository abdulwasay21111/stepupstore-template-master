<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Details #NF-88291 | NOVA FORM</title>
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
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-nova">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item"><a href="account.php">Account</a></li>
          <li class="breadcrumb-item"><a href="orders.php">Orders</a></li>
          <li class="breadcrumb-item active" aria-current="page">NF-88291</li>
        </ol>
      </nav>

      <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center border-bottom pb-3 mb-4">
        <div>
          <span class="badge bg-warning text-dark mb-1 text-uppercase">Processing</span>
          <h1 class="h3 fw-bold font-editorial mb-0">Order Reference #NF-88291</h1>
          <div class="text-muted small">Placed on 28 Oct 2026 &bull; Payment: Cash on Delivery</div>
        </div>
        <div class="mt-3 mt-md-0">
          <button class="btn btn-sm btn-outline-dark" onclick="window.print();"><i class="bi bi-printer me-1"></i> Print Invoice</button>
        </div>
      </div>

      <!-- Status Timeline -->
      <div class="bg-white p-4 border rounded-1 shadow-sm mb-4">
        <h5 class="fs-6 fw-bold text-uppercase mb-4">Dispatch Progress Timeline</h5>
        <div class="row text-center g-3">
          <div class="col-md-3">
            <div class="text-success fs-3"><i class="bi bi-check-circle-fill"></i></div>
            <h6 class="fw-bold mb-0 small">Order Placed</h6>
            <span class="text-muted small" style="font-size: 0.75rem;">28 Oct, 10:15 AM</span>
          </div>
          <div class="col-md-3">
            <div class="text-success fs-3"><i class="bi bi-check-circle-fill"></i></div>
            <h6 class="fw-bold mb-0 small">Confirmed at Workshop</h6>
            <span class="text-muted small" style="font-size: 0.75rem;">28 Oct, 11:30 AM</span>
          </div>
          <div class="col-md-3">
            <div class="text-warning fs-3"><i class="bi bi-box-seam"></i></div>
            <h6 class="fw-bold mb-0 small">Handcrafted Packaging</h6>
            <span class="text-muted small" style="font-size: 0.75rem;">In Progress</span>
          </div>
          <div class="col-md-3">
            <div class="text-muted fs-3"><i class="bi bi-truck"></i></div>
            <h6 class="text-muted fw-bold mb-0 small">Dispatched via TCS</h6>
            <span class="text-muted small" style="font-size: 0.75rem;">Expected Tomorrow</span>
          </div>
        </div>
      </div>

      <div class="row g-4">
        <!-- Order Items -->
        <div class="col-lg-8">
          <div class="bg-white p-4 border rounded-1 shadow-sm mb-4">
            <h5 class="fs-6 fw-bold text-uppercase mb-3">Purchased Footwear</h5>
            <div class="d-flex align-items-center gap-3 py-2 border-bottom">
              <img src="https://images.unsplash.com/photo-1614252235316-8c857d38b5f4?q=80&w=800&auto=format&fit=crop" alt="Regal Wholecut Oxford" class="rounded-1" style="width: 72px; height: 72px; object-fit: cover;">
              <div class="flex-grow-1">
                <h6 class="fw-bold mb-1"><a href="product-details.php" class="text-dark">Regal Wholecut Oxford</a></h6>
                <div class="text-muted small">Size: EU 42 &bull; Color: Nero Black &bull; SKU: NF-OXF-01</div>
              </div>
              <div class="text-end">
                <div class="fw-bold">PKR 14,999</div>
                <div class="text-muted small">Qty: 1</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Address and Breakdown -->
        <div class="col-lg-4">
          <div class="bg-white p-4 border rounded-1 shadow-sm mb-4">
            <h5 class="fs-6 fw-bold text-uppercase mb-3">Delivery Information</h5>
            <p class="small text-muted mb-0">
              <strong>Hamza Tariq</strong><br>
              Lahore, DHA Phase 5<br>
              Phone: +92 300 8472911<br>
              Email: hamza.tariq@gmail.com
            </p>
          </div>

          <div class="order-summary-box">
            <h5 class="fs-6 fw-bold text-uppercase mb-3">Cost Breakdown</h5>
            <div class="d-flex justify-content-between mb-2 small">
              <span class="text-muted">Item Subtotal</span>
              <span>PKR 14,999</span>
            </div>
            <div class="d-flex justify-content-between mb-2 small">
              <span class="text-muted">Courier Shipping</span>
              <span class="text-success fw-bold">FREE</span>
            </div>
            <hr class="my-2">
            <div class="d-flex justify-content-between fw-bold">
              <span>Total Payable</span>
              <span>PKR 14,999</span>
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