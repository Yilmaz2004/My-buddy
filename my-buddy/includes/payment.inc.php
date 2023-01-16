<?php
include '../Private/connection.php';
$groupid = $_GET['groupid'];
$userid = $_SESSION['userid'];

$sql = "SELECT *
        FROM payment
        WHERE groupid = :groupid";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':groupid', $groupid, PDO::PARAM_INT);
$stmt->execute();


$sql2 = "SELECT *
        FROM groups
        WHERE groupid = :groupid";
$stmt2 = $conn->prepare($sql2);
$stmt2->bindParam(':groupid', $groupid, PDO::PARAM_INT);
$stmt2->execute();
$row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT *
        FROM payment
        WHERE groupid = :groupid";
$stmt3 = $conn->prepare($sql);
$stmt3->bindParam(':groupid', $groupid, PDO::PARAM_INT);
$stmt3->execute();
$row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
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
                                    <th>description</th>
                                    <th>payment</th>
                                    <th>date</th>
                                    <th>update</th>
                                    <th>delete</th>

                                    <th>open payments</th>
                                </tr>

                                <button class=" form-outline form-white btn btn-success mb-5"
                                        onclick="window.location.href='index.php?page=payment_insert&groupid=<?= $row2['groupid'] ?> '">
                                    insert
                                </button>
                                </thead>
                                <tbody>
                                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                                    $sql = "SELECT firstname
                                    FROM users
                                    WHERE userid = :userid";
                                    $stmt2 = $conn->prepare($sql);
                                    $stmt2->bindParam(':userid', $row['userid']);
                                    $stmt2->execute();
                                    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC)

                                    ?>
                                    <tr>
                                    <td><?= $row2["firstname"] ?></td>
                                    <td><?= $row["description"] ?></td>
                                    <td><?= $row["price"] ?>$</td>
                                    <td><?= $row["date"] ?></td>
                                    <?php if ($row['userid'] == $userid) { ?>


                                        <td>
                                            <button class="btn btn-primary" type="submit" name="submit"
                                                    onclick="window.location.href='index.php?page=payment_update&groupid=<?= $row["groupid"] ?>&paymentid=<?= $row["paymentid"] ?>'">
                                                update payment
                                            </button>
                                        </td>
                                        <td>
                                            <button class="btn btn-danger" name="groupid"
                                                    onclick=" if(confirm('Weet u zeker dat u dit record wilt verwijderen?'))window.location.href='php/payment_delete.php?groupid=<?= $row["groupid"] ?>&paymentid=<?= $row["paymentid"] ?>'">
                                                verwijderen
                                            </button>
                                        </td>

                                        <td>
                                            <button class="btn btn-success" onclick="window.location.href='index.php?page=groupbalans&paymentid=<?= $row["paymentid"] ?>'">
                                                Betaling zien
                                            </button>
                                        </td>


                                        </tr>

                                    <?php }
                                }


                                ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
</section>