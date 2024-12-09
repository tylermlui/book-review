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

<?php
// Database connection details
$host = 'localhost';
$username = 'root';
$password = 'bookReview';
$dbname = 'bookreview';

// Book title to search for
$searchTitle = "The Great Gatsby";

try {
    // Connect to the database
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL query to find a book by title
    $sql = "SELECT * FROM books WHERE title = :searchTitle";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind the parameter
    $stmt->bindParam(':searchTitle', $searchTitle);

    // Execute the query
    $stmt->execute();

    // Fetch results
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($result) {
        foreach ($result as $row) {
            echo "Author: " . $row['author'] . "<br>";
            echo "Rating: " . $row['rating'] . "<br>";
            echo "numReviews " . $row['numReviews'] . "<br><br>";
        }
    } else {
        echo "No book found with the title '$searchTitle'.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the connection
$conn = null;
?>


<?php include 'includes/footer.php'; ?>
