<?php
include '../Private/connection.php';
if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];
    $sql = "SELECT g.groupid, m.FKuserid, g.name,g.description, g.date, g.picture 
    FROM groups g
    LEFT JOIN member m on g.groupid = m.FKgroupid
    WHERE m.FKuserid = $userid";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);



    $sql = "SELECT *
    FROM payment
    WHERE groupid = :groupid";
    $stmt6 = $conn->prepare($sql);
    $stmt6->bindParam(':groupid', $row['groupid']);
    $stmt6->execute();
    $row6 = $stmt6->fetch(PDO::FETCH_ASSOC);
    ?>

    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=group_overview"> Groep Overzicht</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=payment&groupid=<?= $row['groupid'] ?>"> betalingen Overzicht</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="php/loguit.php">Uitloggen</a>
            </li>
        </ul>
    </nav>

<?php } ?>