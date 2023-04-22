<?php

function admin_payments()
{
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
    HAVING Remaining_Payment > 0
	ORDER BY Project.EndDate");
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}

function tech_payments($UserID){

}

function cust_payments($UserID){

}

?>