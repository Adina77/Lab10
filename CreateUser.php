<?php
//Create a new mysqli object with user harsay, database harsay, and assign to variable name
$connection = new mysqli("mysql.eecs.ku.edu", "harsay", "seijoo9k", "harsay");

//Check connection. I copied this from Lab 10 pdf file, but a book by Robin Nixon
//says it is a security risk to reveal to the user what the connection error code is.
if ($connection->connect_errno) {
    printf("Connect failed: %s\n", $connection->connect_error);
    exit();
}

//Add user to Users table
if (isset($_POST['user_id'])) {
    $user_id = get_post($connection, 'user_id');

    // Print error message for blank entry
    if ($user_id == NULL) {
        echo "You need to enter a User ID. Click your browser's Back button and try again.";
        return 0;
    }
    // If user id does not yet exist, enter into database. The INSERT will fail if
    // user id already exits, because it is a primary key and must be unique.
    else {
        $query = "INSERT INTO Users VALUES" ."('$user_id')";
        $result = $connection->query($query);
        if (!$result) {
            echo "Failed to add new user.<br><br>";
        }
        else {
        echo "New user was successfully stored in the database.";
        }
    }
}

//Function for secure way to obtain post, avoiding hacker corrupting my database
//This is from Robin Nixon book on PHP, MySQL
function get_post($connection, $var) {
    return $connection->real_escape_string($_POST[$var]);
}

//Free result set
$result->free();

//Close connection
$connection->close();

?>
