<?php
include('connection.php');
$id= $_GET['id'];
session_start(); 
if (isset($_SESSION['id'])) {
	
    $userid = $_SESSION['id'];
    $username = $_SESSION['username'];
} else {$userid = '';}

$sql = mysqli_query($conn, "SELECT * FROM members WHERE id='$id' LIMIT 1");
$count = mysqli_num_rows($sql);
if ($count > 1) {
	echo $user_doesnt_exist;
	exit();	
}
$sqll = mysqli_query($conn, "SELECT * FROM members WHERE id='$id' LIMIT 1");
$countl = mysqli_num_rows($sqll);
if ($countl==0) {
	echo $user_doesnt_exist;
	exit();	
}
while($row = mysqli_fetch_array($sql)){
	$name = $row["name"];	
	$about = $row["about"];
	$address = $row["address"];
	$profile_img= $row["profile_img"];
	$username = $row["username"];
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="ISO-8859-1">
       
        <title><?php echo $name; ?></title>
		<link rel="stylesheet" type="text/css" href="profile.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		

		
		
    </head>
    <body>
     <div class="header">
		<table class="header_table" align="center" cellspacing="10">
			<tr>
				<td width="80%">
					<a style="background:transparent;" href="index.php"><img src="logo/logo_color_white.png" width="25%" valign="top"></a>
				</td>
				<td align="right">
  <?php
  
  if (isset($_SESSION['id'])) {
	  
	  ?>
					<div class="profile_info">
	
		
				<!-- Trigger/Open The Modal -->
						<a id="event_btn"><img width="30px" src="logo/add.png"></a>
						<a id="profile_btn"><img width="30px" src="logo/user_edit.png"></a>
							<div id="profile_modal" class="modal">
								<div class="modal-content">
									<span class="close1">&times;</span>
									<form action="edit_profile.php" method="post" enctype="multipart/form-data" id="profile_form" name="profile_form">
										Profilna slika:
										<img id="profile_img" src="<?php echo $profile_img; ?>" width="200px"/><br>
										<input type="file" name="profileToUpload" id="profileToUpload" ><br>
										<input type="text" name="profile_name" value="<?php echo $name; ?>" required><br>
										<textarea name="profile_about" placeholder="<?php echo $about; ?>" ></textarea><br>
										<input type="text" name="profile_address" value="<?php echo $address; ?>" required><br>
										<input type="hidden" name="profile_id" value="<?php echo $userid; ?>" >
										<input type="hidden" id="target_file" name="target_file" value="<?php echo $profile_img; ?>" >
										<input type="hidden" id="target_file2" name="target_file2" value="<?php echo $cover_img; ?>" >
										<input type="submit" name="submit" value="Promijeni">
									</form>
								</div>
							</div>
 
							<div id="event_modal" class="modal">

								<!-- Modal content -->
								<div class="modal-content">
									<span class="close">&times;</span>

									<div id="mainform">

										<!-- Required Div Starts Here -->
										<form action="new_event.php" method="post" enctype="multipart/form-data" id="event_form" name="event_form"   >
											<input type="file" name="fileToUpload" id="fileToUpload" required>
											<img id="event_img" width="200px"/>

											<input class="search" name="event_name" placeholder="Ime događaja" type="text" required>
											<input name="event_address" placeholder="Adresa događaja" type="text" required>
											<textarea name="event_desc" placeholder="Opis događaja...">
											</textarea>
											<input name="event_date" placeholder="Ime događaja" type="date" required>
											<input name="event_time" placeholder="Ime događaja" type="time" required>
											<input type="hidden" id="member_id" name="member_id" value="<?php echo $userid; ?>" required>
											<input id="submit" type="submit" value="Submit">
										</form>
<script>
document.getElementById("fileToUpload").onchange = function () {
    var reader = new FileReader();
	

    reader.onload = function (e) {
        // get loaded data and render thumbnail.
        document.getElementById("event_img").src = e.target.result;
    };

    // read the image file as a data URL.
    reader.readAsDataURL(this.files[0]);
};
</script>
<!--<script>
    function validateForm()
    {
        var a=document.forms["event_form"]["event_name"].value;
        var b=document.forms["event_form"]["event_address"].value;
        var c=document.forms["event_form"]["event_desc"].value;
        var d=document.forms["event_form"]["fileToUpload"].value;
		var e=document.forms["event_form"]["event_date"].value;
		var f=document.forms["event_form"]["event_time"].value;
        if (a==null || a=="",b==null || b=="",c==null || c=="",d==null || d=="" || e=="" || f=="")
        {
            alert("Please Fill All Required Field");
            return false;
        }
    }
</script>-->
									</div>
								</div>

							</div>
<script>

 // Get the modal
var modal = document.getElementById('event_modal');

// Get the button that opens the modal
var btn = document.getElementById("event_btn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
};

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
};

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
};



