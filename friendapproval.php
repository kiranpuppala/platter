<?php
require_once('allvars.php');
require_once('starsess.php');
$userid=$_SESSION['userid'];
$senderid=$_GET['id'];
$status=$_GET['status'];

$dbc=mysqli_connect(DB_ADDR,DB_USER,DB_PASS,DB_NAME)
or die('Error connecting to MySQL server.');

if($status==1){
$query="UPDATE friendrequests SET requeststatus=1 WHERE  userid='$senderid' AND friendid='$userid'";
$result=mysqli_query($dbc,$query) or die ('Error querying');

$query="INSERT INTO friends (userid,friendid) VALUES ('$userid','$senderid')";
$result=mysqli_query($dbc,$query) or die('Error friends');


}
									
if($status==0){
$query="DELETE  FROM friendrequests WHERE userid='$senderid' AND friendid='$userid'";
$result=mysqli_query($dbc,$query) or die ('Error querying');
}
mysqli_close($dbc);
header("Location:homepage.php");     
?>                        