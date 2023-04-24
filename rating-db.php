<?php 

function rateTech($CustID, $TechID, $rating, $comment)
{
    global $db;
    $query1 = "INSERT INTO Ratings VALUES (:custid, :techid, :rating, :comment)";
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':custid', $CustID);
    $statement1->bindValue(':techid', $TechID);
    $statement1->bindValue(':rating', $rating);
    $statement1->bindValue(':comment', $comment);
    $statement1->execute();    
    $statement1->closeCursor();
}

function updateRateTech($CustID, $TechID, $rating, $comment)
{
    global $db;
    $query1 = "UPDATE Ratings SET Rating = :rating, Comment=:comment WHERE CustomerID = :custid AND TechnicianID = :techid";
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':custid', $CustID);
    $statement1->bindValue(':techid', $TechID);
    $statement1->bindValue(':rating', $rating);
    $statement1->bindValue(':comment', $comment);
    $statement1->execute();    
    $statement1->closeCursor();
}

function deleteRateTech($CustID, $TechID)
{
    global $db;
    $query1 = "DELETE FROM Ratings WHERE CustomerID = :custid AND TechnicianID = :techid";
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':custid', $CustID);
    $statement1->bindValue(':techid', $TechID);
    $statement1->execute();
    $statement1->closeCursor();
}

?>