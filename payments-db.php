<?php

function admin_payments()
{
    global $db;
    $stmt = $db->prepare("SELECT CONCAT(User.firstName, ' ', User.lastName) as Customer_Name, Project.JobType, 
    Project.EndDate, FORMAT((Invoice.TotalPrice - TP.Total_Payment), 'C') as Remaining_Payment, Project.ProjectID
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
    HAVING Remaining_Payment > 0
	ORDER BY Project.EndDate");
    $stmt->execute();
    $result = $stmt->fetchAll();
    $stmt->closeCursor();
    return $result;
}

function tech_payments($UserID){
    global $db;
    $stmt = $db->prepare("SELECT CONCAT(User.firstName, ' ', User.lastName) as Customer_Name, Project.JobType, 
    Project.EndDate, FORMAT((Invoice.TotalPrice - TP.Total_Payment), 'C') as Remaining_Payment
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
    WHERE Project.TechnicianID = :UserID
    HAVING Remaining_Payment > 0
	ORDER BY Project.EndDate");
    $stmt->bindValue(':UserID', $UserID);
    $stmt->execute();
    $result = $stmt->fetchAll();
    $stmt->closeCursor();
    return $result;
}

function cust_payments($UserID){
    global $db;
    $stmt = $db->prepare("SELECT CONCAT(User.firstName, ' ', User.lastName) as Customer_Name, Project.JobType, 
    Project.EndDate, FORMAT((Invoice.TotalPrice - TP.Total_Payment), 'C') as Remaining_Payment, Project.ProjectID
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
    WHERE Project.CustomerID = :UserID
    HAVING Remaining_Payment > 0
	ORDER BY Project.EndDate");
    $stmt->bindValue(':UserID', $UserID);
    $stmt->execute();
    $result = $stmt->fetchAll();
    $stmt->closeCursor();
    return $result;
}

function getPrevPayments($UserID){
    global $db;
    $stmt = $db->prepare("SELECT Payment.*, Project.JobType, Project.CustomerID
    FROM Payment
    INNER JOIN Project
    ON Payment.ProjectID = Project.ProjectID
    WHERE Project.CustomerID = :UserID;");

    $stmt->bindValue(':UserID', $UserID);
    $stmt->execute();
    $result = $stmt->fetchAll();
    $stmt->closeCursor();
    return $result;
}

function addPaymentAdmin($projid, $type, $amount)
{
    global $db;
    $query1 = "SELECT * FROM Payment 
    WHERE ProjectID=:projid
    ORDER BY PaymentID
    LIMIT 1";
    $stmt1 = $db->prepare($query1);
    $stmt1->bindValue(':projid', $projid);
    $stmt1->execute();
    $result = $stmt1->fetchAll();
    $stmt1->closeCursor();

    if(!empty($result)){
        $numOld = $result[0]['PaymentID'];
        $newNum = $numOld + 1;
    }else{
        $newNum = 1;
    }
    $currenttime = date('Y-m-d');

    $query2 = "INSERT INTO Payment(ProjectID, PaymentID, Type, Amount, Date) VALUES(:projid, :paymentid, :type, :amount, :date)";
    $stmt2 = $db->prepare($query2);
    $stmt2->bindValue(':projid', $projid);
    $stmt2->bindValue(':paymentid', $newNum);
    $stmt2->bindValue(':type', $type);
    $stmt2->bindValue(':amount', $amount);
    $stmt2->bindValue(':date', $currenttime);
    $stmt2->execute();
    $stmt2->closeCursor();
}

function getNoInvoices(){
    global $db;
    $stmt = $db->prepare("SELECT CONCAT(User.FirstName, ' ', User.LastName) as Customer_Name,
    Project.JobType, Project.StartDate, Project.EndDate, Invoice.TotalPrice
    FROM Project
    INNER JOIN Invoice
    ON Invoice.ProjectID = Project.ProjectID
    INNER JOIN User
    ON User.UserID = Project.CustomerID
    WHERE Invoice.TotalPrice IS NULL OR Invoice.ProjectID NOT IN (
        SELECT Project.ProjectID
        FROM Project)");

    $stmt->execute();
    $result = $stmt->fetchAll();
    $stmt->closeCursor();
    return $result;
}

?>