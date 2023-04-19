<?php
function getAdminAddress($userID){
    global $db;
    $query1 = "SELECT CONCAT(Administrator.Street, ' ', Administrator.City, ', ', Administrator.State, ' ', Administrator.Zip) as Address
    FROM Administrator
    WHERE UserID = :adminID";

    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':adminID', $userID);
    $statement1->execute();    
    $Address = $statement1->fetchAll();
    $statement1->closeCursor();

    return $Address;
}

function getTechProfile($userID){

}

function getCustAddress($userID){
    global $db;
    $query1 = "SELECT CONCAT(Customer.Street, ' ', Customer.City, ', ', Customer.State, ' ', Customer.Zip) as Address
    FROM Customer
    WHERE UserID = :custID";

    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':custID', $userID);
    $statement1->execute();    
    $Address = $statement1->fetchAll();
    $statement1->closeCursor();

    return $Address;

}

function getUserPhones($userID){
    global $db;
    $query2 = "SELECT * 
    FROM PhoneNumber
    WHERE UserID = :adminID";

    $statement2 = $db->prepare($query2);
    $statement2->bindValue(':adminID', $userID);
    $statement2->execute();    
    $Phones = $statement2->fetchAll();
    $statement2->closeCursor();

    return $Phones;
}
