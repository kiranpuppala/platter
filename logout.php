<?php
require_once('allvars.php');
  session_start();

    $userid=$_SESSION['userid'];
$dbc=mysqli_connect(DB_ADDR,DB_USER,DB_PASS,DB_NAME);
$quer="DELETE FROM chat WHERE userid='$userid'";
mysqli_query($dbc,$quer)
or die ('error');
mysqli_close($dbc);
    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) {
      setcookie(session_name(), '', time() - 3600);
    }
    session_destroy();
  setcookie('userid', '', time() - 3600);
  setcookie('firstname', '', time() - 3600);
  $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
  header('Location: ' . $home_url);
?>
