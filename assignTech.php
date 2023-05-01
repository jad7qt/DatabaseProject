<?php 
ob_start();
session_start();
require("connect-db.php");
require("acceptJob-db.php");
require("createProject-db.php");

if ( $_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['Type'] == 'Administrator')
{
    if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Assign Tech"))
    {
        acceptJob($_POST['techid'], $_GET['id']);
        header("Location: projects.php");
        exit();
    }
    
}elseif($_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['Type'] == 'Technician'){
    header("Location: createProject.php?error=Only Customers can create a new project");

}
?>

<?php 
if ( isset($_SESSION['UserID']) && isset($_SESSION['Username'])) {
    $projid = $_GET['id'];
    $Techs = array();
    $Techs = selectAllTechs();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <!-- 2. include meta tag to ensure proper rendering and touch zooming -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Jared Dutt">
    <meta name="description" content="Page to create a new project for customer view">

    <title>Assign Technician</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="icon" type="image/png" href="https://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />
    <link rel="stylesheet" href="css/addCustomer.css">
</head>

<body>
<div class="container">
<div class="header">
    <img src="images/logo_blank.png" alt="Logo" class="logo">
    <h1 class="site-title">Assign a Technician to Project</h1>
</div>
<?php if (isset($_GET['error'])) { ?>
    <p class="error"><?php echo $_GET['error']; ?></p>
<?php } ?>
<form name="mainForm" action="assignTech.php" method="post">
        <div class="row mb-3 mx-3">
            Technician to Assign:
            <select id="techid" style="width:550px"name="techid" class="form-control" required>
                <?php foreach ($Techs as $item): ?>
                <option value="<?php echo $item['UserID']; ?>"><?php echo $item['FirstName'] . " " . $item['LastName'] . " (" . $item['Username'] . ")";?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div id="button-layout">
        <input id="buttonAssignTech" type="submit" class="btn btn-primary" name="actionBtn" value="Assign Tech" title="class to assign Tech" />
        <button id="backBtn" type="button" onclick="window.location.href='homepage.php';" name="actionBtn" value="Back">Back</button>
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