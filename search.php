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

            $sql = "SELECT * FROM reviews WHERE bookTitle LIKE :searchTitle";  // Use LIKE for partial matching

            // Prepare the statement
            $stmt = $conn->prepare($sql);

            // Add wildcards to the title for partial matching
            $searchTitle = "%" . $searchTitleInit . "%";  // Add % to allow partial matching

            // Bind the parameter
            $stmt->bindParam(':searchTitle', $searchTitle);

            // Execute the query
            $stmt->execute();

            // Fetch results
            $reviewResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($result) {
                // Loop through and display the results
                foreach ($result as $row) {
                    $score = ($row['numReviews'] > 0) ? $row['rating'] / $row['numReviews'] : 0;
                    ?>
                    <div class="search-result-container">
                        <div class="book-info">
                            <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                            <p class="author">By <?php echo htmlspecialchars($row['author']); ?></p>
                            <div class="rating-summary">
                                <span class="avg-rating">Average Rating: <?php echo number_format($score, 2); ?>/5</span>
                                <span class="review-count"><?php echo $row['numReviews']; ?> Reviews</span>
                            </div>
                        </div>

                        <div class="reviews-container">
                            <?php 
                            if (!empty($reviewResult)) {
                                foreach ($reviewResult as $review) { 
                            ?>
                                <div class="review">
                                    <div class="review-header">
                                        <span class="reviewer"> Subject: <?php echo htmlspecialchars($review['username']); ?></span>
                                        <span class="review-rating"><?php echo $review['rating']; ?>/5</span>
                                    </div>
                                    <p class="review-text"><?php echo htmlspecialchars($review['comment']); ?></p>
                                </div>
                            <?php 
                                }
                            } else {
                                echo "<p class='no-reviews'>No reviews yet</p>";
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                }
            } else {
                // No results found
                echo "<p class='no-results'>No book found with the title '" . htmlspecialchars($searchTitleInit) . "'.</p>";
            }
        } catch (PDOException $e) {
            // Error handling
            echo "<p class='error'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
        }

        // Close the connection
        $conn = null;
    }
    ?>
</main>

<?php include 'includes/footer.php'; ?>