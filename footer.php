<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>BookHaven Footer Test</title>
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <!-- Bootstrap 5.3 CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

   <!-- FontAwesome -->
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

   <style>
      html, body {
   height: 100%;
   margin: 0;
}

body {
   display: flex;
   flex-direction: column;
}

main {
   flex: 1 0 auto;
}

footer {
   flex-shrink: 0;
}
   </style>
</head>
<body class="bg-white text-dark">
   
<footer class="bg-primary text-white pt-5 pb-3 mt-5">
   <div class="container-fluid px-5">
      <div class="row">
         <div class="col-md-3 mb-4">
            <h5 class="text-uppercase mb-3">Quick Links</h5>
            <ul class="list-unstyled">
               <li><a href="index.php" class="text-white text-decoration-none">Home</a></li>
               <li><a href="about.php" class="text-white text-decoration-none">About Us</a></li>
               <li><a href="shop.php" class="text-white text-decoration-none">Shop</a></li>
               <li><a href="contact.php" class="text-white text-decoration-none">Contact Us</a></li>
            </ul>
         </div>
         <div class="col-md-3 mb-4">
            <h5 class="text-uppercase mb-3">Account</h5>
            <ul class="list-unstyled">
               <li><a href="login.php" class="text-white text-decoration-none">Login</a></li>
               <li><a href="register.php" class="text-white text-decoration-none">Register</a></li>
               <li><a href="cart.php" class="text-white text-decoration-none">Cart</a></li>
               <li><a href="orders.php" class="text-white text-decoration-none">Orders</a></li>
            </ul>
         </div>
         <div class="col-md-3 mb-4">
            <h5 class="text-uppercase mb-3">Contact</h5>
            <p><i class="fas fa-phone me-2"></i> +60 3798798796</p>
            <p><i class="fas fa-envelope me-2"></i> bookhaven@gmail.com</p>
            <p><i class="fas fa-map-marker-alt me-2"></i> Tanjong Malim, Perak</p>
         </div>
         <div class="col-md-3 mb-4">
            <h5 class="text-uppercase mb-3">Follow Us</h5>
            <a href="#" class="text-white d-block mb-1"><i class="fab fa-facebook-f me-2"></i> Facebook</a>
            <a href="#" class="text-white d-block mb-1"><i class="fab fa-twitter me-2"></i> Twitter</a>
            <a href="#" class="text-white d-block mb-1"><i class="fab fa-instagram me-2"></i> Instagram</a>
            <a href="#" class="text-white d-block"><i class="fab fa-youtube me-2"></i> YouTube</a>
         </div>
      </div>
      <div class="text-center border-top border-white pt-3 mt-4">
         <p class="mb-0">&copy; <?= date('Y') ?> BookHaven</p>
      </div>
   </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
