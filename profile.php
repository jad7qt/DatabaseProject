<?php
ob_start();
session_start();

if (isset($_SESSION['UserID']) && isset($_SESSION['Username']) ) {
    // Connect to database
    require("connect-db.php");
    require("customer-db.php");
    require("profile-db.php");
    
    $Address = array();
    $Ratings = array();
    $AVGRating = array();

    $userID = $_SESSION['UserID'];
    $pageID = $_GET['id'];

    //temporary fix for no ID passed in - need to update anywhere that links to profile
    if($pageID == NULL){
        $pageID = $userID;
    }

    //determine what type of user you are viewing NOT YOUR OWN TYPE
    $pageType = getUserType($pageID);
    $pageType = $pageType['Type'];


    //check user type to return correct query
    if ($pageType == 'Administrator') {
        $Address = getAdminAddress($pageID);

    }

    elseif ($pageType == 'Technician') {
        $Ratings = getTechRatings($pageID);
        $AVGRating = getAvgRating($pageID);
    }

    elseif ($pageType == 'Customer') {
        $Address = getCustAddress($pageID);
    }

    $Phones = getUserPhones($pageID);
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

TESTING: UserID = <?php echo $userID ?>
TESTING: PageID = <?php echo $pageID ?> 

<?php if ($pageType != 'Technician'){ ?>
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
    <?php } ?>

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

<!-- Ratings for Technicians -->
<?php if ($pageType == 'Technician'){ ?>
<div class="results-container">
            <?php if (count($AVGRating) > 0): ?>
                <table>
                    <thead> Technician Avg. Rating</thead>
                    <tbody>
                        <?php
                        foreach ($AVGRating as $item): ?>
                            <tr>
                            <td><?php echo $item['AVGRating']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>  
                  </table> 
                <?php else: ?>
                    <p>No Ratings on file</p>
                <?php endif; ?> 
    </div>

    <div class="results-container">
        <?php if (count($Ratings) > 0 ): ?>
            <table>
                <thead>
                    <tr>                       
                        <th>Rating</th>
                        <th>Comment</th>                        
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($Ratings as $item): ?>
                        <tr>
                            <td><?php echo $item['Rating']; ?></td>
                            <td><?php echo $item['Comment']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?> 
            <p>No Ratings on file</p>
        <?php endif; ?>
    </div>
    <?php }

    if($userID == $pageID){ ?>
        TESTING: This is my profile page
        TODO: add update profile link
    <?php } 

    elseif($pageType == 'Technician'){ ?>
        TESTING: Add rating for technician (not self)
        TODO: link to add rating page
    <?php }?>


</body>
</html>


<?php
  } else {
    header("Location: login.php");
    exit();
  }
  ob_end_flush();
?>
