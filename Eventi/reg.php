<?php
include 'connection.php';
$errorMsg = "";

if (isset($_SESSION['id'])) {
	$id2 = $_SESSION['id'];
    header("Location: profile.php?id=$id2");
}

if (isset($_POST['email'])){ 

	 
	$errorMsg = "";
	
	 
	$email = stripslashes($_POST['email']);
	$name = stripslashes($_POST['name']);
	$email = strip_tags($email);
	$email = mysqli_real_escape_string($conn, $email);
	$password = preg_replace("[^A-Za-z0-9]", "", $_POST['password']); 
	
	if((!$email) || (!$name) || (!$password)){
		
		$errorMsg = "".$enter_info."<br /><br />";
		 if(!$email){ 
	       $errorMsg .= "--- Email"; 
	   } 
	    if(!$name){ 
	       $errorMsg .= "--- ".$title.""; 
	   }
	   else if(!$password){ 
	       $errorMsg .= "--- ".$pass.""; 
	   }
	} else {
	// duplikacije u sustavu
	
	$sql_email_check = mysqli_query($conn, "SELECT id FROM members WHERE email='$email' LIMIT 1");
	
	$email_check = mysqli_num_rows($sql_email_check); 
	 if ($email_check > 0){ 
		$errorMsg = "<u>ERROR:</u><br />".$email_in_use."";
	} else {
		// haœs na lozinku
       $hashedPass = md5($password); 
       
       $part1 = explode("@", $email);
$part2 = $part1[1];
$part3 = $part1[0];
$po = mb_substr($part3, 0, 5);
$pt = mb_substr($part2, 0, 3);
$num = rand(1, 100);
$username = ''.$po.''.$pt.''.$num.'';

		
		$sql = mysqli_query($conn, "INSERT INTO members (name, username, email, password, profile_img, cover_img, emailactivated, signupdate) 
		VALUES('$name','$username','$email','$hashedPass', 'profile.jpg', 'cover.jpg', '0', now())") or die (mysqli_error($conn));
		
		if($sql) {
		
		
		}
		// umetnut id
		$id = mysqli_insert_id($conn);
		
		
		
		// kreiraj mapu
		mkdir("members/memberFiles/$id", 0777); 
		mkdir("members/memberFiles/$id/Events", 0777);
		mkdir("members/memberFiles/$id/Profile_img", 0777);
		mkdir("members/memberFiles/$id/Cover_img", 0777);
		
		// poslati email 
		$to = $email;
		// Change this to your site admin email
		$from = "welcome@cooler.com.hr";
		$subject = "Sign in - Cooler.";
		//Begin HTML Email Message where you need to change the activation URL inside
		$message = '<html>
		<body bgcolor="¶FFFFFF">
		Hi ' . $username . '!
		<br /><br />
		Welcome! :) We hope that you will make Cooler more interesting. ;)
		<br><br>
		 &gt;&gt;
		<a href="http://www.cooler.com.hr/users/activation.php?id=' . $id . '">
		Activate my Cooler!</a>
		<br /><br />
		Your Cool info: 
		<br /><br />
		E-mail: ' . $email . ' <br />
		Password: ' . $password . ' 
		<br /><br /> 
		Thank You! 
		</body>
		</html>';
		// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'To:  <'.$email.'>' . "\r\n";
$headers .= 'From: <welcome@cooler.com.hr>' . "\r\n";
$headers .= 'Cc: welcome@cooler.com.hr' . "\r\n";
$headers .= 'Bcc: welcome@cooler.com.hr' . "\r\n";

// Mail it
mail($to, $subject, $message, $headers);
		
if(@mail($to, $subject, $message, $headers))
{

session_start();

 $_SESSION['id'] = $id;
		
        
        
	    $_SESSION['username'] = $username;  
       



  header("Location: profile.php?id=$id");
}else{
  echo 'Error...';
}		 
	} 
  } 
} 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<link rel="stylesheet" type="text/css" href="css.css">
<link href="favicon.ico" rel="icon" type="image/x-icon" />

<title><?php echo $registracija; ?></title>
  
</head>
<body>

<table border="0" width="600" align="center" cellpadding="5" style="margin-top:2.5%;">
  <form action="reg.php" method="post" >
  <tr>
    <td ><a href="index.php" ><img src="logo/logo_color_white.png" style="width:300px;"></a></td>
	
  </tr>
    <tr>
      <td colspan="2"><font color="¶FF0000"><?php echo "".$errorMsg.""; ?></font></td>
    </tr>
	
	<tr>
      
      <td><input  class="search" name="name" type="text" placeholder="Ime" /></td>
    </tr>
    <tr>
      
      <td><input  class="search" name="email" type="text" placeholder="Email" /></td>
    </tr>
    <tr>
      
      <td><input class ="search" name="password" type="password" placeholder="Lozinka" /> 
      </td>
    </tr>
      
    <tr>
      
      <td><input class="main_btn"  type="submit" name="Submit" value="Registriraj me" /></td>
    </tr>
  </form>
</table>

</body>
</html>