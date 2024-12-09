<?php
$pageTitle = "Add Review";
include 'includes/header.php';
?>
<main>
    <h2>Add a Book Review</h2>
    <form method="POST" action="">
         <!-- TODO: Need to add rating system -->
        <input type="text" name="username" placeholder="Username" required>
        <input type="text" name="book_title" placeholder="Book Title" required>
        <textarea name="review" placeholder="Write your review..." required></textarea>
        <button name="submit" type="submit">Submit Review</button>
    </form>
</main>

<?php
// Database connection details
$host = 'localhost';
$username = 'root';
$password = 'bookReview';
$dbname = 'bookreview';

if (isset($_POST['submit'])) {
    // Sanitize and get user inputs
    $bookTitle = $_POST['book_title'];
    $comment = $_POST['review'];
    $user = $_POST['username'];
}

try {
    // Connect to the database
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Book review details
    $id = NULL;
    $rating = 4.5;

    // SQL query to insert data
    $sql = "INSERT INTO reviews (id, bookTitle, rating, comment, username) 
            VALUES (:id, :bookTitle, :rating, :comment, :username)";

    // Prepare and execute the statement
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':bookTitle', $bookTitle);
    $stmt->bindParam(':rating', $rating);
    $stmt->bindParam(':comment', $comment);
    $stmt->bindParam(':username', $user);

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


