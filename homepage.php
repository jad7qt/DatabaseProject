<?php 
ob_start();
session_start();

if (isset($_SESSION['UserID']) && isset($_SESSION['Username']) ) {
  require("connect-db.php");
  require("homepage-db.php");


  $projects = array();
  $prevProjects = array();
  $unassigned = array();
  $userID = $_SESSION['UserID'];
  $amountOwed = 0;

  if ($_SESSION['Type'] == 'Administrator') {
    $projects = getAdminProjs();
    $unassigned = getUnassigned();
    $table2 = $unassigned;
  }

  elseif ($_SESSION['Type'] == 'Technician') {
    $projects = getTechProjs($userID);
    $unassigned = getUnassigned();
    $table2 = $unassigned;
  }

  elseif ($_SESSION['Type'] == 'Customer') {
    $projects = getCustProjs($userID, 0);
    $prevProjects = getCustProjs($userID, 1);
    $table2 = $prevProjects;
    $amountOwed = getAmountOwed($userID);
    $amountOwed = $amountOwed['Total_Remaining_Payment'];
  }
  ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ContractorConnector</title>
  <link rel="stylesheet" href="css/homepage.css">
</head>


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

<div class="search-container">
    <form action="searchResults.php" method="POST">
      <label for="occupation-type">Search for a <b>Local Technician</b></label>
      <div>
      <input type="text" id="occupation-type" name="occupation-type" placeholder="Enter Occupation">
      <button type="submit">
  <img src="images/search.png" alt="Search" style="max-width: 20px; max-height: 20px; filter: invert(1);">
</button>
      </div>
    </form>
</div>

<?php if($_SESSION['Type'] == 'Customer'): ?>
    <div class="results-container">
  <h3>Total Outstanding Balance</h3>
  <div class="amount-owed">
    <?php echo '$' . (empty($amountOwed) ? "0" : $amountOwed); ?>
  </div>
</div>
<?php endif; ?>


<div class="results-container">
    <?php if($_SESSION['Type'] == 'Administrator'): ?>
        <h3>Recently Added Projects</h3>

    <?php elseif($_SESSION['Type'] == 'Technician'): ?>
        <h3>Technician Current Jobs</h3>

    <?php elseif($_SESSION['Type'] == 'Customer'): ?>
        <h3>Customer Current Projects</h3>

    <?php endif; ?>
            <?php if (count($projects) > 0 ): ?>
                <table>
                    <thead>
                        <tr>
                            <th> Details </th>
                            <?php if($_SESSION['Type'] != 'Customer'): ?>
                                <th>Customer Name</th>
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
                        foreach ($projects as $item): ?>
                            <tr>
                            <td>
  <?php echo '<a href="projectDetails.php?id='.$item['ProjectID'].'"><img id="infoImg" src="images/info.png" alt="Project Info" style="max-width: 30px; max-height: 30px;"></a>'; ?>
</td>
                                <?php if($_SESSION['Type'] != 'Customer'): ?>
                                    <td><?php echo $item['Customer_Name']; ?></td>
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
                                            echo '<img src="images/ongoing.png" alt="Completed" style="max-width: 30px; max-height: 30px;">';
                                        }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?> 
<p class="no-results">No results found</p>
            <?php endif; ?>
  </div>

<div class="results-container">
    <?php if($_SESSION['Type'] == 'Administrator'): ?>
        <h3>Unassigned Projects</h3>

    <?php elseif($_SESSION['Type'] == 'Technician'): ?>
        <h3>Unassigned Projects</h3>

    <?php elseif($_SESSION['Type'] == 'Customer'): ?>
        <h3>Customer Previous Projects</h3>

    <?php endif; ?>
            <?php if (count($table2) > 0 ): ?>
                <table>
                    <thead>
                        <tr>
                            <th> Details </th>
                            <?php if($_SESSION['Type'] != 'Customer'): ?>
                                <th>Customer Name</th>
                            <?php endif; ?>
                            <th>Project Type</th>
                            <th>Description</th>
                            <th>Project Address</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <?php if($_SESSION['Type'] == 'Customer'): ?>
                                <th>Technician Name</th>
                            <?php elseif($_SESSION['Type'] == 'Administrator'): ?>
                                <th>Accept Job</th>
                            <?php endif; ?>                        
                            <th>Status</th>                        

                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($table2 as $item): ?>
                            <tr>
                            <td> 
    <?php echo '<a id="infoBtn" href="projectDetails.php?id='.$item['ProjectID'].'"><img src="images/info.png" alt="info" style="max-width: 30px; max-height: 30px;"></a>'; ?> 
</td>
                                <?php if($_SESSION['Type'] != 'Customer'): ?>
                                    <td><?php echo $item['Customer_Name']; ?></td>
                                <?php endif; ?>
                                <td><?php echo $item['JobType']; ?></td>
                                <td><?php echo $item['Description']; ?></td>                            
                                <td><?php echo $item['Project_Address']; ?></td>
                                <td><?php echo $item['StartDate']; ?></td>
                                <td><?php echo $item['EndDate']; ?></td>
                                <?php if($_SESSION['Type'] == 'Customer'): ?>
                                    <td><?php echo $item['Technician_Name']; ?></td>
                                <?php elseif($_SESSION['Type'] == 'Administrator'): ?>
                                    <td class="text-center">
  <?php echo '<a id="red" href="assignTech.php?id='.$item['ProjectID'].'"><img src="images/signup.png" alt="Assign Technician" width=40" height="40"></a>'; ?>
</td>
                                <?php endif; ?>
                                <td>
                                    <?php 
                                        if ($item['Completed'] == "1") {
                                            echo '<img src="images/check.png" alt="Completed" style="max-width: 30px; max-height: 30px;">';
                                        } else {
                                            echo '<img src="images/ongoing.png" alt="Completed" style="max-width: 30px; max-height: 30px;">';
                                        }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?> 
                <p class="no-results">No results found</p>
            <?php endif; ?>
  </div>

</html>

<?php
  } else {
    header("Location: login.php");
    exit();
  }
  ob_end_flush();
?>