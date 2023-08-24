<?php
define('DB_USER', "root"); // db user
define('DB_PASSWORD', ""); // db password (mention your db password here)
define('DB_DATABASE', "user_db"); // database name
define('DB_SERVER', "localhost"); // db server

$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);

// getDbConnection() function will return a database connection object
function getDbConnection()
{
    $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
    return $conn;
}

// Check connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>