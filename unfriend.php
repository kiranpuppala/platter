
<?php
require_once('allvars.php');
require_once('starsess.php');

$userid=$_SESSION['userid'];
$friendid=$_GET['id'];

$dbc=mysqli_connect(DB_ADDR,DB_USER,DB_PASS,DB_NAME)
or die('Error connecting to MySQL server.');
$query="DELETE FROM  friendrequests WHERE userid='$friendid' AND friendid='$userid' OR friendid='$friendid' AND userid='$userid'";
$result=mysqli_query($dbc,$query)
or die('Error1 querying database.');

$query2="DELETE FROM friends WHERE userid='$friendid' AND friendid='$userid' OR friendid='$friendid' AND userid='$userid'";

$result2=mysqli_query($dbc,$query2) or die ('error 2');

header("Location:friends.php");
?>

