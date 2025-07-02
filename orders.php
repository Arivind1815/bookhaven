<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
   header('Location: login.php');
   exit();
}

$user_id = $_SESSION['user_id'];
?>

<?php include 'header.php'; ?>

<div class="container my-5">
   <h2 class="text-center text-primary mb-4">📦 Your Orders</h2>
   <p class="text-center text-muted mb-4"><a href="home.php" class="text-decoration-none">Home</a> / Orders</p>

   <?php
   $orders = mysqli_query($conn, "SELECT * FROM orders WHERE user_id = '$user_id' ORDER BY placed_on DESC") or die('Query failed');

   if (mysqli_num_rows($orders) > 0): ?>
      <div class="row">
         <?php while ($order = mysqli_fetch_assoc($orders)): ?>
            <div class="col-md-6 col-lg-4 mb-4">
               <div class="card shadow-sm h-100">
                  <div class="card-body">
                     <h5 class="card-title text-primary mb-3">📄 Order on <?= date('d M Y', strtotime($order['placed_on'])) ?></h5>
                     <ul class="list-unstyled small">
                        <li><strong>Name:</strong> <?= htmlspecialchars($order['name']) ?></li>
                        <li><strong>Phone:</strong> <?= htmlspecialchars($order['number']) ?></li>
                        <li><strong>Email:</strong> <?= htmlspecialchars($order['email']) ?></li>
                        <li><strong>Address:</strong> <?= htmlspecialchars($order['address']) ?></li>
                        <li><strong>Method:</strong> <?= htmlspecialchars($order['method']) ?></li>
                        <li><strong>Items:</strong> <?= htmlspecialchars($order['total_products']) ?></li>
                        <li><strong>Total:</strong> RM <?= number_format($order['total_price'], 2) ?></li>
                        <li>
                           <strong>Status:</strong> 
                           <span class="badge <?= $order['payment_status'] === 'pending' ? 'bg-warning text-dark' : 'bg-success' ?>">
                              <?= ucfirst($order['payment_status']) ?>
                           </span>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         <?php endwhile; ?>
      </div>
   <?php else: ?>
      <div class="alert alert-info text-center">You haven't placed any orders yet.</div>
   <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
