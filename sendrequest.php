﻿<?php
require_once('allvars.php');
require_once('starsess.php');

$userid=$_SESSION['userid'];
$friendid=$_GET['id'];

$dbc=mysqli_connect(DB_ADDR,DB_USER,DB_PASS,DB_NAME)
or die('Error connecting to MySQL server.');
$query="INSERT INTO friendrequests (userid,friendid,requeststatus,date) VALUES ('$userid','$friendid',0,NOW()) ";
$result=mysqli_query($dbc,$query)
or die('Error1 querying database.');

header("Location:findfriends.php");
?>