<?php 
ob_start();
session_start();
require("connect-db.php");
require("rating-db.php");

if (isset($_SESSION['UserID']) && isset($_SESSION['Username']) ) {
    if ( ($_SERVER['REQUEST_METHOD'] == 'POST' ) ){
        if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "rate"))
        {
            // rates($_SESSION['UserID'], $_POST['TechID'], $_POST['rating'], $_POST['comment']);
            rateTech($_SESSION['UserID'], $_POST['TechID'], $_POST['rating'], $_POST['comment']);
            $id = $_POST['TechID'];
            header("Location: profile.php?id=$id");
            exit();
        }elseif(!empty($_POST['actionBtn']) && $_POST['actionBtn'] == 'updateRate'){
            updateRateTech($_SESSION['UserID'], $_POST['TechID'], $_POST['rating'], $_POST['comment']);
            $id = $_POST['TechID'];
            header("Location: profile.php?id=$id");
            exit();
        }elseif(!empty($_POST['actionBtn']) && $_POST['actionBtn'] == 'deleteRate'){
            deleteRateTech($_SESSION['UserID'], $_POST['TechID']);
            $id = $_POST['TechID'];
            header("Location: profile.php?id=$id");
            exit();
        }
    }

?>


<?php
}else{
    header("Location: login.php");
    exit();
}
ob_end_flush();
?>