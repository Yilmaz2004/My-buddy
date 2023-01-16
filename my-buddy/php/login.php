<?php
session_start();
include '../../Private/connection.php';


$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT role, userid FROM users WHERE email= :email AND password = :password";

$query = $conn->prepare($sql);
$query->bindParam(':email', $email);
$query->bindParam(':password', $password);
$query->execute();

if ($query->rowCount() == 1) {
    $result = $query->fetch(PDO::FETCH_ASSOC);

    $_SESSION['userid'] = $result['userid'];
    header('location: ../index.php?page=group_overview');

} else {
    $_SESSION['melding'] = 'Combinatie gebruikersnaam en Wachtwoord onjuist.';
    header('location: ../index.php?page=login');
}

