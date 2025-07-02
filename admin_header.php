<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Optional flash messages
if (isset($message)) {
   foreach ($message as $msg) {
      echo '
      <div class="alert alert-info alert-dismissible fade show m-0 text-center rounded-0" role="alert">
         ' . htmlspecialchars($msg) . '
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
   }
}

// Get current page for active link highlight
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!-- Bootstrap + Font Awesome -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>
   .navbar-brand span {
      color: #0d6efd;
      font-weight: bold;
   }
   .navbar .nav-link.active {
      font-weight: bold;
      color: #0d6efd !important;
   }
   .account-box {
      background-color: #e3f2fd;
      padding: 0.75rem 1rem;
      border-radius: 8px;
   }
</style>

<!-- Admin Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm sticky-top">
   <div class="container-fluid">
      <a class="navbar-brand d-flex align-items-center" href="admin_dashboard.php">
         <img src="images/favicons.png" alt="Admin Logo" width="40" height="40" class="me-2">
         <span>Admin <span>BookHaven</span></span>
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
         <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="adminNavbar">
         <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
               <a class="nav-link <?= $current_page === 'admin_dashboard.php' ? 'active' : '' ?>" href="admin_dashboard.php">
                  <i class="fas fa-home me-1"></i>Home
               </a>
            </li>
            <li class="nav-item">
               <a class="nav-link <?= $current_page === 'admin_products.php' ? 'active' : '' ?>" href="admin_products.php">
                  <i class="fas fa-book me-1"></i>Products
               </a>
            </li>
            <li class="nav-item">
               <a class="nav-link <?= $current_page === 'admin_orders.php' ? 'active' : '' ?>" href="admin_orders.php">
                  <i class="fas fa-box me-1"></i>Orders
               </a>
            </li>
            <li class="nav-item">
               <a class="nav-link <?= $current_page === 'admin_users.php' ? 'active' : '' ?>" href="admin_users.php">
                  <i class="fas fa-users me-1"></i>Users
               </a>
            </li>
            <li class="nav-item">
               <a class="nav-link <?= $current_page === 'admin_contacts.php' ? 'active' : '' ?>" href="admin_contacts.php">
                  <i class="fas fa-envelope me-1"></i>Messages
               </a>
            </li>
         </ul>
         <div class="d-flex align-items-center ms-3">
            <div class="account-box text-end">
               <p class="mb-1 small">👤 <strong><?= htmlspecialchars($_SESSION['admin_name'] ?? 'Admin') ?></strong></p>
               <p class="mb-1 small text-truncate">📧 <?= htmlspecialchars($_SESSION['admin_email'] ?? 'admin@example.com') ?></p>
               <a href="admin_logout.php" class="btn btn-sm btn-outline-danger mt-1">
                  <i class="fas fa-sign-out-alt me-1"></i>Logout
               </a>
            </div>
         </div>
      </div>
   </div>
</nav>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
