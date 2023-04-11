<?php
session_start();

if (isset($_SESSION['UserID']) && isset($_SESSION['Username']) ) {
  // Connect to database
  $dbhost = 'mysql01.cs.virginia.edu';
  $dbname = 'jad7qt_b';
  $dbuser = 'jad7qt_b';
  $dbpass = 'UpsornWinter2023';

  try {
    $db = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
  } catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit();
  }

    $Technician = array();
    $User = array();

  // Search for technicians
    if (isset($_POST['occupation-type'])) {
        $occupation_type = $_POST['occupation-type'];
        $stmt = $db->prepare("SELECT Technician.userID, CONCAT(User.firstName, ' ', User.lastName) as Technician_Name, Technician.OccupationType, R.Avg_Rating as Rating
        FROM Technician
        INNER JOIN User
        ON Technician.userID = User.userID
        INNER JOIN(
            SELECT Ratings.technicianID, ROUND(AVG(Ratings.rating), 1) as Avg_Rating
            FROM Ratings
            GROUP BY Ratings.technicianID) as R
        ON Technician.userID = R.technicianID
        WHERE Technician.OccupationType = :occupation_type
        ORDER BY R.Avg_Rating DESC");
        $stmt->bindValue(':occupation_type', $occupation_type);
        $stmt->execute();
        $Technician = $stmt->fetchAll();
    }

 // Search for users
    if (isset($_POST['first-name'])) {
        $first_name = $_POST['first-name'];
        $stmt = $db->prepare("SELECT * FROM User WHERE FirstName LIKE :first_name");
        $stmt->bindValue(':first_name', "%$first_name%", PDO::PARAM_STR);
        $stmt->execute();
        $User = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

    <?php
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