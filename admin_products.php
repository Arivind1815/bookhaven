<?php
include 'config.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('location:admin_login.php');
    exit();
}

$message = [];

// --- Add Product ---
if (isset($_POST['add_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = floatval($_POST['price']);
    $mem_price = floatval($_POST['mem_price']);
    $stock = intval($_POST['stock']);
    $genre = mysqli_real_escape_string($conn, $_POST['genre']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/' . basename($image);

    if (mysqli_num_rows(mysqli_query($conn, "SELECT name FROM products WHERE name = '$name'")) > 0) {
        $message[] = 'Product name already exists.';
    } elseif ($_FILES['image']['size'] > 2000000) {
        $message[] = 'Image size too large.';
    } else {
        if (move_uploaded_file($image_tmp, $image_folder)) {
            mysqli_query($conn, "INSERT INTO products(name, price, mem_price, stock, image, genre, description) 
            VALUES('$name', '$price', '$mem_price', '$stock', '$image', '$genre', '$description')");
            $message[] = 'Product added successfully!';
        } else {
            $message[] = 'Image upload failed.';
        }
    }
}

// --- Delete Product ---
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $img_q = mysqli_query($conn, "SELECT image FROM products WHERE id = $id");
    if ($img = mysqli_fetch_assoc($img_q)) @unlink("uploaded_img/" . $img['image']);
    mysqli_query($conn, "DELETE FROM products WHERE id = $id");
    header("Location: admin_products.php");
    exit();
}

// --- Update Product ---
if (isset($_POST['update_product'])) {
    $id = (int) $_POST['update_p_id'];
    $name = mysqli_real_escape_string($conn, $_POST['update_name']);
    $price = floatval($_POST['update_price']);
    $mem_price = floatval($_POST['update_mem_price']);
    $stock = intval($_POST['update_stock']);
    $genre = mysqli_real_escape_string($conn, $_POST['update_genre']);
    $description = mysqli_real_escape_string($conn, $_POST['update_description']);
    $old_image = $_POST['update_old_image'];

    mysqli_query($conn, "UPDATE products SET name='$name', price='$price', mem_price='$mem_price', stock='$stock', genre='$genre', description='$description' WHERE id='$id'");

    if (!empty($_FILES['update_image']['name'])) {
        $new_image = $_FILES['update_image']['name'];
        $tmp_image = $_FILES['update_image']['tmp_name'];
        move_uploaded_file($tmp_image, "uploaded_img/" . $new_image);
        mysqli_query($conn, "UPDATE products SET image='$new_image' WHERE id='$id'");
        @unlink("uploaded_img/" . $old_image);
    }

    header("Location: admin_products.php");
    exit();
}
?>

<?php include 'admin_header.php'; ?>

<div class="container py-5">
    <h2 class="text-primary mb-4 text-center">📘 Manage Products</h2>

    <?php foreach ($message as $msg): ?>
        <div class="alert alert-info"><?= $msg ?></div>
    <?php endforeach; ?>

    <!-- Filter & Sort -->
    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-4">
            <select name="filter_genre" class="form-select">
                <option value="">All Genres</option>
                <?php
                $genres = mysqli_query($conn, "SELECT DISTINCT genre FROM products");
                while ($g = mysqli_fetch_assoc($genres)) {
                    $selected = ($_GET['filter_genre'] ?? '') == $g['genre'] ? 'selected' : '';
                    echo "<option value='{$g['genre']}' $selected>{$g['genre']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-md-4">
            <select name="sort" class="form-select">
                <option value="">Sort by Price</option>
                <option value="low" <?= ($_GET['sort'] ?? '') == 'low' ? 'selected' : '' ?>>Low to High</option>
                <option value="high" <?= ($_GET['sort'] ?? '') == 'high' ? 'selected' : '' ?>>High to Low</option>
            </select>
        </div>
        <div class="col-md-4 d-grid">
            <button type="submit" class="btn btn-outline-primary">Apply</button>
        </div>
    </form>

    <!-- Product Cards -->
    <div class="row">
        <?php
        $filter = '';
        if (!empty($_GET['filter_genre'])) {
            $genre = mysqli_real_escape_string($conn, $_GET['filter_genre']);
            $filter .= " WHERE genre = '$genre'";
        }

        $sort = '';
        if (!empty($_GET['sort'])) {
            $sort = $_GET['sort'] == 'low' ? " ORDER BY price ASC" : " ORDER BY price DESC";
        }

        $products = mysqli_query($conn, "SELECT * FROM products $filter $sort");

        if (mysqli_num_rows($products) > 0):
            while ($row = mysqli_fetch_assoc($products)):
        ?>
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <img src="uploaded_img/<?= htmlspecialchars($row['image']) ?>" class="card-img-top" style="height:180px;object-fit:cover;" alt="">
                <div class="card-body">
                    <h5 class="card-title text-primary"><?= htmlspecialchars($row['name']) ?></h5>
                    <p class="mb-1"><strong>Genre:</strong> <?= htmlspecialchars($row['genre']) ?></p>
                    <p class="mb-1"><strong>Price:</strong> RM <?= number_format($row['price'], 2) ?></p>
                    <p class="mb-1"><strong>Member Price:</strong> RM <?= number_format($row['mem_price'], 2) ?></p>
                    <p class="mb-2"><strong>Stock:</strong> <?= $row['stock'] ?></p>
                    <p class="text-muted small"><?= substr(htmlspecialchars($row['description']), 0, 60) ?>...</p>
                    <a href="?update=<?= $row['id'] ?>" class="btn btn-sm btn-outline-success me-2">Edit</a>
                    <a href="?delete=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this product?')">Delete</a>
                </div>
            </div>
        </div>
        <?php endwhile; else: ?>
            <div class="alert alert-warning text-center">No products found.</div>
        <?php endif; ?>
    </div>

    <!-- Add & Edit Forms -->
    <hr class="my-5">
    <h4 class="mb-3 text-success"><?= isset($_GET['update']) ? '✏️ Edit Product' : '➕ Add New Product' ?></h4>

    <form method="POST" enctype="multipart/form-data" class="row g-3">
        <?php if (isset($_GET['update'])):
            $id = (int) $_GET['update'];
            $product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id = $id"));
        ?>
            <input type="hidden" name="update_p_id" value="<?= $product['id'] ?>">
            <input type="hidden" name="update_old_image" value="<?= $product['image'] ?>">
        <?php endif; ?>

        <div class="col-md-4">
            <input type="text" name="<?= isset($product) ? 'update_name' : 'name' ?>" value="<?= $product['name'] ?? '' ?>" class="form-control" placeholder="Book Name" required>
        </div>
        <div class="col-md-2">
            <input type="number" name="<?= isset($product) ? 'update_price' : 'price' ?>" value="<?= $product['price'] ?? '' ?>" step="0.01" class="form-control" placeholder="Price" required>
        </div>
        <div class="col-md-2">
            <input type="number" name="<?= isset($product) ? 'update_mem_price' : 'mem_price' ?>" value="<?= $product['mem_price'] ?? '' ?>" step="0.01" class="form-control" placeholder="Member Price" required>
        </div>
        <div class="col-md-2">
            <input type="number" name="<?= isset($product) ? 'update_stock' : 'stock' ?>" value="<?= $product['stock'] ?? '' ?>" class="form-control" placeholder="Stock" required>
        </div>
        <div class="col-md-2">
            <select name="<?= isset($product) ? 'update_genre' : 'genre' ?>" class="form-select" required>
                <option disabled selected>Select Genre</option>
                <?php foreach (['Romance', 'Action', 'Horror', 'Historical'] as $g): ?>
                    <option value="<?= $g ?>" <?= isset($product) && $product['genre'] == $g ? 'selected' : '' ?>><?= $g ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6">
            <textarea name="<?= isset($product) ? 'update_description' : 'description' ?>" class="form-control" rows="3" placeholder="Description" required><?= $product['description'] ?? '' ?></textarea>
        </div>
        <div class="col-md-6">
            <input type="file" name="<?= isset($product) ? 'update_image' : 'image' ?>" class="form-control" <?= isset($product) ? '' : 'required' ?>>
        </div>
        <div class="col-12">
            <button type="submit" name="<?= isset($product) ? 'update_product' : 'add_product' ?>" class="btn btn-<?= isset($product) ? 'success' : 'primary' ?> w-100">
                <?= isset($product) ? 'Update Product' : 'Add Product' ?>
            </button>
            <?php if (isset($product)): ?>
                <a href="admin_products.php" class="btn btn-secondary w-100 mt-2">Cancel</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
