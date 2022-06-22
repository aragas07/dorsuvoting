<?php
    include('DBConnection.php');
    global $conn;
    $getCount = $conn->query("SELECT count(*) AS total FROM vote WHERE candidate_id='".$_POST['studid']."' GROUP BY candidate_id");
    while($row = $getCount->fetch_assoc()){
        echo $row['total'];
    }
?>