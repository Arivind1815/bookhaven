<?php
session_start();
include 'config.php';

$error = '';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM admin WHERE username = '$username' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $admin = mysqli_fetch_assoc($result);
        if ($admin['password'] === $password) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $error = "❌ Invalid password.";
        }
    } else {
        $error = "❌ Admin not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - BookHaven</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #90caf9, #e3f2fd);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .login-card {
            background-color: #fff;
            padding: 2.5rem;
            border-radius: 16px;
            box-shadow: 0 12px 24px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 420px;
        }
        .login-card h3 {
            font-weight: 700;
            color: #1976d2;
        }
        .btn-primary {
            background-color: #1976d2;
            border: none;
        }
        .btn-primary:hover {
            background-color: #1565c0;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="text-center mb-4">
        <i class="fas fa-user-shield fa-3x text-primary mb-3"></i>
        <h3>Admin Login</h3>
        <p class="text-muted small">Access the BookHaven Admin Panel</p>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-danger d-flex align-items-center" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> <?= $error ?>
        </div>
    <?php endif; ?>

    <form method="POST" novalidate>
        <div class="mb-3">
            <label class="form-label">Username <i class="fas fa-user ms-1"></i></label>
            <input type="text" name="username" class="form-control" required placeholder="Enter admin username">
        </div>
        <div class="mb-3">
            <label class="form-label">Password <i class="fas fa-lock ms-1"></i></label>
            <input type="password" name="password" class="form-control" required placeholder="Enter password">
        </div>
        <button type="submit" name="login" class="btn btn-primary w-100 py-2">
            <i class="fas fa-sign-in-alt me-2"></i>Login
        </button>
    </form>

    <div class="text-center mt-4">
        <a href="index.php" class="text-decoration-none text-secondary small">
            ← Back to BookHaven Homepage
        </a>
    </div>

    <p class="text-center text-muted small mt-3 mb-0">© <?= date('Y') ?> BookHaven Admin Panel</p>
</div>

</body>
</html>
