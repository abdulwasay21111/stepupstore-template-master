<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Orders | NOVA FORM</title>
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
          <li class="breadcrumb-item active" aria-current="page">My Orders</li>
        </ol>
      </nav>

      <div class="border-bottom pb-3 mb-4">
        <h1 class="h3 fw-bold font-editorial mb-1">Order History</h1>
        <p class="text-muted small mb-0">Review past and ongoing footwear dispatches with delivery statuses.</p>
      </div>

      <div class="bg-white border rounded-1 shadow-sm overflow-hidden">
        <div class="table-responsive">
          <table class="table cart-table mb-0">
            <thead>
              <tr>
                <th>Order Number</th>
                <th>Placement Date</th>
                <th>Items Ordered</th>
                <th>Payment Method</th>
                <th>Total Paid</th>
                <th>Dispatch Status</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td data-label="Order"><strong class="text-dark">#NF-88291</strong></td>
                <td data-label="Date" class="text-muted small">28 Oct 2026</td>
                <td data-label="Items">Regal Wholecut Oxford &bull; Nero Black (EU 42)</td>
                <td data-label="Payment"><span class="badge bg-light text-dark border">Cash on Delivery</span></td>
                <td data-label="Total" class="fw-bold">PKR 14,999</td>
                <td data-label="Status"><span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i> Processing</span></td>
                <td data-label="Action"><a href="order-details.php" class="btn btn-sm btn-nova-dark">View Details</a></td>
              </tr>
              <tr>
                <td data-label="Order"><strong class="text-dark">#NF-88102</strong></td>
                <td data-label="Date" class="text-muted small">14 Jul 2026</td>
                <td data-label="Items">Sienna Burnished Penny Loafer (EU 42)</td>
                <td data-label="Payment"><span class="badge bg-light text-dark border">Bank Transfer</span></td>
                <td data-label="Total" class="fw-bold">PKR 12,499</td>
                <td data-label="Status"><span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Delivered</span></td>
                <td data-label="Action"><a href="order-details.php" class="btn btn-sm btn-nova-dark">View Details</a></td>
              </tr>
              <tr>
                <td data-label="Order"><strong class="text-dark">#NF-87944</strong></td>
                <td data-label="Date" class="text-muted small">02 Apr 2026</td>
                <td data-label="Items">Khyber Heritage Peshawari Chappal (EU 42)</td>
                <td data-label="Payment"><span class="badge bg-light text-dark border">Cash on Delivery</span></td>
                <td data-label="Total" class="fw-bold">PKR 6,899</td>
                <td data-label="Status"><span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Delivered</span></td>
                <td data-label="Action"><a href="order-details.php" class="btn btn-sm btn-nova-dark">View Details</a></td>
              </tr>
            </tbody>
          </table>
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