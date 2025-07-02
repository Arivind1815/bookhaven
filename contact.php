<?php
include 'config.php';
session_start();

// Ensure user is logged in
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
   header('location:login.php');
   exit();
}

$success = '';
$error = '';

// Handle form submission
if (isset($_POST['submit'])) {
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $subject = mysqli_real_escape_string($conn, $_POST['subject']);
   $message = mysqli_real_escape_string($conn, $_POST['message']);

   $query = "INSERT INTO contact_messages (user_id, name, email, subject, message)
             VALUES ('$user_id', '$name', '$email', '$subject', '$message')";

   if (mysqli_query($conn, $query)) {
      $success = "Your message has been sent successfully!";
   } else {
      $error = "Failed to send message: " . mysqli_error($conn);
   }
}
?>

<?php include 'header.php'; ?>

<div class="container my-5">
   <div class="text-center mb-4">
      <h2 class="text-primary">📬 Contact Us</h2>
      <p class="text-muted">We’d love to hear from you!</p>
   </div>

   <?php if ($success): ?>
      <div class="alert alert-success text-center"><?= $success; ?></div>
   <?php elseif ($error): ?>
      <div class="alert alert-danger text-center"><?= $error; ?></div>
   <?php endif; ?>

   <div class="row">
      <!-- Contact Form -->
      <div class="col-md-6 mb-4">
         <div class="card shadow-sm">
            <div class="card-body">
               <h5 class="card-title mb-3">Send us a message</h5>
               <form action="#" method="post">
                  <div class="mb-3">
                     <label class="form-label">Your Name</label>
                     <input type="text" name="name" class="form-control" required>
                  </div>
                  <div class="mb-3">
                     <label class="form-label">Email</label>
                     <input type="email" name="email" class="form-control" required>
                  </div>
                  <div class="mb-3">
                     <label class="form-label">Subject</label>
                     <input type="text" name="subject" class="form-control" required>
                  </div>
                  <div class="mb-3">
                     <label class="form-label">Message</label>
                     <textarea name="message" rows="5" class="form-control" required></textarea>
                  </div>
                  <button type="submit" name="submit" class="btn btn-primary w-100">Send Message</button>
               </form>
            </div>
         </div>
      </div>

      <!-- Contact Info & Map -->
      <div class="col-md-6 mb-4">
         <div class="mb-4">
            <h5 class="fw-bold">📍 Our Location</h5>
            <iframe
               src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15952.606602720968!2d101.5166052!3d3.6834051!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cdcd5c9ce4c115%3A0xd3ac205e8e9df188!2sUniversiti%20Pendidikan%20Sultan%20Idris%20(UPSI)!5e0!3m2!1sen!2smy!4v1658328338987!5m2!1sen!2smy"
               width="100%" height="280" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
         </div>
         <h5 class="fw-bold">📞 Contact Information</h5>
         <p><i class="fas fa-map-marker-alt me-2 text-primary"></i>Universiti Pendidikan Sultan Idris (UPSI), Tanjong Malim, Perak</p>
         <p><i class="fas fa-envelope me-2 text-primary"></i>support@bookhaven.com</p>
         <p><i class="fas fa-phone me-2 text-primary"></i>+60 123-456 789</p>
      </div>
   </div>
</div>

<?php include 'footer.php'; ?>
