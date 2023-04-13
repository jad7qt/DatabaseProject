<?php 
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
    <header>
        <div class="container">
            <h1>ContractorConnections</h1>
            <nav>
                <ul>
                    <!-- <li><a href="#">Home</a></li> -->
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
            <button id="btnlogin" type="submit" name="actionBtn" value="Login">Login</button>
            <button type="button" onclick="window.location.href='addCustomer.php';" name="actionBtn" value="SignUp">SignUp</button>
        </form>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2023 ContractorConnections. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>

