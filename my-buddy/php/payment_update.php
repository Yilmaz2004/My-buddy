<?php
include '../../private/connection.php';
session_start();
$user = $_SESSION['userid'];
$userid = $_POST['userid'];
$price = $_POST['price'];
$description = $_POST['description'];
$date = $_POST['date'];
$paymentid = $_POST['paymentid'];
$groupid = $_POST['groupid'];
$exists = false;

$stmt = $conn->prepare("UPDATE payment SET price = :price, description = :description, date = :date WHERE paymentid = :paymentid");
$stmt->bindParam(':price', $price);
$stmt->bindParam(':description', $description);
$stmt->bindParam(':date', $date);
$stmt->bindParam(':paymentid', $paymentid);
$stmt->execute();

foreach ($userid as $value) {

    $sql = "SELECT userid FROM userpayment where FKpaymentid = :paymentid and userid = :userid ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':paymentid', $paymentid);
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
            $stmt2 = $conn->prepare("INSERT INTO userpayment (userid, FKpaymentid,groupid)
                    VALUES(:userid, :paymentid,:groupid)");
            $stmt2->bindParam(':userid', $value);
            $stmt2->bindParam(':paymentid', $paymentid);
            $stmt2->bindParam(':groupid', $groupid);
            $stmt2->execute();
            $_SESSION['melding'] = 'Deelnemer(s) gekoppeld aan betaling.';
        }
        $sql = "SELECT userid FROM userpayment where userid = :userid and FKpaymentid = :paymentid ";
        $stmt3 = $conn->prepare($sql);
        $stmt3->bindParam(':userid', $user);
        $stmt3->bindParam(':paymentid', $paymentid);
        $stmt3->execute();
        if ($stmt3->rowCount() == 0) {

            $stmt4 = $conn->prepare("INSERT INTO userpayment (userid, FKpaymentid,groupid)
                    VALUES(:userid, :paymentid,:groupid)");
            $stmt4->bindParam(':userid', $user);
            $stmt4->bindParam(':paymentid', $paymentid);
            $stmt4->bindParam(':groupid', $groupid);
            $stmt4->execute();
        }
        $sql = "SELECT  COUNT(*) from  userpayment  where FKpaymentid  = $paymentid and userid !=$user";
        $stmt6 = $conn->prepare($sql);
        $stmt6->execute();
        $row6 = $stmt6->fetch(PDO::FETCH_ASSOC);
        $groupdebt = $price / (int)$row6['COUNT(*)'];
        $ownerdebt = $groupdebt * (int)$row6['COUNT(*)'];
        $groupdebt1 = (round($groupdebt / 0.05, 0)) * 0.05;
        $ownerdebt1 = (round($ownerdebt / 0.05, 0)) * 0.05;

        $stmt7 = $conn->prepare("UPDATE userpayment SET debt = - $groupdebt1  where FKpaymentid = :paymentid and userid != $user ");
        $stmt7->bindParam(':paymentid', $paymentid);
        $stmt7->execute();

        $stmt8 = $conn->prepare("UPDATE userpayment SET debt = $ownerdebt1  where FKpaymentid = :paymentid and userid = $user ");
        $stmt8->bindParam(':paymentid', $paymentid);
        $stmt8->execute();
    } else {
        foreach ($userid as $value) {
            $stmt2 = $conn->prepare("INSERT INTO userpayment (userid, FKpaymentid,debt,groupid)
                    VALUES(:userid, :paymentid,:debt,:groupid)");
            $stmt2->bindParam(':userid', $value);
            $stmt2->bindParam(':paymentid', $paymentid);
            $stmt2->bindParam(':debt', $price);
            $stmt2->bindParam(':groupid', $groupid);
            $stmt2->execute();
            $_SESSION['melding'] = 'Deelnemer(s) gekoppeld aan betaling.';
        }
        $sql = "SELECT userid FROM userpayment where userid = :userid and FKpaymentid = :paymentid ";
        $stmt3 = $conn->prepare($sql);
        $stmt3->bindParam(':userid', $user);
        $stmt3->bindParam(':paymentid', $paymentid);
        $stmt3->execute();

        if ($stmt3->rowCount() == 0) {
            $stmt4 = $conn->prepare("INSERT INTO userpayment (userid, FKpaymentid,debt,groupid)
                    VALUES(:userid, :paymentid,:debt,:groupid)");
            $stmt4->bindParam(':userid', $user);
            $stmt4->bindParam(':paymentid', $paymentid);
            $stmt4->bindParam(':debt', $price);
            $stmt4->bindParam(':groupid', $groupid);
            $stmt4->execute();
        }
        $sql = "SELECT  COUNT(*) from  userpayment  where FKpaymentid  = $paymentid and userid != $user";
        $stmt5 = $conn->prepare($sql);
        $stmt5->execute();
        $row5 = $stmt5->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT  COUNT(*) from  userpayment  where FKpaymentid  = $paymentid";
        $stmt6 = $conn->prepare($sql);
        $stmt6->execute();
        $row6 = $stmt6->fetch(PDO::FETCH_ASSOC);
        $groupdebt = $price / (int)$row6['COUNT(*)'];
        $ownerdebt = $price / (int)$row6['COUNT(*)'] * (int)$row5['COUNT(*)'];

        $groupdebt1 = (round($groupdebt / 0.05, 0)) * 0.05;
        $ownerdebt1 = (round($ownerdebt / 0.05, 0)) * 0.05;

        $stmt7 = $conn->prepare("UPDATE userpayment SET debt = - $groupdebt1  where FKpaymentid = :paymentid and userid != $user ");
        $stmt7->bindParam(':paymentid', $paymentid);
        $stmt7->execute();

        $stmt8 = $conn->prepare("UPDATE userpayment SET debt = $ownerdebt1  where FKpaymentid = :paymentid and userid = $user ");
        $stmt8->bindParam(':paymentid', $paymentid);
        $stmt8->execute();
    }
} else {
    $stmt = $conn->prepare("DELETE FROM userpayment WHERE FKpaymentid = :id");
    $stmt->bindParam(':id', $paymentid);
    $stmt->execute();
    if (!in_array($user, $userid)) {
        foreach ($userid as $value) {
            $stmt2 = $conn->prepare("INSERT INTO userpayment (userid, FKpaymentid,groupid)
                    VALUES(:userid, :paymentid,:groupid)");
            $stmt2->bindParam(':userid', $value);
            $stmt2->bindParam(':paymentid', $paymentid);
            $stmt2->bindParam(':groupid', $groupid);
            $stmt2->execute();
            $_SESSION['melding'] = 'Deelnemer(s) gekoppeld aan betaling.';
        }
        $sql = "SELECT userid FROM userpayment where userid = :userid and FKpaymentid = :paymentid ";
        $stmt3 = $conn->prepare($sql);
        $stmt3->bindParam(':userid', $user);
        $stmt3->bindParam(':paymentid', $paymentid);
        $stmt3->execute();
        if ($stmt3->rowCount() == 0) {
            $stmt4 = $conn->prepare("INSERT INTO userpayment (userid, FKpaymentid,groupid)
                    VALUES(:userid, :paymentid,:groupid)");
            $stmt4->bindParam(':userid', $user);
            $stmt4->bindParam(':paymentid', $paymentid);
            $stmt4->bindParam(':groupid', $groupid);
            $stmt4->execute();
        }
        $sql = "SELECT  COUNT(*) from  userpayment  where FKpaymentid  = $paymentid and userid !=$user";
        $stmt6 = $conn->prepare($sql);
        $stmt6->execute();
        $row6 = $stmt6->fetch(PDO::FETCH_ASSOC);
        $groupdebt = $price / (int)$row6['COUNT(*)'];
        $ownerdebt = $groupdebt * (int)$row6['COUNT(*)'];
        $groupdebt1 = (round($groupdebt / 0.05, 0)) * 0.05;
        $ownerdebt1 = (round($ownerdebt / 0.05, 0)) * 0.05;


    } else {
        foreach ($userid as $value) {
            $stmt2 = $conn->prepare("INSERT INTO userpayment (userid, FKpaymentid,debt,groupid)
                    VALUES(:userid, :paymentid,:debt,:groupid)");
            $stmt2->bindParam(':userid', $value);
            $stmt2->bindParam(':paymentid', $paymentid);
            $stmt2->bindParam(':debt', $price);
            $stmt2->bindParam(':groupid', $groupid);
            $stmt2->execute();
            $_SESSION['melding'] = 'Deelnemer(s) gekoppeld aan betaling.';
        }
        $sql = "SELECT userid FROM userpayment where userid = :userid and FKpaymentid = :paymentid ";
        $stmt3 = $conn->prepare($sql);
        $stmt3->bindParam(':userid', $user);
        $stmt3->bindParam(':paymentid', $paymentid);
        $stmt3->execute();
        if ($stmt3->rowCount() == 0) {

            $stmt4 = $conn->prepare("INSERT INTO userpayment (userid, FKpaymentid,debt,groupid)
                    VALUES(:userid, :paymentid,:debt,:groupid)");
            $stmt4->bindParam(':userid', $user);
            $stmt4->bindParam(':paymentid', $paymentid);
            $stmt4->bindParam(':debt', $price);
            $stmt4->bindParam(':groupid', $groupid);
            $stmt4->execute();
        }
        $sql = "SELECT  COUNT(*) from  userpayment  where FKpaymentid  = $paymentid and userid != $user";
        $stmt5 = $conn->prepare($sql);
        $stmt5->execute();
        $row5 = $stmt5->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT  COUNT(*) from  userpayment  where FKpaymentid  = $paymentid";
        $stmt6 = $conn->prepare($sql);
        $stmt6->execute();
        $row6 = $stmt6->fetch(PDO::FETCH_ASSOC);
        $groupdebt = $price / (int)$row6['COUNT(*)'];
        $ownerdebt = $price / (int)$row6['COUNT(*)'] * (int)$row5['COUNT(*)'];

        $groupdebt1 = (round($groupdebt / 0.05, 0)) * 0.05;
        $ownerdebt1 = (round($ownerdebt / 0.05, 0)) * 0.05;

        $stmt7 = $conn->prepare("UPDATE userpayment SET debt = - $groupdebt1  where FKpaymentid = :paymentid and userid != $user ");
        $stmt7->bindParam(':paymentid', $paymentid);
        $stmt7->execute();

        $stmt8 = $conn->prepare("UPDATE userpayment SET debt = $ownerdebt1  where FKpaymentid = :paymentid and userid = $user ");
        $stmt8->bindParam(':paymentid', $paymentid);
        $stmt8->execute();
    }
}
header('location: ../index.php?page=payment&groupid=' . $groupid);
?>