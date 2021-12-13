<?php

// Error reporting
error_reporting(E_ALL);
ini_set("display_errors", 1);

//Create a new mysqli object with user harsay, database harsay, and assign to variable name
$connection = new mysqli("mysql.eecs.ku.edu", "harsay", "seijoo9k", "harsay");

//Check connection. I copied this from Lab 10 pdf file, but a book by Robin Nixon
//says it is a security risk to reveal to the user what the connection error code is.
if ($connection->connect_errno) {
    printf("Connect failed: %s\n", $connection->connect_error);
    exit();
}

//Add post to Posts table
if (isset($_POST['content']) && 
    isset($_POST['author_id'])) {
    $userpost = get_post($connection, 'content');
    $author = get_post($connection, 'author_id');

    // Print error message for blank entry
    if ($userpost == NULL || $author == NULL) {
        printf("You need to enter a post and user name. Click your browser's Back button and try again.");
        exit();
    }

  
   // Obtain data from Users table to check if author of post is a user
    $query = "SELECT user_id FROM Users WHERE user_id = '$author'";
    $result = $connection->query($query);

    // Determine if any rows had the input author user id
    $rows = $result->num_rows;
    // Print error message if no row had the user id
    if ($rows == 0) {
        echo "Your post can't be saved. No users exist with the user name you entered.";
        exit();
    }
    else {
        // Enter the post into the Posts table
        $query2 = "INSERT INTO Posts VALUES" ."(NULL, '$userpost', '$author')";
        $result2 = $connection->query($query2);
        if (!$result2) {
            echo "Failed to add post.<br><br>";
        }
        else {
            echo "Your post was successfully stored in the database.";
        }
    }
}

//Function for secure way to obtain post, avoiding hacker corrupting my database
//This is from Robin Nixon book on PHP, MySQL
function get_post($connection, $var) {
    return $connection->real_escape_string($_POST[$var]);
}

//Free result set -- commented out because it gives error, because boolean
//$result->free();

//Close connection
$connection->close();

?>
