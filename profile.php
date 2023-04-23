<?php
ob_start();
session_start();

if (isset($_SESSION['UserID']) && isset($_SESSION['Username']) ) {
    // Connect to database
    require("connect-db.php");
    require("profile-db.php");

    // if ( ($_SERVER['REQUEST_METHOD'] == 'POST' ) ){
    //     if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "rate"))
    //     {
    //         rates($_POST['CustID'], $_POST['TechID'], $_POST['rating'], $_POST['comment']);
    //         header("Location: homepage.php");
    //         exit();
    //     }
    // }
    
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
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
         <!-- MODAL BUTTOM -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Rate this Technician
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <form name="rateForm" action="rating.php" method="post">
                <div class="modal-body">
                    <div class="row mb-3 mx-3">
                        Rating (0.0-5.0):
                        <input type="number" class="form-control" name="rating" min=0 max=5 step=0.1 required />
                    </div>
                    <div class="row mb-3 mx-3">
                        Comment:
                        <input type="text" class="form-control" name="comment" required />
                    </div>
                    <input type="hidden" name="TechID" value=<?php echo $_GET['id'];?> />
                    <input type="hidden" name="CustID" value=<?php echo $_SESSION['UserID'];?> />
                </div>
                <div class="modal-footer">
                    <button id="buttonCreateCustomer" type="submit" class="btn btn-primary" name="actionBtn" value="rate">Post</button>
                </div>
                </form>
            </div>
        </div>
        </div>
    <!-- END MODAL -->

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

