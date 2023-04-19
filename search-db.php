<?php

function searchTechByOcc($occupation_type)
{
    global $db;
    $Technician = array();
    $stmt = $db->prepare("SELECT Technician.userID, CONCAT(User.firstName, ' ', User.lastName) as Technician_Name, Technician.OccupationType, R.Avg_Rating as Rating
    FROM Technician
    INNER JOIN User
    ON Technician.userID = User.userID
    INNER JOIN(
        SELECT Ratings.technicianID, ROUND(AVG(Ratings.rating), 1) as Avg_Rating
        FROM Ratings
        GROUP BY Ratings.technicianID) as R
    ON Technician.userID = R.technicianID
    WHERE Technician.OccupationType = :occupation_type
    ORDER BY R.Avg_Rating DESC");
    $stmt->bindValue(':occupation_type', $occupation_type);
    $stmt->execute();
    $Technician = $stmt->fetchAll();
    $stmt->closeCursor();
    return $Technician;
}

?>