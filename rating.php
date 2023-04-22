<?php 
ob_start();
session_start();

if (isset($_SESSION['UserID']) && isset($_SESSION['Username']) ) {
    require("connect-db.php");
    require("rating-db.php");
    if ( ($_SERVER['REQUEST_METHOD'] == 'POST' ) ){
        if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Create Customer"))
        {
            rate($_SESSION['UserID'], $_POST['TechID'], $_POST['rating'], $_POST['comment']);
            header("Location: homepage.php");
            exit();
        }
    }

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

    <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />
    <link rel="stylesheet" href="css/addCustomer.css">
</head>

<body>
<div class="container">
<div class="header">
    <img src="images/logo_blank.png" alt="Logo" class="logo">
    <h1 class="site-title">Rate a Technician</h1>
</div>
<form name="mainForm" action="addCustomer.php" method="post">
        <div class="row mb-3 mx-3">
            Rating (0.0-5.0):
            <input type="number" class="form-control" name="rating" min=0 max=5 step=0.1 required />
        </div>
        <div class="row mb-3 mx-3">
            Comment:
            <input type="text" class="form-control" name="password" required />
        </div>
        <input type="hidden" name="techid" value="Customer" />
        <div id="button-layout">
        <input id="buttonCreateCustomer" type="submit" class="btn btn-primary" name="actionBtn" value="rate" title="class to add rating" />
        <button type="button" onclick="window.location.href='homepage.php';" name="actionBtn" value="Back">Back</button>
        </div>
    </form>
</div>
</body>
</html>

<?php
}else{
    header("Location: login.php");
    exit();
}
ob_end_flush();
?>