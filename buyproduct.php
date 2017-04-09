<?php
require_once('starsess.php');
if(isset($_SESSION['userid'])){
?>
<!DOCTYPE html>
<head>
<title>Product Info</title>
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
<div class="yourfriends"><b>Product Info</b></div>


<?php

require_once('starsess.php');
require_once('allvars.php');
$userid=$_SESSION['userid'];
$pid=$_GET['pid'];
$sid=$_GET['sid'];


$placerid="";
$no_of_rows=0;

if(isset($_GET['rowno']))
$no_of_rows=$_GET['rowno'];

else
$no_of_rows=15;



$dbc=mysqli_connect(DB_ADDR,DB_USER,DB_PASS,DB_NAME) or die('error to connect');



$query="SELECT * FROM placedsales WHERE rowid='$pid'";
$result=mysqli_query($dbc,$query) or die ('error to placerid');

$row=mysqli_fetch_array($result);
$placerid=$row['placerid'];
$date=$row['date'];
$full_date=$date;
$date=date('M. j, y', strtotime($date));
$tme = date('h:i A', strtotime($full_date));
//$date=date('F jS, Y', strtotime($date));
//date("M. j, y")


$query1="SELECT firstname,secondname,primage,place,emailaddr FROM candidates WHERE  userid='$placerid' ";
$result1=mysqli_query($dbc,$query1) or die ('error for no of likes');
$row1=mysqli_fetch_array($result1);

echo '<div class="public_posts ">';
echo '<img class="uploader_pic" src="images/'.$row1['primage'].'" alt="no image">';
echo '<p class="poster_name">'.$row1['firstname'].'&nbsp&nbsp'.$row1['secondname'].'</p>';
echo '<p class="posted_time">'.$date.'</p>';
echo '<hr class="title_hr">';
echo '<p class="post_description">'.$row['itemname'].'</p>';

echo '<img class="uploaded_pic" src="saleimages/'.$row['primage'].'" alt="no image">';
echo '<br>';
echo '<hr>';
echo '<p class="table_heading">Total info:</p>';
echo '<table class="product_info">
<tr><th>Seller name:</th><td>'.$row1['firstname'].'&nbsp&nbsp'.$row1['secondname'].'</td></tr>
<tr><th>Place:</th><td>'.$row1['place'].'</td></tr>
<tr><th>Date placed:</th><td>'.$date.' at '.$tme.'</td></tr>
<tr><th>Price:</th><td>'.$row['price'].'</td></tr>
<!--<tr><th>Seller mobile:</th><td>9989745889</td></tr>-->
<tr><th>Seller Email:</th><td>'.$row1['emailaddr'].'</td></tr>

</table>';



echo '</div>';




?>


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

.yourfriends{
text-align:center;
}

.public_posts{
background:#fff;

margin-top:7px;
margin-left:10px;
padding:10px;
float:left;
width:100%;
border-radius:2px;
font-size:15px;
}

.public_posts img.uploader_pic{
width:70px;
height:70px;
border-radius:1000px;
float:left;
display:block;
}

.public_posts img.uploaded_pic{

margin:auto;

display:block;
width:60%;
}

.public_posts p.posted_time{
float:right;
opacity:.7;
padding-right:20px;
}

.public_posts p.poster_name{
float:left;
color:#54696d;
padding-left:20px;
}


.public_posts p.post_description{
opacity:.7;
}

hr.title_hr{
margin-top:100px;
height:3px;
background-color:#54696d;
//clear:both;
}



.sender_title{

 clear:both;
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

padding-left:10px;
margin-top:7px;
width:50%;
}


.product_info{
margin:auto;
}

table td{
color:#F26522;
opacity:.7;
}
table th{
opacity:.7;
}
.table_heading{
text-align:center;
}





.loadearlier {
text-align:center;
clear:both;
}
.loadearlier a{
color:#548989;
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
color:#54696d;
font-weight:bold;
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



.public_posts{
box-shadow:0 0px 0px 0 rgba(0,0,0,0),0 0px 0px 0 rgba(0,0,0,0);
margin-top:7px;
margin-left:0px;
padding:0px;
float:left;
border-radius:0px;
}

.public_posts img.uploader_pic{
width:50px;
height:50px;
}

.public_posts img.uploaded_pic{
float:left;
margin:auto;
display:block;
width:100%;
}

.public_posts p.posted_time{
float:right;
opacity:.7;
padding-right:20px;
}

.public_posts p.poster_name{
padding-left:15px;
}

hr.title_hr{
margin-top:50px;
clear:both;
}

.sender_title{
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
