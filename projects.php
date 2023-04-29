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
	<link rel="stylesheet" type="text/css" href="css/projects.css">
</head>


<!--HEADER-->
<?php include('header.php'); ?>
<!--HEADER-->
<!--hamburger-->
<?php include('hamburger.php'); ?>
<!--hamburger-->

    
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
                            <th>Status</th>                        

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
                                <td>
                                    <?php 
                                        if ($item['Completed'] == "1") {
                                            echo '<img src="images/check.png" alt="Completed" style="max-width: 30px; max-height: 30px;">';
                                        } else {
                                            echo "Ongoing";
                                        }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?> 
                <p>No results found</p>
            <?php endif; ?>

            <button type="button" onclick="window.location.href='createProject.php'" class="btn btn-primary">
            Add a New Project
            </button>
        </div>

</body>




<?php
  } else {
    header("Location: login.php");
    exit();
  }
?>