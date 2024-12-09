<?php
$pageTitle = "Search";
include 'includes/header.php';
?>
<main>
    <h2>Search for a Book</h2>
    <form method="GET" action="search_results.php">
        <input type="text" name="query" placeholder="Enter book title..." required>
        <button type="submit">Search</button>
    </form>
</main>

<?php include 'includes/footer.php'; ?>
