<?php
function acceptJob($techid, $projid)
{
    global $db;
    $query = "UPDATE Project SET TechnicianID=;techid 
    WHERE ProjectID=:projid";
    $statement = $db->prepare($query);
    $statement->bindValue(':description', $techid);
    $statement->bindValue(':description', $projid);
    $statement->execute();
    $statement->closeCursor();
}

?>