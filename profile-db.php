<?php

function getUserType($pageID){
    global $db;
    $query1 = "SELECT User.Type
    FROM User
    WHERE User.UserID = :viewID
    LIMIT 1";

    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':viewID', $pageID);
    $statement1->execute();    
    $userType = $statement1->fetch();
    $statement1->closeCursor();

    return $userType;
}

function getAdminAddress($userID){
    global $db;
    $query1 = "SELECT CONCAT(Administrator.Street, ' ', Administrator.City, ', ', Administrator.State, ' ', Administrator.Zip) as Address
    FROM Administrator
    WHERE UserID = :adminID
    LIMIT 1";

    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':adminID', $userID);
    $statement1->execute();    
    $Address = $statement1->fetchAll();
    $statement1->closeCursor();

    return $Address;
}

function getTechRatings($userID){
    global $db;
    $query1 = "SELECT Rating, Comment
    FROM Ratings
    WHERE TechnicianID = :techID
    ORDER BY Rating DESC";

    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':techID', $userID);
    $statement1->execute();    
    $Ratings = $statement1->fetchAll();
    $statement1->closeCursor();

    return $Ratings;
}

function getAvgRating($userID){
    global $db;
    $query1 = "SELECT TechnicianID, ROUND(AVG(Rating), 1) as AVGRating
    FROM Ratings
    WHERE TechnicianID = :techID
    GROUP BY TechnicianID;";

    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':techID', $userID);
    $statement1->execute();    
    $Ratings = $statement1->fetchAll();
    $statement1->closeCursor();

    return $Ratings;
}

function getCustAddress($userID){
    global $db;
    $query1 = "SELECT CONCAT(Customer.Street, ' ', Customer.City, ', ', Customer.State, ' ', Customer.Zip) as Address
    FROM Customer
    WHERE UserID = :custID
    LIMIT 1";

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
