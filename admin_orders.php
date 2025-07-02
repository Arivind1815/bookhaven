<?php
include 'config.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
   header('location:admin_login.php');
   exit();
}

// Update order payment status
if (isset($_POST['update_order'])) {
   $order_id = intval($_POST['order_id']);
   $update_status = mysqli_real_escape_string($conn, $_POST['update_status']);
   mysqli_query($conn, "UPDATE orders SET payment_status = '$update_status' WHERE id = $order_id") or die('Query failed');
   header("Location: admin_orders.php");
   exit();
}

// Delete order
if (isset($_GET['delete'])) {
   $id = intval($_GET['delete']);
   mysqli_query($conn, "DELETE FROM orders WHERE id = $id") or die('Query failed');
   header("Location: admin_orders.php");
   exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Admin Orders - BookHaven</title>
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
   <style>
      body {
         background-color: #f8f9fa;
      }
      .table thead th {
         vertical-align: middle;
      }
      .status-badge {
         font-size: 0.9rem;
      }
   </style>
</head>
<body>

<?php include 'admin_header.php'; ?>

<div class="container py-5">
   <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="text-primary"><i class="fas fa-clipboard-list me-2"></i>Manage Orders</h2>
   </div>

   <div class="table-responsive">
      <table class="table table-bordered table-hover text-center align-middle bg-white shadow-sm">
         <thead class="table-primary">
            <tr>
               <th>ID</th>
               <th>Customer</th>
               <th>Contact</th>
               <th>Shipping Address</th>
               <th>Items</th>
               <th>Total</th>
               <th>Method</th>
               <th>Status</th>
               <th>Date</th>
               <th>Action</th>
            </tr>
         </thead>
         <tbody>
            <?php
            $orders = mysqli_query($conn, "SELECT * FROM orders ORDER BY placed_on DESC") or die('Query failed');

            if (mysqli_num_rows($orders) > 0):
               while ($order = mysqli_fetch_assoc($orders)):
            ?>
            <tr>
               <td>#<?= $order['id'] ?></td>
               <td>
                  <strong><?= htmlspecialchars($order['name']) ?></strong>
               </td>
               <td class="text-start">
                  <span class="d-block"><i class="fas fa-phone-alt me-1 text-secondary"></i> <?= htmlspecialchars($order['number']) ?></span>
                  <span class="d-block"><i class="fas fa-envelope me-1 text-secondary"></i> <?= htmlspecialchars($order['email']) ?></span>
               </td>
               <td class="text-start">
                  <i class="fas fa-location-dot me-1 text-secondary"></i> <?= nl2br(htmlspecialchars($order['address'])) ?>
               </td>
               <td><?= htmlspecialchars($order['total_products']) ?></td>
               <td class="fw-bold text-success">RM <?= number_format($order['total_price'], 2) ?></td>
               <td><span class="badge bg-info text-dark"><?= htmlspecialchars($order['method']) ?></span></td>
               <td>
                  <form method="POST" class="d-flex justify-content-center align-items-center gap-2">
                     <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                     <select name="update_status" class="form-select form-select-sm w-auto">
                        <option value="Pending" <?= $order['payment_status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="Completed" <?= $order['payment_status'] === 'Completed' ? 'selected' : '' ?>>Completed</option>
                     </select>
                     <button type="submit" name="update_order" class="btn btn-success btn-sm">
                        <i class="fas fa-check"></i>
                     </button>
                  </form>
               </td>
               <td><small class="text-muted"><?= htmlspecialchars($order['placed_on']) ?></small></td>
               <td>
                  <a href="?delete=<?= $order['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this order?')">
                     <i class="fas fa-trash-alt"></i>
                  </a>
               </td>
            </tr>
            <?php endwhile; else: ?>
               <tr>
                  <td colspan="10" class="text-muted py-4">No orders found.</td>
               </tr>
            <?php endif; ?>
         </tbody>
      </table>
   </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
