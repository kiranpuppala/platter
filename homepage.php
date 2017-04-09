<?php
require_once('starsess.php');
if(isset($_SESSION['userid'])){
?>
<!DOCTYPE html>
<head>
<title>srkr network home page</title>
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

function dispname(){
var a=document.getElementById("pimage").value;
document.getElementById("filenam").innerHTML=a;
}

</script>



</head>
<body>

<!--<div class="logo">
<img src="logo.png" alt="no image" width="180px" height="46px">-->
<ul class="topnav" id="myTopnav">
<li><img style="margin-top:10px" src="images/platterlogin.png" alt="no image" width="150px" height="45px"></li>
<li style="visibility:hidden">Hidden field for space only for space.It gives more  simplifies.Some some some some some </li>
  <li><a class="logout" href="logout.php">log out</a></li>
     <li><a class="old" href="oldstuff.php">old stuff</a></li>
  <li><a class="wiki" href="#">app</a></li>
  <li><a class="friends" href="friends.php">friends</a></li>
  <li><a class="inbox" href="inbox.php">inbox</a></li>
  <li id="on"><a href="online.php">online</a></li>
  <li id="fr"><a href="friendrequests.php">friend requests</a></li>
  <li id="ep"><a href="editprof.php">edit profile</a></li>
  <li id="wh"><a href="whatshot.php">what's hot</a></li>
 <li class="icon">
    <a href="javascript:void(0);" style="font-size:15px;" onclick="myFunction()"><span style="font-size:20px">≡</span></a>
  </li>
</ul>
<!--</div>-->
<!--☰≡\2718 \271A home1022427F0  inbox 99932709  telephone260e  call2706-->

<div class="empty_space"></div>

<div class="column1 col-2">
<!-- start of column-->
<?php
require_once('allvars.php');
require_once('starsess.php');
$userid=$_SESSION['userid'];

$dbc=mysqli_connect(DB_ADDR,DB_USER,DB_PASS,DB_NAME)
or die('Error connecting to MySQL server.');

$query="SELECT * FROM candidates WHERE userid='$userid'";
$result=mysqli_query($dbc,$query) or die ('Error querying for profile details');

$row_pdetails=mysqli_fetch_array($result);

echo '<div class="profile_details ">';
echo '<p><b>My details</b></p>';
echo '<img src="images/'.$row_pdetails['primage'].'">';
echo '<hr>';
echo '<p style="opacity:.7">'.$row_pdetails['firstname'].' '.$row_pdetails['secondname'].'<br>'.$row_pdetails['place'].', '.$row_pdetails['country'].'<br>'.$row_pdetails['date'].'</p>';
echo '</div>';

mysqli_close($dbc);
?>

<div class="photos_edit_list ">
<a class="edit_icon" href="editprof.php">Edit Profile</a>
<a href="#">My Photos</a>
</div>
<!--End of first column-->
</div>

<div class="column2 col-7">
<!-- start of second column-->

<div class="findfrien">
<form  action="findfriends.php" method="post">
<input name="findfrien" type="text" placeholder="Find a friend">
<input class="submit" type="submit" value="Find"  name="submit_find_friend">
</form>
</div>





<div class="post ">
<p style="opacity:.7">What's on your mind</p>
<form enctype="multipart/form-data" action="postredirect.php" method="post">
<input class="un" name="posttext" type="text" placeholder="Post here" >
<div class="upld_img fileUpload">


<!--<p>Upload image file:</p>-->

<!--<div class="custom-file-upload">-->

<input id="pimage" name="pimage" type="file"  >

<!--</div>-->
<div id="filenam"></div>


</div>


<input class="submit" type="submit" style="float:right" value="Post" name="submit_post">
</form>
</div>




<?php
require_once('allvars.php');
$emailaddr="";
$no_of_rows=0;
$no_of_likes=0;
$chatter_id=0;
$friendid=0;

if(isset($_GET['rowno']))
$no_of_rows=$_GET['rowno'];
else
$no_of_rows=10;


$dbc=mysqli_connect(DB_ADDR,DB_USER,DB_PASS,DB_NAME)
or die('Error connecting to MySQL server.');

$query="SELECT * FROM post ORDER BY date_time DESC LIMIT $no_of_rows";
$result=mysqli_query($dbc,$query) or die ('Error querying database');


while($row=mysqli_fetch_array($result)){

$date=$row['date_time'];
$full_date=$date;
$date=date('M. j, y', strtotime($date));
$tme = date('h:i A', strtotime($full_date));


$current_email=$row['emailaddr'];
$qry_fr_pr_pic="SELECT primage FROM candidates WHERE emailaddr='$current_email' ";
$result_prpic=mysqli_query($dbc,$qry_fr_pr_pic);
$row_prpic=mysqli_fetch_array($result_prpic);

$postno=$row['rowid'];

$query_likes="SELECT * FROM likes WHERE postid='$postno'";
$result_likes=mysqli_query($dbc,$query_likes) or die('error no of likes');



echo '<div class="public_posts ">';


echo '<img class="uploader_pic" src="images/'.$row_prpic['primage'].'" alt="no image">';
echo '<p class="poster_name">'.$row['name'].'</p>';
echo '<p class="posted_time">'.$date.' '.$tme.'</p>';
echo '<hr>';
echo '<p class="post_description">'.$row['posttext'].'</p>';
if($row['pimage']!=""){

echo '<img style="image-orientation: from-image;" class="uploaded_pic" src="postimages/'.$row['pimage'].'" alt="no image">';
}
echo '<div class="like_comment">';
echo '<a href="like.php?pid='.$row['rowid'].'&s=y"><span class="redheart"> Like </span></a>';
echo '<a href="like.php?pid='.$row['rowid'].'&s=n"><span class="pen_sym">Comment</span></a>';
echo '<a style="color:#F26522" href="likedpeople.php?pid='.$row['rowid'].'">'.mysqli_num_rows($result_likes).' <span style="color:white">likes</span></a>';
echo '</div>';

echo '</div>';
}

echo '<div class="show_more_posts"><a  href="homepage.php?rowno='.($no_of_rows+10).'">show more</a></div>';
mysqli_close($dbc);

?>





<!--end of second column-->
</div>

<div class="column3 col-2">
<!-- start of third column-->

<div class="new_event ">
<p><b>What's Hot</b></p>

<?php



require_once('allvars.php');
require_once('starsess.php');
$userid=$_SESSION['userid'];

$dbc=mysqli_connect(DB_ADDR,DB_USER,DB_PASS,DB_NAME)
or die('Error connecting to MySQL server.');
$query="SELECT eventday,eventtext,pimage,date FROM eventdetails ORDER BY date DESC";
$result=mysqli_query($dbc,$query) or die('error whats hot');

$row=mysqli_fetch_array($result);

echo '<img src="images/'.$row['pimage'].'" alt="no image">';
echo '<p style="opacity:.7">'.$row['eventday'].'<br>'.$row['eventtext'].'</p>';

?>


</div>

<div class="friend_request">
<?php
require_once('starsess.php');
require_once('allvars.php');

$userid=$_SESSION['userid'];
$senderid=0;

$dbc=mysqli_connect(DB_ADDR,DB_USER,DB_PASS,DB_NAME)
or die('Error connecting to MySQL server.');


$query="SELECT * FROM friendrequests WHERE friendid='$userid' AND requeststatus=0  ORDER BY date DESC LIMIT 1";
$result=mysqli_query($dbc,$query) or die ('Error querying database for request');
$row=mysqli_fetch_array($result);

$senderid=$row['userid'];

$query="SELECT firstname,secondname,primage FROM candidates WHERE userid='$senderid'";
$result=mysqli_query($dbc,$query) or die ('Error querying database for request');
$row=mysqli_fetch_array($result);

echo '<p><b>Friend Requests</b></p>';

if(mysqli_num_rows($result)==0){
echo '<p style="opacity:.7">No friend requests yet</p>';
echo '<div class="accept_decline">';
echo '<a href="sentrequests.php">View sent requests</a>';
echo '</div>';
}
else{
echo '<img src="images/'.$row['primage'].'" alt="no image">';
echo '<p style="opacity:.7">'.$row['firstname'].'&nbsp&nbsp'.$row['secondname'].'</p>';
echo '<hr>';
echo '<div class="accept_decline">';
echo '<a href="friendapproval.php?id='.$senderid.'&status=1"><span style="color:#F26522">&#10004&nbsp</span>Accept</a>';
echo '<a style="margin-left:2px" href="friendapproval.php?id='.$senderid.'&status=0"><span class="decline_icon">&nbsp</span>Decline</a><br><br>';
echo '<a href="friendrequests.php">Show More</a>';
echo '</div>';
}

echo '</div>';

echo '<div class="chats">';

echo '<p><b>Online</b></p>';

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

$query3="SELECT firstname,secondname FROM candidates WHERE userid='$friendid'";
$result3=mysqli_query($dbc,$query3) or die('error chat 3');
$row3=mysqli_fetch_array($result3);
echo '<p><a style="text-decoration:none;opacity:.7;color:#54696d;" href="messaging.php?id='.$friendid.'">'.$row3['firstname'].'&nbsp&nbsp'.$row3['secondname'].'</a></p>';
}
}

}

