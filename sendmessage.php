<?php
require_once('starsess.php');
require_once('allvars.php');
$userid=$_SESSION['userid'];
$receiver_id=$_GET['ri'];
$mess_content=$_POST['mess_content'];

$mimage=$_FILES['mimage']['name'];
$tmp=$_FILES['mimage']['tmp_name'];
$target=MESS_IMAGE_PATH.$mimage;
$filesize=$_FILES['mimage']['size'];


if ((($_FILES["mimage"]["type"] == "image/gif")
|| ($_FILES["mimage"]["type"] == "image/jpeg")
|| ($_FILES["mimage"]["type"] == "image/jpg")
|| ($_FILES["mimage"]["type"] == "image/pjpeg")
|| ($_FILES["mimage"]["type"] == "image/x-png")
|| ($_FILES["mimage"]["type"] == "image/png"))||$pimage=="")
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

$dbc=mysqli_connect(DB_ADDR,DB_USER,DB_PASS,DB_NAME)
or die('Error connecting to MySQL server.');
$query="INSERT INTO mess (toid,fromid,messag,mimage,date) VALUES ('$receiver_id','$userid','$mess_content','$mimage',NOW())";
$result=mysqli_query($dbc,$query) or die ('error query for  mess');

header("Location:messaging.php?id=$receiver_id");

mysqli_close($dbc);
}
else{
header("Location:messaging.php?id=$receiver_id");
}
?>