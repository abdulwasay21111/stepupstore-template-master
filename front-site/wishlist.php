<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Saved Wishlist | NOVA FORM</title>
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
        <h1 class="h3 fw-bold font-editorial mb-1">Your Saved Footwear Wishlist</h1>
        <p class="text-muted small mb-0">Shoes and loafers curated for your personal shoe collection.</p>
      </div>

      <div class="row g-3 g-md-4">
        
          <div class="col-lg-4 col-md-6">
            <div class="product-card">
              <div class="product-img-wrap">
                <a href="product-details.php">
                  <img src="https://images.unsplash.com/photo-1533867617858-e7b97e060509?q=80&w=800&auto=format&fit=crop" alt="Sienna Burnished Penny Loafer">
                </a>
              </div>
              <div class="product-info">
                <div class="product-category">Loafers</div>
                <h3 class="product-name"><a href="product-details.php">Sienna Burnished Penny Loafer</a></h3>
                <div class="product-price-box mb-3">
                  <span class="current-price">PKR 12,499</span>
                </div>
                <div class="d-flex gap-2">
                  <button class="btn btn-nova-dark btn-sm flex-grow-1 btn-quick-add" data-product-title="Sienna Burnished Penny Loafer">
                    <i class="bi bi-bag-plus me-1"></i> Add To Bag
                  </button>
                  <button class="btn btn-outline-danger btn-sm" onclick="this.closest('.col-lg-4').remove(); alert('Removed from wishlist');">
                    <i class="bi bi-trash"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        
          <div class="col-lg-4 col-md-6">
            <div class="product-card">
              <div class="product-img-wrap">
                <a href="product-details.php">
                  <img src="https://images.unsplash.com/photo-1560769629-975ec94e6a86?q=80&w=800&auto=format&fit=crop" alt="Kensington Braided Tassel Loafer">
                </a>
              </div>
              <div class="product-info">
                <div class="product-category">Loafers</div>
                <h3 class="product-name"><a href="product-details.php">Kensington Braided Tassel Loafer</a></h3>
                <div class="product-price-box mb-3">
                  <span class="current-price">PKR 13,200</span>
                </div>
                <div class="d-flex gap-2">
                  <button class="btn btn-nova-dark btn-sm flex-grow-1 btn-quick-add" data-product-title="Kensington Braided Tassel Loafer">
                    <i class="bi bi-bag-plus me-1"></i> Add To Bag
                  </button>
                  <button class="btn btn-outline-danger btn-sm" onclick="this.closest('.col-lg-4').remove(); alert('Removed from wishlist');">
                    <i class="bi bi-trash"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        
          <div class="col-lg-4 col-md-6">
            <div class="product-card">
              <div class="product-img-wrap">
                <a href="product-details.php">
                  <img src="https://images.unsplash.com/photo-1543163521-1bf539c55dd2?q=80&w=800&auto=format&fit=crop" alt="Mayfair Double Monk Strap">
                </a>
              </div>
              <div class="product-info">
                <div class="product-category">Formal Shoes</div>
                <h3 class="product-name"><a href="product-details.php">Mayfair Double Monk Strap</a></h3>
                <div class="product-price-box mb-3">
                  <span class="current-price">PKR 15,499</span>
                </div>
                <div class="d-flex gap-2">
                  <button class="btn btn-nova-dark btn-sm flex-grow-1 btn-quick-add" data-product-title="Mayfair Double Monk Strap">
                    <i class="bi bi-bag-plus me-1"></i> Add To Bag
                  </button>
                  <button class="btn btn-outline-danger btn-sm" onclick="this.closest('.col-lg-4').remove(); alert('Removed from wishlist');">
                    <i class="bi bi-trash"></i>
                  </button>
                </div>
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