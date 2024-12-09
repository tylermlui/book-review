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

<?php
// Database connection details
$host = 'localhost';
$username = 'root';
$password = 'bookReview';
$dbname = 'bookreview';

try {
    // Connect to the database
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Book review details
    $bookTitle = "The Great G";
    $id = "2342311";
    $rating = 4.5;
    $comment = "I love this book so much! Can't wait to be Gatsby";
    $username = "Iluv2read";

    // SQL query to insert data
    $sql = "INSERT INTO reviews (id, bookTitle, rating, comment, username) 
            VALUES (:id, :bookTitle, :rating, :comment, :username)";

    // Prepare and execute the statement
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':bookTitle', $bookTitle);
    $stmt->bindParam(':rating', $rating);
    $stmt->bindParam(':comment', $comment);
    $stmt->bindParam(':username', $username);

    if ($stmt->execute()) {
        echo "Book review added successfully!";
    } else {
        echo "Failed to add the book review.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the connection
$conn = null;
?>

<?php include 'includes/footer.php'; ?>


