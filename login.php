<?php
session_start();
include 'config.php';

if (isset($_POST['submit'])) {
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $password = $_POST['password'];

   $query = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'") or die('Query failed');

   if (mysqli_num_rows($query) > 0) {
      $user = mysqli_fetch_assoc($query);
      if (password_verify($password, $user['password'])) {
         $_SESSION['user_id'] = $user['id'];
         $_SESSION['user_name'] = $user['name'];
         $_SESSION['user_email'] = $user['email'];
         header('location: index.php');
         exit();
      } else {
         $message[] = 'Incorrect password!';
      }
   } else {
      $message[] = 'No account found with that email!';
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Login - BookHaven</title>
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="icon" href="images/favicons.png" type="image/x-icon">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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
         box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      }
      .card-header {
         background: linear-gradient(45deg, #0d6efd, #6ea8fe);
         color: white;
         border-top-left-radius: 1rem;
         border-top-right-radius: 1rem;
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
            <div class="card-header text-center py-3">
               <img src="images/favicons.png" width="60" alt="BookHaven Logo" class="mb-2">
               <h4 class="mb-0">Login to BookHaven</h4>
            </div>
            <div class="card-body p-4">
               <?php if (isset($message)): ?>
                  <?php foreach ($message as $msg): ?>
                     <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <?= $msg ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                     </div>
                  <?php endforeach; ?>
               <?php endif; ?>

               <form method="post" class="needs-validation" novalidate>
                  <div class="form-floating mb-3">
                     <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
                     <label for="email">Email Address</label>
                  </div>
                  <div class="form-floating mb-3">
                     <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                     <label for="password">Password</label>
                  </div>

                  <div class="mb-3 text-end">
                     <a href="forgot_password.php" class="small text-decoration-none">Forgot password?</a>
                  </div>

                  <button type="submit" name="submit" class="btn btn-primary w-100 py-2">Login</button>
               </form>

               <div class="text-center mt-4">
                  <p>Don't have an account? <a href="register.php">Register now</a></p>
                  <p class="text-muted">Are you an admin? <a href="admin_login.php">Admin Login</a></p>
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
