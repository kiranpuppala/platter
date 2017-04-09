<?php
require_once('allvars.php');
require_once('starsess.php');
$error_image=false;


if(isset($_SESSION['userid'])){
$userid=$_SESSION['userid'];
if(isset($_POST['submit'])){

$output_form = false;

$itemname=$_POST['itemname'];
$category=$_POST['category'];

$price=$_POST['price'];
$mobile=$_POST['mobile'];

$emailaddr=$_POST['emailaddr'];

$primage=$_FILES['primage']['name'];
$tmp=$_FILES['primage']['tmp_name'];
$target=SALE_IMAGE_PATH.$primage;
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
    $exif = @exif_read_data($target);
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
        }//switch close

        imagejpeg($image, $target, 90);
    }//exif orientation close
}
/// jpeg check close


$query="INSERT INTO placedsales (placerid,itemname,price,mobile,emailaddr,primage,category,date) VALUES ('$userid','$itemname','$price','$mobile','$emailaddr','$primage','$category',NOW())";
$result=mysqli_query($dbc,$query)
or die('Error querying database.');


mysqli_close($dbc);
//$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/homepage.php';
//header('Location: ' . $home_url);
echo 'sale has been placed';

}// total image check close

else{
$output_form=true;
$error_image=true;
}


}

else{
$output_form= true;
}

if ($output_form) {
?>

<!DOCTYPE html>
<head>
<title>Sell item</title>
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
<li style="visibility:hidden">Hidden field for space only for space.It gives more  simplifies.Some some ndofdndnodnndfon </li>
<li><a href="oldstuff.php">home</a></li>
  <li><a class="logout" href="logout.php">log out</a></li>
  <li><a class="friends" href="placedsales.php">placed sales</a></li>
  <li><a class="inbox" href="sellitem.php">sell item</a></li>
  <li id="fr"><a href="studmat.php">study materials</a></li>
  <li id="ep"><a href="editprof.php">edit profile</a></li>

 <li class="icon">
    <a href="javascript:void(0);" style="font-size:15px;" onclick="myFunction()">☰</a>
  </li>
</ul>

<div class="empty_space"></div>

<div class="total col-5">
<div class="edit_prof">
<p><b>Place sale</b></p>
<hr>
<form  enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"  onsubmit="return validateForm()" >


<label for="itemname">Item name:</label><br>
<input id="itemname" value="<?php if(!empty($itemname)) echo $itemname;?>" placeholder="Example:- Drafter 2014 model" type="text" name="itemname"> <br><div id="citemname"></div><br>


<label for="category">Category:</label>
<select id="category" name="category">
<option selected="selected"  value="">------</option>
<option   value="Stationary">Stationary</option>
<option  value="Books">Books</option>
<option value="Studymaterials">Study materials</option>
<option value="Mobiles">Mobiles</option>
<option value="Electronicgadgets">Electronic gadgets</option>
<option value="Sports">Sports</option>
<option value="Others">Others</option>
</select><br><br><div id="ccategory"></div><br>


<label for="price">Price:</label><br>
<input id="price"  value="<?php if(!empty($price)) echo $price;?>" placeholder="Example:- 500" type="text" name="price" ><br><div id="cprice"></div><br>


<label for="mobile">Mobile:</label><br>
<input id="mobile" value="<?php if(!empty($mobile)) echo $mobile;?>"  type="text" name="mobile" ><br><div id="cmobile"></div><br>


<label for="emailaddr">Email address:</label><br>
<input id="emailaddr"  value="<?php if(!empty($emailaddr)) echo $emailaddr;?>" type="text" name="emailaddr"  ?><br><div id="cemailaddr"></div><br>

<label for="primage">Upload image file</label>
<input id="primage" name="primage" type="file" /><br/><div id="cprimage"></div><br>
<p style="color:#ff0000"><?php if($error_image){ echo 'Choose only png,jpeg,jpg,pjpeg,x-png,png'; } ?></p>


<input id="submit" type="submit" name="submit" value="place sale" >




</form>
</div>
</div>


</body>





<script>
function validateForm() {

if(document.getElementById("itemname").value.length<3){
document.getElementById("citemname").innerHTML="enter atleast 3 characters";
document.getElementById("citemname").style="color:#ff0000";
return false;
}
else if(document.getElementById("itemname").value.length>30){
document.getElementById("citemname").innerHTML="not more than 30 characters";
document.getElementById("citemname").style="color:#ff0000";
return false;
}
else
document.getElementById("citemname").innerHTML="";


if(document.getElementById("category").value.length<3){
document.getElementById("ccategory").innerHTML="select category";
document.getElementById("ccategory").style="color:#ff0000";
return false;
}
else{
document.getElementById("ccategory").innerHTML="";
}

if(document.getElementById("price").value.length<1){
document.getElementById("cprice").innerHTML="specify price";
document.getElementById("cprice").style="color:#ff0000";
return false;
}
else{
document.getElementById("cprice").innerHTML="";
}


if(document.getElementById("mobile").value.length<10){
document.getElementById("cmobile").innerHTML="specify mobile no.";
document.getElementById("cmobile").style="color:#ff0000";
return false;
}
else{
document.getElementById("cmobile").innerHTML="";
}


if(document.getElementById("emailaddr").value.length<10){
document.getElementById("cemailaddr").innerHTML="specify valid email";
document.getElementById("cemailaddr").style="color:#ff0000";
return false;
}
else{
document.getElementById("cemailaddr").innerHTML="";
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
