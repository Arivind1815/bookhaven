<?php
session_start();
include 'config.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header('location:login.php');
    exit();
}

$message = [];

// Add to cart
if (isset($_POST['add_to_cart'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    $check_cart = mysqli_query($conn, "SELECT * FROM cart WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
    if (mysqli_num_rows($check_cart) > 0) {
        $message[] = 'Product already in cart!';
    } else {
        mysqli_query($conn, "INSERT INTO cart(user_id, name, price, quantity, image) 
            VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
        $message[] = 'Product added to cart!';
    }
}

// Get genres
$genres = [];
$result = mysqli_query($conn, "SELECT DISTINCT genre FROM products ORDER BY genre ASC");
while ($row = mysqli_fetch_assoc($result)) {
    $genres[] = $row['genre'];
}

// Filters
$searchTerm = $_GET['search'] ?? '';
$filterGenre = $_GET['genre'] ?? '';
$sort = $_GET['sort'] ?? '';

$where = [];
if ($filterGenre && $filterGenre !== 'all') {
    $where[] = "genre = '" . mysqli_real_escape_string($conn, $filterGenre) . "'";
}
if (!empty($searchTerm)) {
    $search = mysqli_real_escape_string($conn, $searchTerm);
    $where[] = "(name LIKE '%$search%' OR author LIKE '%$search%')";
}

$whereSQL = count($where) > 0 ? 'WHERE ' . implode(' AND ', $where) : '';
$orderSQL = '';
if ($sort === 'low') $orderSQL = 'ORDER BY price ASC';
elseif ($sort === 'high') $orderSQL = 'ORDER BY price DESC';
else $orderSQL = 'ORDER BY release_date DESC';

$productsQuery = "SELECT * FROM products $whereSQL $orderSQL";
$select_products = mysqli_query($conn, $productsQuery) or die('query failed');
?>

<?php include 'header.php'; ?>

<?php if (!empty($message)): ?>
<div class="container mt-3">
    <?php foreach ($message as $msg): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($msg) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<div class="container text-center mt-5 mb-4">
    <h2 class="text-primary">🛍️ Our Shop</h2>
    <p><a href="home.php" class="text-decoration-none text-muted">Home</a> / Shop</p>
</div>

<section class="container mb-5">
    <div class="row">
        <!-- Sidebar -->
        <aside class="col-md-3 mb-4">
            <h5>Filter by Genre</h5>
            <ul class="list-group">
                <a href="shop.php?genre=all&search=<?= urlencode($searchTerm) ?>&sort=<?= $sort ?>" class="list-group-item <?= ($filterGenre == '' || $filterGenre == 'all') ? 'active' : '' ?>">All Genres</a>
                <?php foreach ($genres as $genre): ?>
                    <a href="shop.php?genre=<?= urlencode($genre) ?>&search=<?= urlencode($searchTerm) ?>&sort=<?= $sort ?>" class="list-group-item <?= ($filterGenre == $genre) ? 'active' : '' ?>">
                        <?= htmlspecialchars($genre) ?>
                    </a>
                <?php endforeach; ?>
            </ul>

            <!-- Search -->
            <form method="GET" class="mt-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search..." value="<?= htmlspecialchars($searchTerm) ?>">
                    <input type="hidden" name="genre" value="<?= htmlspecialchars($filterGenre) ?>">
                    <input type="hidden" name="sort" value="<?= htmlspecialchars($sort) ?>">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </form>

            <!-- Sort -->
            <form method="GET" class="mt-3">
                <input type="hidden" name="search" value="<?= htmlspecialchars($searchTerm) ?>">
                <input type="hidden" name="genre" value="<?= htmlspecialchars($filterGenre) ?>">
                <label class="form-label mt-2">Sort by Price</label>
                <select name="sort" class="form-select" onchange="this.form.submit()">
                    <option value="">Default (Newest)</option>
                    <option value="low" <?= $sort === 'low' ? 'selected' : '' ?>>Low to High</option>
                    <option value="high" <?= $sort === 'high' ? 'selected' : '' ?>>High to Low</option>
                </select>
            </form>
        </aside>

        <!-- Product List -->
        <div class="col-md-9">
            <?php if (mysqli_num_rows($select_products) > 0): ?>
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <?php while ($product = mysqli_fetch_assoc($select_products)): ?>
                        <div class="col">
                            <form method="post" class="card h-100 shadow-sm border-0">
                                <img src="uploaded_img/<?= htmlspecialchars($product['image']); ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']); ?>" style="height:250px; object-fit:cover;">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title text-primary"><?= htmlspecialchars($product['name']); ?></h5>
                                    <p class="mb-1"><strong>Price:</strong> RM <?= number_format($product['price'], 2); ?></p>
                                    <p class="mb-1 text-success"><strong>Member Price:</strong> RM <?= number_format($product['mem_price'], 2); ?></p>
                                    <p class="mb-1"><strong>Stock:</strong> <?= (int)$product['stock'] ?></p>
                                    <p class="mb-1"><strong>Genre:</strong> <?= htmlspecialchars($product['genre']); ?></p>
                                    <p class="text-muted small"><?= substr(htmlspecialchars($product['description']), 0, 60); ?>...</p>

                                    <div class="mt-auto">
                                        <?php if ($product['stock'] > 0): ?>
                                            <div class="mb-2">
                                                <input type="number" name="product_quantity" value="1" min="1" max="<?= $product['stock'] ?>" class="form-control form-control-sm" required>
                                            </div>
                                            <input type="hidden" name="product_name" value="<?= htmlspecialchars($product['name']); ?>">
                                            <input type="hidden" name="product_price" value="<?= $product['mem_price']; ?>">
                                            <input type="hidden" name="product_image" value="<?= htmlspecialchars($product['image']); ?>">
                                            <button type="submit" name="add_to_cart" class="btn btn-outline-primary w-100 btn-sm">
                                                <i class="fas fa-cart-plus me-1"></i> Add to Cart
                                            </button>
                                        <?php else: ?>
                                            <div class="alert alert-danger text-center py-1 small mt-2 mb-0">Out of Stock</div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p class="text-center text-muted">No products found matching your criteria.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
