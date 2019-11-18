<?php
include ('connection.php');
 
$id = $_GET['id'];
$sql=($conn,"delete * from events where id = '$id' ");

?>