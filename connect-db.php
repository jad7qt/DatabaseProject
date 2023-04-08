<?php

$username = 'jad7qt_b';
$password = apache_getenv('PASS');
$host = 'mysql01.cs.virginia.edu';
$dbname = 'jad7qt_b';
$dsn = "mysql:host=$host;dbname=$dbname";

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