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

echo "<h2>User names for all users of the message board system: </h2>";

// Obtain the entire Users table and store in object called result
$query = "SELECT user_id FROM Users";
$result = $connection->query($query);

// Obtain the number of rows, so I can set for loop parameters
$rows = $result->num_rows;

// for loop syntax from Robin Nixon book; prints the table contents.
// The syntax is designed to clean the data for security reasons.
for ($j = 0 ; $j < $rows; ++$j ) {
    $result->data_seek($j);
    echo " " .$result->fetch_assoc()['user_id'] ."<br>";
}

/* Can also use while loop instead of above for loop, as in Lab 10 pdf
if ($result = $connection->query($query)) {
    // fetch associative array
    while ($row = $result->fetch_assoc()) {
        printf ("%s\n", $row["user_id"]);
    }
}
*/

//Close things to recalim memory
$result->close();
$connection->close();

?>