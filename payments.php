<?php
ob_start();
session_start();

if (isset($_SESSION['UserID']) && isset($_SESSION['Username']) ) {
    require("connect-db.php");
    require("customer-db.php");
    require("payments-db.php");

    $Payments = array();
    $prevPayments = array();

  // Display Payments

	//admin outstanding payments query
  if($_SESSION['Type']=='Administrator'){
    $Payments = admin_payments();
  }elseif($_SESSION['Type']=='Technician'){
    $Payments = tech_payments($_SESSION['UserID']);
  }else{
    $Payments = cust_payments($_SESSION['UserID']);
    $prevPayments = getPrevPayments($_SESSION['UserID']);
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
              <?php if($_SESSION['Type'] != "Technician"){ ?>
                <th>Add Payment</th>
              <?php } ?>
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
                    <?php if($_SESSION['Type'] != "Technician"){ ?>
                      <td><?php echo '<a id="paymentBtnn" href="addPayment.php?id='.$item['ProjectID'].'">Add Payment</a>'; ?></td>
                    <?php } ?>
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


<?php if($_SESSION['Type'] == 'Customer'){ ?>
  <div class="results-container">
		<h3>Previous Payments</h3>
		<?php if (count($Payments) > 0 ): ?>
			<table>
				<thead>
					<tr>
              <th>Job Type</th>
              <th>Payment ID</th>
              <th>Amount</th>
              <th>Payment Type</th>
              <th>Date</th>

					</tr>
				</thead>
				<tbody>
					<?php 
              foreach ($prevPayments as $item): ?>
						    <tr>
                    <td><?php echo $item['JobType']; ?></td>
                    <td><?php echo $item['PaymentID']; ?></td>
                    <td><?php echo $item['Amount']; ?></td>
                    <td><?php echo $item['Type']; ?></td>
                    <td><?php echo $item['Date']; ?></td>
						    </tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php else: ?>
			<p>No results found.</p>
		<?php endif; ?>
	</div> 
  <?php } ?>



</body>
</html>


<?php
  } else {
    header("Location: login.php");
    exit();
  }
  ob_end_flush();
?>