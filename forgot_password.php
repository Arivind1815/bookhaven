<?php
include 'config.php';

$success = $error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $token = bin2hex(random_bytes(32));

   $check_user = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
   if (mysqli_num_rows($check_user) > 0) {
      mysqli_query($conn, "UPDATE users SET reset_token = '$token' WHERE email = '$email'");
      $reset_link = "http://localhost:8081/bookhaven/reset_password.php?token=$token";
      $success = "We've sent a password reset link to your email: <a href='$reset_link'>$reset_link</a>";
   } else {
      $error = "No account found with that email address.";
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Forgot Password - BookHaven</title>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="icon" href="images/favicons.png" type="image/x-icon">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
   <style>
      body {
         background: linear-gradient(to right, #e3f2fd, #ffffff);
         min-height: 100vh;
         display: flex;
         align-items: center;
         justify-content: center;
      }
      .card {
         border: none;
         border-radius: 1rem;
         box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
      }
      .card-header {
         background: linear-gradient(45deg, #0d6efd, #6ea8fe);
         color: white;
         border-top-left-radius: 1rem;
         border-top-right-radius: 1rem;
         padding: 1.5rem;
         text-align: center;
      }
      .card-header h4 {
         margin: 0;
      }
      .form-floating label {
         padding: 0.5rem 1rem;
      }
   </style>
</head>
<body>

<div class="container px-4">
   <div class="row justify-content-center">
      <div class="col-md-6 col-lg-5">
         <div class="card">
            <div class="card-header">
               <img src="images/favicons.png" alt="Logo" width="50" class="mb-2">
               <h4>Forgot Your Password?</h4>
               <p class="small mb-0">We’ll help you reset it!</p>
            </div>
            <div class="card-body p-4">

               <?php if ($success): ?>
                  <div class="alert alert-info alert-dismissible fade show" role="alert">
                     <?= $success ?>
                     <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                  </div>
               <?php elseif ($error): ?>
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                     <?= $error ?>
                     <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                  </div>
               <?php endif; ?>

               <form method="post" class="needs-validation" novalidate>
                  <div class="form-floating mb-3">
                     <input type="email" name="email" class="form-control" id="floatingEmail" placeholder="Email" required>
                     <label for="floatingEmail">Registered Email</label>
                  </div>
                  <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
               </form>

               <div class="text-center mt-4">
                  <a href="login.php" class="text-decoration-none">← Back to Login</a>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Bootstrap validation
(() => {
   'use strict';
   const forms = document.querySelectorAll('.needs-validation');
   Array.from(forms).forEach(form => {
      form.addEventListener('submit', event => {
         if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
         }
         form.classList.add('was-validated');
      }, false);
   });
})();
</script>
</body>
</html>
