<?php
require_once('starsess.php');
require_once('allvars.php');
if(isset($_SESSION['userid'])){
?>
<!DOCTYPE html>
<head>
<title>Find friends</title>
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

<div class="total col-7">
<!-- start of second column-->




<div class="sear_results">




<?php

$no_of_rows=0;
$friendid="";

require_once('starsess.php');
require_once('allvars.php');

$userid=$_SESSION['userid'];


if(isset($_GET['rowno']))
$no_of_rows=$_GET['rowno'];
else
$no_of_rows=10;


$dbc=mysqli_connect(DB_ADDR,DB_USER,DB_PASS,DB_NAME) or die('error connecting');
$query="SELECT * FROM friendrequests WHERE userid='$userid' LIMIT $no_of_rows";
$result=mysqli_query($dbc,$query) or die('error for friend requests');

while($row=mysqli_fetch_array($result)){
$friendid=$row['friendid'];

$query2="SELECT primage,firstname,secondname,country,place FROM candidates WHERE userid='$friendid'";
$result2=mysqli_query($dbc,$query2) or die('error 2');

$row2=mysqli_fetch_array($result2);

echo '<img class="uploader_pic" src="images/'.$row2['primage'].'" alt="no image">';
echo '<br>';
echo '<p class="friend_name">'.$row2['firstname'].'&nbsp&nbsp'.$row2['secondname'].'<br>
<br><span style="font-weight:bold;opacity:.7">'.$row2['place'].',&nbsp'.$row2['country'].'</span></p>';
echo '<div class="send_reque">';

echo '<a href="deleterequest.php?id='.$friendid.'"><span class="decline_icon">&nbsp</span>Delete request</a>';
echo '<a href="viewprofile.php?id='.$friendid.'">View details</a>';

echo '</div>';
echo '<hr class="sear_hr">';
}

echo '<div class="show_more_posts"><a  href="sentrequests.php?rowno='.($no_of_rows+10).'">show more</a></div>';
?>





</div>

<!--end of second column-->
</div>

</body>
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




.sear_results img.uploader_pic{
width:100px;
height:100px;
border-radius:1000px;
float:left;
display:block;
}

.sear_results img.uploaded_pic{
float:left;
margin:auto;
display:block;
}



.sear_results p.friend_name{
float:left;
color:#54696d;
font-weight:bold;
padding-left:20px;
}

.sear_results hr{
margin-top:100px;
height:3px;
background:#54696d;
//clear:both;
}

.send_reque{
margin-top:30px;
margin-right:5%;
float:right;

}

.send_reque  a{

text-decoration:none;
background:#54696d;
color:#fff;
//width:100%;
padding:10px;
margin-left:5px;
font-size:15px;
border-radius:10px;
transition: .3s;
}

.send_reque a:hover{
opacity:.5;
}

.send_req_icon:before{ content:"\271A";color:#F26522;}
.decline_icon:before{content:"\2718";color:#F26522;}


input{
//width:100%;
padding:12px 20px;
margin:8px 0;
box-sizing:border-box;
font-family:"Century Gothic";
}

input[type="text"]{
width:100%;
color:#54696d;
font-weight:bold;
border-style:ridge;
border-width:1px;
border-opacity:.5;
}

.findfrien input[type="text"]{
width:90%;
color:#54696d;
font-weight:bold;
border-style:ridge;
border-width:1px;
border-opacity:.5;
}

input[type="submit"]{
background-color:#54696d;
color:#fff;
border:0px;
border-radius:10px;
transition:.3s;
font-weight:bold;
}
input[type="submit"]:hover{
//box-shadow:0 8px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
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

.topnav img{

margin-left:20px;
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
.findfrien{box-shadow:0 0px 0px 0 rgba(0,0,0,0),0 0px 0px 0 rgba(0,0,0,0);padding:0px;}


.sear_results{
box-shadow:0 0px 0px 0 rgba(0,0,0,0),0 0px 0px 0 rgba(0,0,0,0);
margin-top:7px;
padding:0px;
border-radius:0px;
line-height:70%;
}

.sear_results img.uploader_pic{
width:50px;
height:50px;
}

.sear_results img.uploaded_pic{
float:left;
margin:auto;
display:block;
}



.sear_results p.friend_name{
float:left;
color:#434343;
font-weight:bold;
margin-top:0px;
padding-left:20px;
}

.sear_results hr{
margin-top:110px;
clear:both;
}

.send_reque{
margin-top:30px;
float:left;
}

.send_reque  a{
padding:5px;
margin-left:5px;
font-size:15px;
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
.show_more_posts a{
background:#F26522;
margin-right:5%;
float:right;
text-decoration:none;
color:#fff;
padding:10px;
margin-left:5px;
font-size:15px;
transition:.3s;
border-radius:10px;
}
.show_more_posts a:hover{
opacity:.5;
transition:.3s;
}
</style>
</html>
<?php
}
else{
header("Location:index.php");
}
?>
