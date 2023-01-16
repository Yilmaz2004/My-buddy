<?php
include '../Private/connection.php';
$paymentid = $_GET['paymentid'];
$user = $_SESSION['userid'];


$sql = "SELECT  u.firstname
        FROM userpayment up
        LEFT JOIN users u on up.userid = u.userid
        WHERE up.FKpaymentid = :paymentid ";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':paymentid', $paymentid);
$stmt->execute();

$sql = "SELECT  up.FKpaymentid,up.userid,p.date,p.description 
        FROM userpayment up
        LEFT JOIN payment p on up.FKpaymentid = p.paymentid
        WHERE up.FKpaymentid = :paymentid ";
$stmt2 = $conn->prepare($sql);
$stmt2->bindParam(':paymentid', $paymentid);
$stmt2->execute();

$sql = "SELECT  * from  payment  where paymentid  = :paymentid";
$stmt4 = $conn->prepare($sql);
$stmt4->bindParam(':paymentid', $paymentid);
$stmt4->execute();
$row4 = $stmt4->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT  COUNT(*) from  userpayment  where FKpaymentid  = :paymentid ";
$stmt6 = $conn->prepare($sql);
$stmt6->bindParam(':paymentid', $paymentid);
$stmt6->execute();
$row6 = $stmt6->fetch(PDO::FETCH_ASSOC);
$groupdebt = $row4['price'] / (int)$row6['COUNT(*)'];
$ownerdebt = $groupdebt * (int)$row6['COUNT(*)'];
$groupdebt1 = (round($groupdebt / 0.05, 0)) * 0.05;
$ownerdebt1 = (round($ownerdebt / 0.05, 0)) * 0.05;

?>

    <section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
    <div>
    <div class="card bg-dark text-white" style="border-radius: 1rem;">
    <div class="card-body p-5 text-center">
    <div class="mb-md-5 mt-md-5 pb-5">
    <div class="container mt-3">
    <h2>payment</h2>
    <table class="table table-striped">
    <thead>
    <tr>
        <th>firstname</th>
        <th>dept</th>
    </tr>
    </thead>
    <tbody>

<?php if ($stmt->rowCount() > 0) {
while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
    $sql = "SELECT firstname 
                    FROM users 
                    WHERE userid = :userid";
    $stmt3 = $conn->prepare($sql);
    $stmt3->bindParam(':userid', $row['userid']);
    $stmt3->execute();
    $row3 = $stmt3->fetch(PDO::FETCH_ASSOC); ?>

    <tr>
        <td><?= $row3["firstname"] ?></td>
        <td>-<?= $groupdebt1 ?>$</td>
    </tr>

<?php }} ?>