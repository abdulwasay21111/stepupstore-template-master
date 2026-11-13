<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shopping Bag | NOVA FORM</title>
  <meta name="description" content="View your NOVA FORM shopping bag, apply promotional vouchers, and proceed to checkout.">
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
      
      <!-- Page Title -->
      <div class="border-bottom pb-3 mb-4">
        <h1 class="h3 fw-bold font-editorial mb-1">Your Shopping Bag</h1>
        <p class="text-muted small mb-0">Review your chosen footwear models and specify delivery details.</p>
      </div>

      <div id="cartTableWrapper">
        <div class="row g-4">
          
          <!-- Items List Col -->
          <div class="col-lg-8">
            <div class="bg-white border rounded-1 shadow-sm overflow-hidden mb-4">
              <table class="table cart-table mb-0">
                <thead>
                  <tr>
                    <th>Footwear Item</th>
                    <th>Size & Color</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Line Total</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Item 1 -->
                  <tr class="cart-item-row" data-price="14999">
                    <td data-label="Item">
                      <div class="d-flex align-items-center gap-3">
                        <img src="https://images.unsplash.com/photo-1614252235316-8c857d38b5f4?q=80&w=800&auto=format&fit=crop" alt="Regal Wholecut Oxford" class="rounded-1" style="width: 72px; height: 72px; object-fit: cover;">
                        <div>
                          <h6 class="mb-1 fw-bold"><a href="product-details.php" class="text-dark">Regal Wholecut Oxford</a></h6>
                          <div class="text-muted small">NF-OXF-01</div>
                        </div>
                      </div>
                    </td>
                    <td data-label="Variant">
                      <span class="badge bg-light text-dark border">EU 42</span><br>
                      <small class="text-muted">Nero Black</small>
                    </td>
                    <td data-label="Price" class="fw-semibold">PKR 14,999</td>
                    <td data-label="Quantity">
                      <div class="quantity-control">
                        <button type="button" class="quantity-btn quantity-btn-dec"><i class="bi bi-dash"></i></button>
                        <input type="text" class="quantity-input" value="1" readonly>
                        <button type="button" class="quantity-btn quantity-btn-inc"><i class="bi bi-plus"></i></button>
                      </div>
                    </td>
                    <td data-label="Total" class="fw-bold line-total-val">PKR 14,999</td>
                    <td data-label="Action">
                      <button class="btn btn-sm btn-link text-danger btn-remove-cart" title="Remove Item"><i class="bi bi-trash3"></i></button>
                    </td>
                  </tr>

                  <!-- Item 2 -->
                  <tr class="cart-item-row" data-price="12499">
                    <td data-label="Item">
                      <div class="d-flex align-items-center gap-3">
                        <img src="https://images.unsplash.com/photo-1533867617858-e7b97e060509?q=80&w=800&auto=format&fit=crop" alt="Sienna Burnished Penny Loafer" class="rounded-1" style="width: 72px; height: 72px; object-fit: cover;">
                        <div>
                          <h6 class="mb-1 fw-bold"><a href="product-details.php" class="text-dark">Sienna Burnished Penny Loafer</a></h6>
                          <div class="text-muted small">NF-PEN-02</div>
                        </div>
                      </div>
                    </td>
                    <td data-label="Variant">
                      <span class="badge bg-light text-dark border">EU 43</span><br>
                      <small class="text-muted">Sienna Tan</small>
                    </td>
                    <td data-label="Price" class="fw-semibold">PKR 12,499</td>
                    <td data-label="Quantity">
                      <div class="quantity-control">
                        <button type="button" class="quantity-btn quantity-btn-dec"><i class="bi bi-dash"></i></button>
                        <input type="text" class="quantity-input" value="1" readonly>
                        <button type="button" class="quantity-btn quantity-btn-inc"><i class="bi bi-plus"></i></button>
                      </div>
                    </td>
                    <td data-label="Total" class="fw-bold line-total-val">PKR 12,499</td>
                    <td data-label="Action">
                      <button class="btn btn-sm btn-link text-danger btn-remove-cart" title="Remove Item"><i class="bi bi-trash3"></i></button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <a href="shop.php" class="btn btn-nova-outline"><i class="bi bi-arrow-left me-2"></i> Continue Shopping</a>
              <span class="text-muted small">Standard Express Delivery takes 2-3 business days.</span>
            </div>
          </div>

          <!-- Order Summary Col -->
          <div class="col-lg-4">
            <div class="order-summary-box">
              <h5 class="fw-bold text-uppercase fs-6 mb-3">Order Summary</h5>
              
              <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Bag Subtotal</span>
                <span class="fw-semibold" id="cartSubtotal">PKR 27,498</span>
              </div>

              <div class="d-flex justify-content-between mb-3">
                <span class="text-muted">Nationwide Delivery</span>
                <span class="fw-semibold text-success" id="cartShippingVal">FREE</span>
              </div>

              <hr class="my-3">

              <div class="d-flex justify-content-between align-items-baseline mb-4">
                <span class="fw-bold text-dark fs-5">Estimated Total</span>
                <span class="fs-4 fw-bold text-dark" id="cartGrandTotal">PKR 27,498</span>
              </div>

              <a href="checkout.php" class="btn btn-nova-dark w-100 py-3 text-center mb-3">
                Proceed To Checkout <i class="bi bi-arrow-right ms-2"></i>
              </a>

              <div class="text-center">
                <span class="text-muted small"><i class="bi bi-shield-lock me-1"></i> Cash on Delivery & SSL Protected</span>
              </div>
            </div>
          </div>

        </div>
      </div>

      <!-- Empty State -->
      <div id="emptyCartState" class="d-none text-center py-5">
        <i class="bi bi-bag-x display-1 text-muted"></i>
        <h3 class="fw-bold font-editorial mt-3">Your Shopping Bag is Currently Empty</h3>
        <p class="text-muted mb-4">Discover our handcrafted men's formal dress shoes, loafers, and traditional styles.</p>
        <a href="shop.php" class="btn btn-nova-dark">Explore The Collection</a>
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