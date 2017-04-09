<?php 

require_once('starsess.php');
require_once('allvars.php');

$userid=$_SESSION['userid'];
$friendid=$_GET['id'];

/////////////////////////////////////setting seen field to one////////////////////////////

$dbc=mysqli_connect(DB_ADDR,DB_USER,DB_PASS,DB_NAME)
or die('Error connecting to MySQL server.');
$query="UPDATE mess SET seen=1 WHERE toid='$userid' AND fromid='$friendid'";
$result=mysqli_query($dbc,$query) or die('error query for seen');



header("Location:messaging.php?id=$friendid");

?>