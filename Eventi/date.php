<?php
include('connection.php');
session_start(); 
if (isset($_SESSION['id'])) {
	
    $userid = $_SESSION['id'];
    $username = $_SESSION['username'];
}
$date= $_GET['date'];
$city= $_GET['city'];



?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
       
        <title><?php echo $name; ?></title>
	</head>
	<body>
		     <div class="header">
				<img src="logo.png">
					<div class="search-container">
						<form action="search.php">
							<input type="text" placeholder="" name="search">
							<button type="submit">Opleti</button>
						</form>
	<?php
	
	
	
	if (isset($_SESSION['id'])) {
	echo '<a href="logout.php">'.$log_out.'</a>';
	} else {
		echo '<a href="login.php">'.$log_in.'</a>
					<br>
					<a href="reg.php">'.$sign_up.'</a>';
			}
	?>
					</div>
			</div>
	<?php
	
	//Events ordered by selected date and city
	
		$sql = mysqli_query($conn, "SELECT * FROM events WHERE date='$date' AND city ='$city'");

        while($row = mysqli_fetch_array($sql)){
			$event_id = $row["id"];
			$name = $row["name"];	
			$description = $row["description"];
			$picture= $row["picture"];
			$address= $row["address"];
			$datetime = $row["datetime"];
			$member_id = $row["member_id"];

			echo '<div class="event">
					<img src="'.$profile_img.'"
					Događaj organizira <a href="profile.php?id='.$member_id.'">'.$member_name.'</a>
					<br>
					<a href="event.php?id='.$event_id.'">'.$name.'</a>
					<br>
					'.$description.'
					<br>
					'.$address.'
					<br>
					'.$datetime.'
					<br>
					<img src="memeberFiles/'.$id.'/Events/'.$picture.'">
		
					<br>
				';
			if ($userid == $member_id){
				echo'
				<a href="delete_event">Obriši događaj</a>
				<br>
				<a href="edit_event.php?id='.$event_id.'">Uredi događaj</a>
				';
			}
			echo'
					<div class="mapouter">
						<div class="gmap_canvas">
							<iframe width="300" height="300" id="gmap_canvas" src="https://maps.google.com/maps?q='.$address.'&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0">
							</iframe>
						</div>
						<style>.mapouter{text-align:right;height:300px;width:300px;}.gmap_canvas {overflow:hidden;background:none!important;height:300px;width:300px;}</style>
					</div>
				</div>';

}
		?>
		
		
		</body>
		</html>