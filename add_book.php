<?php
$pageTitle = "Add Book";
include 'includes/header.php';
?>
<main>
    <h2>Add a New Book</h2>
    <form method="POST" action="submit_book.php">
        <input type="text" name="book_title" placeholder="Book Title" required>
        <input type="text" name="author" placeholder="Author" required>
        <button type="submit">Add Book</button>
    </form>
</main>
<?php include 'includes/footer.php'; ?>
