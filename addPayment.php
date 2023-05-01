<?php 
ob_start();
session_start();
require("connect-db.php");
require("customer-db.php");
require("payments-db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['Type'] != 'Technician')
{
    if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Add Payment"))
    {
        addPaymentAdmin($_POST['projid'], $_POST['paymentType'], $_POST['amount']);
        header("Location: payments.php");
        exit();
    }
}

if (isset($_SESSION['UserID']) && isset($_SESSION['Username']) && $_SESSION['Type'] == "Administrator") {
    $pageID = $_GET['id'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <!-- 2. include meta tag to ensure proper rendering and touch zooming -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="your name">
    <meta name="description" content="include some description about your page">

    <title>Add Payment</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="icon" type="image/png" href="https://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />
    <link rel="stylesheet" href="css/addTechnician.css">
</head>

<body>
<div class="container">
<div class="header">
    <img src="images/logo_blank.png" alt="Logo" class="logo">
    <h1 id="addPay" class="site-title">Add Payment</h1>
</div>
<form name="mainForm" action="addPayment.php" method="post">
        <div class="row mb-3 mx-3">
            Payment Type:
            <select id="paymentType" style="width:90%" name="paymentType" class="form-control" required>
                <option value="Cash">Cash</option>  
                <option value="Debit Card">Debit Card</option>  
                <option value="Credit Card">Credit Card</option> 
                <option value="Check">Check</option>   
            </select>
        </div>
        <div class="row mb-3 mx-3">
            Payment Amount:
            <input type="number" class="form-control" name="amount" required />
        </div>
        <input type="hidden" name="projid" value="<?php echo $pageID; ?>" />
        <div id="button-layout"> 
        <input id="buttonAddTechnician" type="submit" class="btn btn-primary" name="actionBtn" value="Add Payment" title="class to add payment" />
        <button type="button" onclick="window.location.href='payments.php';" name="actionBtn" value="Back">Back</button>
        </div>
    </form>
</div>
</body>
</html>



<?php 
}else if(isset($_SESSION['UserID']) && $_SESSION['Type'] != 'Administrator'){
    header("Location: homepage.php");
}else{
     header("Location: login.php");
     exit();
}
ob_end_flush();
 ?>