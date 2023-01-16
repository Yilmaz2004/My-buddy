<?php
session_start();
include '../../private/connection.php';
$password = $_POST['password'];
$passwordrepeat = $_POST['passwordrepeat'];
if ($password == $passwordrepeat) {
    $firstname = $_POST['firstname'];
    $insertion = $_POST['insertion'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $role = "user";
    $stmt = $conn->prepare("INSERT INTO users (firstname, insertion, lastname, email, password, role)
                                                   values(:firstname, :insertion, :lastname,:email,:password, :role)");

    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':insertion', $insertion);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':role', $role);

    $stmt->execute();
    $_SESSION['userid'] = $conn->lastInsertId();
    header('location: ../index.php?page=group_overview');
} else {
    $_SESSION['melding'] = 'Wachtwoorden komen niet overeen';
    header('location: ../index.php?page=register');
}
?>

