<?php
include '../../private/connection.php';

$groupid = $_GET['groupid'];
$sql = 'SELECT * FROM member';
$stmt = $conn->prepare($sql);
$stmt->execute();

if($stmt->rowCount() > 0);{


    $stmt = $conn->prepare("DELETE FROM member  where FKgroupid = :groupid");
    $stmt->bindParam(':groupid' ,$groupid);
    $stmt->execute();
    header('location: ../index.php?page=group_overview');

    $stmt = $conn->prepare("DELETE FROM groups  where groupid = :groupid");
    $stmt->bindParam(':groupid' ,$groupid);
    $stmt->execute();
    header('location: ../index.php?page=group_overview');

    $stmt = $conn->prepare("DELETE FROM payment  where groupid = :groupid");
    $stmt->bindParam(':groupid' ,$groupid);
    $stmt->execute();
    header('location: ../index.php?page=group_overview');

    $stmt = $conn->prepare("DELETE FROM userpayment  where groupid = :groupid");
    $stmt->bindParam(':groupid' ,$groupid);
    $stmt->execute();
    header('location: ../index.php?page=group_overview');
}