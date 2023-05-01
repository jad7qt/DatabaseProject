<?php 
ob_start();
session_start();
require("connect-db.php");

    if (isset($_POST['uname']) && isset($_POST['password']) && !empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Login") ) {

        function validate($data){

        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
        }
        $uname = validate($_POST['uname']);
        $pass = validate($_POST['password']);

        if (empty($uname)) {

            header("Location: login.php?error=User Name is required");

            exit();

        }else if(empty($pass)){

            header("Location: login.php?error=Password is required");

            exit();

        }else{

            global $db;
            $query1 = "SELECT * FROM User WHERE Username=:username AND Password=:pass";
            $statement = $db->prepare($query1);
            $statement->bindValue(':username', $uname);
            $statement->bindValue(':pass', $pass);
            $statement->execute();
            $result = $statement->fetchAll();
            $statement->closeCursor();

            if ($result[0]['Username'] === $uname && $result[0]['Password'] === $pass) {

                echo "Logged in!";
                $_SESSION['Username'] = $result[0]['Username'];
                $_SESSION['FirstName'] = $result[0]['FirstName'];
                $_SESSION['LastName'] = $result[0]['LastName'];
                $_SESSION['UserID'] = $result[0]['UserID'];
                $_SESSION['Type'] = $result[0]['Type'];

                header("Location: homepage.php");

                exit();

            }else{

                header("Location: login.php?error=Incorect User name or password");

                exit();

            }
        }
    }

if (!isset($_SESSION['Username'])){
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto&display=swap">
    <link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>
<header style="position: fixed; left: 0; top: 0; width: 100%;">
  <div class="container" style="display: flex; align-items: center; justify-content: space-between;">
    <div style="display: flex; align-items: center;">
      <img src="images/logo_blank.png" alt="ContractorConnections Logo" style="max-width: 50px; max-height: 50px; margin-right: 10px;">
      <h1 style="margin: 0;">ContractorConnections</h1>
    </div>
    <nav>
      <ul style="display: flex; align-items: center; justify-content: flex-end; margin: 0;">
        <li><a href="about.html">About</a></li>
        <li><a href="services.html">Services</a></li>
        <li><a href="contact.php">Contact</a></li>
      </ul>
    </nav>
  </div>
</header>





    <main>
        <form action="login.php" method="post">
            <h2>LOGIN</h2>
            <?php if (isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>
            <label>User Name</label>
            <input type="text" name="uname" placeholder="User Name"><br>
            <label>Password</label>
            <input type="password" name="password" placeholder="Password"><br>
            <button class="btnlogin" type="submit" name="actionBtn" value="Login">
  Login <img src="images/login.png" alt="Login" style="max-width: 20px; max-height: 20px; filter: invert(1); display: inline-block; vertical-align: middle;">
</button>

            <button id="signUpBtn" type="button" onclick="window.location.href='addCustomer.php';" name="actionBtn" value="SignUp">
  SignUp <img src="images/signup.png" alt="SignUp" style="max-width: 20px; max-height: 20px; filter: invert(1); display: inline-block; vertical-align: middle;">
</button>


</form>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2023 ContractorConnections. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>
<?php
}else{
    header("Location: homepage.php");
    exit();
}
ob_end_flush();
?>

