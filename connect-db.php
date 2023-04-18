<?php

// $username = 'jad7qt_b';
// $password = 'UpsornWinter2023';
// $host = 'mysql01.cs.virginia.edu';
// $dbname = 'jad7qt_b';
// $dsn = "mysql:host=$host;dbname=$dbname";

$username = 'root';                       // or your username
$password = 'UpsornWinter2023';     
$host = 'contractorconnecter:us-east4:contractordb';       // e.g., 'cs4750:us-east4:db-demo'; 
$dbname = 'cc';           // e.g., 'guestbook';
$dsn = "mysql:unix_socket=/cloudsql/$host;dbname=$dbname";


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