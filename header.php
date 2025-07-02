<?php
include 'config.php';
if (session_status() === PHP_SESSION_NONE) {
   session_start();
}

// Cart item count (optional: show 0 if not logged in)
$user_id = $_SESSION['user_id'] ?? null;
$cart_count = 0;
if ($user_id) {
   $cart_result = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$user_id'");
   $cart_count = mysqli_num_rows($cart_result);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>BookHaven</title>
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
   <!-- Bootstrap 5 CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
   <!-- FontAwesome for icons -->
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
   <!-- Custom CSS -->
   <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body class="bg-white text-dark">

<!-- Top Bar with Social Links -->
<div class="bg-primary text-white py-1">
   <div class="container d-flex justify-content-between">
      <div>
         <a href="#" class="text-white me-2"><i class="fab fa-facebook-f"></i></a>
         <a href="#" class="text-white me-2"><i class="fab fa-twitter"></i></a>
         <a href="#" class="text-white me-2"><i class="fab fa-instagram"></i></a>
         <a href="#" class="text-white"><i class="fab fa-youtube"></i></a>
      </div>
      <div>
         <?php if (!$user_id): ?>
            <a href="login.php" class="text-white text-decoration-none me-2">Login</a> |
            <a href="register.php" class="text-white text-decoration-none ms-2">Register</a>
         <?php endif; ?>
      </div>
   </div>
</div>

<!-- Main Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
   <div class="container">
      <a class="navbar-brand d-flex align-items-center fw-bold text-primary" href="index.php">
         <img src="images/favicons.png" alt="Logo" width="50" height="50" class="me-2">
         BookHaven
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
         <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
         <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
            <li class="nav-item"><a class="nav-link" href="shop.php">Shop</a></li>
            <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
            <li class="nav-item"><a class="nav-link" href="orders.php">Orders</a></li>
            <li class="nav-item"><a class="nav-link" href="search.php"><i class="fas fa-search"></i></a></li>
            <li class="nav-item">
               <a class="nav-link position-relative" href="cart.php">
                  <i class="fas fa-shopping-cart"></i>
                  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                     <?= $cart_count ?>
                  </span>
               </a>
            </li>
         </ul>

         <?php if ($user_id): ?>
         <!-- Member Dropdown -->
         <div class="dropdown ms-lg-3">
            <a class="btn btn-outline-primary dropdown-toggle" href="#" role="button" id="memberDropdown" data-bs-toggle="dropdown">
               <i class="fas fa-user"></i> Member
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="memberDropdown">
               <li class="px-3 py-2">
                  <strong>Username:</strong> <?= $_SESSION['user_name'] ?? 'User' ?><br>
                  <strong>Email:</strong> <?= $_SESSION['user_email'] ?? '-' ?>
               </li>
               <li><hr class="dropdown-divider"></li>
               <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
            </ul>
         </div>
         <?php endif; ?>
      </div>
   </div>
</nav>

<main class="container py-4">
