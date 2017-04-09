<?php
require_once('allvars.php');
require_once('starsess.php');
if(isset($_SESSION['userid'])){
$userid=$_SESSION['userid'];
if(isset($_POST['submit'])){

$output_form = false;
$firstname=$_POST['firstname'];
$secondname=$_POST['secondname'];
if(isset($_POST['gender'])){
$gender=$_POST['gender'];
}
else {
$gender="";
}

$date=$_POST['date'];
$place=$_POST['place'];
$country=$_POST['country'];

$emailaddr=$_POST['emailaddr'];
$password=$_POST['password'];
$primage=$_FILES['primage']['name'];
$tmp=$_FILES['primage']['tmp_name'];
$target=IMAGE_PATH.$primage;
$filesize=$_FILES['primage']['size'];

$dbc=mysqli_connect(DB_ADDR,DB_USER,DB_PASS,DB_NAME) or die('error to connect');

if ((($_FILES["primage"]["type"] == "image/gif")
|| ($_FILES["primage"]["type"] == "image/jpeg")
|| ($_FILES["primage"]["type"] == "image/jpg")
|| ($_FILES["primage"]["type"] == "image/pjpeg")
|| ($_FILES["primage"]["type"] == "image/x-png")
|| ($_FILES["primage"]["type"] == "image/png"))&&$primage!="")
{
$image_presence=move_uploaded_file($tmp,$target);

if ($_FILES["primage"]["type"] == "image/jpeg"){
    $exif = exif_read_data($target);
    if (!empty($exif['Orientation'])) {
        $image = imagecreatefromjpeg($target);
        switch ($exif['Orientation']) {
            case 3:
                $image = imagerotate($image, 180, 0);
                break;

            case 6:
                $image = imagerotate($image, -90, 0);
                break;

            case 8:
                $image = imagerotate($image, 90, 0);
                break;
        }

        imagejpeg($image, $target, 90);
    }
}



$query="UPDATE candidates SET  primage='$primage' WHERE userid='$userid' ";
$result=mysqli_query($dbc,$query)
or die('Error querying database.');
}



if($firstname!=""){
$query="UPDATE candidates SET  firstname='$firstname' WHERE userid='$userid' ";
$result=mysqli_query($dbc,$query)
or die('Error querying database frstname.');
}

if($secondname!=""){
$query="UPDATE candidates SET  secondname='$secondname' WHERE userid='$userid' ";
$result=mysqli_query($dbc,$query)
or die('Error querying database.');
}

if($gender!=""){
$query="UPDATE candidates SET  gender='$gender' WHERE userid='$userid' ";
$result=mysqli_query($dbc,$query)
or die('Error querying database.');
}

if($date!=""){
$query="UPDATE candidates SET  date='$date' WHERE userid='$userid' ";
$result=mysqli_query($dbc,$query)
or die('Error querying database.');
}

if($place!=""){
$query="UPDATE candidates SET  place='$place' WHERE userid='$userid' ";
$result=mysqli_query($dbc,$query)
or die('Error querying database.');
}

if($country!=""){
$query="UPDATE candidates SET  country='$country' WHERE userid='$userid' ";
$result=mysqli_query($dbc,$query)
or die('Error querying database.');
}

if($emailaddr!=""){
$query="UPDATE candidates SET  emailaddr='$emailaddr' WHERE userid='$userid' ";
$result=mysqli_query($dbc,$query)
or die('Error querying database.');
}

if($password!=""){
$query="UPDATE candidates SET password=SHA('$password')  WHERE userid='$userid' ";
$result=mysqli_query($dbc,$query)
or die('Error querying database.');
}



mysqli_close($dbc);
$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/homepage.php';
header('Location: ' . $home_url);

}
else{
$output_form= true;
}

if ($output_form) {
?>

<!DOCTYPE html>
<head>
<title>edit profile</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="screen.css" type="text/css" media="screen"/>



<script>

 function showhide(id) {
    var e = document.getElementById(id);
    e.style.display = (e.style.display == 'block') ? 'none' : 'block';
 }


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
$db=mysqli_connect(DB_ADDR,DB_USER,DB_PASS,DB_NAME) or die('error to connect');
$quer="SELECT * FROM candidates WHERE userid='$userid' ";
$info=mysqli_query($db,$quer) or die ('error for details');
$row_info=mysqli_fetch_array($info);

echo '<div class="total col-5">';
echo '<div class="edit_prof">';
echo '<p><b>Edit your details</b></p>';
echo '<img src="images/'.$row_info['primage'].'">';
echo '<hr>';

echo '<form enctype="multipart/form-data" method="post" action="'.$_SERVER['PHP_SELF'].'" > '; 
echo '<p>'.$row_info['firstname'].'&nbsp&nbsp'.$row_info['secondname'].'<a  style="color:#F26522"  href="javascript:showhide(\'names\')">
edit&#8594</a></p>';

echo '<div id="names" style="display:none;">';
echo '<label for="firstname">FIRST NAME:</label><br>';
echo '<input id="firstname"  type="text" name="firstname" ><br>';
echo '<p id="cfname"> </p><br>';
echo '<label for="secondname">SECOND NAME:</label><br>';
echo '<input id="secondname" type="text" name="secondname" ><br>';
echo '<p id="csname"> </p><br>';
echo '</div>';

echo '<p>'.$row_info['gender'].' &nbsp&nbsp<a style="color:#F26522"href="javascript:showhide(\'gend\')">edit&#8594</a></p>';
echo '<div id="gend" style="display:none;">';
echo '<label for="gender">GENDER:</label><br>';
echo '<input type="radio" name="gender" value="Male"> Male';
echo '<input type="radio" name="gender" value="Female"> Female<br>';
echo '</div>';





echo '<p>'.$row_info['date'].' &nbsp&nbsp<a style="color:#F26522"href="javascript:showhide(\'dob\')">edit&#8594</a></p>';
echo '<div id="dob" style="display:none">';
echo '<label for="date">DATE OF BIRTH:</label><br>';
echo '<input id="date" type="date" name="date" ><br>';
echo '<p id="cdate"> </p><br>';
echo '</div>';

echo '<p>'.$row_info['place'].' &nbsp&nbsp<a style="color:#F26522"href="javascript:showhide(\'loc\')">edit&#8594</a></p>';
echo '<div id="loc" style="display:none">';
echo '<label for="place">Your Location:</label><br>';
echo '<input id="place"  type="text" name="place" ><br>';
echo '<p id="cplace"> </p><br>';
echo '</div>';

echo '<p>'.$row_info['country'].' &nbsp&nbsp<a style="color:#F26522"href="javascript:showhide(\'coun\')">edit&#8594</a></p>';
echo '<div id="coun" style="display:none">';
echo '<label for="country">Country:</label>';
echo '<select name="country">';
echo '<option selected="selected"  value="">------</option>';
echo '<option   value="India">India</option>';
echo '<option  value="America">America</option>';
echo '<option value="England">England</option>';
echo '<option value="Greece">Greece</option>';
echo '</select>';
echo '<p id="ccountry"> </p><br>';
echo '</div>';

echo '<p>'.$row_info['emailaddr'].' &nbsp&nbsp<a style="color:#F26522"href="javascript:showhide(\'emaddr\')">edit&#8594</a></p>';
echo '<div id="emaddr" style="display:none">';
echo '<label for="emailaddr">EMAIL ADDRESS:</label><br>';
echo '<input id="emailaddr"  type="text" name="emailaddr"  ?>"<br><div id="al"></div>';
echo '<p id="cemailaddr"> </p><br>';
echo '</div>';

echo '<p>Change Password &nbsp&nbsp<a style="color:#F26522"href="javascript:showhide(\'pass\')">edit&#8594</a></p>';
echo '<div id="pass" style="display:none">';
echo '<label for="password">PASSWORD:</label><br>';
echo '<input id="password"  type="password" name="password"><br>';
echo '<p id="cpassword"> </p><br>';
echo '<label for="conpassword">CONFIRM PASSWORD:</label><br>';
echo '<input id="conpassword"  type="password" name="conpassword"><br>';
echo '<p id="cconpassword"> </p><br>';
echo '</div>';

echo '<p>Change Profile Picture &nbsp&nbsp<a style="color:#F26522" href="javascript:showhide(\'profileim\')">edit&#8594</a></p>';
echo '<div id="profileim" style="display:none">';
echo '<label for="primage">Upload image file</label>';
echo '<input id="primage" name="primage" type="file" /><br/>';
echo '</div>';

echo '<!--<input id="submit" type="submit" name="submit" value="update" onClick="ValidateForm(this.form)">-->';
echo '<input id="submit" type="submit" name="submit" value="update" >';




echo '</form>';
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

hr{
height:3px;
background-color:#54696d;
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
border-radius:10px;
border:0px;
transition:.3s;
}
input[type="submit"]:hover{

opacity:.5;
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

.topnav img{
margin-left:20px;
}

ul.topnav li a {
  display: inline-block;
  color: #f2f2f2;
  font-weight:bold;
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
.edit_prof{
box-shadow:0 0px 0px 0 rgba(0,0,0,0),0 0px 0px 0 rgba(0,0,0,0);
margin-top:0px;
margin-left:0px;
padding:0px;
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
}
else{
header("Location:index.php");
}
?>
