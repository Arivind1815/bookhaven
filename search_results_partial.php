<?php
include 'config.php';
include 'helpers.php';

$searchTerm = $_GET['q'] ?? '';
$selectedGenre = $_GET['genre'] ?? 'all';
$view = $_GET['view'] ?? 'card';

$where = [];
if ($selectedGenre !== 'all') {
   $where[] = "LOWER(genre) = LOWER('" . mysqli_real_escape_string($conn, $selectedGenre) . "')";
}
if (!empty($searchTerm)) {
   $safe = mysqli_real_escape_string($conn, $searchTerm);
   $where[] = "(LOWER(name) LIKE '%$safe%' OR LOWER(author) LIKE '%$safe%' OR LOWER(genre) LIKE '%$safe%')";
}
$whereSQL = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';
$query = "SELECT * FROM products $whereSQL ORDER BY release_date DESC";
$result = mysqli_query($conn, $query);
?>

<?php if (mysqli_num_rows($result) > 0): ?>
   <?php if ($view == 'card'): ?>
      <div class="row row-cols-1 row-cols-md-3 g-4">
         <?php while ($book = mysqli_fetch_assoc($result)): ?>
            <div class="col">
               <div class="card h-100 shadow-sm">
                  <img src="uploaded_img/<?= htmlspecialchars($book['image']) ?>" class="card-img-top" style="height: 220px; object-fit: cover;" alt="<?= htmlspecialchars($book['name']) ?>" onerror="this.src='default.jpg';">
                  <div class="card-body d-flex flex-column">
                     <h5 class="card-title"><?= highlight($book['name'], $searchTerm) ?></h5>
                     <p class="mb-1"><strong>Author:</strong> <?= highlight($book['author'], $searchTerm) ?></p>
                     <p class="mb-1"><strong>Genre:</strong> <?= highlight($book['genre'], $searchTerm) ?></p>
                     <p class="mb-1 text-success"><strong>Price:</strong> RM <?= number_format($book['mem_price'], 2) ?></p>
                     <p class="text-muted small mb-2"><?= htmlspecialchars(substr($book['description'], 0, 60)) ?>...</p>
                     <p class="text-muted small mt-auto">📅 <?= date('d M Y', strtotime($book['release_date'])) ?></p>
                  </div>
               </div>
            </div>
         <?php endwhile; ?>
      </div>
   <?php else: ?>
      <div class="list-group">
         <?php mysqli_data_seek($result, 0); while ($book = mysqli_fetch_assoc($result)): ?>
            <div class="list-group-item mb-3 shadow-sm">
               <div class="row g-3">
                  <div class="col-md-3">
                     <img src="uploaded_img/<?= htmlspecialchars($book['image']) ?>" class="img-fluid rounded" style="height: 180px; object-fit: cover;" alt="<?= htmlspecialchars($book['name']) ?>" onerror="this.src='default.jpg';">
                  </div>
                  <div class="col-md-9">
                     <h5><?= highlight($book['name'], $searchTerm) ?></h5>
                     <p><strong>Author:</strong> <?= highlight($book['author'], $searchTerm) ?></p>
                     <p><strong>Genre:</strong> <?= highlight($book['genre'], $searchTerm) ?></p>
                     <p><?= htmlspecialchars($book['description']) ?></p>
                     <p><strong>Price:</strong> RM <?= number_format($book['mem_price'], 2) ?></p>
                     <p class="text-muted small">📅 Released on: <?= date('d M Y', strtotime($book['release_date'])) ?></p>
                  </div>
               </div>
            </div>
         <?php endwhile; ?>
      </div>
   <?php endif; ?>
<?php else: ?>
   <p class="text-muted">No books found matching your search.</p>
<?php endif; ?>
