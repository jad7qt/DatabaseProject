<?php
ob_start();
session_start();

if (isset($_SESSION['UserID']) && isset($_SESSION['Username']) ) {
    // Connect to database
    require("connect-db.php");
    require("profile-db.php");

    if ( ($_SERVER['REQUEST_METHOD'] == 'POST' ) ){
        if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "addPhone"))
        {
            addPhoneNum($_SESSION['UserID'], $_POST['phoneType'], $_POST['phoneNum']);
            header("Location: profile.php");
            exit();
        }
    }
    
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="css/profile.css">
</head>
<body>

<!--HEADER-->
<?php include('header.php'); ?>
<!--HEADER-->
<!--hamburger-->
<?php include('hamburgerBoot.php'); ?>
<!--hamburger-->


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
        <!-- ADD MODAL HERE FOR ADDING PHONE NUMBERS -->
        <?php if($pageID == $userID){
            ?>
        <button id="buttonRed" type="button" class="btn btn-primary" data-toggle="modal" data-target="#phoneModal">
        Add Phone Number
        </button>

        <!-- Modal -->
        <div class="modal fade" id="phoneModal" tabindex="-1" role="dialog" aria-labelledby="phoneModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="phoneModalLabel">Add Phone Number</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <form name="rateForm" action="profile.php" method="post">
                <div class="modal-body">
                    <div class="row mb-3 mx-3">
                        Type:
                        <select id="phoneType" name="phoneType" class="form-control" required>
                            <option value="Mobile">Mobile</option>
                            <option value="Work">Work</option>
                            <option value="Home">Home</option>
                        </select>
                    </div>
                    <div class="row mb-3 mx-3">
                        Phone Number:
                        <input type="tel" id="phoneNum" class="form-control" name="phoneNum" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required />
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="buttonAddPhone" type="submit" class="btn btn-primary" name="actionBtn" value="addPhone">Add</button>
                </div>
                </form>
            </div>
        </div>
        </div>

        <?php
        }
        ?>

        <!-- END MODAL FOR ADD PHONE -->
    </div>

<!-- Ratings for Technicians -->
<?php if ($pageType == 'Technician'){ 
    $hasRated = FALSE;
    ?>


<div class="results-container">
  <?php if (count($AVGRating) > 0): ?>
    <table>
      <div id="rating">Technician Average Rating</div>
      <tbody>
        <?php foreach ($AVGRating as $item): ?>
          <tr>
            <td>
              <img src="images/star.png" alt="Star" style="width: 30px; height: 30px; vertical-align: middle;">
              <span style="color: #f7941e; font-size: 24px; vertical-align: middle;"><?php echo $item['AVGRating']; ?></span>
            </td>
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
                        <?php
                        if ($item['CustomerID']==$_SESSION['UserID'] && !$hasRated){
                            $hasRated = TRUE;
                            $ratingGiven = $item;
                        }
                        ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?> 
            <p>No Ratings on file</p>
        <?php endif; ?>

        <?php
        if($_SESSION['Type'] == "Customer"){ ?>
         <!-- MODAL BUTTOM -->
         <!-- TODO: Make this button only show up if user has not already rated, change to update btn
        if the user has already rated which will allow them to change or delete their old rating. -->
        <?php if(!$hasRated){?>
        <button id="buttonRate" type="button" class="btn btn-primary" data-toggle="modal" data-target="#ratingModal">
        Rate this Technician
        </button>
        

        <!-- Modal -->
        <div class="modal fade" id="ratingModal" tabindex="-1" role="dialog" aria-labelledby="ratingModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ratingModalLabel">Rate Technician</h5>
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
        <?php }else{?>
        <button id="buttonRate" type="button" class="btn btn-primary" data-toggle="modal" data-target="#ratingModal">
        Update Rating
        </button>
        

        <!-- Modal -->
        <div class="modal fade" id="ratingModal" tabindex="-1" role="dialog" aria-labelledby="ratingModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ratingModalLabel">Update Technician Rating</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <form name="rateForm" action="rating.php" method="post">
                <div class="modal-body">
                    <div class="row mb-3 mx-3">
                        Rating (0.0-5.0):
                        <input type="number" class="form-control" name="rating" min=0 max=5 step=0.1 value="<?php if ($hasRated) echo $ratingGiven['Rating'] ?>" required />
                    </div>
                    <div class="row mb-3 mx-3">
                        Comment:
                        <input type="text" class="form-control" name="comment" maxlength=65 value="<?php if ($hasRated) echo $ratingGiven['Comment'] ?>" required />
                    </div>
                    <input type="hidden" name="TechID" value=<?php echo $_GET['id'];?> />
                    <input type="hidden" name="CustID" value=<?php echo $_SESSION['UserID'];?> />
                </div>
                <div class="modal-footer">
                    <button id="buttonDeleteRating" type="submit" class="btn btn-primary" name="actionBtn" value="deleteRate">Delete</button>
                    <button id="buttonUpdateRating" type="submit" class="btn btn-primary" name="actionBtn" value="updateRate">Update</button>
                </div>
                </form>
            </div>
        </div>
        </div>

        <?php }?>
    <!-- END MODAL -->
    <?php } ?>

    </div>
    <?php }

    if($userID == $pageID){ ?>
    <div id="centerAlign">
        <button id="updateProfileBtn" onclick="window.location.href='updateProfile.php'" class="btn btn-primary" value="updateProfile">Update Profile</button>
    </div>
    <?php } ?>



</body>
</html>


<?php
  } else {
    header("Location: login.php");
    exit();
  }
  ob_end_flush();
?>

