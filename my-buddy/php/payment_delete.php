<?php
include '../../private/connection.php';

$paymentid = $_GET['paymentid'];
$groupid = $_GET['groupid'];


$stmt = $conn->prepare("DELETE FROM userpayment WHERE FKpaymentid = :paymentid");
$stmt->bindParam(':paymentid', $paymentid, PDO::PARAM_INT);
$stmt->execute();

$stmt = $conn->prepare("DELETE FROM payment WHERE paymentid = :paymentid");
$stmt->bindParam(':paymentid', $paymentid, PDO::PARAM_INT);
$stmt->execute();


header('location: ../index.php?page=payment&groupid=' . $groupid);

?>

