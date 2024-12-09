<?php
$pageTitle = "Search";
include 'includes/header.php';
?>
<main>
    <h2>Search for a Book</h2>
    <form method="GET" action="">
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

    // Check if 'query' parameter is passed via GET
    if (isset($_GET['query'])) {
        $searchTitleInit = $_GET['query'];  // Get the search query from the form input

        try {
            // Connect to the database
            $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // SQL query to find a book by title
            $sql = "SELECT * FROM books WHERE title LIKE :searchTitle";  // Use LIKE for partial matching

            // Prepare the statement
            $stmt = $conn->prepare($sql);

            // Add wildcards to the title for partial matching
            $searchTitle = "%" . $searchTitleInit . "%";  // Add % to allow partial matching

            // Bind the parameter
            $stmt->bindParam(':searchTitle', $searchTitle);

            // Execute the query
            $stmt->execute();

            // Fetch results
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($result) {
                // Loop through and display the results
                foreach ($result as $row) {
                    // need to format output 
                    echo "<p>Author: " . $row['author'] . "</p><br>";
                    echo "<p>Rating: " . $row['rating'] . "</p><br>";
                    echo "<p>Number of Reviews: " . $row['numReviews'] . "</p><br><br>";
                }
            } else {
                // No results found
                echo "<p>No book found with the title '$searchTitleInit'.</p>";
            }
        } catch (PDOException $e) {
            // Error handling
            echo "Error: " . $e->getMessage();
        }

        // Close the connection
        $conn = null;
    }
    ?>

<?php include 'includes/footer.php'; ?>