echo '</div>';


mysqli_close($dbc);
?>


<!--end of third column-->
</div>




<div class="column4 col-12">

<p style="margin:auto;color:white;font-family:arial;text-align:center;font-weight:lighter;margin-top:110px">&copy 2016-17</p>
<p style="margin:auto;color:white;font-family:arial;text-align:center;font-weight:lighter;margin-top:10px">Platter,Inc. Bhimavaram</p>
<p style="margin:auto;color:white;font-family:arial;text-align:center;font-weight:lighter;margin-top:10px">All rights reserved.</p>
</div>

<div class="column5 col-12">
<p style="margin:auto;text-align:center;padding-top:10px;color:#fff;font-family:arial;font-weight:lighter">Contact us at</p>
<hr style="width:30%;margin:auto">
<div style="width:50%;float:left">
<a  style="text-decoration:none" href="http://www.facebook.com/platterpeople"><p class="fb">f</p></a>
</div>

<div style="width:50%;float:left">
<a  style="text-decoration:none" href="https://plus.google.com/u/0/107537932943509859076" ><p class="email"><span style="font-size:30px">G+</span></p></a>
</div>


</div>




</body>
<style>



input[type="file"] {

}

.custom-file-upload {
    border: 1px solid #ccc;
    display: inline-block;
    padding: 5px 10px;
    cursor: pointer;
font-size:10px;
}

