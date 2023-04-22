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
	<link rel="stylesheet" type="text/css" href="css/searchResults.css">
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
      <label for="occupation-type">Search for a Technician</label>
      <input type="text" id="occupation-type" name="occupation-type" placeholder="Enter Name">
      <button type="submit">Search</button>
    </form>
</div>

<?php if($_SESSION['Type'] == 'Administrator'){ ?>
	<form action="addTechnician.php">
    	<input type="submit" value="Add Technician"/>
	</form>
</div>	
<?php } ?>

<div class="results-container">
		<h3>Technician Results</h3>
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
                            <td><?php echo '<a href="profile.php?id='.$item['userID'].'">'.$item['Technician_Name'].'</a>'; ?></td>
							<td><?php echo $item['OccupationType']; ?></td>
                            <td><?php echo $item['Rating']; ?></td>
						</tr>
					<?php endforeach; ?>
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
?>