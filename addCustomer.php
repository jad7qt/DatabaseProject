<?php 
ob_start();
session_start();
require("connect-db.php");
require("customer-db.php");

if ( ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_SESSION['UserID']) && !isset($_SESSION['Username'])) || (isset($_SESSION['Type']) && $_SESSION['Type'] == 'Administrator'))
{
    if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Create Customer"))
    {
        if (usernameTaken($_POST['username'])) {
            header("Location: addCustomer.php?error=Username is already taken");
            exit();
        }else{
        addUser($_POST['username'], $_POST['password'], $_POST['type'], $_POST['fname'], $_POST['lname']);
        addCustomer($_POST['username'], $_POST['st'], $_POST['city'], $_POST['state'], $_POST['zip']);
        header("Location: login.php");
        exit();
        }
    }
    
}
?>

<?php 
if ( (!isset($_SESSION['UserID']) && !isset($_SESSION['Username'])) || $_SESSION['Type'] == 'Administrator') {

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <!-- 2. include meta tag to ensure proper rendering and touch zooming -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="your name">
    <meta name="description" content="include some description about your page">

    <title>Bootstrap example</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="icon" type="image/png" href="https://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />
    <link rel="stylesheet" href="css/addCustomer.css">
</head>

<body>
<div class="container">
<div class="header">
    <img src="images/logo_blank.png" alt="Logo" class="logo">
    <h1 class="site-title">Welcome to ContractorConnector</h1>
</div>
<?php if (isset($_GET['error'])) { ?>
    <p class="error"><?php echo $_GET['error']; ?></p>
<?php } ?>
<form name="mainForm" action="addCustomer.php" method="post">
        <div class="row mb-3 mx-3">
            Username:
            <input type="text" class="form-control" name="username" maxlength=19 required />
        </div>
        <div class="row mb-3 mx-3">
            Password:
            <input type="password" class="form-control" name="password" maslength=29 required />
        </div>
        <div class="row mb-3 mx-3">
            First Name:
            <input type="text" class="form-control" name="fname" maxlength=10 required />
        </div>
        <div class="row mb-3 mx-3">
            Last Name:
            <input type="text" class="form-control" name="lname" maxlength=10 required/>
        </div>
        <div id="liner"></div>
        <div id="address">
        Address:
        </div>
        <div class="row mb-3 mx-3">
            Street:
            <input type="text" class="form-control" name="st" maxlength=20 required/>
            City:
            <input type="text" class="form-control" name="city" maxlength=25 required/>
            State:
            <input type="text" class="form-control" name="state" maxlength=2 required/>
            Zip:
            <input type="text" class="form-control" name="zip" pattern="\b\d{5}\b" required/>
        </div>
        <input type="hidden" name="type" value="Customer" />
        <div id="button-layout">
        <input id="buttonCreateCustomer" type="submit" class="btn btn-primary" name="actionBtn" value="Create Customer" title="class to add Customer/User" />
        <button type="button" onclick="window.location.href='login.php';" name="actionBtn" value="Back">Back</button>
        </div>
    </form>
</div>
</body>
</html>

<?php 
}else{
     header("Location: homepage.php");
     exit();
}
ob_end_flush();

 ?>