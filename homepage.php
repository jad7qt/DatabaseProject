<?php 
session_start();

if (isset($_SESSION['UserID']) && isset($_SESSION['Username']) ) {
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ContractorConnector</title>
  <link rel="stylesheet" href="css/homepage.css">
</head>

<!--HEADER-->
<?php include('header.php'); ?>
<!--HEADER-->
<!--hamburger-->
<?php include('hamburger.php'); ?>
<!--hamburger-->

<div class="search-container">
    <form action="searchResults.php" method="POST">
      <label for="occupation-type">Search for a Local Technician</label>
      <input type="text" id="occupation-type" name="occupation-type" placeholder="Enter occupation type">
      <button type="submit">Search</button>
    </form>
</div>

</html>

<?php
  } else {
    header("Location: login.php");
    exit();
  }
?>