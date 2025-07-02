<?php
include 'config.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
   header('location:admin_login.php');
   exit();
}

// Delete user
if (isset($_GET['delete'])) {
   $user_id = intval($_GET['delete']);
   mysqli_query($conn, "DELETE FROM users WHERE id = $user_id") or die('Query failed');
   header('location:admin_users.php');
   exit();
}

// Handle search
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$query = $search 
    ? "SELECT * FROM users WHERE email LIKE '%$search%' OR username LIKE '%$search%' ORDER BY id DESC" 
    : "SELECT * FROM users ORDER BY id DESC";
$result = mysqli_query($conn, $query) or die('Query failed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Admin Users - BookHaven</title>
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <!-- Bootstrap + Font Awesome -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

   <style>
      body {
         background-color: #f8f9fa;
      }
      .table th, .table td {
         vertical-align: middle !important;
      }
      .action-btn {
         font-size: 0.85rem;
      }
   </style>
</head>
<body>

<?php include 'admin_header.php'; ?>

<div class="container py-5">
   <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="text-primary"><i class="fas fa-users me-2"></i>Registered Users</h2>
      <form method="GET" class="d-flex" style="max-width: 300px;">
         <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" class="form-control" placeholder="Search email or username">
         <button type="submit" class="btn btn-outline-primary ms-2"><i class="fas fa-search"></i></button>
      </form>
   </div>

   <div class="table-responsive shadow-sm bg-white rounded">
      <table class="table table-bordered text-center align-middle mb-0">
         <thead class="table-primary">
            <tr>
               <th>ID</th>
               <th>Name</th>
               <th>Username</th>
               <th>Email</th>
               <th>Phone</th>
               <th>Action</th>
            </tr>
         </thead>
         <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
               <?php while ($row = mysqli_fetch_assoc($result)): ?>
                  <tr>
                     <td>#<?= $row['id'] ?></td>
                     <td><?= htmlspecialchars($row['name']) ?></td>
                     <td><?= htmlspecialchars($row['username']) ?></td>
                     <td><?= htmlspecialchars($row['email']) ?></td>
                     <td><?= htmlspecialchars($row['phone']) ?></td>
                     <td>
                        <a href="?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger action-btn" onclick="return confirm('Are you sure you want to delete this user?');">
                           <i class="fas fa-trash-alt me-1"></i> Delete
                        </a>
                     </td>
                  </tr>
               <?php endwhile; ?>
            <?php else: ?>
               <tr>
                  <td colspan="6" class="text-muted py-4">No users found.</td>
               </tr>
            <?php endif; ?>
         </tbody>
      </table>
   </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
