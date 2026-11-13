<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shoe Size Guide (EU 39 - 46) | NOVA FORM</title>
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
        <h1 class="h2 fw-bold font-editorial mb-1">Men's Footwear Size & Fitting Guide</h1>
        <p class="text-muted small mb-0">Follow our precise measuring instructions to find your ideal fit in EU sizes 39 through 46.</p>
      </div>

      <div class="row g-5">
        
        <!-- Table Column -->
        <div class="col-lg-7">
          <div class="bg-white p-4 border rounded-1 shadow-sm mb-4">
            <h5 class="fs-6 fw-bold text-uppercase mb-3">EU 39–46 Standard Conversion Chart</h5>
            <div class="table-responsive">
              <table class="table table-bordered text-center align-middle small mb-0">
                <thead class="table-dark">
                  <tr>
                    <th>EU Size</th>
                    <th>UK Equivalent</th>
                    <th>US Equivalent</th>
                    <th>Foot Length (CM)</th>
                    <th>Foot Length (Inches)</th>
                  </tr>
                </thead>
                <tbody>
                  
                    <tr class="">
                      <td><strong>EU 39</strong></td>
                      <td>UK 6</td>
                      <td>US 6.5</td>
                      <td>24.5 cm</td>
                      <td>9.6"</td>
                    </tr>
                  
                    <tr class="">
                      <td><strong>EU 40</strong></td>
                      <td>UK 6.5</td>
                      <td>US 7.5</td>
                      <td>25 cm</td>
                      <td>9.8"</td>
                    </tr>
                  
                    <tr class="">
                      <td><strong>EU 41</strong></td>
                      <td>UK 7.5</td>
                      <td>US 8.5</td>
                      <td>26 cm</td>
                      <td>10.2"</td>
                    </tr>
                  
                    <tr class="table-warning fw-bold">
                      <td><strong>EU 42</strong></td>
                      <td>UK 8.5</td>
                      <td>US 9.5</td>
                      <td>27 cm</td>
                      <td>10.6"</td>
                    </tr>
                  
                    <tr class="">
                      <td><strong>EU 43</strong></td>
                      <td>UK 9.5</td>
                      <td>US 10.5</td>
                      <td>28 cm</td>
                      <td>11"</td>
                    </tr>
                  
                    <tr class="">
                      <td><strong>EU 44</strong></td>
                      <td>UK 10.5</td>
                      <td>US 11.5</td>
                      <td>28.5 cm</td>
                      <td>11.2"</td>
                    </tr>
                  
                    <tr class="">
                      <td><strong>EU 45</strong></td>
                      <td>UK 11.5</td>
                      <td>US 12.5</td>
                      <td>29.5 cm</td>
                      <td>11.6"</td>
                    </tr>
                  
                    <tr class="">
                      <td><strong>EU 46</strong></td>
                      <td>UK 12.5</td>
                      <td>US 13.5</td>
                      <td>30.5 cm</td>
                      <td>12"</td>
                    </tr>
                  
                </tbody>
              </table>
            </div>
            <small class="text-muted d-block mt-3 fst-italic">
              * Note: Foot measurements are indicative. Because handcrafted lasts vary slightly by shoe silhouette (e.g. chisel-toe Oxfords vs wide-strap Peshawari Chappals), we offer a complimentary 15-day exchange if your chosen size requires adjustment.
            </small>
          </div>
        </div>

        <!-- How to Measure Instructions -->
        <div class="col-lg-5">
          <div class="bg-light p-4 border rounded-1 shadow-sm h-100">
            <h5 class="fs-6 fw-bold text-uppercase mb-3"><i class="bi bi-rulers me-2 text-warning"></i> How To Measure Your Foot</h5>
            
            <ol class="small text-muted ps-3 mb-4 d-flex flex-column gap-3" style="line-height: 1.7;">
              <li>
                <strong>Step onto Paper:</strong> Place a blank sheet of A4 paper on a hard, flat floor against a flat wall.
              </li>
              <li>
                <strong>Stand with Socks:</strong> Wear the typical socks you plan to wear with your dress shoes or loafers. Place your heel firmly touching the wall.
              </li>
              <li>
                <strong>Mark the Longest Point:</strong> Use a pen held vertically to mark the tip of your longest toe (usually the big toe or second toe).
              </li>
              <li>
                <strong>Measure with Ruler:</strong> Measure the distance from the edge of the paper to your mark in centimeters (cm).
              </li>
              <li>
                <strong>Match to Chart:</strong> Compare your measurement to our chart above. If you are between two sizes, choose the larger size for maximum comfort.
              </li>
            </ol>

            <div class="p-3 bg-white border rounded-1">
              <h6 class="fw-bold small mb-1">Wide Feet Advice</h6>
              <p class="text-muted small mb-0">
                Gentlemen with wider feet or higher insteps frequently prefer our <em>Plain Toe Derbies</em> or <em>Monk Straps</em> which allow variable buckle and lacing expansion.
              </p>
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