</script>		
		<br>
		</div>	
<?php
  }
?>
				</td>
  <td  align="right">
  
	<?php
	if (isset($_SESSION['id'])) {
	echo '<a href="logout.php">'.$log_out.'</a>';
	} else {echo '<a  href="login.php">'.$log_in.'</a>
					
					<a href="reg.php">'.$sign_up.'</a>';}
	?>
			</td>
		</tr>
	</table>
</div>
        <div class="content">
	
	
			<table align="center" style="width:60%;" border="0" cellspacing="10">
				<tr>
					<td style="width:30%;" valign="top">
						<img style="width:100%;height:20%;" src="<?php echo $profile_img ?>">
						<br>
						<div style="width:200px;color:#5B5B5B;padding-top:15px;">
							<b style="color:#333;font-size:20px;"><?php echo $name ?></b>
							<br>
							<?php echo $address ?>
						</div>
					</td>
					<td valign="top" height="100%">
						<div class="mapouter">
						<div class="gmap_canvas">
						<iframe width="100%" height="100%" id="gmap_canvas" src="https://maps.google.com/maps?q=<?php echo $address; ?>&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0">
						</iframe>
						</div>
						<style>.mapouter{text-align:right;height:100%;}.gmap_canvas {overflow:hidden;background:none!important;height:300px;}</style>
						</div>
					</td>
				</tr>
				<tr>
					<td style="text-align:left;width:100px;" valign="top">
		
					</td>
					<td>
						<div class="events">
		
							<?php
$sql2 = mysqli_query($conn, "SELECT * FROM events WHERE member_id='$id' ORDER BY id DESC");
$count2 = mysqli_num_rows($sql2);

if ($count2==0) {
	
	exit();	
} else {
	
while($row2 = mysqli_fetch_array($sql2)){
	$event_id = $row2["id"];
	$name = $row2["name"];	
	$description = $row2["description"];
	$picture= $row2["picture"];
	$event_address= $row2["address"];
	$datetime = $row2["datetime"];
	$date = new DateTime($datetime);
	$f_date = $date->format("d.m.Y");
	$time = $date->format("H:m");


echo '<div class="event" id="event'.$event_id.'">
		<table cellpadding="10"  width="100%">
			<tr>
				<td valign="top" width="40%">

					<img width="100%" src="'.$picture.'">
		
				</td>
				<td valign="top"> 
					<b><a href="event.php?id='.$event_id.'">'.$name.'</a></b>
					<br>
					'.$description.'
					<br>
					<br>
					<img width="22px" src="logo/placeholder.png">	'.$event_address.'
					<br>
					<img width="22px" src="logo/calendar.png">	'.$f_date.' u ' .$time.'
				</td>
			</tr>

	';
	
		if ($userid == $id){
			echo'
			<tr>
				<td style="text-align:right;" colspan="2">
					<button class="btn-danger"><a id="'.$event_id.'">Obriši događaj</a></button>
		
					<a href="edit_event.php?id='.$event_id.'">Uredi događaj</a>
				</td>
			</tr>
		';
		}
		echo'
		</table>
	</div>';

}

}

		?>
		<!--event delete button...popravi -->
		<script type="text/javascript">
    $(document).ready(function() {
        $('.btn-danger').click(function() {
            var id = $(this).attr("id");
            if (confirm("Are you sure you want to delete this Member?")) {
                $.ajax({
                    type: "POST",
                    url: "delete_event.php",
                    data: ({
                        id: id
                    }),
                    cache: false,
                    success: function(html) {
                        $("#event" + id).fadeOut('slow');
                    }
                });
            } else {
                return false;
            }
        });
    });
</script>
		</div>
		</td>
		</tr>
	</table>	
		

		
		
		
</div>
				

 <script>
	var modal1 = document.getElementById('profile_modal');

// Get the button that opens the modal
	var btn1 = document.getElementById("profile_btn");

// Get the <span> element that closes the modal
	var span1 = document.getElementsByClassName("close1")[0];

// When the user clicks the button, open the modal 
	btn1.onclick = function() {
		modal1.style.display = "block";
	};

// When the user clicks on <span> (x), close the modal
	span1.onclick = function() {
		modal1.style.display = "none";
	};

// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event1) {
		if (event1.target == modal1) {
			modal1.style.display = "none";
		}
	};
  </script>
			
</body>


</html>
