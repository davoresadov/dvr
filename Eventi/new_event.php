<?php
session_start(); 
include('connection.php');

if (isset($_SESSION['id'])) {
	
    $userid = $_SESSION['id'];
    $username = $_SESSION['username'];

if (isset($_FILES["fileToUpload"]["name"])) {
	
	$name = $_POST["event_name"];
	$address = $_POST["event_address"];
	$desc = $_POST["event_desc"];
	$date = $_POST["event_date"];
	$time = $_POST["event_time"];
	$memberid = $_POST["member_id"];
	$datetime = ''.$date.' '.$time.'';
	
	echo $datetime;
	
	if ($userid!==$memberid){echo "Nemate dozvolu uploadati!";}
	
//image upload
    $sql = mysqli_query($conn, "INSERT INTO events (name, address, description, datetime, member_id) 
		VALUES('$name','$address','$desc','$datetime', '$memberid')") or die (mysqli_error($conn));
	if(!$sql) {echo "Greska!";}
	$eventid = mysqli_insert_id($conn);
	mkdir("members/memberFiles/$memberid/Events/$eventid", 0777);
	
	$target_dir = "members/memberFiles/$memberid/Events/$eventid/";

$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "Datoteka je slika - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "Datoteka nije slika.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Datoteka već postoji.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Datoteka je prevelika";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Samo JPG, JPEG, PNG & GIF formati su dozvoljeni.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Datoteka nije prenesena.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $sql2 = mysqli_query($conn,"UPDATE events SET picture='$target_file' WHERE id=$eventid");
				if ($sql2) {header('Location: profile?id='.$memberid.'');} else echo "Koji k";
    } else {
        echo "Došlo je do pogreške prilikom prenošenja datoteke.";
    }
}
}
}
?>