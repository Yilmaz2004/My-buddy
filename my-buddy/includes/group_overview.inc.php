<?php
include '../Private/connection.php';

$userid = $_SESSION['userid'];


$sql = "SELECT g.groupid,g.name,g.description,g.picture,g.useradminid,g.date,m.FKuserid FROM groups g
left join member m on g.groupid = m.FKgroupid

where m.FKuserid = :userid ";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':userid', $userid);
    $stmt->execute();
?>
<section class="vh-100 gradient-custom" >
    <div class="container py-5 h-100">
        <div class="">
            <div class="card bg-dark text-white" style="border-radius: 1rem;">
                <div class="card-body p-5 text-center">
                    <div class="mb-md-5 mt-md-5 pb-5">
                        <div>
                            <h2 class="fw-bold mb-5 text-uppercase">group overview</h2>
                            <button class=" form-outline form-white btn btn-success mb-5" onclick="window.location.href='index.php?page=group_insert&groupid='">Toevoegen</button>
                            <table class="table table-striped">
                                <tbody>
                                <tr>
                                    <th> picture</th>
                                    <th> activiteit</th>
                                    <th> description</th>
                                    <th> date</th>
                                    <th> </th>
                                    <th> </th>
                                    <th> enter group </th>
                                </tr>
                                <?php

                                if ($stmt->rowCount() > 0){
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <tr>
                                            <td><img  class="picture" src="<?= $row["picture"]?>" width="150"
                                              height="100" ></td>
                                            <td><?= $row["name"] ?></td>
                                            <td><?= $row["description"] ?></td>
                                            <td><?= $row["date"] ?></td>
                                            <td>
                                                <button class=" btn btn-warning mb-5" onclick="window.location.href='index.php?page=group&groupid=<?= $row["groupid"] ?>'">enter group</button>
                                            </td>

                                         <?php   $sql2 = "SELECT useradminid FROM groups where groupid = :groupid";
                                                 $stmt2 = $conn->prepare($sql2);
                                                 $stmt2->bindParam(':groupid', $row['groupid'], PDO::PARAM_INT);
                                                 $stmt2->execute();
                                                 $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                                                 if   ($row2['useradminid'] == $userid){ ?>
                                            <td>
                                                <button class=" btn btn-warning mb-5" onclick="window.location.href='index.php?page=group_update&groupid=<?= $row["groupid"] ?>'">Aanpassen</button>
                                            </td>
                                            <td>
                                                <button class="btn btn-danger" name="groupid"
                                                    onclick=" if(confirm('Weet u zeker dat u dit record wilt verwijderen?'))window.location.href='php/group_delete.php?groupid=<?= $row["groupid"] ?>'">
                                                verwijderen

                                            </td>
                                        </tr>
                    </div>
                </div>
        </div>
    </div>
</section>

       <?php }}}?>

