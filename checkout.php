<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
   header('location:login.php');
   exit();
}

// Handle order placement
if (isset($_POST['order_btn'])) {
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $number = mysqli_real_escape_string($conn, $_POST['number']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $method = mysqli_real_escape_string($conn, $_POST['method']);
   $flat = mysqli_real_escape_string($conn, $_POST['flat']);
   $street = mysqli_real_escape_string($conn, $_POST['street']);
   $city = mysqli_real_escape_string($conn, $_POST['city']);
   $state = mysqli_real_escape_string($conn, $_POST['state']);
   $country = mysqli_real_escape_string($conn, $_POST['country']);
   $pin_code = mysqli_real_escape_string($conn, $_POST['pin_code']);

   $address = "Flat No. $flat, $street, $city, $state, $country - $pin_code";

   $cart_total = 0;
   $cart_products = [];

   $cart_query = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$user_id'") or die('Query failed');
   while ($item = mysqli_fetch_assoc($cart_query)) {
      $cart_products[] = $item['name'] . ' (' . $item['quantity'] . ')';
      $cart_total += $item['price'] * $item['quantity'];
   }

   $total_products = implode(', ', $cart_products);
   $date = date('Y-m-d H:i:s');

   if ($cart_total > 0) {
      mysqli_query($conn, "INSERT INTO orders (user_id, name, number, email, method, address, total_products, total_price, placed_on) 
         VALUES ('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$date')") or die('Insert failed');
      mysqli_query($conn, "DELETE FROM cart WHERE user_id = '$user_id'") or die('Delete failed');
      $message[] = "✅ Order placed successfully!";
   } else {
      $message[] = "⚠️ Your cart is empty!";
   }
}
?>

<?php include 'header.php'; ?>

<div class="container my-5">
   <h2 class="text-center text-primary mb-4">🧾 Checkout</h2>

   <?php if (isset($message)): ?>
      <div class="mb-4">
         <?php foreach ($message as $msg): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
               <?= $msg ?>
               <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
         <?php endforeach; ?>
      </div>
   <?php endif; ?>

   <!-- Cart Summary -->
   <div class="card mb-4">
      <div class="card-header bg-light fw-bold">🛒 Your Cart Summary</div>
      <ul class="list-group list-group-flush">
         <?php
         $grand_total = 0;
         $cart_items = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$user_id'");
         if (mysqli_num_rows($cart_items) > 0):
            while ($item = mysqli_fetch_assoc($cart_items)):
               $total = $item['price'] * $item['quantity'];
               $grand_total += $total;
         ?>
            <li class="list-group-item d-flex justify-content-between">
               <?= htmlspecialchars($item['name']) ?> (x<?= $item['quantity'] ?>)
               <span>RM <?= number_format($total, 2) ?></span>
            </li>
         <?php endwhile; ?>
            <li class="list-group-item d-flex justify-content-between fw-bold text-primary">
               Total
               <span>RM <?= number_format($grand_total, 2) ?></span>
            </li>
         <?php else: ?>
            <li class="list-group-item text-muted">Your cart is empty.</li>
         <?php endif; ?>
      </ul>
   </div>

   <!-- Checkout Form -->
   <div class="card shadow-sm">
      <div class="card-body">
         <h5 class="card-title mb-4">📦 Shipping & Payment Info</h5>
         <form method="post" class="row g-3">
            <div class="col-md-6">
               <label class="form-label">Full Name</label>
               <input type="text" name="name" required class="form-control">
            </div>
            <div class="col-md-6">
               <label class="form-label">Phone Number</label>
               <input type="text" name="number" required class="form-control">
            </div>
            <div class="col-md-6">
               <label class="form-label">Email</label>
               <input type="email" name="email" required class="form-control">
            </div>
            <div class="col-md-6">
               <label class="form-label">Payment Method</label>
               <select name="method" class="form-select">
                  <option value="Cash on Delivery">Cash on Delivery</option>
                  <option value="Credit Card">Credit Card</option>
                  <option value="PayPal">PayPal</option>
                  <option value="Touch 'n Go">Touch 'n Go</option>
               </select>
            </div>
            <div class="col-12">
               <label class="form-label">Address</label>
            </div>
            <div class="col-md-3">
               <input type="text" name="flat" placeholder="Flat No." required class="form-control">
            </div>
            <div class="col-md-5">
               <input type="text" name="street" placeholder="Street" required class="form-control">
            </div>
            <div class="col-md-4">
               <input type="text" name="city" placeholder="City" required class="form-control">
            </div>
            <div class="col-md-4">
               <input type="text" name="state" placeholder="State" required class="form-control">
            </div>
            <div class="col-md-4">
               <input type="text" name="country" placeholder="Country" required class="form-control">
            </div>
            <div class="col-md-4">
               <input type="text" name="pin_code" placeholder="Postcode" required class="form-control">
            </div>
            <div class="col-12">
               <button type="submit" name="order_btn" class="btn btn-primary w-100" <?= $grand_total == 0 ? 'disabled' : '' ?>>Place Order</button>
            </div>
         </form>
      </div>
   </div>
</div>

<?php include 'footer.php'; ?>

