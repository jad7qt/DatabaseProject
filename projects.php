<?php
session_start();

if (isset($_SESSION['UserID']) && isset($_SESSION['Username']) ) {
    require("connect-db.php");
    require("customer-db.php");
    require("projects-db.php");

    $Projects = array();

  // Display Projects

	//admin master project table query
if ($_SESSION['Type'] == 'Administrator') {
    $Projects = adminMasterTable();
}

elseif ($_SESSION['Type'] == 'Technician') {
    $Projects = techProjTable($_SESSION['UserID']);
}

elseif ($_SESSION['Type'] == 'Customer') {
    $Projects = custProjTable($_SESSION['UserID']);
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Projects</title>
	<link rel="stylesheet" type="text/css" href="css/searchResults.css">
</head>
<body>
	<header>
		<div class="logo-container">
      		<img src="images/logo_blank.png" alt="Logo" class="logo">
      		<h1 class="site-title">ContractorConnector</h1>
    	</div>
    	<h2 class="welcome-message">Project page for <?php echo $_SESSION['Type'], ' ', $_SESSION['FirstName']?> </h2>
    	<button class="logout-button" onclick="window.location.href='logout.php'">Logout</button>
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
	      <a href="projects.php"><li>Projects</li></a>
	      <a href="payments.php"><li>Payments</li></a>
	      <a href="#"><li>Profile</li></a>
	      <a href="#"><li>Contact</li></a>
	    </ul>
	  </div>
	</nav>

	<div class="results-container">
    <?php if($_SESSION['Type'] == 'Administrator'): ?>
        <h3>Admin Project Master Table</h3>

    <?php elseif($_SESSION['Type'] == 'Technician'): ?>
        <h3>Technician Jobs Table</h3>

    <?php elseif($_SESSION['Type'] == 'Customer'): ?>
        <h3>Customer Projects Table</h3>

    <?php endif; ?>

            <?php if (count($Projects) > 0 ): ?>
                <table>
                    <thead>
                        <tr>
                            <?php if($_SESSION['Type'] != 'Customer'): ?>
                                <th>Customer Name</th>
                                <th>Customer Phone</th>
                            <?php endif; ?>
                            <th>Project Type</th>
                            <th>Description</th>
                            <th>Project Address</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <?php if($_SESSION['Type'] != 'Technician'): ?>
                                <th>Technician Name</th>
                            <?php endif; ?>                        
                            <th>Completed</th>                        

                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($Projects as $item): ?>
                            <tr>
                                <?php if($_SESSION['Type'] != 'Customer'): ?>
                                    <td><?php echo $item['Customer_Name']; ?></td>
                                    <td><?php echo $item['CustomerPhone']; ?></td>
                                <?php endif; ?>
                                <td><?php echo $item['JobType']; ?></td>
                                <td><?php echo $item['Description']; ?></td>                            
                                <td><?php echo $item['Project_Address']; ?></td>
                                <td><?php echo $item['StartDate']; ?></td>
                                <td><?php echo $item['EndDate']; ?></td>
                                <?php if($_SESSION['Type'] != 'Technician'): ?>
                                    <td><?php echo $item['Technician_Name']; ?></td>
                                <?php endif; ?>
                                <td><?php echo $item['Completed']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?> 
                <p>No results found</p>
            <?php endif; ?>
        </div>

</body>
</html>


<?php
  } else {
    header("Location: login.php");
    exit();
  }
?>