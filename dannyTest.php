<?php 
session_start();
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ContractorConnector</title>
  <link rel="stylesheet" href="homepage.css">
</head>
<body>
  <header>
    <div class="logo-container">
      <img src="images/logo_blank.png" alt="Logo" class="logo">
      <h1 class="site-title">ContractorConnector</h1>
    </div>
    <h2 class="welcome-message">Hello <?php echo $_SESSION['FirstName']?></h2>
    <button class="logout-button" onclick="window.location.href='logout.php'">Logout</button>
      <!-- <a href="logout.php">Logout</a> -->
  </header>
</body>
</html>
