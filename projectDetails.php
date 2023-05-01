<?php
ob_start();
session_start();

if (isset($_SESSION['UserID']) && isset($_SESSION['Username']) ) {
    // Connect to database
    require("connect-db.php");
    require("projects-db.php");
    require("createProject-db.php");

    $pageID = $_GET['id'];
    $project = getProject($pageID);

    $comments = array();
    $payments = array();
    $comments = getComments($pageID);
    $invoice = getInvoice($pageID);
    $payments = getPayments($pageID);

    if ( $_SERVER['REQUEST_METHOD'] == 'POST' ){
        if(!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "postComment")){
            postComment($_POST['projid'], $_SESSION['UserID'], $_POST['comment']);
            $id=$_POST['projid'];
            header("Location: projectDetails.php?id=$id");
            quit();
        }elseif(!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "deleteComment")){
            deleteComment($_POST['userid'], $_POST['datetime']);
            $id=$_POST['projid'];
            header("Location: projectDetails.php?id=$id");
            quit();
        }

    }

}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Projects</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="css/projects.css">

</head>


<!--HEADER-->
<?php include('header.php'); ?>
<!--HEADER-->
<!--hamburger-->
<?php include('hamburgerBoot.php'); ?>
<!--hamburger-->

<div class="results-container">
    <h3>Project Details</h3>
    <table>
        <thead>
            <tr>
                <th>Job Type</th>
                <th>Description </th>
                <th>Start Date</th> 
                <th>End Date</th> 
                <th>Completed</th>
            </tr>
        <tbody>
            <tr>
                <td><?php echo $project['JobType']; ?></td>
                <td><?php echo $project['Description']; ?></td>
                <td><?php echo $project['StartDate']; ?></td>
                <td><?php echo $project['EndDate']; ?></td>
                <td>                                    
                    <?php 
                        if ($project['Completed'] == "1") {
                            echo '<img src="images/check.png" alt="Completed" style="max-width: 30px; max-height: 30px;">';
                        } else {
                            echo "Ongoing"; } ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="results-container">
    <h3>Customer Information</h3>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Address </th>
                <th>Primary Phone</th>
            </tr>
        <tbody>
            <tr>
                <td><?php echo $project['Customer_Name']; ?></td>
                <td><?php echo $project['Project_Address']; ?></td>
                <td><?php echo $project['CustomerPhone']; ?></td>
            </tr>
        </tbody>
    </table>
</div>

<div class="results-container">
    <h3>Technician Information</h3>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Occupation </th>
            </tr>
        <tbody>
            <tr>
                <td><?php echo $project['Technician_Name']; ?></td>
                <td><?php echo $project['Technician_Type']; ?></td>
            </tr>
        </tbody>
    </table>
</div>

<div class="results-container">
    <h3>Comments</h3>
    <?php if (count($comments) > 0 ): ?>
        <table>
            <thead>
                <tr>
                    <th>Commentor</th>
                    <th>Comment Text </th>
                    <th>Date/Time </th>

                </tr>
            <tbody>
                <?php foreach($comments as $item): ?>

                    <tr>
                        <td><?php echo $item['FullName']; ?></td>
                        <td><?php echo $item['Text']; ?> 
                        <?php if($item['UserID'] == $_SESSION['UserID'] || $_SESSION['Type'] == "Administrator"){ ?>
                            <form name="commentDeleteForm" action="projectDetails.php" method="post">
                                <button style="float: right;" id="delBtn" type="submit" class="btn btn-danger" name="actionBtn" value="deleteComment">X</button>
                                <input type="hidden" name="userid" value="<?php echo $item['UserID']; ?>" />
                                <input type="hidden" name="datetime" value="<?php echo $item['DateTime']; ?>" />
                                <input type="hidden" name="projid" value="<?php echo $item['ProjectID']; ?>" />
                            </form>
                        <?php } ?>
                        </td>
                        <td><?php echo $item['DateTime']; ?></td>
                    </tr>


                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="no-results">No comments found for project</p>
    <?php endif; ?>
    <button id="addCommentBtn" type="button" class="btn btn-primary" data-toggle="modal" data-target="#commentModal" id="btnAddComment" >
        Add Comment
        </button>

        <!-- Modal -->
        <div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commentModalLabel">Add Comment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <form name="commentForm" action="projectDetails.php" method="post">
                <div class="modal-body">
                    <div class="row mb-3 mx-3">
                        Comment:
                        <input type="text" id="comment" class="form-control" name="comment" minlength=1 maxlength=95 required />
                    </div>
                </div>
                <input type="hidden" id="projid" name="projid" value="<?php echo $pageID;?>" />
                <div class="modal-footer">
                    <button id="buttonAddComment" type="submit" class="btn btn-primary" name="actionBtn" value="postComment">Post</button>
                </div>
                </form>
            </div>
        </div>
        </div>
</div>

<div class="results-container">
    <h3>Invoice Details</h3>
    <table>
        <thead>
            <tr>
                <th>Total Price</th>
                <th>Amount Payed </th>
                <th>Remaining Payment</th>
            </tr>
        <tbody>
            <tr>
                <td><?php echo $invoice['TotalPrice']; ?></td>
                <td><?php echo $invoice['Total_Payment']; ?></td>
                <td><?php echo $invoice['Remaining_Payment']; ?></td>
            </tr>
        </tbody>
    </table>
</div>

<div class="results-container">
    <h3>Payments</h3>
    <?php if (count($payments) > 0 ): ?>
        <table>
            <thead>
                <tr>
                    <th>Payment Amount</th>
                    <th>Payment Type</th>
                    <th>Date</th>

                </tr>
            <tbody>
                <?php foreach($payments as $item): ?>
                    <tr>
                        <td><?php echo $item['Amount']; ?></td>
                        <td><?php echo $item['Type']; ?></td>
                        <td><?php echo $item['Date']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="no-results">No payments found for project</p>
    <?php endif; ?>
</div>



<?php
ob_end_flush();
?>