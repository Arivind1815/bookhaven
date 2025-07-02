<?php
session_start();
include 'config.php';
include 'helpers.php';

$searchTerm = $_GET['q'] ?? '';
$selectedGenre = $_GET['genre'] ?? 'all';
$view = $_GET['view'] ?? 'card';

$genres = [];
$genreQuery = mysqli_query($conn, "SELECT DISTINCT genre FROM products ORDER BY genre ASC");
while ($row = mysqli_fetch_assoc($genreQuery)) {
   $genres[] = $row['genre'];
}

// Fetch search results
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

<?php include 'header.php'; ?>

<div class="container text-center mt-5 mb-4">
   <h2 class="text-primary">🔎 Search Books</h2>
   <p><a href="home.php" class="text-decoration-none text-muted">Home</a> / Search</p>
</div>

<section class="container mb-4">
   <!-- Search Bar -->
   <form id="search-form" method="GET" action="search.php" class="row g-3 mb-4">
      <div class="col-md-5">
         <input type="text" name="q" id="search-input" class="form-control" placeholder="Search by name, author, or genre"
            value="<?= htmlspecialchars($searchTerm) ?>">
      </div>
      <div class="col-md-3">
         <select name="genre" id="genre-select" class="form-select">
            <option value="all">All Genres</option>
            <?php foreach ($genres as $g): ?>
               <option value="<?= htmlspecialchars($g) ?>" <?= $selectedGenre == $g ? 'selected' : '' ?>>
                  <?= htmlspecialchars($g) ?>
               </option>
            <?php endforeach; ?>
         </select>
      </div>
      <div class="col-md-2">
         <select name="view" id="view-select" class="form-select">
            <option value="card" <?= $view == 'card' ? 'selected' : '' ?>>Card View</option>
            <option value="detail" <?= $view == 'detail' ? 'selected' : '' ?>>Detail View</option>
         </select>
      </div>
      <div class="col-md-2">
         <button type="submit" class="btn btn-primary w-100">Search</button>
      </div>
   </form>

   <!-- Results Container -->
   <div id="results-container">
      <?php include 'search_results_partial.php'; ?>
   </div>
</section>

<script>
document.getElementById('search-input').addEventListener('keyup', function() {
   const query = this.value;
   const genre = document.getElementById('genre-select').value;
   const view = document.getElementById('view-select').value;

   fetch(`search_results_partial.php?q=${encodeURIComponent(query)}&genre=${encodeURIComponent(genre)}&view=${view}`)
      .then(response => response.text())
      .then(data => document.getElementById('results-container').innerHTML = data);
});
</script>

<?php include 'footer.php'; ?>
