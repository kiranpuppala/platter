<?php
require_once('allvars.php');
$already_exist=false;
if(isset($_POST['submit'])){
$output_form = false;
$firstname=$_POST['firstname'];
$secondname=$_POST['secondname'];
$gender=$_POST['gender'];
$date=$_POST['date'];
$place=$_POST['place'];
$country=$_POST['country'];
$already_exist=false;

$emailaddr=$_POST['emailaddr'];
$password=$_POST['password'];
$primage=$_FILES['primage']['name'];
$tmp=$_FILES['primage']['tmp_name'];
$target=IMAGE_PATH.$primage;
$filesize=$_FILES['primage']['size'];

if ((($_FILES["primage"]["type"] == "image/gif")
|| ($_FILES["primage"]["type"] == "image/jpeg")
|| ($_FILES["primage"]["type"] == "image/jpg")
|| ($_FILES["primage"]["type"] == "image/pjpeg")
|| ($_FILES["primage"]["type"] == "image/x-png")
|| ($_FILES["primage"]["type"] == "image/png"))){


if(move_uploaded_file($tmp,$target)){

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


$dbc=mysqli_connect(DB_ADDR,DB_USER,DB_PASS,DB_NAME)
or die('Error connecting to MySQL server.');

$query="SELECT emailaddr FROM candidates";
$result=mysqli_query($dbc,$query) or die('error 0');

while($row=mysqli_fetch_array($result)){
if($emailaddr==$row['emailaddr']){
$already_exist=true;
break;
}
}

if(!$already_exist){
$query1="INSERT INTO candidates (firstname,secondname,gender,date,place,country,emailaddr,password,primage)".
"VALUES ('$firstname','$secondname','$gender','$date','$place','$country','$emailaddr',SHA('$password'),'$primage')";
$result1=mysqli_query($dbc,$query1)
or die('Error querying database.');
mysqli_close($dbc);
$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
header('Location: ' . $home_url);
}
else { 
$output_form = true;
}

}
else { 
$output_form = true;
}

}///////////////if to check image file or any other file
else { 
$output_form = true;
}///////////////if to check image file or any other file

}
else{
$output_form= true;
}

if ($output_form) {
?>
<!DOCTYPE html>
<head>
<title>srkr network log in</title>
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
    } else {
     x.className = "topnav";
document.getElementById("wh").style.display="none";
document.getElementById("fr").style.display="none";
document.getElementById("ep").style.display="none";
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
}

}
</script>







<body>

<!--<div class="logo">
<img src="logo.png" alt="no image" width="180px" height="46px">-->
<ul class="topnav" id="myTopnav">
<li><img style="margin-top:10px" src="images/platterlogin.png" alt="no image" width="150px" height="45px"></li>
<li style="visibility:hidden">Hidden field for space only for space.It gives more  simplifies.Some some some some some some some some</li>
  <li><a class="login" href="index.php">login</a></li>
  <li><a class="wiki" href="#">app</a></li>
  <li><a class="friends" href="about.html">about</a></li>


 <li class="icon">
    <a href="javascript:void(0);" style="font-size:15px;" onclick="myFunction()"><span style="font-size:20px">≡</span></a>
  </li>
</ul>
<!--</div>-->


<div class="empty_space"></div>
<div class="login_inputs">

<div class="enter_all_info">
<p >Enter all information</p>
</div>
<br>
<form  enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"  onsubmit="return validateForm()" >
<label for="firstname">FIRST NAME:</label><br>
<input id="firstname"  type="text" name="firstname" value="<?php if(!empty($firstname)) echo $firstname; ?>"><br>
<p id="cfname"> </p><br>
<label for="secondname">SECOND NAME:</label><br>
<input id="secondname" type="text" name="secondname" value="<?php if(!empty($secondname)) echo $secondname; ?>"><br>

<p id="csname"> </p><br>

<label for="gender">GENDER:</label><br>
Male
&nbsp&nbsp&nbsp<input id="gender" type="radio"  name="gender" value="Male" ><br>
Female <input id="gender" type="radio"  name="gender" value="Female" ><br>


<label for="date">DATE OF BIRTH:</label><br>
<input id="date" type="date" name="date" ><br>

<p id="cdate"> </p><br>



<label for="place">Your location:</label><br>
<input id="place" type="text" name="place" value="<?php if(!empty($place)) echo $place; ?>"><br>
<p id="cplace"> </p><br>


