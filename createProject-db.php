<?php

function selectAllTechs()
{
    global $db;
    $query2 = "SELECT * FROM Technician NATURAL JOIN User ORDER BY FirstName";
    $statement2 = $db->prepare($query2);
    $statement2->execute();    
    $techs = $statement2->fetchAll();
    $statement2->closeCursor();
    return $techs;
}

function newProject($custid, $techid, $jobtype, $description, $startdate, $enddate)
{
    global $db;
    $query2 = "INSERT INTO Project(CustomerID, TechnicianID, JobType, Description, StartDate, EndDate, Completed)
     VALUES(:custid, :techid, :jobtype, :description, :startdate, :enddate, 0)";
    $statement2 = $db->prepare($query2);
    $statement2->bindValue(':custid', $custid);
    $statement2->bindValue(':techid', $techid);
    $statement2->bindValue(':jobtype', $jobtype);
    $statement2->bindValue(':description', $description);
    $statement2->bindValue(':startdate', $startdate);
    $statement2->bindValue(':enddate', $enddate);
    $statement2->execute();
    $statement2->closeCursor();
}

function postComment($projid, $userid, $comment)
{
    global $db;
    // $currenttime = date('Y-m-d H:i:s');
    $query2 = "INSERT INTO Comment(UserID, DateTime, ProjectID, Text)
    VALUES(:userid, '3/3/2023 9:30', :projid, :text)";
    $statement2 = $db->prepare($query2);
    $statement2->bindValue(':userid', $userid);
    $statement2->bindValue(':projid', $projid);
    $statement2->bindValue(':text', $comment);
    // $statement2->bindValue(':currenttime', $currenttime);
    $statement2->execute();
    $statement2->closeCursor();
}


?>