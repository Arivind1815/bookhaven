<?php
session_start();
include 'config.php';

if (isset($_POST['submit'])) {
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $username = mysqli_real_escape_string($conn, $_POST['username']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $phone = mysqli_real_escape_string($conn, $_POST['phone']);
   $password = mysqli_real_escape_string($conn, $_POST['password']);
   $confirm = mysqli_real_escape_string($conn, $_POST['confirm']);

   $user_check = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'") or die('query failed');

   if (mysqli_num_rows($user_check) > 0) {
      $message[] = 'Email already registered!';
   } elseif ($password != $confirm) {
      $message[] = 'Passwords do not match!';
   } else {
      $password = password_hash($password, PASSWORD_DEFAULT);
      mysqli_query($conn, "INSERT INTO users (name, username, email, phone, password) VALUES ('$name', '$username', '$email', '$phone', '$password')") or die('query failed');
      $message[] = 'Registration successful! You can now log in.';
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Register - BookHaven</title>
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
         box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      }
      .form-floating > label {
         padding: 0.5rem 1rem;
      }
      .form-control:focus {
         box-shadow: none;
         border-color: #0d6efd;
      }
   </style>
</head>
<body>

<div class="container px-4">
   <div class="row justify-content-center">
      <div class="col-lg-7 col-md-9">
         <div class="card">
            <div class="card-header bg-primary text-white text-center py-3 rounded-top">
               <img src="images/favicons.png" width="60" alt="Logo" class="mb-2">
               <h4 class="mb-0">Create Your BookHaven Account</h4>
            </div>
            <div class="card-body p-4">
               <?php if (!empty($message)): ?>
                  <?php foreach ($message as $msg): ?>
                     <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <?= $msg ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                     </div>
                  <?php endforeach; ?>
               <?php endif; ?>

               <form method="post" class="row g-3 needs-validation" novalidate>
                  <div class="col-md-6 form-floating">
                     <input type="text" name="name" id="name" class="form-control" required placeholder="Full Name">
                     <label for="name">Full Name</label>
                  </div>
                  <div class="col-md-6 form-floating">
                     <input type="text" name="username" id="username" class="form-control" required placeholder="Username">
                     <label for="username">Username</label>
                  </div>
                  <div class="col-md-6 form-floating">
                     <input type="email" name="email" id="email" class="form-control" required placeholder="Email">
                     <label for="email">Email Address</label>
                  </div>
                  <div class="col-md-6 form-floating">
                     <input type="text" name="phone" id="phone" class="form-control" required placeholder="Phone">
                     <label for="phone">Phone Number</label>
                  </div>
                  <div class="col-md-6 form-floating">
                     <input type="password" name="password" id="password" class="form-control" required placeholder="Password">
                     <label for="password">Password</label>
                  </div>
                  <div class="col-md-6 form-floating">
                     <input type="password" name="confirm" id="confirm" class="form-control" required placeholder="Confirm Password">
                     <label for="confirm">Confirm Password</label>
                  </div>
                  <div class="col-12">
                     <button type="submit" name="submit" class="btn btn-primary w-100 py-2">Register</button>
                  </div>
                  <div class="text-center">
                     <p class="mt-3">Already have an account? <a href="login.php">Login here</a></p>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Optional Bootstrap validation
(() => {
   'use strict'
   const forms = document.querySelectorAll('.needs-validation')
   Array.from(forms).forEach(form => {
      form.addEventListener('submit', event => {
         if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
         }
         form.classList.add('was-validated')
      }, false)
   })
})()
</script>
</body>
</html>

