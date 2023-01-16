<?php
session_start();
include '../../private/connection.php';

$email = $_POST['email'];
$groupid = $_POST['groupid'];


$sql = 'SELECT userid FROM users where email = :email ';
$stmt = $conn->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($stmt->rowCount() > 0) {

    $sql = 'SELECT FKuserid FROM member where FKuserid = :userid AND FKgroupid =:groupid ';
    $stmt2 = $conn->prepare($sql);
    $stmt2->bindParam(':userid', $row['userid']);
    $stmt2->bindParam(':groupid', $groupid);
    $stmt2->execute();
    if ($stmt2->rowCount() == 0) {
        $stmt3 = $conn->prepare("INSERT INTO member (FKuserid, FKgroupid)
                    VALUES(:userid, :groupid)");
        $stmt3->bindParam(':userid', $row['userid']);
        $stmt3->bindParam(':groupid', $groupid);
        $stmt3->execute();
        $_SESSION['melding'] = 'Gebruiker is toegevoegd aan de groep.';
    } else {
        $_SESSION['melding'] = 'Gebruiker is al toegevoegd aan de groep.';
    }
} else {
    $_SESSION['melding'] = 'Email bestaat niet.';
}

header('location: ../index.php?page=group&groupid=' . $groupid);