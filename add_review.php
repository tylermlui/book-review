<?php
$pageTitle = "Add Review";
include 'includes/header.php';
?>
<main>
    <h2>Add a Book Review</h2>
    <form method="POST" action="">
         <!-- TODO: Need to add rating system -->
        <input type="text" name="subject" placeholder="Subject" required>
        <input type="text" name="book_title" placeholder="Book Title" required>
        <label>Rate book on a scale of 1-5</label>
        <input type="range" name="rating" min="1" max="5" value="3" oninput="this.form.amountInput.value=this.value" />
        <input type="number" name="amountInput" min="1" max="5" value="3" oninput="this.form.amountRange.value=this.value" />
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
    $subject = $_POST['subject'];
    $rating = (int)$_POST['rating'];

try {
    // Connect to the database
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Book review details
    $id = NULL;

    $checkBookSql = "SELECT * FROM books WHERE title = :bookTitle";
    $checkStmt = $conn->prepare($checkBookSql);
    $checkStmt->bindParam(':bookTitle', $bookTitle);
    $checkStmt->execute();

    if ($checkStmt->rowCount() > 0) {
    // SQL query to insert data
    $sql = "INSERT INTO reviews (id, bookTitle, rating, comment, username) 
            VALUES (:id, :bookTitle, :rating, :comment, :username)";

    // Prepare and execute the statement
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':bookTitle', $bookTitle);
    $stmt->bindParam(':rating', $rating);
    $stmt->bindParam(':comment', $comment);
    $stmt->bindParam(':username', $subject);

    if ($stmt->execute()    ) {
        echo "Book review added successfully!";
    } else {
        echo "Failed to add the book review.";
    }

    $sql = "UPDATE books SET numReviews = numReviews + 1 WHERE title = :bookTitle";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':bookTitle', $bookTitle); 

    if ($stmt->execute()) {
        echo "Number of reviews updated successfully!";
    } else {
        echo "Failed to update the number of reviews.";
    }

    $sql = "UPDATE books SET rating = rating + :rating WHERE title = :bookTitle";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':bookTitle', $bookTitle); 
    $stmt->bindParam(':rating', $rating); 

    if ($stmt->execute()) {
        echo "Number of reviews updated successfully!";
    } else {
        echo "Failed to update the number of reviews.";
    }
}
else {
    echo "<p>Book not found, it needs to be added before the review</p>";
}

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the connection
$conn = null;
}
?>

<?php include 'includes/footer.php'; ?>


