<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Reviews</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .reviews {
            list-style: none;
            padding: 0;
        }

        .review {
            border: 1px solid #ccc;
            background-color: #fff;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
        }

        .rating {
            color: #FFD700; /* Golden color for stars */
        }

        .comment-form {
            margin-top: 30px;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .comment-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
            resize: vertical;
        }

        .rating-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .rate-label {
            font-weight: bold;
        }

        .submit-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        .submit-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    
<form action="" method="post">
        <label for="comment">Write your comment:</label>
        <textarea name="comment" id="comment" required></textarea>

        <p>Rate our service:</p>
        <div class="rating">
            <input type="radio" id="star5" name="rating" value="5" required>
            <label for="star5">5 stars</label>
            <input type="radio" id="star4" name="rating" value="4">
            <label for="star4">4 stars</label>
            <input type="radio" id="star3" name="rating" value="3">
            <label for="star3">3 stars</label>
            <input type="radio" id="star2" name="rating" value="2">
            <label for="star2">2 stars</label>
            <input type="radio" id="star1" name="rating" value="1">
            <label for="star1">1 star</label>
        </div>

        <input type="submit" name="submit" value="Submit">
    </form>

    
    <?php
include 'config.php'; // Include database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $comment = $_POST['comment'];
    $rating = $_POST['rating'];

    // Insert data into the reviews table
    $sql = "INSERT INTO reviews (comment, rating) VALUES ('$comment', '$rating')";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Thank you for your review!</p>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>


<h1>Customer Reviews</h1>
    
    <?php
    include 'config.php'; // Include database connection file

    // Retrieve reviews from the database
    $sql = "SELECT comment, rating FROM reviews";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Display each review
        while ($row = $result->fetch_assoc()) {
            $comment = $row['comment'];
            $rating = $row['rating'];

            // Output the review content
            echo "<div class='review'>";
            echo "<p>Rating: $rating stars</p>";
            echo "<p>$comment</p>";
            echo "</div>";
        }
    } else {
        echo "<p>No reviews yet.</p>";
    }

    $conn->close();
    ?>


</body>
</html>
