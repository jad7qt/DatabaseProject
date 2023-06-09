<?php 
ob_start();
session_start();
require("connect-db.php");
require("search-db.php");


if (isset($_SESSION['UserID']) && isset($_SESSION['Username']) ) {
    $Technician = array();

    //check if search entered
    if (isset($_POST['occupation-type'])) {
        $Technician = searchTechByName($_POST['occupation-type']);
    } else {
        $Technician = getAllTech();        
    }
  ?>
<!DOCTYPE html>
<html>
<head>
	<title>Search Results</title>
	<link rel="stylesheet" type="text/css" href="css/technicians.css">
</head>
<body>

<!--HEADER-->
<?php include('header.php'); ?>
<!--HEADER-->
<!--hamburger-->
<?php include('hamburger.php'); ?>
<!--hamburger-->

<div class="search-container">
    <form action="technicians.php" method="POST">
      <label for="occupation-type">Search for a <b>Technician</b></label>
	  <div>
      <input type="text" id="occupation-type" name="occupation-type" placeholder="Enter Name">
      <button type="submit">
  <img src="images/search.png" alt="Search" style="max-width: 20px; max-height: 20px; filter: invert(1);">
</button>

<!--     ADD Technician if they arent in the system    --><?php if($_SESSION['Type'] == 'Administrator'){ ?>

    <button type="button" class="techButton" onclick="window.location.href='addTechnician.php';" value="Add Technician"> <span class="plus-sign">+</span>
Add Technician</button>

<?php } ?>

</div>
</div>

    </form>
</div>


<div class="results-container">
		<h3>Technician Search Results</h3>
		<?php if (count($Technician) > 0): ?>
			<table>
				<thead>
					<tr>
                        <th>Technician Name</th>
						<th>Occupation Type</th>
                        <th>Rating</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($Technician as $item): ?>
						<tr>
						<td class="techNames"><b><?php echo '<a id="techName" href="profile.php?id='.$item['userID'].'">'.$item['Technician_Name'].'</a>'; ?></b></td>
							<td><?php echo $item['OccupationType']; ?></td>
							<td>
  <?php if ($item['Rating']): ?>
    <img src="images/star.png" alt="Star" style="width: 20px; height: 20px;">
    <?php echo $item['Rating']; ?>
  <?php endif; ?>
</td>					<?php endforeach; ?>
				</tbody>
			</table>
		<?php else: ?>
			<p>No results found.</p>
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