<label for="country">Country:</label>
<select id="country" name="country">
<option selected="selected"  value=""></option>
<option   value="India">India</option>
<option  value="America">America</option>
<option value="England">England</option>
</select>

<p id="ccountry"> </p><br>

<label for="emailaddr">EMAIL ADDRESS:</label><br>
<input id="emailaddr"  type="text" name="emailaddr" value="<?php if(!empty($emailaddr)) echo $emailaddr; ?>"<br><div id="al"></div>
<p id="cemailaddr"> </p><br>
<p style="color:#ff0000"><?php if($already_exist) echo 'Email address already exist'; ?></p>

<label for="password">PASSWORD:</label><br>
<input id="password"  type="password" name="password"><br>
<p id="cpassword"> </p><br>
<label for="conpassword">CONFIRM PASSWORD:</label><br>
<input id="conpassword"  type="password" name="conpassword"><br>
<p id="cconpassword"> </p><br>
<label for="primage">Upload image file</label>
<input id="primage" name="primage" type="file" /><br/>
<p id="cprimage"> </p><br>

<input id="submit" type="submit" name="submit" value="signup">

</form>

</div>

<div class="footer" style="padding:50px;text-decoration:none;">

<p class="cpyrt" style="margin:auto;color:white;font-family:arial;text-align:center;font-weight:lighter;margin-top:110px">&copy 2016-17</p>
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
<a  style="text-decoration:none" href="https://plus.google.com/u/0/107537932943509859076" ><p class="email"><span style="font-size:25px">G+</span></p></a>
</div>

</body>
<script>
function validateForm() {

if(document.getElementById("firstname").value.length<3){
document.getElementById("cfname").innerHTML="enter atleast 3 characters";
document.getElementById("cfname").style="color:#ff0000";
return false;
}
else{
document.getElementById("cfname").innerHTML="";
}

if(document.getElementById("secondname").value.length<3){
document.getElementById("csname").innerHTML="enter atleast 3 characters";
document.getElementById("csname").style="color:#ff0000";
return false;
}
else{
document.getElementById("csname").innerHTML="";
}

/*if(document.getElementById("gender").value=""){
document.getElementById("cgender").innerHTML="specify gender";return false;
}
else{
document.getElementById("cgender").innerHTML="";
}*/


//function check() {
var r = document.getElementsByName("gender");
var c = -1;

for(var i=0; i < r.length; i++){
   if(r[i].checked) {
      c = i; 
   }
}
if (c == -1){
 alert("please select gender");
return false;
}
//}




if(document.getElementById("date").value.length<1){
document.getElementById("cdate").innerHTML="specify date";
document.getElementById("cdate").style="color:#ff0000";
return false;
}
else{
document.getElementById("cdate").innerHTML="";
}




if(document.getElementById("place").value.length<3){
document.getElementById("cplace").innerHTML="specify precise village name";
document.getElementById("cplace").style="color:#ff0000";
return false;
}
else{
document.getElementById("cplace").innerHTML="";
}

if(document.getElementById("country").value.length<3){
document.getElementById("ccountry").innerHTML="select your country";
document.getElementById("ccountry").style="color:#ff0000";
return false;
}
else{
document.getElementById("ccountry").innerHTML="";
}


if(document.getElementById("emailaddr").value.length<10){
document.getElementById("cemailaddr").innerHTML="specify valid email";
document.getElementById("cemailaddr").style="color:#ff0000";
return false;
}
else{
document.getElementById("cemailaddr").innerHTML="";
}


var password=document.getElementById("password").value;

if(document.getElementById("password").value.length<8){
document.getElementById("cpassword").innerHTML="atleast be 8 characters";
document.getElementById("cpassword").style="color:#ff0000";
return false;
}
else{
document.getElementById("cpassword").innerHTML="";
}

var password=document.getElementById("password").value;
var conpassword=document.getElementById("conpassword").value;

if(!(password==conpassword)){
document.getElementById("cconpassword").innerHTML="passwords do not match";
document.getElementById("cconpassword").style="color:#ff0000";
return false;
}
else{
document.getElementById("cconpassword").innerHTML="";
}

if(document.getElementById("primage").value.length<1){
document.getElementById("cprimage").innerHTML="select profile picture";
document.getElementById("cprimage").style="color:#ff0000";
return false;
}
else{
document.getElementById("cprimage").innerHTML="";
}



}
</script>








