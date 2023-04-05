<?php 

session_start();

session_unset();

session_destroy();

header("Location: homepage.php"); // WHERE THE USER IS DIRECTED TO AFTER LOGOUT
?>