<?php
function adminMasterTable(){
    global $db;
    $query1 = "SELECT Project.*, CONCAT(Customer.Street, ' ', Customer.City, ', ', Customer.State, ' ', Customer.Zip) as Project_Address,
    CONCAT(User.firstName, ' ', User.lastName) as Customer_Name, PhoneNumber.number as CustomerPhone, Tech.Name as Technician_Name
    FROM Project
    INNER JOIN (
        SELECT CONCAT(User.firstName, ' ', User.lastName) as Name, User.UserID as ID
        FROM User
        WHERE User.Type = 'Technician') as Tech
    ON Tech.ID = Project.TechnicianID
    INNER JOIN User
    ON Project.customerID = User.UserID
    INNER JOIN PhoneNumber
    ON PhoneNumber.userID = Project.customerID
    INNER JOIN Customer
    ON Customer.UserID = Project.CustomerID
    WHERE PhoneNumber.type = 'mobile' ";
    $statement1 = $db->prepare($query1);
    $statement1->execute();    
    $Projects = $statement1->fetchAll();
    $statement1->closeCursor();
    return $Projects;
}

function techProjTable($userID){
    global $db;
    $query1 = "SELECT Project.*, CONCAT(User.firstName, ' ', User.lastName) as Customer_Name, 
    CONCAT(Customer.Street, ' ', Customer.City, ', ', Customer.State, ' ', Customer.Zip) as Project_Address, 
    PhoneNumber.number as CustomerPhone
    FROM Project
    INNER JOIN User
    ON Project.customerID = User.UserID
    INNER JOIN PhoneNumber
    ON PhoneNumber.userID = Project.customerID
    INNER JOIN Customer
    ON Customer.UserID = Project.CustomerID
    WHERE PhoneNumber.type = 'mobile' and Project.technicianID = :userID
    ORDER BY Project.startDate; ";

    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':userID', $userID);
    $statement1->execute();    
    $Projects = $statement1->fetchAll();
    $statement1->closeCursor();
    return $Projects;

}

function custProjTable($userID){
    global $db;
    $query1 = "SELECT Project.*, CONCAT(User.firstName, ' ', User.lastName) as Technician_Name, 
    CONCAT(Customer.Street, ' ', Customer.City, ', ', Customer.State, ' ', Customer.Zip) as Project_Address
    FROM Project
    INNER JOIN User
    ON Project.TechnicianID = User.UserID
    INNER JOIN Customer
    ON Customer.UserID = Project.CustomerID
    WHERE Project.customerID = :custID
    ORDER BY Project.startDate";

    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':custID', $userID);
    $statement1->execute();    
    $Projects = $statement1->fetchAll();
    $statement1->closeCursor();
    return $Projects;
}

?>
