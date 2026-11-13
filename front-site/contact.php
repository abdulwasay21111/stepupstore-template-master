<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact & Ateliers | NOVA FORM Pakistan</title>
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
      
      <div class="border-bottom pb-3 mb-4">
        <h1 class="h2 fw-bold font-editorial mb-1">Client Concierge & Ateliers</h1>
        <p class="text-muted small mb-0">Reach our bespoke shoe fitting advisors or visit an atelier in Lahore, Karachi, or Islamabad.</p>
      </div>

      <div class="row g-5">
        <!-- Contact Form -->
        <div class="col-lg-6">
          <div class="bg-white p-4 p-md-5 border rounded-1 shadow-sm">
            <h3 class="fs-5 fw-bold font-editorial mb-3">Send a Message</h3>
            <p class="text-muted small mb-4">Have an inquiry regarding custom sizing, wedding orders, or bulk corporate gifting?</p>

            <form id="demoContactForm">
              <div class="mb-3">
                <label class="form-label-nova">Your Full Name *</label>
                <input type="text" class="form-control form-control-nova" placeholder="e.g. Asad Mehmood" required>
              </div>

              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <label class="form-label-nova">Email Address *</label>
                  <input type="email" class="form-control form-control-nova" placeholder="name@domain.com" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label-nova">Phone Number</label>
                  <input type="tel" class="form-control form-control-nova" placeholder="+92 300 0000000">
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label-nova">Subject</label>
                <select class="form-select form-select-nova">
                  <option selected>Shoe Size & Fitting Consultation</option>
                  <option>Exchange / Return Request</option>
                  <option>Groomsmen Wedding Collection Inquiry</option>
                  <option>Corporate Orders & Gifting</option>
                  <option>Other Question</option>
                </select>
              </div>

              <div class="mb-4">
                <label class="form-label-nova">Message *</label>
                <textarea class="form-control form-control-nova" rows="4" placeholder="How can our shoemakers assist you?" required></textarea>
              </div>

              <button type="submit" class="btn btn-nova-dark w-100 py-3">Transmit Message</button>
            </form>
          </div>
        </div>

        <!-- Ateliers Details -->
        <div class="col-lg-6">
          <div class="d-flex flex-column gap-4">
            
            <div class="p-4 bg-white border rounded-1 shadow-sm">
              <div class="d-flex align-items-center gap-2 mb-2 text-warning fs-5">
                <i class="bi bi-geo-alt"></i>
                <h5 class="text-dark fw-bold mb-0 fs-6">Lahore Flagship Atelier</h5>
              </div>
              <p class="text-muted small mb-2">92-B/II, MM Alam Road, Gulberg III, Lahore, Pakistan</p>
              <p class="text-muted small mb-0"><i class="bi bi-telephone me-1"></i> +92 (042) 3578-9921 &bull; Hours: 11:00 AM - 10:00 PM</p>
            </div>

            <div class="p-4 bg-white border rounded-1 shadow-sm">
              <div class="d-flex align-items-center gap-2 mb-2 text-warning fs-5">
                <i class="bi bi-geo-alt"></i>
                <h5 class="text-dark fw-bold mb-0 fs-6">Karachi Bukhari Atelier</h5>
              </div>
              <p class="text-muted small mb-2">Lane 4, Bukhari Commercial, DHA Phase VI, Karachi, Pakistan</p>
              <p class="text-muted small mb-0"><i class="bi bi-telephone me-1"></i> +92 (021) 3584-1102 &bull; Hours: 12:00 PM - 11:00 PM</p>
            </div>

            <div class="p-4 bg-white border rounded-1 shadow-sm">
              <div class="d-flex align-items-center gap-2 mb-2 text-warning fs-5">
                <i class="bi bi-geo-alt"></i>
                <h5 class="text-dark fw-bold mb-0 fs-6">Islamabad Blue Area Atelier</h5>
              </div>
              <p class="text-muted small mb-2">Shop 14, Beverly Centre, Jinnah Avenue, Blue Area, Islamabad</p>
              <p class="text-muted small mb-0"><i class="bi bi-telephone me-1"></i> +92 (051) 2871-449 &bull; Hours: 11:00 AM - 09:30 PM</p>
            </div>

            <div class="p-4 bg-light border rounded-1">
              <h6 class="fw-bold text-uppercase small mb-2"><i class="bi bi-headset me-2 text-warning"></i> National Customer Concierge</h6>
              <p class="text-muted small mb-1">WhatsApp Helpline: <strong>+92 300 8472911</strong></p>
              <p class="text-muted small mb-0">Email: <strong>concierge@novaformshoes.pk</strong></p>
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