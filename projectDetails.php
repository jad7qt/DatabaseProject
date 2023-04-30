<?php
ob_start();
session_start();

if (isset($_SESSION['UserID']) && isset($_SESSION['Username']) ) {
    // Connect to database
    require("connect-db.php");
    require("projects-db.php");

    $pageID = $_GET['id'];
    $project = getProject($pageID);

    $comments = array();
    $payments = array();
    $comments = getComments($pageID);
    $invoice = getInvoice($pageID);
    $payments = getPayments($pageID);
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
                        <td><?php echo $item['Text']; ?></td>
                        <td><?php echo $item['DateTime']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No comments found for project</p>
    <?php endif; ?>
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
        <p>No payments found for project</p>
    <?php endif; ?>
</div>



