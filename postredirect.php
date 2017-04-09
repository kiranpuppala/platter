<?php
require_once('allvars.php');

$emailaddr="";
$image_presence=false;
$userid=$_SESSION['userid'];
$posttext=$_POST['posttext'];
$pimage=$_FILES['pimage']['name'];
$tmp=$_FILES['pimage']['tmp_name'];
$target=POST_IMAGE_PATH.$pimage;
$filesize=$_FILES['pimage']['size'];
$userid=$_COOKIE['userid'];
$firstname="";

////////////&& ($_FILES["file"]["size"] < 100000)

if ((($_FILES["pimage"]["type"] == "image/gif")
|| ($_FILES["pimage"]["type"] == "image/jpeg")
|| ($_FILES["pimage"]["type"] == "image/jpg")
|| ($_FILES["pimage"]["type"] == "image/pjpeg")
|| ($_FILES["pimage"]["type"] == "image/x-png")
|| ($_FILES["pimage"]["type"] == "image/png"))||$pimage=="")
{
$dbc=mysqli_connect(DB_ADDR,DB_USER,DB_PASS,DB_NAME)
or die('Error connecting to MySQL server.');
$query="SELECT emailaddr,firstname FROM candidates WHERE userid='$userid'";
$result=mysqli_query($dbc,$query);
if(mysqli_num_rows($result)==1){
$row=mysqli_fetch_array($result);
$emailaddr=$row['emailaddr'];
$firstname=$row['firstname'];
}
$image_presence=move_uploaded_file($tmp,$target);


if ($_FILES["pimage"]["type"] == "image/jpeg"){
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

$query="INSERT INTO post (posterid,posttext,name,pimage,emailaddr,date_time)".
"VALUES ('$userid','$posttext','$firstname','$pimage','$emailaddr',NOW())";

$result=mysqli_query($dbc,$query)
or die('Error1 querying database.');

header("Location:homepage.php");
}
else{
header("Location:homepage.php");
}


?>