label:hover{
transition:.3s;
background-color:#F26522;
color:white;
}

#filenam{
color:#F26522;
font-size:10px;
}




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



.column1{
float:left;

}






.column2{
float:left;
padding-left:3.5%;
}

.column3{
float:left;
padding-left:2%;
}

.column4{
float:left;
background:#54696d;
height:300px;
}


.column5{
float:left;
background:#F26522;
height:120px;
}


.pen_sym:before               { content: "\270E";color:#F26522; }

.edit_icon:before {content: "\270E"; }

.accept_icon:before{ content:"\271A";color:#F26522;}
.decline_icon:before{content:"\2718";color:#F26522;}



.redheart:before { content:"\2764";color:#F26522;}
//\2764

//.redheart {color:#F26522; font-size:15px;
  //    font-family:'arial unicode MS', arial, geneva, sans-serif; }


.profile_details{
background:#fff;

margin-top:0px;
margin-left:10px;
padding:20px;
float:left;
width:100%;
border-radius:2px;
text-align:center;
}

.profile_details p{
line-height:180%;
}


.profile_details img {
width:100px;
height:100px;
border-radius:1000px;
margin:auto;
display:block;
}


.fb{
 border-radius: 50%;
    behavior: url(PIE.htc); /* remove if you don't care about IE8 */
    width: 36px;
    height: 36px;
    padding: 8px;
    background: #fff;;
    //border: 2px solid #666;
    color: #fff;
    text-align: center;
    font: 32px Arial, sans-serif;
margin-left:80%;
color:#F26522;

}

.email{
 border-radius: 50%;
    behavior: url(PIE.htc); /* remove if you don't care about IE8 */
    width: 36px;
    height: 36px;
    padding: 8px;
margin-bottom:30px;
    background: #fff;;
    //border: 2px solid #666;
    color: #fff;
    text-align: center;
    font: 32px Arial, sans-serif;
margin-left:10%;
color:#F26522;


}
.fb:hover{
background:#5590CC;
color:white;
transition:.3s;
}

.email:hover{
color:#fff;
background:#DB4439;
transition:.3s;
}



.img {
image-orientation:from-image;
 }




.photos_edit_list{
background:#fff;
//box-shadow:0 8px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
margin-top:7px;
margin-left:10px;
padding:20px;

float:left;
width:100%;
border-radius:2px;
text-align:center;
}

.photos_edit_list a{
text-decoration:none;
background:#54696d;
color:#fff;
width:100%;
border-radius:10px;
transition: .3s;
padding:10px;
}

.photos_edit_list a:hover{
opacity:.5;
}

.post{
background:#fff;
//box-shadow:0 8px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
margin-top:7px;
margin-left:10px;
padding:10px;
float:left;
width:100%;
border-radius:2px;
}

.findfrien{
background:#fff;
//box-shadow:0 8px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
margin-top:0px;
margin-left:10px;
padding:10px;
float:left;
width:100%;
border-radius:2px;
}


.public_posts{
background:#fff;
//box-shadow:0 8px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
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
margin:auto;
display:block;
width:auto;
height:auto;
max-width:400px;
max-height:500px;
}

.public_posts p.posted_time{
float:right;
opacity:.7;
padding-right:20px;
}

.public_posts p.post_description {
opacity:.7;
}

.public_posts p.poster_name{
float:left;
color:#54696d;
font-weight:bold;
padding-left:20px;
}

.public_posts hr{
margin-top:100px;
height:3px;
background:#54696d;
//clear:both;
}

.like_comment{
margin-top:20px;
margin-left:0px;
float:left;
width:100%;
}
.like_comment a{
margin-left:5px;
border-radius:10px;
}

.show_more_posts{
text-align:center;
width:100%;

}

.show_more_posts a{
text-decoration:none;
background:#54696d;
color:#fff;
width:100%;
padding:5px;
margin-top:20px;
color:#fff;
border-radius:10px;
transition: .3s;
}
.show_more_posts a:hover{
opacity:.5;
//box-shadow:0 8px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
}
.like_comment a{
text-decoration:none;
background:#54696d;

transition: .3s;
color:#fff;
width:100%;
padding:5px;
}

.like_comment a:hover{
//box-shadow:0 8px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
opacity:.5;




}

.new_event{
background:#fff;
//box-shadow:0 8px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
margin-top:0px;
margin-left:10px;
padding:10px;
float:left;
width:100%;
border-radius:2px;
text-align:center;
}

.new_event img {
margin:auto;
display:block;
}




.new_event p{
line-height:180%;
}

.friend_request{
background:#fff;
//box-shadow:0 8px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
margin-top:7px;
margin-left:10px;
padding:10px;
float:left;
width:100%;
border-radius:2px;
text-align:center;
}

.friend_request img {
margin:auto;
display:block;
}
.friend_request p{
line-height:180%;
}

.accept_decline{
margin-top:15px;
}

.accept_decline a{
margin-top:15px;
text-decoration:none;
background:#54696d;
color:#fff;
width:100%;
padding:5px;
transition:.3s;
border-radius:10px;
}

.accept_decline a:hover{
//box-shadow:0 8px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
opacity:.5;

}


.chats{
background:#fff;
//box-shadow:0 8px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
margin-top:7px;
margin-left:10px;
padding:10px;
float:left;
width:100%;
border-radius:2px;
text-align:center;
}

.chats p:after {
    content: ' \25CF';
    font-size: 20px;
    color:#5f5;
}

.upld_img p{
width:20%;
float:left;
}
.upld_img input[type="file"]{
width:70%;
float:left;
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

    box-sizing: border-box;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;

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

ul.topnav li {
float: left;
}

ul.topnav li a {
margin-top:3px;
  display: inline-block;
  color: #f2f2f2;
  font-weight:bold;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  transition: 0.3s;
  font-size: 17px;
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
.public_posts img.uploader_pic{padding-left:5px}
.public_posts p.posted_time{float:right;padding-right:5px}
.public_posts p.poster_name{padding-left:5px}
.public_posts hr{padding-left:5px;padding-right:5px}

.post_description{padding-left:5px}

.fb{
margin-left:60%;
}

.public_posts img.uploaded_pic{
margin:auto;
display:block;
width:100%;
height:auto;
max-height:500px;

}



.public_posts{box-shadow:0 0px 0px 0 rgba(0,0,0,0),0 0px 0px 0 rgba(0,0,0,0);margin-left:0px;padding:0px;border-radius:0px;margin-bottom:7px;}
.findfrien{
box-shadow:0 0px 0px 0 rgba(0,0,0,0),0 0px 0px 0 rgba(0,0,0,0);margin-left:0px;padding:0px;border-radius:0px;
}
.post{
box-shadow:0 0px 0px 0 rgba(0,0,0,0),0 0px 0px 0 rgba(0,0,0,0);margin-left:0px;padding:0px;border-radius:0px;
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
    //height: auto;
}

.many_likes a:hover{
opacity:1;
}

</style>
</html>
<?php
}
else{
header("Location:index.php");
}
?>
