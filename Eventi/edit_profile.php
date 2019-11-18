<?php 
session_start();
include('connection.php');

if (isset($_SESSION['id'])) {
	
    $userid = $_SESSION['id'];
    $username = $_SESSION['username'];
    
//get user info from a form in users profile 	
	
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	
	$name = $_POST["profile_name"];
	$address = $_POST["profile_address"];
	$about = $_POST["profile_about"];
	$date = $_POST["event_date"];
	$time = $_POST["event_time"];
	$memberid = $_POST["profile_id"];
	$targetfile = $_POST["target_file"];
	$targetfile2 = $_POST["target_file2"];
	
	
	if ($userid!==$memberid){echo "Nemate dozvolu mijenjati!";}
	
//image upload
	
	if (isset($_FILES["profileToUpload"]["name"])) {
	$target_dir = "members/memberFiles/$memberid/Profile_img/";

$target_file = $target_dir . basename($_FILES["profileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["profileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Check file size
if ($_FILES["profileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
	
	$files = glob(''.$target_dir.'*'); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file))
    unlink($file); // delete file
}
	
    if (move_uploaded_file($_FILES["profileToUpload"]["tmp_name"], $target_file)) {
        
		$targetfile = $target_file;
		
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
} else $targetfile = $targetfile;

	
	
	
	if (isset($_FILES["coverToUpload"]["name"])) {
	$target_dir2 = "members/memberFiles/$memberid/Cover_img/";

$target_file2 = $target_dir2 . basename($_FILES["coverToUpload"]["name"]);
$uploadOk2 = 1;
$imageFileType2 = strtolower(pathinfo($target_file2,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check2 = getimagesize($_FILES["coverToUpload"]["tmp_name"]);
    if($check2 !== false) {
        echo "File is an image - " . $check2["mime"] . ".";
        $uploadOk2 = 1;
    } else {
        echo "File is not an image.";
        $uploadOk2 = 0;
    }
}

// Check file size
if ($_FILES["coverToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk2 = 0;
}
// Allow certain file formats
if($imageFileType2 != "jpg" && $imageFileType2 != "png" && $imageFileType2 != "jpeg"
&& $imageFileType2 != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk2 = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk2 == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
	
	$files2 = glob(''.$target_dir2.'*'); // get all file names
foreach($files2 as $file2){ // iterate files
  if(is_file($file2))
    unlink($file2); // delete file
}
	
    if (move_uploaded_file($_FILES["coverToUpload"]["tmp_name"], $target_file2)) {
        
		$targetfile2 = $target_file2;
		
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
} else $targetfile2 = $targetfile2;

$sql3 = mysqli_query($conn,"UPDATE members SET name = '$name', about = '$about', address = '$address', profile_img = '$targetfile', cover_img = '$targetfile2' WHERE id = '$memberid' ");
				if ($sql3) {header('Location: profile.php?id='.$memberid.'');} else  echo mysqli_error($conn);


}
}

?>