<style>


body{
font-family:"Century Gothic";
font-weight:bold;
}

/*for mobile phones*/
@media only screen and (max-width: 680px) {
    body {
      background-image:url("images/boyandgirl.jpg");
background-attachment:fixed;
margin:0;
padding:0;
  background-size: cover;
    }

.logo a{margin-left:0px;}

    [class*="col-"] {
        width: 100%;
    }

.empty_space{
height:170px;
}



.login_inputs{
font-family:"Century Gothic";
color:#ffb3b3;
text-align:center;
background:#0A6363;

margin:auto;
padding:0px;
width:100%;
height:auto;
opacity:.7;
}




}







ul.topnav {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;

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

/*for desktop*/
@media only screen and (min-width: 500px) {
body{
background-image:url("images/boyandgirl.jpg");
background-attachment:fixed;

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

.empty_space{
height:130px;
}

.logo{position:fixed;}


.login_inputs{
font-family:"Century Gothic";
color:#ffb3b3;
text-align:center;
background:#0A6363;
//float:left;
margin:auto;

//border-left:10px solid #CA4848;
width:350px;
height:auto;
opacity:.8;
padding-top:10px;
}

.enter_all_info {font-size:20px;width:350px;height:auto;border-bottom:10px solid #F26522;}


}




.logo{
margin:0;
font-family:"Century Gothic";
background-color:#000;
height:60px;
width:100%;
position:fixed;
}

.logo img{
padding-top:12px;
}

div.logo a:link{background-color:#ffb3b3;color:#1DB7B7;padding:5px 10px;
text-align:center;text-decoration:none;display:inline-block;border-radius:3px}

 div.logo a:visited{color:#ffffff;}
div.logo a:hover{background-color:#ff6666;color:white;padding:5px 10px;text-align:center;text-decoration:none;display:inline-block;border-radius:3px}
div.logo a {float:right;padding:10px;margin-right:10px;margin-top:15px}

#quote1{font-family:"Century Gothic"; font-size:50px;text-align:center;margin:auto;color:#ff6666;padding-top:200px;height:50%}
#quote2{font-family:"Century Gothic"; font-size:50px;text-align:center;margin:auto;color:#ff6666;padding-top:350px;height:50%}



.footer{


background:#0A6363;
height:300px;
padding-left:20px;height:270px;margin-top:200px;
opacity:.7;

}

.column5{
float:left;
background:#F26522;
height:120px;
opacity:.7;
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


 a {text-decoration:none;}
div.footer ul li {margin:10px 0; color:white;list-style-type:none;font-family:"Century Gothic";}


div.footer_col1 {float:left;width:20%;margin-left:8%}
div.footer_col2 {float:left;width:20%;margin-left:8%}
div.footer_col3 {float:left;width:20%;margin-left:8%}

 div.footer a:visited{color:#ffffff;}

div.footer ul.footer_col1_list1 a.footer_elem_services{color:#1DB7B7;font-size:20px;font-weight:900;font-family:"Century Gothic";}
div.footer ul.footer_col2_list2 a.footer_elem_services{color:#1DB7B7;font-size:20px;font-weight:900;font-family:"Century Gothic";}
div.footer ul.footer_col3_list3 a.footer_elem_services{color:#1DB7B7;font-size:20px;font-weight:900;font-family:"Century Gothic";}
img {
    max-width: 100%;
    height: auto;
}



div.login_inputs label{}

input{
//width:100%;
padding:12px 20px;
margin:8px 0;
box-sizing:border-box;
font-family:"Century Gothic";
}

input[type="submit"]{
background-color:#F26522;
font-weight:bold;
color:white;
transition:.3s;
border:0px;
}
input[type="submit"]:hover{
background-color:#fff;
color:#F26522;
border:0px;
}

@media screen and (max-width:680px) {
  ul.topnav li:not(:first-child) {display: none;}
  ul.topnav li.icon {
    float: right;
    display: inline-block;
  }

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
background:#F26522;
  }

ul.topnav.responsive li a:hover {
  background:#fff;
color:#F26522;
  }

.fb{
margin-left:60%;
}
.footer{
margin-top:10px;
height:200px;
}
.cpyrt{
margin-top:50px;
}

.empty_space{
height:70px;
}

}



</style>
</html>
<?php
}
?>
