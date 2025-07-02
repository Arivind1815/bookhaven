<?php
include 'admin_header.php';
include 'config.php';

// Get totals
$product_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM products"))['total'];
$order_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM orders"))['total'];
$user_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM users"))['total'];
$message_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM contact_messages"))['total'];

// Product count by genre
$genre_data = [];
$genre_query = mysqli_query($conn, "SELECT Genre, COUNT(*) as count FROM products GROUP BY Genre");
while ($row = mysqli_fetch_assoc($genre_query)) {
    $genre_data[$row['Genre']] = $row['count'];
}

// Orders by payment method
$method_data = [];
$method_query = mysqli_query($conn, "SELECT method, COUNT(*) as count FROM orders GROUP BY method");
while ($row = mysqli_fetch_assoc($method_query)) {
    $method_data[$row['method']] = $row['count'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Admin Dashboard - BookHaven</title>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

   <style>
      .card-summary {
         transition: 0.3s;
         border-left: 5px solid #0d6efd;
      }
      .card-summary:hover {
         transform: translateY(-3px);
         box-shadow: 0 8px 18px rgba(0,0,0,0.1);
      }
      .chart-title {
         font-size: 1.1rem;
         font-weight: 600;
         color: #333;
      }
   </style>
</head>
<body>

<div class="container py-5">
   <h2 class="text-center text-primary mb-4">📊 Admin Dashboard</h2>

   <div class="row g-4 mb-5">
      <div class="col-sm-6 col-lg-3">
         <div class="card card-summary text-center shadow-sm">
            <div class="card-body">
               <h5 class="card-title">📚 Products</h5>
               <h2 class="text-primary"><?= $product_count ?></h2>
               <p class="text-muted small">Total listed books</p>
            </div>
         </div>
      </div>
      <div class="col-sm-6 col-lg-3">
         <div class="card card-summary text-center shadow-sm">
            <div class="card-body">
               <h5 class="card-title">🛒 Orders</h5>
               <h2 class="text-success"><?= $order_count ?></h2>
               <p class="text-muted small">All placed orders</p>
            </div>
         </div>
      </div>
      <div class="col-sm-6 col-lg-3">
         <div class="card card-summary text-center shadow-sm">
            <div class="card-body">
               <h5 class="card-title">👥 Users</h5>
               <h2 class="text-info"><?= $user_count ?></h2>
               <p class="text-muted small">Registered customers</p>
            </div>
         </div>
      </div>
      <div class="col-sm-6 col-lg-3">
         <div class="card card-summary text-center shadow-sm">
            <div class="card-body">
               <h5 class="card-title">✉️ Messages</h5>
               <h2 class="text-danger"><?= $message_count ?></h2>
               <p class="text-muted small">Contact form entries</p>
            </div>
         </div>
      </div>
   </div>

   <!-- Chart Section -->
   <div class="row">
      <div class="col-md-6 mb-4">
         <div class="card shadow-sm p-3">
            <p class="chart-title text-center mb-3">📚 Products by Genre</p>
            <canvas id="genreChart" height="200"></canvas>
         </div>
      </div>
      <div class="col-md-6 mb-4">
         <div class="card shadow-sm p-3">
            <p class="chart-title text-center mb-3">💳 Orders by Payment Method</p>
            <canvas id="methodChart" height="200"></canvas>
         </div>
      </div>
   </div>
</div>

<script>
const genreChart = new Chart(document.getElementById('genreChart'), {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_keys($genre_data)) ?>,
        datasets: [{
            label: 'Books per Genre',
            data: <?= json_encode(array_values($genre_data)) ?>,
            backgroundColor: 'rgba(30, 136, 229, 0.7)'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { precision: 0 }
            }
        }
    }
});

const methodChart = new Chart(document.getElementById('methodChart'), {
    type: 'doughnut',
    data: {
        labels: <?= json_encode(array_keys($method_data)) ?>,
        datasets: [{
            label: 'Orders',
            data: <?= json_encode(array_values($method_data)) ?>,
            backgroundColor: [
                '#4caf50', '#fbc02d', '#e53935', '#42a5f5', '#ab47bc'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>

</body>
</html>
