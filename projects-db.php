<?php
function adminMasterTable(){
    global $db;
    $query1 = "SELECT Project.*, CONCAT(Customer.Street, ' ', Customer.City, ', ', Customer.State, ' ', Customer.Zip) as Project_Address,
    CONCAT(User.firstName, ' ', User.lastName) as Customer_Name, Tech.Name as Technician_Name
    FROM Project
    LEFT JOIN (
        SELECT CONCAT(User.firstName, ' ', User.lastName) as Name, User.UserID as ID
        FROM User
        WHERE User.Type = 'Technician') as Tech
    ON Tech.ID = Project.TechnicianID
    INNER JOIN User
    ON Project.customerID = User.UserID
    INNER JOIN Customer
    ON Customer.UserID = Project.CustomerID ";
    $statement1 = $db->prepare($query1);
    $statement1->execute();    
    $Projects = $statement1->fetchAll();
    $statement1->closeCursor();
    return $Projects;
}

function techProjTable($userID){
    global $db;
    $query1 = "SELECT Project.*, CONCAT(User.firstName, ' ', User.lastName) as Customer_Name, 
    CONCAT(Customer.Street, ' ', Customer.City, ', ', Customer.State, ' ', Customer.Zip) as Project_Address
    FROM Project
    INNER JOIN User
    ON Project.customerID = User.UserID
    INNER JOIN Customer
    ON Customer.UserID = Project.CustomerID
    WHERE Project.technicianID = :techID and Project.completed = 0
    ORDER BY Project.startDate";

    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':techID', $userID);
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
    LEFT JOIN User
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

function getProject($pageID){
    global $db;
    $query1 = "SELECT Project.*, CONCAT(Customer.Street, ' ', Customer.City, ', ', Customer.State, ' ', Customer.Zip) as Project_Address,
    CONCAT(User.firstName, ' ', User.lastName) as Customer_Name, Tech.Name as Technician_Name, Tech.Type as Technician_Type
    FROM Project
    LEFT JOIN (
        SELECT CONCAT(User.firstName, ' ', User.lastName) as Name, User.UserID as ID, Technician.OccupationType as Type
        FROM User
        INNER JOIN Technician
        ON User.UserID = Technician.UserID
        WHERE User.Type = 'Technician') as Tech
    ON Tech.ID = Project.TechnicianID
    INNER JOIN User
    ON Project.customerID = User.UserID
    INNER JOIN Customer
    ON Customer.UserID = Project.CustomerID
    WHERE Project.ProjectID = :pageID ";

    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':pageID', $pageID);
    $statement1->execute();    
    $Projects = $statement1->fetch();
    $statement1->closeCursor();
    return $Projects;    
}


function getComments($pageID){
    global $db;
    $query1 = "SELECT Comment.*, CONCAT (User.FirstName, ' ', User.LastName) as FullName
    FROM Comment
    INNER JOIN User
    ON Comment.UserID = User.UserID
    WHERE ProjectID = :pageID";

    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':pageID', $pageID);
    $statement1->execute();    
    $Projects = $statement1->fetchAll();
    $statement1->closeCursor();
    return $Projects; 
}

function getPayments($pageID){
    global $db;
    $query1 = "SELECT FORMAT(Payment.Amount, 'C') as Amount, Payment.Date, Payment.Type
    FROM Payment
    WHERE Payment.ProjectID = :pageID";

    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':pageID', $pageID);
    $statement1->execute();    
    $Projects = $statement1->fetchAll();
    $statement1->closeCursor();
    return $Projects; 
}

function getInvoice($pageID){
    global $db;
    $query1 = "SELECT FORMAT(Invoice.TotalPrice, 'C') as TotalPrice, FORMAT(TP.Total_Payment, 'C') as Total_Payment,
    FORMAT((Invoice.TotalPrice - TP.Total_Payment), 'C') as Remaining_Payment
    FROM Invoice
    INNER JOIN 
        (SELECT Payment.ProjectID, SUM(Payment.Amount) as Total_Payment
        FROM Payment
        GROUP BY Payment.ProjectID
        ORDER BY ProjectID) as TP
    ON Invoice.ProjectID = TP.ProjectID
    INNER JOIN Project
    ON Project.ProjectID = Invoice.ProjectID
    INNER JOIN User
    ON Project.CustomerID = User.UserID
    WHERE Project.ProjectID = :pageID";

    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':pageID', $pageID);
    $statement1->execute();    
    $Projects = $statement1->fetch();
    $statement1->closeCursor();
    return $Projects; 
}

?>
