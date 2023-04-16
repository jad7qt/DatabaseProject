<?php

$username = 'jad7qt_b';
$password = 'UpsornWinter2023';
$host = 'mysql01.cs.virginia.edu';
$dbname = 'jad7qt_b';
$dsn = "mysql:host=$host;dbname=$dbname";

// FOR GCP DATABASE

// $username = 'root';                       // or your username
// $password = 'your-root-password';     
// $host = 'instance-connection-name';       // e.g., 'cs4750:us-east4:db-demo'; 
// $dbname = 'your-database-name';           // e.g., 'guestbook';
// $dsn = "mysql:unix_socket=/cloudsql/instance-connection-name;dbname=your-database-name";
//       e.g., "mysql:unix_socket=/cloudsql/cs4750:us-east4:db-demo;dbname=guestbook";

try
{
    $db = new PDO($dsn, $username, $password);
}
catch(PDOException $e)
{
    $error_message = $e->getMessage();
    echo "<p>An error occurred while connecting to the database: $error_message </p>";
}
catch(Exception $e)
{
    $error_message = $e->getMessage();
    echo "<p>Error message: $error_message </p>";
}
?>