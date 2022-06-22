<?php

include('db/DBConnection.php');
global $conn;
if(!$conn->query("TRUNCATE student")){
    echo $conn->error;
}
?>