
<!DOCTYPE html>
<head>
<title>View profile</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="screen.css" type="text/css" media="screen"/>
</head>
<script>


window.onload=function(){
var a= <?php echo setseen();?> //call the php add function
}

/*window.onbeforeunload = function (e) {
  var a= <?php echo setseen();?> //call the php add function
}*/

</script>
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
var a=document.getElementById("mimage").value;
document.getElementById("filenam").innerHTML=a;
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


<?php 
function setseen(){
require_once('starsess.php');
require_once('allvars.php');

if(isset($_SESSION['userid']))
$userid=$_SESSION['userid'];

else
header("Location:index.php");

$friendid=$_GET['id'];

/////////////////////////////////////setting seen field to one////////////////////////////

$dbc=mysqli_connect(DB_ADDR,DB_USER,DB_PASS,DB_NAME)
or die('Error connecting to MySQL server.');
$query="UPDATE mess SET seen=1 WHERE toid='$userid' AND fromid='$friendid'";
$result=mysqli_query($dbc,$query) or die('error query for seen');
}

?>

<?php

require_once('starsess.php');
require_once('allvars.php');
$total_mess="";
$mess_offset="";
$set_earlier_off=0;
$userid=$_SESSION['userid'];
$friendid=$_GET['id'];

/////////////////////////////////////setting seen field to one////////////////////////////

$dbc=mysqli_connect(DB_ADDR,DB_USER,DB_PASS,DB_NAME)
or die('Error connecting to MySQL server.');




///////////////////////displaying all messages//////////////////////////////////////
if(isset($_GET['rowno'])){
$no_of_rows=$_GET['rowno'];
}
else
$no_of_rows=10;

$mess_oppo="";
$mess_own="";
$oppo_flag=0;
$own_flag=0;
$image_own="";
$image_oppo="";


$query="SELECT firstname,secondname,primage FROM candidates WHERE userid='$friendid'";
$result=mysqli_query($dbc,$query) or die ('error 1');



$row=mysqli_fetch_array($result);

echo '<div class="chatters">';
echo '<img src="images/'.$row['primage'].'">';
echo '<p class="you">You</p>';
echo '<p class="opponent">'.$row['firstname'].'&nbsp&nbsp'.$row['secondname'].'</p>';

echo '</div>';
echo '<br><br><br>';
echo '<hr>';


$query2="SELECT * FROM mess WHERE toid='$friendid' AND fromid='$userid' OR  toid='$userid' AND fromid='$friendid'  ORDER BY date ASC "; 
$result2=mysqli_query($dbc,$query2) or die ('error2');

$total_mess=mysqli_num_rows($result2);



$mess_offset=$total_mess-$no_of_rows;

if($mess_offset<0)
$mess_offset=0;

echo '<div class="loadearlier"><a  href="messaging.php?id='.$friendid.'&rowno='.($no_of_rows+10).'">Load earlier</a></div><br>';

echo '<br>';

$query3="SELECT * FROM mess WHERE toid='$friendid' AND fromid='$userid' OR  toid='$userid' AND fromid='$friendid'  ORDER BY date ASC LIMIT  $mess_offset, $no_of_rows "; 
$result3=mysqli_query($dbc,$query3) or die ('error3');


while($row3=mysqli_fetch_array($result3)){

if($row3['toid']==$userid){
$mess_oppo=$row3['messag'];
if($row3['mimage']!="")
$image_oppo=$row3['mimage'];

$oppo_flag=1;
}

if($row3['fromid']==$userid){
$mess_own=$row3['messag'];

if($row3['mimage']!="")
$image_own=$row3['mimage'];
$own_flag=1;
}

if($oppo_flag==1){
echo '<div class="sender">';
if($mess_oppo!="")
echo '<p class="sender_text">'.$mess_oppo.'</p>';
if($image_oppo!="")
echo '<img src="messimages/'.$image_oppo.'">';
echo '</div>';
}

if($own_flag==1){
echo '<div class="receiver">';
if($mess_own!="")
echo '<p class="receiver_text">'.$mess_own.'</p>';
if($image_own!="")
echo '<img src="messimages/'.$image_own.'">';
echo '</div>';
}

$oppo_flag=0;
$own_flag=0;
$image_own="";
$image_oppo="";
$mess_oppo="";
$mess_own="";

}

echo '<div class="findfrien" >';
echo '<form  enctype="multipart/form-data" action="sendmessage.php?ri='.$friendid.'" method="post">';
echo '<input  name="mess_content" type="text" placeholder="Enter a message" >';


echo '<input id="mimage" name="mimage" style="float:left;width:40%;margin-left:0px;padding-left:0px" type="file"/>';
echo '<div class="mess_sub">';
echo '<input class="submit"   type="submit" value="Send"  name="submit_mess_content">';

echo '</div>
';
echo '</div>
';

?>


<script>



/*window.onunload=function(){
window.location.href="tosetseen.php?id=<?php echo $friendid ?>";
}*/



</script>

</div>

</body>



<style>



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

.mess_sub input[type="submit"]{

float:right;

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


.total{
margin-left: auto ;
  margin-right: auto ;
background:#fff;
border-radius:2px;
padding:20px;


}

.chatters{
float:left;
width:100%;
height:auto;
}
.chatters img{
float:left;
height:30px;
width:30px;
border-radius:1000px;

}
.chatters p{
float:left;
}

hr{
background-color:#54696d;
height:3px;
}


.chatters p.you{
float:right;
margin-right:40px;
margin-top:6px;
}

.chatters p.opponent{
padding-left:10px;
padding-top:0px;
margin-top:6px;
}

.loadearlier {
text-align:center;
}
.loadearlier a{
color:#548989;
}


.sender{
max-width:50%;
}

.receiver{
text-align:right;
max-width:100%;
margin-left:50%;
}


p.sender_text{
background:#548989;
  display:inline-block;
padding:15px;
border-radius:10px;
color:#fff;

}

p.receiver_text{
background:#DBECEC;
  display:inline-block;
padding:15px;
border-radius:10px;
color:#548989;

 
}


.findfrien{margin-left:0;height:100px}

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
border-radius:10px;
color:#54696d;
font-weight:bold;

    box-sizing: border-box;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
display:block; width:100%;
}

input[type="submit"]{
background-color:#FFB3B3;
color:#fff;
border:0px;
border-radius:10px;
transition:.3s;
font-weight:bold;
}
input[type="submit"]:hover{
background-color:#E15B82;
border:0px;

}
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
.findfrien{margin-left:0;height:150px}
.public_posts p.posted_time{float:right;padding-right:0px}
.public_posts p.poster_name{padding-left:5px}


input[type="text"]{
width:100%;
border-style:ridge;
border-width:1px;
border-opacity:.5;
border-radius:10px;



    width: 100%;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
display:block; width:100%;border-width:0;


}


.total{

border-radius:0px;
padding:0px;
}

.chatters{
float:left;
width:100%;
}


.chatters p.opponent{
padding-left:10px;
padding-top:0px;
margin-top:6px;
}

.loadearlier {
text-align:center;
}

.sender{
max-width:70%;
}

.receiver{
text-align:right;
max-width:100%;
margin-left:10%;
}





p.sender_text{
background:#548989;
  display:inline-block;
padding:15px;
border-radius:10px;
color:#fff;

}

p.receiver_text{
background:#DBECEC;
  display:inline-block;
padding:15px;
border-radius:10px;
color:#548989;

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




