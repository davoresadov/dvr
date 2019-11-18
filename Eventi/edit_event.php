<?php
session_start(); 
include('connection.php');

if (isset($_SESSION['id'])) {
	
    $userid = $_SESSION['id'];
    $username = $_SESSION['username'];
    $eventid = $_GET["id"];
	
	
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	
	$name = $_POST["event_name"];
	$address = $_POST["event_address"];
	$desc = $_POST["event_desc"];
	$date = $_POST["event_date"];
	$time = $_POST["event_time"];
	$memberid = $_POST["member_id"];
	$targetfile = $_POST["target_file"];
	$datetime = ''.$date.' '.$time.'';
	
	
	if ($userid!==$memberid){echo "Nemate dozvolu mijenjati!";}
	
//image upload
	
	if (isset($_FILES["fileToUpload"]["name"])) {
	$target_dir = "members/memberFiles/$memberid/Events/$eventid/";

$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
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
	
	
//if everything is ok, edit in table
	
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        
		$targetfile = $target_file;
		
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
} else $targetfile = $targetfile;

$sql3 = mysqli_query($conn,"UPDATE events SET name = '$name', address = '$address', description = '$desc', picture = '$targetfile', datetime = '$datetime' WHERE id = '$eventid' ");
				if ($sql3) {header('Location: event.php?id='.$eventid.'');} else  echo mysqli_error($conn);


}

//get event info

$sql2 = mysqli_query($conn, "SELECT * FROM events WHERE id='$eventid'");

while($row2 = mysqli_fetch_array($sql2)){
	$event_id = $row2["id"];
	$name = $row2["name"];	
	$desc = $row2["description"];
	$targetfile= $row2["picture"];
	$address= $row2["address"];
	$datetime = $row2["datetime"];
	$member_id = $row2["member_id"];

	$pieces = explode(" ", $datetime);
	$date = $pieces[0]; 
	$time = $pieces[1]; 

}


?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
       
        <title><?php echo $name; ?></title>
	</head>
	
	<body>

	<!--Fill form with existing event info for user to change-->
	
		<form action="edit_event.php?id=<?php echo $eventid; ?>" method="post" enctype="multipart/form-data" id="event_form" name="event_form"   >
			<input type="file" name="fileToUpload" id="fileToUpload" >
			<img id="event_img" src="<?php echo $targetfile; ?>" width="200px"/>
			<input name="event_name" placeholder="Ime događaja" type="text" value="<?php echo $name; ?>" required>
			<input name="event_address" placeholder="Adresa događaja" type="text" value="<?php echo $address; ?>" required>
			<textarea name="event_desc" placeholder="Opis događaja..." value="<?php echo $desc; ?>">
			</textarea>
			<input name="event_date" placeholder="Ime događaja" type="date" value="<?php echo $date; ?>" required>
			<input name="event_time" placeholder="Ime događaja" type="time" value="<?php echo $time; ?>" required>
			<input type="hidden" id="member_id" name="member_id" value="<?php echo $userid; ?>" >
			<input type="hidden" id="target_file" name="target_file" value="<?php echo $targetfile; ?>" >
			<input type="hidden" id="event_id" name="event_id" value="<?php echo $eventid; ?>" >
			<input id="submit" type="submit" value="Submit">
		</form>
		
		
	</body>
</html>

<?php } ?>