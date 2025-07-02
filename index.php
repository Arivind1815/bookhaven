<?php
@include 'config.php'; 
session_start();
include 'header.php'; ?>

<!-- Hero Section -->
<section class="py-5 bg-light rounded shadow-sm mb-5">
   <div class="container text-center">
      <h1 class="display-5 fw-bold text-primary">Welcome to BookHaven 📚</h1>
      <p class="lead text-muted">Your trusted destination for books, knowledge, and imagination.</p>
      <a href="shop.php" class="btn btn-primary btn-lg mt-3">Shop Now</a>
   </div>
</section>

<!-- Featured Books -->
<section class="mb-5">
   <div class="container">
      <h2 class="text-center text-primary mb-4">Featured Books</h2>
      <div class="row">
         <?php
         $select_books = mysqli_query($conn, "SELECT * FROM products LIMIT 4") or die('query failed');
         if (mysqli_num_rows($select_books) > 0) {
            while ($book = mysqli_fetch_assoc($select_books)) {
         ?>
         <div class="col-md-3 mb-4">
            <div class="card h-100 shadow-sm">
               <img src="uploaded_img/<?= $book['image']; ?>" class="card-img-top" alt="<?= $book['name']; ?>">
               <div class="card-body d-flex flex-column">
                  <h5 class="card-title text-primary"><?= $book['name']; ?></h5>
                  <p class="card-text text-muted small"><?= substr($book['description'], 0, 60); ?>...</p>
                  <div class="mt-auto">
                     <p class="fw-bold text-dark">RM <?= number_format($book['price'], 2); ?></p>
                     <form action="cart.php" method="post">
                        <input type="hidden" name="product_id" value="<?= $book['id']; ?>">
                        <button type="submit" name="add_to_cart" class="btn btn-sm btn-outline-primary w-100">Add to Cart</button>
                     </form>
                  </div>
               </div>
            </div>
         </div>
         <?php
            }
         } else {
            echo '<p class="text-center text-muted">No featured books available right now.</p>';
         }
         ?>
      </div>
   </div>
</section>

<!-- Why Choose Us -->
<section class="bg-white py-5 border-top border-bottom">
   <div class="container text-center">
      <h2 class="text-primary mb-4">Why Choose BookHaven?</h2>
      <div class="row">
         <div class="col-md-4 mb-4">
            <i class="fas fa-truck fa-2x text-primary mb-3"></i>
            <h5 class="fw-bold">Fast Delivery</h5>
            <p class="text-muted">Get your favorite books delivered to your doorstep quickly and reliably.</p>
         </div>
         <div class="col-md-4 mb-4">
            <i class="fas fa-book-reader fa-2x text-primary mb-3"></i>
            <h5 class="fw-bold">Wide Selection</h5>
            <p class="text-muted">Explore a large variety of genres, authors, and academic resources.</p>
         </div>
         <div class="col-md-4 mb-4">
            <i class="fas fa-headset fa-2x text-primary mb-3"></i>
            <h5 class="fw-bold">Support</h5>
            <p class="text-muted">Have questions? We're here to help with excellent customer service.</p>
         </div>
      </div>
   </div>
</section>

<?php include 'footer.php'; ?>
