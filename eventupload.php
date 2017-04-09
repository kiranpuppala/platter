<?php
require_once('allvars.php');
$image_presence=false;
$eventday=$_POST['eventday'];
$eventtext=$_POST['eventtext'];
$pimage=$_FILES['pimage']['name'];
$tmp=$_FILES['pimage']['tmp_name'];
$target=IMAGE_PATH.$pimage;
$filesize=$_FILES['pimage']['size'];



$dbc=mysqli_connect(DB_ADDR,DB_USER,DB_PASS,DB_NAME)
or die('Error connecting to MySQL server.');

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




$query="INSERT INTO eventdetails (eventday,eventtext,pimage,date)".
"VALUES ('$eventday','$eventtext','$pimage',NOW())";

$result=mysqli_query($dbc,$query)
or die('Error1 querying database.');
mysqli_close($dbc);
echo 'submitted succefully';
?>