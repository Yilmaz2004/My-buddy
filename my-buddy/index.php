<?php
session_start();

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page='login';
}?>
<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <title>Login Form</title>
    <link rel="stylesheet"  href="css/style.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<body>
<?php include 'Includes/navbar.inc.php'; ?>
<?php include 'Includes/'.$page.'.inc.php'; ?>
</body>
</html>