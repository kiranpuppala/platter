 <?php
require_once('allvars.php');
require_once('starsess.php');

$userid='';
$login_wrong=false;
if(!isset($_SESSION['userid'])){
if(isset($_POST['submit'])){
$dbc=mysqli_connect(DB_ADDR,DB_USER,DB_PASS,DB_NAME);
$emailaddr=     $_POST['emailaddr'];                                                    //mysqli_real_escape_string($dbc,trim($_POST['email']));
$password=  $_POST['password'];                                                //mysqli_real_escape_string($dbc,trim($_POST['password']));
if(!empty($emailaddr)&&!empty($password)){
$query="SELECT userid,firstname FROM candidates WHERE emailaddr='$emailaddr' AND password=SHA('$password') ";
$data=mysqli_query($dbc,$query);
if(mysqli_num_rows($data)==1){
$row=mysqli_fetch_array($data);
$_SESSION['userid']=$row['userid'];
$userid=$_SESSION['userid'];
$_SESSION['firstname']=$row['firstname'];

setcookie('userid',$row['userid'],time() + (60 * 60 * 24 * 30));
setcookie('firstname',$row['firstname'],time() + (60 * 60 * 24 * 30));

$query="INSERT INTO chat (userid) VALUES ('$userid')";
$result=mysqli_query($dbc,$query) or die('error chat');



mysqli_close($dbc);
$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/homepage.php?id='. $userid.' ';
header('Location: ' . $home_url);
}//num of rows
else{
$login_wrong=true;
}
}// not empty user name
}//is set post submit
?>
 <!DOCTYPE html>
<head>
<title>srkr network log in</title>
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




</head>
<body>
<!--<div class="logo">
<img src="logo.png" alt="no image" width="180px" height="46px">-->
<ul class="topnav" id="myTopnav">
<li><img style="margin-top:10px" src="images/platterlogin.png" alt="no image" width="150px" height="45px"></li>
<li style="visibility:hidden">Hidden field for space only for space.It gives more  simplifies.Some some some some some some some some</li>
  <li><a class="signup" href="signup.php">signup</a></li>
  <li><a class="wiki" href="#">app</a></li>
  <li><a class="friends" href="about.html">about</a></li>


 <li class="icon">
    <a href="javascript:void(0);" style="font-size:15px;" onclick="myFunction()"><span style="font-size:20px">≡</span></a>
  </li>
</ul>
<!--</div>-->

<div class="empty_space"></div>



<div class="login_details">
<img src="images/profilepic.png" alt="no image">
</div>

<div class="login_inputs">

<form  name="myform" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"  onsubmit="return validateForm()">
<label for="emailaddr" id="un">Email address</label><br>
<input class="emailaddr" name="emailaddr" type="text" value="<?php if(!empty($emailaddr)) echo $emailaddr; ?>"><br>
<label for="password" id="pw">Password</label><br>
<input class="pw" name="password" type="password"><br>
<p><?php if($login_wrong) echo 'email or password is wrong'; ?></p>

<input class="submit" type="submit" value="login" name="submit" >

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
<a  style="text-decoration:none" href="https://plus.google.com/u/0/107537932943509859076" ><p class="email"><span style="font-size:30px">G+</span></p></a>
</div>

</body>
<style>
body{
font-family:"Century Gothic";
font-weight:bold;
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

@media screen and (max-width:680px) {
  ul.topnav li:not(:first-child) {display: none;}
  ul.topnav li.icon {
    float: right;
    display: inline-block;
  }
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
height:30px;
}



.login_details{
font-family:"Century Gothic"; 
margin:auto;
height:auto;
background:#fff;

border-radius:100px;
opacity:.7;
width:30%;
padding:30px;
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
height:190px;
}

.logo{position:fixed;}

.login_details{
font-family:"Century Gothic"; 
height:200px;
margin-left:360px;
background:#fff;
opacity:.7;
width:200px;
padding:50px;
float:left;
}

.login_inputs{
font-family:"Century Gothic";
color:#ffb3b3;
text-align:center;
background:#0A6363;
float:left;
border-left:10px solid #E74225;
padding:0px;
width:350px;
height:250px;
opacity:.7;
padding-top:50px;
}


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
padding-left:20px;height:270px;margin-top:410px;
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

.wrong_login_details{
font-size:15px;
color:red;
font-family:"Century Gothic";
color:#BA7777;

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
border:0px;
transition:.3s;
font-weight:bold;
color:white;
}
input[type="submit"]:hover{
background-color:#fff;
color:#F26522;


}

@media only screen and (max-width: 680px) {
.fb{
margin-left:60%;
}
.footer{
margin-top:100px;
height:200px;
}
.cpyrt{
margin-top:50px;
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


}

.



</style>
</html>
<?php
}
else{
header("Location:homepage.php");
}
?>


