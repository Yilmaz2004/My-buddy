<?php
session_start();
include '../../private/connection.php';

$user = $_SESSION['userid'];
$price = $_POST['price'];
$groupid = $_POST['groupid'];
$description = $_POST['description'];
$date = $_POST['date'];
$userid = $_POST['userid'];
$exists = false;

$stmt = $conn->prepare("insert into payment (price, description,date,groupid,userid)
                                                   values(:price,:description,:date,:groupid,:userid)");
$stmt->bindParam(':price', $price);
$stmt->bindParam(':groupid', $groupid);
$stmt->bindParam(':description', $description);
$stmt->bindParam(':date', $date);
$stmt->bindParam(':userid', $user);
$stmt->execute();

$order = $conn->lastInsertId();

foreach ($userid as $value) {

    $sql = "SELECT userid FROM userpayment where FKpaymentid = :paymentid and userid = :userid ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':paymentid', $order);
    $stmt->bindParam(':userid', $value);
    $stmt->execute();
    if ($stmt->rowCount() != 0) {
        $exists = true;
        break;
    }
}
if (!$exists) {
    if (!in_array($user, $userid)) {
        foreach ($userid as $value) {
            $stmt2 = $conn->prepare("INSERT INTO userpayment (userid, FKpaymentid,debt,groupid)
                    VALUES(:userid, :paymentid,:debt,:groupid)");
            $stmt2->bindParam(':userid', $value);
            $stmt2->bindParam(':paymentid', $order);
            $stmt2->bindParam(':debt', $price);
            $stmt2->bindParam(':groupid', $groupid);
            $stmt2->execute();
            $_SESSION['melding'] = 'Deelnemer(s) gekoppeld aan betaling.';
        }
        $sql = "SELECT  COUNT(*) from  userpayment  where FKpaymentid  = $order";
        $stmt6 = $conn->prepare($sql);
        $stmt6->execute();
        $row6 = $stmt6->fetch(PDO::FETCH_ASSOC);
        $groupdebt = $price / (int)$row6['COUNT(*)'];
        $groupdebt1 = (round($groupdebt / 0.05, 0)) * 0.05;

        $stmt7 = $conn->prepare("UPDATE userpayment SET debt = - $groupdebt1  where FKpaymentid = :paymentid");
        $stmt7->bindParam(':paymentid', $order);
        $stmt7->execute();

    } else {
        foreach ($userid as $value) {
            $stmt2 = $conn->prepare("INSERT INTO userpayment (userid, FKpaymentid,debt,groupid)
                    VALUES(:userid, :paymentid,:debt,:groupid)");
            $stmt2->bindParam(':userid', $value);
            $stmt2->bindParam(':paymentid', $order);
            $stmt2->bindParam(':debt', $price);
            $stmt2->bindParam(':groupid', $groupid);
            $stmt2->execute();
            $_SESSION['melding'] = 'Deelnemer(s) gekoppeld aan betaling.';
        }
        $sql = "SELECT  COUNT(*) from  userpayment  where FKpaymentid  = $order";
        $stmt6 = $conn->prepare($sql);
        $stmt6->execute();
        $row6 = $stmt6->fetch(PDO::FETCH_ASSOC);
        $groupdebt = $price / (int)$row6['COUNT(*)'];
        $groupdebt1 = (round($groupdebt / 0.05, 0)) * 0.05;

        $stmt7 = $conn->prepare("UPDATE userpayment SET debt = - $groupdebt1  where FKpaymentid = :paymentid ");
        $stmt7->bindParam(':paymentid', $order);
        $stmt7->execute();
    }
} else {
    $_SESSION['melding'] = '1 of meer deelnemers al gekoppeld aan deze betaling.';
}
header('location: ../index.php?page=payment&groupid=' . $groupid);