<?php

// $username = 'jad7qt_b';
// $password = 'UpsornWinter2023';
// $host = 'mysql01.cs.virginia.edu';
// $dbname = 'jad7qt_b';
// $dsn = "mysql:host=$host;dbname=$dbname";

// FOR GCP DATABASE

// $username = 'root';                       // or your username
// $password = 'UpsornWinter2023';     
// $host = 'contractorconnecter:us-east4:contractordb';       // e.g., 'cs4750:us-east4:db-demo'; 
// $dbname = 'cc';           // e.g., 'guestbook';
// $dsn = "mysql:unix_socket=/cloudsql/$host;dbname=$dbname";
//       e.g., "mysql:unix_socket=/cloudsql/cs4750:us-east4:db-demo;dbname=guestbook";

// FOR LOCAL XAMPP w GCP Database

$username = 'root';
$password = 'UpsornWinter2023';
$host = 'contractorconnecter:us-east4:contractordb';       // e.g., 'cs4750:us-east4:db-demo'; 
$dbname = 'cc';;           // e.g., 'guestbook';
$dsn = "mysql:host=34.85.250.218;dbname=$dbname";   // connect PHP (XAMPP) to DB (GCP)
//       e.g., "mysql:host=99.99.999.99;dbname=$dbname";   

// to get public IP addres of the SQL instance, go to GCP SQL overview page

// To connect from a local PHP to GCP SQL instance, need to add authormized network
// to allow (my)machine to connect to the SQL instance. 
// 1. Get IP of the computer that tries to connect to the SQL instance
//    (use http://ipv4.whatismyv6.com/ to find the IP address)
// 2. On the SQL connections page, add authorized networks, enter the IP address

try
{
    // $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
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