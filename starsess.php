<?php
  session_start();

  // If the session vars aren't set, try to set them with a cookie
  if (!isset($_SESSION['userid'])) {
    if (isset($_COOKIE['userid']) && isset($_COOKIE['firstname'])) {
      $_SESSION['userid'] = $_COOKIE['userid'];
      $_SESSION['firstname'] = $_COOKIE['firstname'];
    }
  }
?>