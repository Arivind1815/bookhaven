<?php
include 'config.php';
session_start();

// Admin session check
if (!isset($_SESSION['admin_id'])) {
   header('location:admin_login.php');
   exit();
}

// Delete message
if (isset($_GET['delete'])) {
   $msg_id = intval($_GET['delete']);
   mysqli_query($conn, "DELETE FROM contact_messages WHERE id = $msg_id") or die('Query failed');
   header('location:admin_contacts.php');
   exit();
}

// Fetch messages
$result = mysqli_query($conn, "SELECT * FROM contact_messages ORDER BY created_at DESC") or die('Query failed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Admin Messages - BookHaven</title>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
   <style>
      body {
         background-color: #f8f9fa;
      }
      .truncate {
         max-width: 200px;
         white-space: nowrap;
         overflow: hidden;
         text-overflow: ellipsis;
      }
      .table th, .table td {
         vertical-align: middle !important;
      }
   </style>
</head>
<body>

<?php include 'admin_header.php'; ?>

<div class="container py-5">
   <h2 class="text-center text-primary mb-4"><i class="fas fa-envelope-open-text me-2"></i>User Messages</h2>

   <div class="table-responsive shadow bg-white rounded">
      <table class="table table-bordered text-center align-middle mb-0">
         <thead class="table-warning">
            <tr>
               <th>#</th>
               <th>Name</th>
               <th>Email</th>
               <th>Subject</th>
               <th style="min-width: 200px;">Message</th>
               <th>Sent On</th>
               <th>Action</th>
            </tr>
         </thead>
         <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
               <?php while ($row = mysqli_fetch_assoc($result)): ?>
               <tr>
                  <td><?= $row['id'] ?></td>
                  <td><?= htmlspecialchars($row['name']) ?></td>
                  <td><?= htmlspecialchars($row['email']) ?></td>
                  <td class="truncate" title="<?= htmlspecialchars($row['subject']) ?>">
                     <?= htmlspecialchars($row['subject']) ?>
                  </td>
                  <td class="text-start small">
                     <?= nl2br(htmlspecialchars($row['message'])) ?>
                  </td>
                  <td><?= date('d M Y, h:i A', strtotime($row['created_at'])) ?></td>
                  <td>
                     <a href="?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this message?');">
                        <i class="fas fa-trash-alt"></i>
                     </a>
                  </td>
               </tr>
               <?php endwhile; ?>
            <?php else: ?>
               <tr>
                  <td colspan="7" class="text-muted py-4">No messages received yet.</td>
               </tr>
            <?php endif; ?>
         </tbody>
      </table>
   </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

