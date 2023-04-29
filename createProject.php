<?php 
ob_start();
session_start();
require("connect-db.php");
require("createProject-db.php");

if ( $_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['Type'] == 'Customer')
{
    if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Create Project"))
    {
        newProject($_SESSION['UserID'], $_POST['techid'], $_POST['jobtype'], $_POST['description'], $_POST['startdate'], $_POST['enddate']);
        header("Location: projects.php");
        exit();
    }
    
}elseif($_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['Type'] == 'Technician'){
    header("Location: createProject.php?error=Only Customers can create a new project");

}
?>

<?php 
if ( isset($_SESSION['UserID']) && isset($_SESSION['Username'])) {
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

    <title>Add Project</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="icon" type="image/png" href="https://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />
    <link rel="stylesheet" href="css/addCustomer.css">
</head>

<body>
<div class="container">
<div class="header">
    <img src="images/logo_blank.png" alt="Logo" class="logo">
    <h1 class="site-title">Create a New Project</h1>
</div>
<?php if (isset($_GET['error'])) { ?>
    <p class="error"><?php echo $_GET['error']; ?></p>
<?php } ?>
<form name="mainForm" action="createProject.php" method="post">
        <div class="row mb-3 mx-3">
            Requested Technician:
            <select id="techid" style="width:550px"name="techid" class="form-control" required>
                <option value="Any" > Any </option>
                <?php foreach ($Techs as $item): ?>
                <option value="<?php echo $item['UserID']; ?>"><?php echo $item['FirstName'] . " " . $item['LastName'] . " (" . $item['Username'] . ")";?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="row mb-3 mx-3">
            Job Type:
            <input type="text" class="form-control" name="jobtype" maxlength=24 required />
        </div>
        <div class="row mb-3 mx-3">
            Description:
            <input type="text" class="form-control" name="description" maxlength=64 required />
        </div>
        <div id="liner"></div>
        <div class="row mb-3 mx-3">
            Proposed Start Date:
            <input id="startDateInput" type="date" class="form-control" name="startdate" min='2023-04-15' required/>
        </div>
        <div class="row mb-3 mx-3">
            Proposed End Date:
            <input id="endDateInput" type="date" class="form-control" name="enddate" min='2023-04-15' required/>
        </div>
        <script>
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1; // Since Jan is 1, add 1
            var yyyy = today.getFullYear();

            if (dd < 10) {
            dd = '0' + dd;
            }

            if (mm < 10) {
            mm = '0' + mm;
            } 
            today = yyyy +'-'+ mm +'-'+ dd;
            document.getElementById("startDateInput").setAttribute("min", today);
            document.getElementById("endDateInput").setAttribute("min", today);
        </script>
        <div id="button-layout">
        <input id="buttonCreateProject" type="submit" class="btn btn-primary" name="actionBtn" value="Create Project" title="class to add new Project" />
        <button type="button" onclick="window.location.href='project.php';" name="actionBtn" value="Back">Back</button>
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