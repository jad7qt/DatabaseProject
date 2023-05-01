<?php
function acceptJob($techid, $projid)
{
    global $db;
    $query = "UPDATE Project SET TechnicianID=:techid 
    WHERE ProjectID=:projid";
    $statement = $db->prepare($query);
    $statement->bindValue(':techid', $techid);
    $statement->bindValue(':projid', $projid);
    $statement->execute();
    $statement->closeCursor();
}

function assignPrice($projid, $totalPrice)
{
    global $db;
    $query = "UPDATE Invoice SET TotalPrice=:totalprice 
    WHERE ProjectID=:projid";
    $statement = $db->prepare($query);
    $statement->bindValue(':totalprice', $totalPrice);
    $statement->bindValue(':projid', $projid);
    $statement->execute();
    $statement->closeCursor();
}

?>