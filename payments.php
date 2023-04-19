<?php
session_start();

if (isset($_SESSION['UserID']) && isset($_SESSION['Username']) ) {
    require("connect-db.php");
    require("customer-db.php");

    $Payments = array();

  // Display Payments

	//admin outstanding payments query
    $stmt = $db->prepare("SELECT CONCAT(User.firstName, ' ', User.lastName) as Customer_Name, Project.JobType, 
    Project.EndDate, FORMAT((Invoice.TotalPrice - TP.Total_Payment), 'C') as Remaining_Payment
    FROM Invoice
    INNER JOIN 
        (SELECT Payment.ProjectID, SUM(Payment.Amount) as Total_Payment
        FROM Payment
        GROUP BY Payment.ProjectID
        ORDER BY ProjectID) as TP
    ON Invoice.ProjectID = TP.ProjectID
    INNER JOIN Project
    ON Project.ProjectID = Invoice.ProjectID
    INNER JOIN User
    ON Project.CustomerID = User.UserID
    HAVING Remaining_Payment > 0
	ORDER BY Project.EndDate");
    $stmt->execute();
    $Payments = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Payments</title>
	<link rel="stylesheet" type="text/css" href="css/searchResults.css">
</head>
<body>
	<header>
		<div class="logo-container">
      		<img src="images/logo_blank.png" alt="Logo" class="logo">
      		<h1 class="site-title">ContractorConnector</h1>
    	</div>
    	<h2 class="welcome-message">Welcome <?php echo $_SESSION['FirstName']?></h2>
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
	      <a href="homepage.php"><li>Projects</li></a>
	      <a href="payments.php"><li>Payments</li></a>
	      <a href="#"><li>Profile</li></a>
	      <a href="#"><li>Contact</li></a>
	    </ul>
	  </div>
	</nav>

	<div class="results-container">
		<h3>Projects with Remaining Payments</h3>
		<?php if (count($Payments) > 0 ): ?>
			<table>
				<thead>
					<tr>
                        <th>Customer Name</th>
						<th>Project Type</th>
                        <th>End Date</th>
                        <th>Remaining Payment</th>
					</tr>
				</thead>
				<tbody>
					<?php 
                    foreach ($Payments as $item): ?>
						<tr>
                            <td><?php echo $item['Customer_Name']; ?></td>
							<td><?php echo $item['JobType']; ?></td>
                            <td><?php echo $item['EndDate']; ?></td>
                            <td><?php echo $item['Remaining_Payment']; ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php else: ?>
			<p>No results found.</p>
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