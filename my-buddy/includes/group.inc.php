<?php
include '../Private/connection.php';
$groupid = $_GET['groupid'];
$userid = $_SESSION['userid'];
$id = $_GET['groupid'];

$sql = "SELECT u.userid, sum(debt) AS sum FROM users u RIGHT JOIN member m on m.fkuserid = u.userid left JOIN userpayment p on p.userid = u.userid where  m.FKgroupid = :groupid GROUP BY userid ";
$stmt5 = $conn->prepare($sql);
$stmt5->bindParam(':groupid', $groupid);
$stmt5->execute();

$sql = "SELECT useradminid FROM groups WHERE groupid = :groupid ";
$stmt3 = $conn->prepare($sql);
$stmt3->bindParam(':groupid', $groupid, PDO::PARAM_INT);
$stmt3->execute();
$row3 = $stmt3->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT *
FROM groups
WHERE groupid = :groupid";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':groupid', $groupid, PDO::PARAM_INT);
$stmt->execute();

$sql = "SELECT u.userid, u.firstname, m.memberid
    FROM member m 
    LEFT JOIN users u on m.FKuserid = u.userid
    WHERE m.FKgroupid = $groupid";
$stmt4 = $conn->prepare($sql);
$stmt4->execute();
?>
<section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
        <div>
            <div class="card bg-dark text-white" style="border-radius: 1rem;">
                <div class="card-body p-5 text-center">
                    <div class="mb-md-5 mt-md-5 pb-5">
                        <div class="container mt-3">
                            <table class="table table-striped">
                                <thead>
                                </tr>
                                <table class="table table-striped">
                                    <thead>
                                    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
                                    <form action="php/member_add.php" method="post">
                                        <div class="mb-3 mt-3">
                                            <label>email:</label>
                                            <input type="email" class="form-control" placeholder="Enter email"
                                                   name="email" required>
                                        </div>
                                        <?php
                                        if (isset($_SESSION['melding'])) {
                                            echo $_SESSION['melding'];
                                            unset($_SESSION['melding']);
                                        }
                                        ?>
                                        <div class="w3-bar">
                                            <input type="hidden" name="groupid" value="<?= $groupid ?>">
                                            <button class="w3-button w3-left w3-light-grey" type="submit" name="submit">
                                                add
                                            </button>
                                            <button class="w3-button w3-right w3-green"
                                                    onclick="window.location.href='index.php?page=payment&groupid=<?= $groupid ?>'">
                                                view payment
                                            </button
                                        </div>
                                    </form>
                                    <tr>
                                    </tr>
                                    </thead>
                                    <th>Picture</th>
                                    <th>firstname</th>
                                    <th>name</th>
                                    <th>date</th>
                                    <tbody>
                                    <?php while ($row2 = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <td><img class="picture" src="<?= $row2["picture"] ?>" width="150px"
                                                 height="100px"></td>
                                        <td><?= $row2["name"] ?></td>
                                        <td><?= $row2["description"] ?></td>
                                        <td><?= $row2["date"] ?></td>
                                    <?php }
                                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                    while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <tr>
                                        <td><?= $row4["firstname"] ?></td>
                                        <td> <?php if ($row3['useradminid'] == $userid && $row3['useradminid'] != $row4['userid']) { ?></td>
                                            <td>
                                                <button class="btn btn-success"
                                                        onclick=" if(confirm('Weet u zeker dat u deze deelnemer wilt verwijderen?'))window.location.href='php/member_delete.php?memberid=<?= $row4["memberid"] ?>&groupid=<?= $row["groupid"] ?>'">
                                                    Lid Verwijderen
                                                </button>
                                            </td>
                                            </Tr>
                                        <?php }
                                    } ?>
                                    </tbody>
                                </table>
                                </thead>
                                <thead>
                                <table>
                                    <tbody>
                                    <?php while ($row5 = $stmt5->fetchAll(PDO::FETCH_ASSOC)) {
                                    $sql = "SELECT u.userid, sum(price) AS sum FROM users u RIGHT JOIN member m on m.fkuserid = u.userid left JOIN payment p on p.userid = u.userid where m.FKgroupid = :groupid GROUP BY userid";
                                    $stmt15 = $conn->prepare($sql);
                                    $stmt15->bindParam(':groupid', $id);
                                    $stmt15->execute();
                                    $row15 = $stmt15->fetchAll(PDO::FETCH_ASSOC);

                                    $array =array_merge($row15, $row5);
                                    $result5 = array();
                                    foreach($array as $k => $v) {
                                        $id = $v['userid'];
                                        $result5[$id][] = $v['sum'];
                                    }
                                    $new = array();
                                    foreach($result5 as $key => $value) {
                                        $new[] = array('userid' => $key, 'sum' => array_sum($value));
                                    }

                                        $i=0;
                                    foreach ($new as $rowtest){
                                    $sql = "SELECT * FROM users where userid=:userid";
                                    $stmt6 = $conn->prepare($sql);
                                    $stmt6->bindParam(':userid', $rowtest['userid']);
                                    $stmt6->execute();
                                    $row6 = $stmt6->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                    <tbody>
                                    <tr>
                                        <td><?= $row6["firstname"] ?></td>
                                        <td><?= $new[$i]['sum'] ?></td><?php $i++;}?>
                                    </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                                </thead>
                        </div>
                    </div>
                </div>
</section>