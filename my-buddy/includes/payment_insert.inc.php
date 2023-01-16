<?php
include '../private/connection.php';

$userid = $_SESSION['userid'];
$groupid = $_GET['groupid'];
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
                            <h2>betaling toevoegen</h2>
                            <form action="php/payment_insert.php" method="POST" >
                                <div class="mb-3 mt-3">
                                    <label>description:</label>
                                    <input type="text" class="form-control" placeholder="Enter description"
                                           name="description" required>
                                </div>
                                <div class="mb-3 mt-3">
                                    <label>price:</label>
                                    <input type="number" class="form-control" placeholder="Enter price" name="price"
                                           required>
                                </div>
                                <div class="mb-3 mt-3">
                                    <label>date:</label>
                                    <input type="date" class="form-control" placeholder="Enter date" name="date"
                                           required>
                                </div>
                                <button name="submit" type="submit" class="btn btn-success">Toevoegen</button>
                                <?php while ($row3 = $stmt4->fetch(PDO::FETCH_ASSOC)) {?>
                                <input type="checkbox" name="userid[]" value="<?= $row3['userid'] ?>" >
                                <label for="vehicle1" ><?= $row3['firstname'] ?></label><?php }?>

                                <input type="hidden" name="paymentid" value="<?= $row6['paymentid'] ?>">
                                <input type="hidden" name="groupid" value="<?= $groupid ?>">
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>
</section><?php  ?>