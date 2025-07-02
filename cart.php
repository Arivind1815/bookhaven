<?php
include 'config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
   header('location:login.php');
   exit();
}

// Handle cart removal
if (isset($_GET['remove'])) {
   $remove_id = $_GET['remove'];
   mysqli_query($conn, "DELETE FROM cart WHERE id = '$remove_id' AND user_id = '$user_id'") or die('Query failed');
   $_SESSION['message'] = 'Item removed from cart.';
   header('location:cart.php');
   exit();
}

// Handle quantity update
if (isset($_POST['update_cart'])) {
   $cart_id = $_POST['cart_id'];
   $quantity = $_POST['quantity'];
   mysqli_query($conn, "UPDATE cart SET quantity = '$quantity' WHERE id = '$cart_id' AND user_id = '$user_id'") or die('Query failed');
   $_SESSION['message'] = 'Cart updated successfully.';
   header('location:cart.php');
   exit();
}
?>

<?php include 'header.php'; ?>

<div class="container mt-5">
   <h2 class="text-primary text-center mb-4">🛒 Your Book Cart</h2>

   <?php if (!empty($_SESSION['message'])): ?>
      <div class="alert alert-success text-center">
         <?= $_SESSION['message']; unset($_SESSION['message']); ?>
      </div>
   <?php endif; ?>

   <?php
   $grand_total = 0;
   $cart_items = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$user_id'") or die('Query failed');

   if (mysqli_num_rows($cart_items) > 0): ?>
      <div class="table-responsive">
         <table class="table table-bordered align-middle text-center">
            <thead class="table-primary">
               <tr>
                  <th>Image</th>
                  <th>Book Name</th>
                  <th>Price (RM)</th>
                  <th>Quantity</th>
                  <th>Subtotal (RM)</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tbody>
            <?php while ($item = mysqli_fetch_assoc($cart_items)):
               $sub_total = $item['price'] * $item['quantity'];
               $grand_total += $sub_total;
            ?>
               <tr>
                  <td><img src="uploaded_img/<?= htmlspecialchars($item['image']); ?>" width="60" height="80" style="object-fit: cover;"></td>
                  <td><?= htmlspecialchars($item['name']); ?></td>
                  <td><?= number_format($item['price'], 2); ?></td>
                  <td>
                     <form method="post" class="d-flex justify-content-center">
                        <input type="hidden" name="cart_id" value="<?= $item['id']; ?>">
                        <input type="number" name="quantity" value="<?= $item['quantity']; ?>" min="1" class="form-control form-control-sm w-50 me-2" required>
                        <button type="submit" name="update_cart" class="btn btn-sm btn-outline-secondary">Update</button>
                     </form>
                  </td>
                  <td><?= number_format($sub_total, 2); ?></td>
                  <td>
                     <a href="cart.php?remove=<?= $item['id']; ?>" onclick="return confirm('Remove this item?')" class="btn btn-sm btn-danger">
                        <i class="fas fa-trash"></i>
                     </a>
                  </td>
               </tr>
            <?php endwhile; ?>
            </tbody>
            <tfoot>
               <tr class="fw-bold">
                  <td colspan="4" class="text-end">Total:</td>
                  <td colspan="2" class="text-start text-success">RM <?= number_format($grand_total, 2); ?></td>
               </tr>
            </tfoot>
         </table>
      </div>

      <div class="text-end">
         <a href="shop.php" class="btn btn-outline-primary me-2">Continue Shopping</a>
         <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
      </div>

   <?php else: ?>
      <div class="alert alert-info text-center">Your cart is currently empty.</div>
      <div class="text-center">
         <a href="shop.php" class="btn btn-outline-primary">Browse Books</a>
      </div>
   <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
