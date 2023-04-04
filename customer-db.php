<?php
function addUser($username, $password, $type, $fname, $lname)
{
    global $db;
    $query = "INSERT INTO User(Username, Password, Type, FirstName, LastName) VALUES(:username, :password, :type, :fname, :lname)";
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->bindValue(':password', $password);
    $statement->bindValue(':type', $type);
    $statement->bindValue(':fname', $fname);
    $statement->bindValue(':lname', $lname);
    $statement->execute();
    $statement->closeCursor();

}

function addCustomer($username, $street, $city, $state, $zip)
{
    global $db;
    $query1 = "SELECT UserID FROM User WHERE Username=:username";
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':username', $username);
    $statement1->execute();    
    $usersID = $statement1->fetchAll();
    $statement1->closeCursor();

    $query2 = "INSERT INTO Customer VALUES(:usersID, :street, :city, :state, :zip)";
    $statement2 = $db->prepare($query2);
    $statement2->bindValue(':usersID', $usersID[0]["UserID"]);
    $statement2->bindValue(':street', $street);
    $statement2->bindValue(':city', $city);
    $statement2->bindValue(':state', $state);
    $statement2->bindValue(':zip', $zip);
    $statement2->execute();
    $statement2->closeCursor();
}

?>