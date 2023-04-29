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

?>