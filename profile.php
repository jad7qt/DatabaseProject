<?php
ob_start();
session_start();

if (isset($_SESSION['UserID']) && isset($_SESSION['Username']) ) {
    // Connect to database
    require("connect-db.php");
    require("customer-db.php");
    require("profile-db.php");

    $Address = array();

    //check user type to return correct query
    if ($_SESSION['Type'] == 'Administrator') {
        $Address = getAdminAddress($_SESSION['UserID']);
    }

    elseif ($_SESSION['Type'] == 'Technician') {
        //$Address = getTechProfile($_SESSION['UserID']);
    }

    elseif ($_SESSION['Type'] == 'Customer') {
        $Address = getCustAddress($_SESSION['UserID']);
    }

    $Phones = getUserPhones($_SESSION['UserID']);
?>


<!DOCTYPE html>
<html>
<head>
	<title>Profile</title>
	<link rel="stylesheet" type="text/css" href="css/searchResults.css">
</head>
<body>
	<header>
		<div class="logo-container">
      		<img src="images/logo_blank.png" alt="Logo" class="logo">
      		<h1 class="site-title">ContractorConnector</h1>
    	</div>
    	<h2 class="welcome-message">Profile page for <?php echo $_SESSION['Type'], ' ', $_SESSION['FirstName']?> </h2>
    	<button class="logout-button" onclick="window.location.href='logout.php'">Logout</button>
	</header>

<!--HEADER-->
<?php include('header.php'); ?>
<!--HEADER-->
<!--hamburger-->
<?php include('hamburger.php'); ?>
<!--hamburger-->

	<div class="results-container">
        <?php if (count($Address) > 0 ): ?>
            <table>
                <thead>
                    <tr>                       
                        <th>Address</th>                        
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($Address as $item): ?>
                        <tr>
                            <td><?php echo $item['Address']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?> 
            <p>No Address on file</p>
        <?php endif; ?>
    </div>

	<div class="results-container">
        <?php if (count($Phones) > 0 ): ?>
            <table>
                <thead>
                    <tr>                       
                        <th>Phone Type</th>
                        <th> Phone Number</th>                        
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($Phones as $item): ?>
                        <tr>
                            <td><?php echo $item['Type']; ?></td>
                            <td><?php echo $item['Number']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?> 
            <p>No Phone Numbers on file</p>
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