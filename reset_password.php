<?php
include 'config.php';

$token = $_GET['token'] ?? '';
$success = $error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $new_pass = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
   $update = mysqli_query($conn, "UPDATE users SET password = '$new_pass', reset_token = NULL WHERE reset_token = '$token'");
   if (mysqli_affected_rows($conn) > 0) {
      $success = "✅ Password updated successfully! <a href='login.php'>Login now</a>";
   } else {
      $error = "❌ Invalid or expired token!";
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Reset Password - BookHaven</title>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="icon" href="images/favicons.png" type="image/x-icon">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
   <style>
      body {
         background: linear-gradient(to right, #f8fbff, #e1f5fe);
         min-height: 100vh;
         display: flex;
         align-items: center;
         justify-content: center;
      }
      .card {
         border: none;
         border-radius: 1rem;
         box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
      }
      .card-header {
         background: linear-gradient(45deg, #198754, #48c78e);
         color: white;
         padding: 1.5rem;
         border-top-left-radius: 1rem;
         border-top-right-radius: 1rem;
         text-align: center;
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
               <h4 class="mb-0">Reset Your Password</h4>
               <p class="mb-0 small">Enter a new password to continue</p>
            </div>
            <div class="card-body p-4">

               <?php if ($success): ?>
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                     <?= $success ?>
                     <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                  </div>
               <?php elseif ($error): ?>
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                     <?= $error ?>
                     <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                  </div>
               <?php endif; ?>

               <?php if (!$success): ?>
               <form method="post" class="needs-validation" novalidate>
                  <div class="form-floating mb-3">
                     <input type="password" name="new_password" id="newPassword" class="form-control" placeholder="New Password" required>
                     <label for="newPassword">New Password</label>
                  </div>
                  <button type="submit" class="btn btn-success w-100">Reset Password</button>
               </form>
               <?php endif; ?>

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
// Bootstrap form validation
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
