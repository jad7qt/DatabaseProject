<?php 

session_start();

 ?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Homepage</title>
  <link rel="stylesheet" href="homepage.css">
</head>

<nav>
    <ul class="sidebar">
      <h3 class="logo">ContractorConnector</h3>
      <li>Home</li>
      <li>Profile</li>
      <li>Info</li>
      <button class="logout-button" onclick="window.location.href='logout.php'">Logout</button>
      <!-- <a href="logout.php">Logout</a> -->
    </ul>

    <input type="checkbox" id="sidebar-btn" class="sidebar-btn" checked/>
    <label for="sidebar-btn"></label>

    <div class="content">
      <h1 class="h1BodyText">Hello <?php echo $_SESSION['FirstName']?></h1>
    </div>
  </nav>

