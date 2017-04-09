<?php
require_once('starsess.php');
if(isset($_SESSION['userid'])){
?>
<!DOCTYPE html>
<head>
<title>Likers</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="screen.css" type="text/css" media="screen"/>
</head>
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

<div class="total col-7">
<div class="yourfriends"><p><b>Online</b></p></div>

<div class="sear_results">


<?php

require_once('allvars.php');
require_once('starsess.php');
$userid=$_SESSION['userid'];


$dbc=mysqli_connect(DB_ADDR,DB_USER,DB_PASS,DB_NAME)
or die('Error connecting to MySQL server.');

$query1="SELECT userid FROM chat";
$result1=mysqli_query($dbc,$query1) or die('error for chats');

while($row1=mysqli_fetch_array($result1)){

$chatter_id=$row1['userid'];

$query2="SELECT userid,friendid FROM friends WHERE userid='$userid' OR friendid='$userid'";
$result2=mysqli_query($dbc,$query2) or die('error chat2 ');

while($row2=mysqli_fetch_array($result2)){

if(($row2['userid']==$userid)||($row2['friendid']==$userid))
{
}

if($row2['userid']!=$userid){
$friendid=$row2['userid'];
}

if($row2['friendid']!=$userid){
$friendid=$row2['friendid'];
}

if($friendid==$chatter_id){

$query3="SELECT firstname,secondname,primage FROM candidates WHERE userid='$friendid'";
$result3=mysqli_query($dbc,$query3) or die('error chat 3');
$row3=mysqli_fetch_array($result3);

echo '<div class="sender_title">';
echo '<img class="uploader_pic" src="images/'.$row3['primage'].'" alt="no image">';
echo '<p class="friend_name"><a style="text-decoration:none;opacity:.7;color:#54696d;" href="messaging.php?id='.$friendid.'">'.$row3['firstname'].'&nbsp&nbsp'.$row3['secondname'].'</a></p><br>';
echo '<hr>';
}
}

}




echo '</div>';

?>





</div>





<style>
body{
//background:#DAE5F3;
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

.yourfriends{
text-align:center;
}

.yourfriends p:after {
    content: ' \25CF';
    font-size: 20px;
    color:#5f5;
}

.findfrien{
background:#fff;

margin-top:0px;
padding:10px;
float:left;
width:100%;
border-radius:2px;
}

.sear_results{
background:#fff;

margin-top:7px;
padding:10px;
float:left;
width:100%;
border-radius:2px;
line-height:100%;
}


.sender_title{

margin:auto;
}

.sender_title img.uploader_pic{
width:30px;
height:30px;
border-radius:1000px;
float:left;
display:block;
}

.sender_title p.friend_name{
float:left;
color:#54696d;
font-weight:bold;
padding-left:10px;
margin-top:7px;
width:50%;
}

.sear_results hr{
clear:both;
height:3px;
background-color:#54696d;
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

.findfrien input[type="text"]{
width:90%;
border-style:ridge;
border-width:1px;
border-opacity:.5;
}

input[type="submit"]{
transition:.3s;
background-color:#54696d;
color:#fff;
border:0px;
border-radius:10px;
}
input[type="submit"]:hover{
opacity:.5;
}


//.post:after,.new_event:after,.profile_details:after,picture_edit_list:after
//{content:"";display:table;clear:both}








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



.sear_results{

box-shadow:0 0px 0px 0 rgba(0,0,0,0),0 0px 0px 0 rgba(0,0,0,0);
margin-top:7px;
padding:0px;
border-radius:0px;
}

.sear_results hr{
clear:both;
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

.topnav img{
margin-left:20px;
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
