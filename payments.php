<?php
ob_start();
session_start();

if (isset($_SESSION['UserID']) && isset($_SESSION['Username']) ) {
    require("connect-db.php");
    require("customer-db.php");
    require("payments-db.php");

    $Payments = array();

  // Display Payments

	//admin outstanding payments query
  if($_SESSION['Type']=='Administrator'){
    $Payments = admin_payments();
  }elseif($_SESSION['Type']=='Technician'){
    $Payments = tech_payments($_SESSION['UserID']);
  }else{
    $Payments = cust_payments($_SESSION['UserID']);
  }

?>

<!DOCTYPE html>
<html>
<head>
	<title>Payments</title>
	<link rel="stylesheet" type="text/css" href="css/searchResults.css">
</head>
<body>

<!--HEADER-->
<?php include('header.php'); ?>
<!--HEADER-->

<!--hamburger-->
<?php include('hamburger.php'); ?>
<!--hamburger-->


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
  ob_end_flush();
?>