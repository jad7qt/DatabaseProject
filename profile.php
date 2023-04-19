<?php
ob_start();
session_start();

if (isset($_SESSION['UserID']) && isset($_SESSION['Username']) ) {
    // Connect to database
    require("connect-db.php");
    require("customer-db.php");
    require("profile-db.php");

    $Profile = array();

    //check user type to return correct query
    if ($_SESSION['Type'] == 'Administrator') {
        $Address = getAdminAddress($_SESSION['UserID']);
        $Phones = getUserPhones($_SESSION['UserID']);
    }
    elseif ($_SESSION['Type'] == 'Technician') {
        $Profile = getTechProfile($_SESSION['UserID']);
    }

    elseif ($_SESSION['Type'] == 'Customer') {
        $Profile = getCustProfile($_SESSION['UserID']);
    }

?>


<!DOCTYPE html>
<html>
<head>
	<title>Profile</title>
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