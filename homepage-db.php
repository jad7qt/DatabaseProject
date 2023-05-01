<?php

function getCustProjs($userID, $completed){
    global $db;
    $query1 = "SELECT Project.*, CONCAT(User.firstName, ' ', User.lastName) as Technician_Name, 
    CONCAT(Customer.Street, ' ', Customer.City, ', ', Customer.State, ' ', Customer.Zip) as Project_Address
    FROM Project
    LEFT JOIN User
    ON Project.TechnicianID = User.UserID
    INNER JOIN Customer
    ON Customer.UserID = Project.CustomerID
    WHERE Project.customerID = :custID and Project.completed = :completed
    ORDER BY Project.startDate
    LIMIT 3";

    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':custID', $userID);
    $statement1->bindValue(':completed', $completed);
    $statement1->execute();    
    $Projects = $statement1->fetchAll();
    $statement1->closeCursor();
    return $Projects;
}

function getTechProjs($userID){
    global $db;
    $query1 = "SELECT Project.*, CONCAT(User.firstName, ' ', User.lastName) as Customer_Name, 
    CONCAT(Customer.Street, ' ', Customer.City, ', ', Customer.State, ' ', Customer.Zip) as Project_Address
    FROM Project
    INNER JOIN User
    ON Project.customerID = User.UserID
    INNER JOIN Customer
    ON Customer.UserID = Project.CustomerID
    WHERE Project.technicianID = :techID and Project.completed = 0
    ORDER BY Project.startDate
    LIMIT 3";

    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':techID', $userID);
    $statement1->execute();    
    $Projects = $statement1->fetchAll();
    $statement1->closeCursor();
    return $Projects;
}

function getUnassigned(){
    global $db;
    $query1 = "SELECT Project.*, CONCAT(User.firstName, ' ', User.lastName) as Customer_Name, 
    CONCAT(Customer.Street, ' ', Customer.City, ', ', Customer.State, ' ', Customer.Zip) as Project_Address
    FROM Project
    INNER JOIN User
    ON Project.customerID = User.UserID
    INNER JOIN Customer
    ON Customer.UserID = Project.CustomerID
    WHERE Project.technicianID IS NULL
    ORDER BY Project.startDate";

    $statement1 = $db->prepare($query1);
    $statement1->execute();    
    $Projects = $statement1->fetchAll();
    $statement1->closeCursor();
    return $Projects;
}


function getAdminProjs(){
    global $db;
    $query1 = "SELECT Project.*, CONCAT(Customer.Street, ' ', Customer.City, ', ', Customer.State, ' ', Customer.Zip) as Project_Address,
    CONCAT(User.firstName, ' ', User.lastName) as Customer_Name, Tech.Name as Technician_Name
    FROM Project
    LEFT JOIN (
        SELECT CONCAT(User.firstName, ' ', User.lastName) as Name, User.UserID as ID
        FROM User
        WHERE User.Type = 'Technician') as Tech
    ON Project.TechnicianID = Tech.ID
    INNER JOIN User
    ON Project.customerID = User.UserID
    INNER JOIN Customer
    ON Customer.UserID = Project.CustomerID
    ORDER BY Project.ProjectID DESC
    LIMIT 3";

    $statement1 = $db->prepare($query1);
    $statement1->execute();    
    $Projects = $statement1->fetchAll();
    $statement1->closeCursor();
    return $Projects;
}

function getAmountOwed($userID){
    global $db;
    $query1 = "SELECT CONCAT(User.firstName, ' ', User.lastName) as Customer_Name, SUM(Invoice.TotalPrice - TP.Total_Payment) as Total_Remaining_Payment
    FROM Invoice
    LEFT JOIN 
        (SELECT Payment.ProjectID, SUM(Payment.Amount) as Total_Payment
        FROM Payment
        GROUP BY Payment.ProjectID
        ORDER BY ProjectID) as TP
    ON Invoice.ProjectID = TP.ProjectID
    INNER JOIN Project
    ON Project.ProjectID = Invoice.ProjectID
    INNER JOIN User
    ON Project.CustomerID = User.UserID
    WHERE User.UserID = :custID
    GROUP BY User.UserID";

    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':custID', $userID);
    $statement1->execute();    
    $Projects = $statement1->fetch();
    $statement1->closeCursor();
    return $Projects;
}

?>
