<?php
require_once('starsess.php');
require_once('allvars.php');
$userid=$_SESSION['userid'];
$com_text=$_POST['com_text'];
$postid=$_POST['postid'];
$posterid=$_POST['posterid'];
$dbc=mysqli_connect(DB_ADDR,DB_USER,DB_PASS,DB_NAME) or die('error to connect');

$query="INSERT INTO  comments (postid,posterid,commenterid,comment,date) VALUES ('$postid','$posterid','$userid','$com_text',NOW())";
$result=mysqli_query($dbc,$query) or die ('error to comment');

header("Location:like.php?pid=$postid");


?>