








<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formal Shoes & Luxury Loafers | NOVA FORM</title>
  <meta name="description" content="Shop handcrafted men's formal shoes, cap-toe Oxfords, wingtip Brogues, and luxury Penny Loafers.">
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
  

  <main>
    <!-- Category Hero Banner -->
    <div class="position-relative bg-dark text-white py-5" style="background: linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)), url('https://images.unsplash.com/photo-1614252235316-8c857d38b5f4?q=80&w=1600&auto=format&fit=crop') center/cover;">
      <div class="container py-4">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-nova text-white-50">
            <li class="breadcrumb-item"><a href="index.php" class="text-white-50">Home</a></li>
            <li class="breadcrumb-item"><a href="shop.php" class="text-white-50">Categories</a></li>
            <li class="breadcrumb-item active text-white" aria-current="page">Formal Shoes & Loafers</li>
          </ol>
        </nav>
        <div class="max-w-700">
          <span class="badge bg-warning text-dark text-uppercase fw-bold px-3 py-1 mb-2">Category Showcase</span>
          <h1 class="display-5 fw-bold font-editorial text-white mb-2">Formal Shoes & Luxury Loafers</h1>
          <p class="lead text-white-50 mb-0" style="max-width: 650px;">
            From black-tie Oxfords to supple Italian-cut Penny Loafers, our dress shoe atelier combines bespoke lasts with glove-soft calfskin.
          </p>
        </div>
      </div>
    </div>



    <div class="container py-5">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="text-muted small">Showing <strong>9</strong> handcrafted models</div>
        <div class="d-flex align-items-center gap-2">
          <label class="small text-muted mb-0">Sort:</label>
          <select class="form-select form-select-sm" style="width: 170px;">
            <option>Featured First</option>
            <option>Price: Low to High</option>
            <option>Price: High to Low</option>
          </select>
        </div>
      </div>

      <div class="row g-3 g-md-4">
        
          <div class="col-lg-3 col-md-6 col-6 col-product-grid">
            
  <div class="product-card">
    <div class="product-img-wrap">
      <div class="product-badges">
        <span class="badge-sale">Sale</span>
        
      </div>
      <button class="product-wishlist-btn" title="Add to Wishlist" data-product-id="NF-1001">
        <i class="bi bi-heart"></i>
      </button>
      <a href="product-details.php">
        <img src="https://images.unsplash.com/photo-1614252235316-8c857d38b5f4?q=80&w=800&auto=format&fit=crop" alt="Regal Wholecut Oxford" loading="lazy">
      </a>
      <div class="product-quick-actions">
        <button class="quick-view-btn btn-quick-add" data-product-title="Regal Wholecut Oxford">
          <i class="bi bi-bag-plus me-1"></i> Quick Add
        </button>
      </div>
    </div>
    <div class="product-info">
      <div class="product-category">Formal Shoes</div>
      <h3 class="product-name">
        <a href="product-details.php">Regal Wholecut Oxford</a>
      </h3>
      <div class="product-rating">
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <span class="count">(38)</span>
      </div>
      <div class="product-price-box">
        <span class="current-price">PKR 14,999</span>
        <span class="original-price">PKR 17,500</span>
      </div>
      <div class="product-colors">
        <span class="color-dot" style="background-color: #141414;" title="Available Color"></span><span class="color-dot" style="background-color: #4a2c11;" title="Available Color"></span>
      </div>
    </div>
  </div>
  
          </div>
        
          <div class="col-lg-3 col-md-6 col-6 col-product-grid">
            
  <div class="product-card">
    <div class="product-img-wrap">
      <div class="product-badges">
        
        <span class="badge-new">New</span>
      </div>
      <button class="product-wishlist-btn" title="Add to Wishlist" data-product-id="NF-1002">
        <i class="bi bi-heart"></i>
      </button>
      <a href="product-details.php">
        <img src="https://images.unsplash.com/photo-1533867617858-e7b97e060509?q=80&w=800&auto=format&fit=crop" alt="Sienna Burnished Penny Loafer" loading="lazy">
      </a>
      <div class="product-quick-actions">
        <button class="quick-view-btn btn-quick-add" data-product-title="Sienna Burnished Penny Loafer">
          <i class="bi bi-bag-plus me-1"></i> Quick Add
        </button>
      </div>
    </div>
    <div class="product-info">
      <div class="product-category">Loafers</div>
      <h3 class="product-name">
        <a href="product-details.php">Sienna Burnished Penny Loafer</a>
      </h3>
      <div class="product-rating">
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <span class="count">(52)</span>
      </div>
      <div class="product-price-box">
        <span class="current-price">PKR 12,499</span>
        <span class="original-price">PKR 14,000</span>
      </div>
      <div class="product-colors">
        <span class="color-dot" style="background-color: #633d1c;" title="Available Color"></span><span class="color-dot" style="background-color: #141414;" title="Available Color"></span><span class="color-dot" style="background-color: #8c5324;" title="Available Color"></span>
      </div>
    </div>
  </div>
  
          </div>
        
          <div class="col-lg-3 col-md-6 col-6 col-product-grid">
            
  <div class="product-card">
    <div class="product-img-wrap">
      <div class="product-badges">
        <span class="badge-sale">Sale</span>
        
      </div>
      <button class="product-wishlist-btn" title="Add to Wishlist" data-product-id="NF-1003">
        <i class="bi bi-heart"></i>
      </button>
      <a href="product-details.php">
        <img src="https://images.unsplash.com/photo-1560769629-975ec94e6a86?q=80&w=800&auto=format&fit=crop" alt="Kensington Braided Tassel Loafer" loading="lazy">
      </a>
      <div class="product-quick-actions">
        <button class="quick-view-btn btn-quick-add" data-product-title="Kensington Braided Tassel Loafer">
          <i class="bi bi-bag-plus me-1"></i> Quick Add
        </button>
      </div>
    </div>
    <div class="product-info">
      <div class="product-category">Loafers</div>
      <h3 class="product-name">
        <a href="product-details.php">Kensington Braided Tassel Loafer</a>
      </h3>
      <div class="product-rating">
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <span class="count">(29)</span>
      </div>
      <div class="product-price-box">
        <span class="current-price">PKR 13,200</span>
        <span class="original-price">PKR 15,500</span>
      </div>
      <div class="product-colors">
        <span class="color-dot" style="background-color: #422817;" title="Available Color"></span><span class="color-dot" style="background-color: #141414;" title="Available Color"></span>
      </div>
    </div>
  </div>
  
          </div>
        
          <div class="col-lg-3 col-md-6 col-6 col-product-grid">
            
  <div class="product-card">
    <div class="product-img-wrap">
      <div class="product-badges">
        <span class="badge-sale">Sale</span>
        
      </div>
      <button class="product-wishlist-btn" title="Add to Wishlist" data-product-id="NF-1004">
        <i class="bi bi-heart"></i>
      </button>
      <a href="product-details.php">
        <img src="https://images.unsplash.com/photo-1543163521-1bf539c55dd2?q=80&w=800&auto=format&fit=crop" alt="Mayfair Double Monk Strap" loading="lazy">
      </a>
      <div class="product-quick-actions">
        <button class="quick-view-btn btn-quick-add" data-product-title="Mayfair Double Monk Strap">
          <i class="bi bi-bag-plus me-1"></i> Quick Add
        </button>
      </div>
    </div>
    <div class="product-info">
      <div class="product-category">Formal Shoes</div>
      <h3 class="product-name">
        <a href="product-details.php">Mayfair Double Monk Strap</a>
      </h3>
      <div class="product-rating">
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <span class="count">(22)</span>
      </div>
      <div class="product-price-box">
        <span class="current-price">PKR 15,499</span>
        <span class="original-price">PKR 18,000</span>
      </div>
      <div class="product-colors">
        <span class="color-dot" style="background-color: #141414;" title="Available Color"></span><span class="color-dot" style="background-color: #543015;" title="Available Color"></span>
      </div>
    </div>
  </div>
  
          </div>
        
          <div class="col-lg-3 col-md-6 col-6 col-product-grid">
            
  <div class="product-card">
    <div class="product-img-wrap">
      <div class="product-badges">
        
        
      </div>
      <button class="product-wishlist-btn" title="Add to Wishlist" data-product-id="NF-1009">
        <i class="bi bi-heart"></i>
      </button>
      <a href="product-details.php">
        <img src="https://images.unsplash.com/photo-1582898967732-7235a8e0f93a?q=80&w=800&auto=format&fit=crop" alt="Westminster Wingtip Derby Brogue" loading="lazy">
      </a>
      <div class="product-quick-actions">
        <button class="quick-view-btn btn-quick-add" data-product-title="Westminster Wingtip Derby Brogue">
          <i class="bi bi-bag-plus me-1"></i> Quick Add
        </button>
      </div>
    </div>
    <div class="product-info">
      <div class="product-category">Formal Shoes</div>
      <h3 class="product-name">
        <a href="product-details.php">Westminster Wingtip Derby Brogue</a>
      </h3>
      <div class="product-rating">
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <span class="count">(31)</span>
      </div>
      <div class="product-price-box">
        <span class="current-price">PKR 13,999</span>
        <span class="original-price">PKR 16,000</span>
      </div>
      <div class="product-colors">
        <span class="color-dot" style="background-color: #522915;" title="Available Color"></span><span class="color-dot" style="background-color: #141414;" title="Available Color"></span>
      </div>
    </div>
  </div>
  
          </div>
        
          <div class="col-lg-3 col-md-6 col-6 col-product-grid">
            
  <div class="product-card">
    <div class="product-img-wrap">
      <div class="product-badges">
        <span class="badge-sale">Sale</span>
        <span class="badge-new">New</span>
      </div>
      <button class="product-wishlist-btn" title="Add to Wishlist" data-product-id="NF-1010">
        <i class="bi bi-heart"></i>
      </button>
      <a href="product-details.php">
        <img src="https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?q=80&w=800&auto=format&fit=crop" alt="Amalfi Velour Suede Loafer" loading="lazy">
      </a>
      <div class="product-quick-actions">
        <button class="quick-view-btn btn-quick-add" data-product-title="Amalfi Velour Suede Loafer">
          <i class="bi bi-bag-plus me-1"></i> Quick Add
        </button>
      </div>
    </div>
    <div class="product-info">
      <div class="product-category">Loafers</div>
      <h3 class="product-name">
        <a href="product-details.php">Amalfi Velour Suede Loafer</a>
      </h3>
      <div class="product-rating">
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <span class="count">(26)</span>
      </div>
      <div class="product-price-box">
        <span class="current-price">PKR 11,999</span>
        <span class="original-price">PKR 13,500</span>
      </div>
      <div class="product-colors">
        <span class="color-dot" style="background-color: #3b4959;" title="Available Color"></span><span class="color-dot" style="background-color: #b39474;" title="Available Color"></span><span class="color-dot" style="background-color: #504136;" title="Available Color"></span>
      </div>
    </div>
  </div>
  
          </div>
        
          <div class="col-lg-3 col-md-6 col-6 col-product-grid">
            
  <div class="product-card">
    <div class="product-img-wrap">
      <div class="product-badges">
        
        <span class="badge-new">New</span>
      </div>
      <button class="product-wishlist-btn" title="Add to Wishlist" data-product-id="NF-1014">
        <i class="bi bi-heart"></i>
      </button>
      <a href="product-details.php">
        <img src="https://images.unsplash.com/photo-1614252235316-8c857d38b5f4?q=80&w=800&auto=format&fit=crop" alt="Edinburgh Plain Toe Derby" loading="lazy">
      </a>
      <div class="product-quick-actions">
        <button class="quick-view-btn btn-quick-add" data-product-title="Edinburgh Plain Toe Derby">
          <i class="bi bi-bag-plus me-1"></i> Quick Add
        </button>
      </div>
    </div>
    <div class="product-info">
      <div class="product-category">Formal Shoes</div>
      <h3 class="product-name">
        <a href="product-details.php">Edinburgh Plain Toe Derby</a>
      </h3>
      <div class="product-rating">
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <span class="count">(15)</span>
      </div>
      <div class="product-price-box">
        <span class="current-price">PKR 12,999</span>
        <span class="original-price">PKR 14,500</span>
      </div>
      <div class="product-colors">
        <span class="color-dot" style="background-color: #111111;" title="Available Color"></span><span class="color-dot" style="background-color: #4f2b14;" title="Available Color"></span>
      </div>
    </div>
  </div>
  
          </div>
        
          <div class="col-lg-3 col-md-6 col-6 col-product-grid">
            
  <div class="product-card">
    <div class="product-img-wrap">
      <div class="product-badges">
        
        <span class="badge-new">New</span>
      </div>
      <button class="product-wishlist-btn" title="Add to Wishlist" data-product-id="NF-1023">
        <i class="bi bi-heart"></i>
      </button>
      <a href="product-details.php">
        <img src="https://images.unsplash.com/photo-1533867617858-e7b97e060509?q=80&w=800&auto=format&fit=crop" alt="Portofino Woven Leather Penny Loafer" loading="lazy">
      </a>
      <div class="product-quick-actions">
        <button class="quick-view-btn btn-quick-add" data-product-title="Portofino Woven Leather Penny Loafer">
          <i class="bi bi-bag-plus me-1"></i> Quick Add
        </button>
      </div>
    </div>
    <div class="product-info">
      <div class="product-category">Loafers</div>
      <h3 class="product-name">
        <a href="product-details.php">Portofino Woven Leather Penny Loafer</a>
      </h3>
      <div class="product-rating">
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <span class="count">(19)</span>
      </div>
      <div class="product-price-box">
        <span class="current-price">PKR 14,499</span>
        <span class="original-price">PKR 16,500</span>
      </div>
      <div class="product-colors">
        <span class="color-dot" style="background-color: #54321b;" title="Available Color"></span><span class="color-dot" style="background-color: #141414;" title="Available Color"></span>
      </div>
    </div>
  </div>
  
          </div>
        
          <div class="col-lg-3 col-md-6 col-6 col-product-grid">
            
  <div class="product-card">
    <div class="product-img-wrap">
      <div class="product-badges">
        <span class="badge-sale">Sale</span>
        
      </div>
      <button class="product-wishlist-btn" title="Add to Wishlist" data-product-id="NF-1024">
        <i class="bi bi-heart"></i>
      </button>
      <a href="product-details.php">
        <img src="https://images.unsplash.com/photo-1614252235316-8c857d38b5f4?q=80&w=800&auto=format&fit=crop" alt="Cambridge Cap-Toe Semi-Brogue" loading="lazy">
      </a>
      <div class="product-quick-actions">
        <button class="quick-view-btn btn-quick-add" data-product-title="Cambridge Cap-Toe Semi-Brogue">
          <i class="bi bi-bag-plus me-1"></i> Quick Add
        </button>
      </div>
    </div>
    <div class="product-info">
      <div class="product-category">Formal Shoes</div>
      <h3 class="product-name">
        <a href="product-details.php">Cambridge Cap-Toe Semi-Brogue</a>
      </h3>
      <div class="product-rating">
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <span class="count">(35)</span>
      </div>
      <div class="product-price-box">
        <span class="current-price">PKR 13,999</span>
        <span class="original-price">PKR 15,999</span>
      </div>
      <div class="product-colors">
        <span class="color-dot" style="background-color: #141414;" title="Available Color"></span><span class="color-dot" style="background-color: #4a2c14;" title="Available Color"></span>
      </div>
    </div>
  </div>
  
          </div>
        
      </div>

      <!-- Pagination -->
      <nav class="mt-5 d-flex justify-content-center" aria-label="Page navigation">
        <ul class="pagination pagination-sm">
          <li class="page-item active"><a class="page-link" href="#">1</a></li>
          <li class="page-item"><a class="page-link" href="#">2</a></li>
          <li class="page-item"><a class="page-link" href="#"><i class="bi bi-chevron-right"></i></a></li>
        </ul>
      </nav>
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