<?php
include '../private/connection.php';

$groupid = $_GET['groupid'];


$stmt = $conn->prepare("SELECT * FROM groups WHERE groupid = :groupid");
$stmt->bindParam(':groupid', $groupid, PDO::PARAM_INT);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC) ?>

    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="">
                <div class="card bg-dark text-white" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
                        <div class="mb-md-5 mt-md-5 pb-5">
                            <div class="container mt-3">
                                <h2>name aanpassen</h2>
                                <form action="php/group_update.php" method="POST" enctype="multipart/form-data">
                                    <div class="mb-3 mt-3">
                                        <label>Naam:</label>
                                        <input type="text" class="form-control" placeholder="Enter name" name="name"
                                               value="<?= $row["name"] ?>" required>
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label>description:</label>
                                        <input type="text" class="form-control" placeholder="Enter description"
                                               name="description" value="<?= $row["description"] ?>" required>
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label>picture:</label>
                                        <input type="file" class="form-control" placeholder="Enter picture"
                                               name="picture" value="<?= $row["picture"] ?>" required>
                                    </div>
                                    <input type="hidden" name="groupid" value="<?= $groupid ?>">
                                    <button type="submit" name="submit" class="btn btn-success"
                                            onclick=" if(confirm('Weet u zeker dat u dit record wilt updaten?'))window.location.href='php/group_update.php?groupid=<?= $row["groupid"] ?>'">
                                        Opslaan
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>

<?php } ?>
<?php
