<?php
require_once('starsess.php');
if(isset($_SESSION['userid'])){
?>
<!DOCTYPE html>
<head>
<title>View post</title>
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
<div class="yourfriends"><b>View Post</b></div>


<?php

require_once('starsess.php');
require_once('allvars.php');
$userid=$_SESSION['userid'];
$postid=$_GET['pid'];

if(isset($_GET['s'])){
$like_status=$_GET['s'];
}
else $like_status='n';


$posterid="";
$posttext="";
$date="";
$pimage="";
$no_of_likes="";
$already_liked=0;
$comment="";
$commenterid="";
$no_of_rows=0;

if(isset($_GET['rowno']))
$no_of_rows=$_GET['rowno'];

else
$no_of_rows=15;



$dbc=mysqli_connect(DB_ADDR,DB_USER,DB_PASS,DB_NAME) or die('error to connect');



$query="SELECT * FROM post WHERE rowid='$postid'";
$result=mysqli_query($dbc,$query) or die ('error to posterid');

$row=mysqli_fetch_array($result);
$posterid=$row['posterid'];
$posttext=$row['posttext'];
$date=$row['date_time'];
$pimage=$row['pimage'];


$query1="SELECT * FROM likes WHERE  postid='$postid' AND likerid ='$userid'";
$result1=mysqli_query($dbc,$query1) or die ('error for no of likes');

if(mysqli_num_rows($result1)==0&&$userid!=0&&$like_status=='y'){
$query2="INSERT INTO likes (postid,posterid,likerid) VALUES ('$postid','$posterid','$userid')";
$result2=mysqli_query($dbc,$query2) or die ('error to like');
}




$query3="SELECT firstname,secondname,primage FROM candidates WHERE userid='$posterid'";
$result3=mysqli_query($dbc,$query3) or die ('error for candidate details');

$row3=mysqli_fetch_array($result3);

/***USED IF POSTER SHOULD NOT LIKE A PHOTO POSTED BY HIMSELF
//$query4="SELECT * FROM likes WHERE  postid='$postid' AND likerid !='$posterid'";
*******/

$query4="SELECT * FROM likes WHERE  postid='$postid'";
$result4=mysqli_query($dbc,$query4) or die ('error for no of likes');


$no_of_likes=mysqli_num_rows($result4);


echo '<div class="public_posts ">';
echo '<img class="uploader_pic" src="images/'.$row3['primage'].'" alt="no image">';
echo '<p class="poster_name">'.$row3['firstname'].'&nbsp&nbsp'.$row3['secondname'].'</p>';
echo '<p class="posted_time">'.$date.'</p>';
echo '<hr class="title_hr">';
echo '<p class="post_description">'.$posttext.'</p>';
if($pimage!="")
echo '<img class="uploaded_pic" src="postimages/'.$pimage.'" alt="no image">';
echo '<br>';


echo '<p><a style="color:#F26522" href="likedpeople.php?pid='.$postid.'">'.$no_of_likes.' people</a> likes this post</p>';
 
echo '<form action="comment.php" method="post">';
echo '<input name="com_text" type="text" placeholder="This post is like...">';
echo '<input name="postid" style="display:none" type="text" value="'.$postid.'">';
echo '<input name="posterid"  style="display:none" type="text" value="'.$posterid.'">';
echo '<input type="submit" name="submit_comment" class="submit"  value="comment">';
echo '<hr>';
$query5="SELECT * from comments WHERE postid='$postid' ORDER BY date DESC LIMIT $no_of_rows";
$result5=mysqli_query($dbc,$query5) or die ('error for whole comment list');


while($row5=mysqli_fetch_array($result5)){

$comment=$row5['comment'];
$commenterid=$row5['commenterid'];

$query6="SELECT firstname,secondname,primage FROM candidates WHERE userid='$commenterid'";
$result6=mysqli_query($dbc,$query6) or die('error query6');

$row6=mysqli_fetch_array($result6);


echo '<div class="sender_title">';
echo '<img class="uploader_pic" src="images/'.$row6['primage'].'" alt="no image">';
echo '<p class="friend_name">'.$row6['firstname'].'&nbsp&nbsp'.$row6['secondname'].'<br>';
echo '<br><span style="opacity:.7">'.$comment.'</span></p>';
echo '</div>';

}


echo '<div class="loadearlier"><a  href="like.php?pid='.$postid.'&rowno='.($no_of_rows+10).'">Load earlier</a></div><br>';

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
}

.public_posts img.uploader_pic{
width:70px;
height:70px;
border-radius:1000px;
float:left;
display:block;
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
