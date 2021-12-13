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

$user = $_POST["user"];

echo "<h2>" . $user . "'s Posts</h2>";

$query = "SELECT * FROM Posts WHERE author_id = '$user'";

if ($result = $connection->query($query)) {
    echo '<table border="1">';
    echo "<th>Post ID</th><th>Content</th>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["post_id"] . "</td><td>" . $row["content"] . "</td>";
    }
    echo "</table>";
}

$connection->close();

?>

