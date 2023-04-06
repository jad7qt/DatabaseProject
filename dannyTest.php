<?php 
session_start();
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ContractorConnector</title>
  <link rel="stylesheet" href="css/dannyTest.css">
</head>
  <header>
    <div class="logo-container">
      <img src="images/logo_blank.png" alt="Logo" class="logo">
      <h1 class="site-title">ContractorConnector</h1>
    </div>
    <h2 class="welcome-message">Welcome <?php echo $_SESSION['FirstName']?></h2>
    <button class="logout-button" onclick="window.location.href='logout.php'">Logout</button>
      <!-- <a href="logout.php">Logout</a> -->
  </header>



<!--HAMBURGER BELOW -->
<nav role="navigation">
  <div id="menuToggle">
    <!--
    A fake / hidden checkbox is used as click reciever,
    so you can use the :checked selector on it.
    -->
    <input type="checkbox" />
    
    <!--
    Some spans to act as a hamburger.
    
    They are acting like a real hamburger,
    not that McDonalds stuff.
    -->
    <span></span>
    <span></span>
    <span></span>
    
    <!--
    Too bad the menu has to be inside of the button
    but hey, it's pure CSS magic.
    -->
    <ul id="menu">
      <a href="#"><li>Projects</li></a>
      <a href="#"><li>Payments</li></a>
      <a href="#"><li>Profile</li></a>
      <a href="#"><li>Contact Admin</li></a>
    </ul>
  </div>
</nav>

</html>
