<?php
$pageTitle = "Add Review";
include 'includes/header.php';
?>
<main>
    <h2>Add a Book Review</h2>
    <form method="POST" action="submit_review.php">
        <input type="text" name="book_title" placeholder="Book Title" required>
        <textarea name="review" placeholder="Write your review..." required></textarea>
        <button type="submit">Submit Review</button>
    </form>
</main>
<?php include 'includes/footer.php'; ?>
