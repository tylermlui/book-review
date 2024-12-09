<?php
$pageTitle = "Add Book";
include 'includes/header.php';
?>
<main>
    <h2>Add a New Book</h2>
    <form method="POST" action="">
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

if (isset($_POST['submit'])) {
    // Sanitize and get user inputs
    $title = $_POST['book_title'];
    $author = $_POST['author'];

try {
    // Connect to the database
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Book review details
    $rating = 0;
    $numReviews = 0;
    $bookNum = 12345;

    // SQL query to insert data
    $sql = "INSERT INTO books (title, author, rating, numReviews, bookNum) 
            VALUES (:title, :author, :rating, :numReviews, :bookNum)";

    // Prepare and execute the statement
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':author', $author);
    $stmt->bindParam(':rating', $rating);
    $stmt->bindParam(':numReviews', $numReviews);
    $stmt->bindParam(':bookNum', $bookNum);

    if ($stmt->execute()) {
        echo "<p>$title added successfully!</p>";
    } else {
        echo "<p>Failed to add the book .</p>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


// Close the connection
$conn = null;
}
?>

<?php include 'includes/footer.php'; ?>
