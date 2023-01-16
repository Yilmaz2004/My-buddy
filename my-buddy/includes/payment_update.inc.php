<?php
include '../private/connection.php';

$groupid = $_GET['groupid'];
$paymentid = $_GET['paymentid'];

$stmt = $conn->prepare("SELECT * FROM payment WHERE groupid = :groupid AND paymentid = :paymentid ");
$stmt->bindParam(':groupid', $groupid, PDO::PARAM_INT);
$stmt->bindParam(':paymentid', $paymentid, PDO::PARAM_INT);
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);
$sql = "SELECT *
FROM payment
WHERE groupid = $groupid";
$stmt6 = $conn->prepare($sql);
$stmt6->execute();
$row6 = $stmt6->fetch();

$sql = "SELECT u.userid, u.firstname
    FROM member m 
    LEFT JOIN users u on m.FKuserid = u.userid
    WHERE m.FKgroupid = $groupid";
$stmt4 = $conn->prepare($sql);
$stmt4->execute();


?>


<section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="">
            <div class="card bg-dark text-white" style="border-radius: 1rem;">
                <div class="card-body p-5 text-center">
                    <div class="mb-md-5 mt-md-5 pb-5">
                        <div class="container mt-3">
                            <h2>payment</h2>
                            <form action="php/payment_update.php" method="POST" enctype="multipart/form-data">
                                <div class="mb-3 mt-3">
                                    <label>description:</label>
                                    <input type="text" class="form-control" placeholder="Enter description"
                                           name="description" value="<?= $row["description"] ?>" required>
                                </div>
                                <div class="mb-3 mt-3">
                                    <label>price:</label>
                                    <input type="decimal" class="form-control" placeholder="Enter price" name="price"
                                           value="<?= $row["price"] ?>" required>
                                    <input type="hidden" name="oldprice"
                                           value="<?= $row["price"] ?>">
                                </div>
                                <div class="mb-3 mt-3">
                                    <label>date:</label>
                                    <input type="date" class="form-control" placeholder="Enter date" name="date"
                                           value="<?= $row["date"] ?>" required>
                                </div>
                                <?php while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {

                                    $sql = "SELECT userid FROM userpayment WHERE FKpaymentid = :id";
                                    $stmt50 = $conn->prepare($sql);
                                    $stmt50->bindParam(':id', $paymentid);
                                    $stmt50->execute();
                                    ?>

                                    <input type="checkbox" name="userid[]" value="<?= $row4['userid'] ?>"

                                        <?php  while ($row50 = $stmt50->fetch(PDO::FETCH_ASSOC)){

                                        echo ($row50['userid'] == $row4['userid']) ? 'checked=="checked"' : ''; } ?>/>

                                    <label for="vehicle1" ><?= $row4['firstname'] ?></label><?php }?>

                                <input type="hidden" name="paymentid" value="<?= $row6['paymentid'] ?>">
                                <input type="hidden" name="groupid" value="<?= $groupid ?>">

                                <button name="submit" type="submit" class="btn btn-success">Toevoegen</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>



