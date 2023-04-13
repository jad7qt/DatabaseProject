<?php
session_start();
require("connect-db.php");
require("search-db.php");

if (isset($_SESSION['UserID']) && isset($_SESSION['Username']) ) {
  // Connect to database
    $Technician = array();
    $User = array();

  // Search for technicians
    if (isset($_POST['occupation-type'])) {
        $Technician = searchTechByOcc($_POST['occupation-type']);
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


	<div class="results-container">
		<h3>Technician Results</h3>
		<?php if (count($Technician) > 0 || count($User) > 0): ?>
			<table>
				<thead>
					<tr>
                        <th>Technician Name</th>
						<th>Occupation Type</th>
                        <th>Rating</th>
					</tr>
				</thead>
				<tbody>
					<?php $mergedArray = array_merge($Technician, $User);
                    foreach ($mergedArray as $item): ?>
						<tr>
                            <td><?php echo $item['Technician_Name']; ?></td>
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
</body>
</html>


<?php
  } else {
    header("Location: login.php");
    exit();
  }
?>