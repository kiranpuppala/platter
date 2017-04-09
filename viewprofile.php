<?php
require_once('starsess.php');
if(isset($_SESSION['userid'])){
?>
<!DOCTYPE html>
<head>
<title>View profile</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="screen.css" type="text/css" media="screen"/>

<script>
function myFunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
   x.className += " responsive";
document.getElementById("wh").style.display="block";
document.getElementById("fr").style.display="block";
document.getElementById("ep").style.display="block";
document.getElementById("on").style.display="block";
    } else {
     x.className = "topnav";
document.getElementById("wh").style.display="none";
document.getElementById("fr").style.display="none";
document.getElementById("ep").style.display="none";
document.getElementById("on").style.display="none";
    }
}
window.onresize = displayWindowSize;
    window.onload = displayWindowSize;

    function displayWindowSize() {
        myWidth = window.innerWidth;
        myHeight = window.innerHeight;

if(myWidth>680){
document.getElementById("wh").style.display="none";
document.getElementById("fr").style.display="none";
document.getElementById("ep").style.display="none";
document.getElementById("on").style.display="none";
}
}
</script>



</head>

<body>


<ul class="topnav" id="myTopnav">
<li><img style="margin-top:10px" src="images/platterlogin.png" alt="no image" width="150px" height="45px"></li>
<li style="visibility:hidden">Hidden field for space only for space.It gives more  simplifies.Some some some some some some so</li>
<li><a href="homepage.php">home</a></li>
  <li><a class="logout" href="logout.php">log out</a></li>
  <li><a class="wiki" href="#">app</a></li>
  <li><a class="friends" href="friends.php">friends</a></li>
  <li><a class="inbox" href="inbox.php">inbox</a></li>
  <li id="on"><a href="online.php">online</a></li>
<li id="fr"><a href="friendrequests.php">friend requests</a></li>
  <li id="ep"><a href="editprof.php">edit profile</a></li>
  <li id="wh"><a href="whatshot.php">what's hot</a></li>
 <li class="icon">
    <a href="javascript:void(0);" style="font-size:15px;" onclick="myFunction()">☰</a>
  </li>
</ul>

<div class="empty_space"></div>


<?php

require_once('starsess.php');
require_once('allvars.php');
$friend_id=$_GET['id'];
$db=mysqli_connect(DB_ADDR,DB_USER,DB_PASS,DB_NAME)
or die('Error connecting to MySQL server.');
$quer="SELECT * FROM candidates WHERE userid='$friend_id' ";
$info=mysqli_query($db,$quer) or die ('error for details');
$row_info=mysqli_fetch_array($info);

echo '<div class="total col-5">';
echo '<div class="edit_prof">';
echo '<p><b>'.$row_info['firstname'].'&nbsp&nbsp'.$row_info['secondname'].'</b></p>';
echo '<img src="images/'.$row_info['primage'].'">';
echo '<hr>';

echo '<p><b>Name:</b><span style="opacity:.7">&nbsp&nbsp'.$row_info['firstname'].'&nbsp&nbsp'.$row_info['secondname'].'</style></p>';

echo '<p><b>Gender:</b><span style="opacity:.7">&nbsp&nbsp'.$row_info['gender'].'</span></p>';

echo '<p><b>DOB:</b><span style="opacity:.7">&nbsp&nbsp'.$row_info['date'].'</style></p>';

echo '<p><b>Place:</b><span style="opacity:.7">&nbsp&nbsp'.$row_info['place'].'</span></p>';

echo '<p><b>Country:</b><span style="opacity:.7">&nbsp&nbsp'.$row_info['country'].'</span></p>';

echo '<p><b>Email:</b><span style="opacity:.7">&nbsp&nbsp'.$row_info['emailaddr'].'</span></p>';

echo '</div>';
echo '</div>';


echo '</body>';

mysqli_close($db);
?>
<style>
body{
background:#dfe7e9;
font-family:"Century Gothic";
color:#54696d;
  font-weight:bold;
}

.empty_space{
height:10px;
}


.total {
  margin-left: auto ;
  margin-right: auto ;
}

.edit_prof{
background:#fff;

margin-top:0px;
margin-left:10px;

padding:20px;
//float:left;
width:100%;
border-radius:2px;
text-align:center;
}

.edit_prof p{
line-height:180%;
}

hr{
height:3px;
background-color:#54696d;
}


.edit_prof img {
width:100px;
height:100px;
border-radius:1000px;
margin:auto;
display:block;
}


input{
//width:100%;
padding:12px 20px;
margin:8px 0;
box-sizing:border-box;
font-family:"Century Gothic";
}

input[type="text"]{
width:100%;
border-style:ridge;

border-width:1px;
border-opacity:.5;
}

input[type="button"]{
background-color:#434343;
color:#fff;
border:0px;
}
input[type="button"]:hover{
box-shadow:0 8px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
border:0px;
}


/*for mobile phones*/
@media only screen and (max-width: 500px) {
    body {
margin:0;
padding:0;
    }

    [class*="col-"] {
        width: 100%;
    }

}
/************************************************************/
/*for desktop*/
@media only screen and (min-width: 500px) {
body{
margin:0;
padding:0;
}

.col-1 {width: 8.33%;}
.col-2 {width: 16.66%;}
.col-3 {width: 25%;}
.col-4 {width: 33.33%;}
.col-5 {width: 41.66%;}
.col-6 {width: 50%;}
.col-7 {width: 58.33%;}
.col-8 {width: 66.66%;}
.col-9 {width: 75%;}
.col-10 {width: 83.33%;}
.col-11 {width: 91.66%;}
.col-12 {width: 100%;}
.logo{position:fixed;}
}

/******************************************************************************/



.logo{
margin:0;
font-family:"Century Gothic";
background-color:#434343;

height:60px;
width:100%;
}

.logo img{
padding-top:12px;
}

body {margin:0;padding:0}
ul.topnav {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #54696d;
border-top:3px solid #F26522;
}

ul.topnav li {float: left;}

ul.topnav li a {
  display: inline-block;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  transition: 0.3s;
  font-size: 17px;
margin-top:3px;
}

.topnav img{
margin-left:20px;
}

ul.topnav li a:hover {background-color: #fff;color:#54696d;font-weight:bold;font-size:20px;}

ul.topnav li.icon {display: none;}

@media screen and (max-width:680px) {
  ul.topnav li:not(:first-child) {display: none;}
  ul.topnav li.icon {
    float: right;
    display: inline-block;
  }
.column1{display:none;}
.column3{display:none;}
.column2{padding-left:0;margin:auto;margin:auto;
display:block;float:none}
.post{margin-left:0}
.public_posts{margin-left:0}
.findfrien{margin-left:0}
.public_posts p.posted_time{float:right;padding-right:0px}
.public_posts p.poster_name{padding-left:5px}





.edit_prof{
box-shadow:0 0px 0px 0 rgba(0,0,0,0),0 0px 0px 0 rgba(0,0,0,0);
margin-top:0px;
margin-left:0px;
padding:0px;
width:100%;
border-radius:0px;
}

.edit_prof p{
line-height:180%;
}


}

@media screen and (max-width:680px) {
  ul.topnav.responsive {position: relative;}
  ul.topnav.responsive li.icon {
    position: absolute;
    right: 0;
    top: 0;
  }
  ul.topnav.responsive li {
    float: none;
    display: inline;
  }
  ul.topnav.responsive li a {
    display: block;
    text-align: left;
  }
}




img {
    max-width: 100%;

}
</style>
</html>
<?php
}
else{
header("Location:index.php");
}
?>