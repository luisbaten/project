<?php
include 'db_connect.php';
$qry = $conn->query("SELECT * FROM client_project_approval where id = ".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
	$$k = $v;
}
include 'new_donation.php';
?>