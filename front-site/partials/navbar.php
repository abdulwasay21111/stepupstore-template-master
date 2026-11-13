<?php require_once __DIR__ . '/annoncmentbar.php'; ?>
<header class="nova-navbar">
    <div class="container">
      <div class="d-flex align-items-center justify-content-between">
        
        <!-- Mobile Menu Toggle Button -->
        <button class="navbar-toggler d-lg-none border-0 p-0 text-dark me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileNavOffcanvas" aria-controls="mobileNavOffcanvas">
          <i class="bi bi-list fs-2"></i>
        </button>

        <!-- Brand Identity -->
        <a href="index.php" class="brand-logo text-decoration-none me-4">
          NOVA FORM<span class="dot"></span>
        </a>

        <!-- Desktop Navigation Links -->
        <nav class="d-none d-lg-flex align-items-center gap-1">
          <a href="index.php" class="nav-link-nova active">Home</a>
          <a href="shop.php" class="nav-link-nova ">Shop All</a>
          
          <div class="dropdown">
            <a href="category.php" class="nav-link-nova dropdown-toggle " data-bs-toggle="dropdown" aria-expanded="false">
              Categories
            </a>
            <ul class="dropdown-menu dropdown-menu-nova shadow-sm">
              <li><a class="dropdown-item" href="category.php"><i class="bi bi-suit-club me-2 text-muted"></i> Formal Shoes</a></li>
              <li><a class="dropdown-item" href="category.php"><i class="bi bi-layers me-2 text-muted"></i> Luxury Loafers</a></li>
              <li><a class="dropdown-item" href="category.php"><i class="bi bi-compass me-2 text-muted"></i> Casual Shoes</a></li>
              <li><a class="dropdown-item" href="category.php"><i class="bi bi-lightning-charge me-2 text-muted"></i> Sneakers & Trainers</a></li>
              <li><a class="dropdown-item" href="category.php"><i class="bi bi-sun me-2 text-muted"></i> Leather Sandals</a></li>
              <li><a class="dropdown-item" href="category.php"><i class="bi bi-shield-check me-2 text-muted"></i> Traditional Peshawari</a></li>
              <li><a class="dropdown-item" href="category.php"><i class="bi bi-gem me-2 text-muted"></i> Chelsea & Boots</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger fw-semibold" href="shop.php"><i class="bi bi-tag me-2"></i> View Special Offers</a></li>
            </ul>
          </div>

          <a href="category.php" class="nav-link-nova">Formal</a>
          <a href="category.php" class="nav-link-nova">Loafers</a>
          <a href="category.php" class="nav-link-nova">Traditional</a>
          <a href="about.php" class="nav-link-nova ">About</a>
          <a href="shop.php" class="nav-link-nova sale-link">Sale</a>
        </nav>

        <!-- Action Icons -->
        <div class="d-flex align-items-center gap-1">
          <button class="nav-action-btn" data-bs-toggle="modal" data-bs-target="#searchModal" title="Search catalog">
            <i class="bi bi-search"></i>
          </button>
          
          <div class="dropdown">
            <button class="nav-action-btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" title="Account">
              <i class="bi bi-person"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-nova shadow-sm">
              <li><h6 class="dropdown-header text-uppercase text-muted small fw-bold">Customer Portal</h6></li>
              <li><a class="dropdown-item" href="account.php"><i class="bi bi-person-circle me-2 text-muted"></i> My Account</a></li>
              <li><a class="dropdown-item" href="orders.php"><i class="bi bi-bag-check me-2 text-muted"></i> Order History</a></li>
              <li><a class="dropdown-item" href="wishlist.php"><i class="bi bi-heart me-2 text-muted"></i> Wishlist</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="login.php"><i class="bi bi-box-arrow-in-right me-2 text-muted"></i> Sign In</a></li>
              <li><a class="dropdown-item" href="register.php"><i class="bi bi-person-plus me-2 text-muted"></i> Create Account</a></li>
            </ul>
          </div>

          <a href="wishlist.php" class="nav-action-btn" title="Saved Wishlist">
            <i class="bi bi-heart"></i>
            <span class="nav-action-badge wishlist-count-badge">3</span>
          </a>

          <a href="cart.php" class="nav-action-btn" title="Shopping Bag">
            <i class="bi bi-bag"></i>
            <span class="nav-action-badge cart-count-badge">2</span>
          </a>
        </div>

      </div>
    </div>
  </header>