<?php
session_start();
include '../../private/connection.php';
$name = $_POST['name'];
$description = $_POST['description'];
$userid = $_SESSION['userid'];

$marker = "picture/" . basename($_FILES["picture"]["name"]);

$target_dir = "../picture/";
$target_file = $target_dir . basename($_FILES["picture"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
    echo $marker . '<br>';
    $check = getimagesize($_FILES["picture"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["picture"]["name"])) . " has been uploaded.";
            $stmt = $conn->prepare("INSERT INTO groups  (name, description, picture, useradminid)
                        VALUES(:name, :description, :picture , :useradminid)");
            $stmt->bindParam(':picture', $marker);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':useradminid', $userid);
            $stmt->execute();

            $groupid = $conn->lastInsertId();

            $stmt2 = $conn->prepare("INSERT INTO member (FKuserid, FKgroupid)
                    VALUES(:userid, :groupid)");
            $stmt2->bindParam(':userid', $userid);
            $stmt2->bindParam(':groupid', $groupid);
            $stmt2->execute();

        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    header('location: ../index.php?page=group_overview');
}
?>