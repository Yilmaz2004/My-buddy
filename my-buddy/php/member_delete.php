<?php
include '../../private/connection.php';
$memberid = $_GET['memberid'];
$groupid = $_GET['groupid'];

$stmt = $conn->prepare("DELETE FROM member WHERE memberid = :memberid");
$stmt->bindParam(':memberid', $memberid);
$stmt->execute();

header('location: ../index.php?page=group&groupid='.$groupid);
?>