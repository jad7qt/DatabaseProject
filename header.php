<header>
    <link rel="stylesheet" href="css/header.css">
		<div class="logo-container">
      		<img src="images/logo_blank.png" alt="Logo" class="logo">
      		<Button id="CCbutton" onclick="window.location.href='homepage.php'">
      <h1 class="site-title">ContractorConnector</h1>
      </Button>
    	</div>
    	<h2 id="name" class="welcome-message">Welcome <?php echo $_SESSION['FirstName']?> (<?php echo $_SESSION['Type']?>)
  		</h2>

		  <button class="logout-button" onclick="window.location.href='logout.php'">
  			<img src="images/logout.png" alt="Logout" style="filter: invert(1); max-width: 20px; max-height: 20px;">
			</button>

</header>
