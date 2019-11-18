<?php
 include_once "connection.php";
session_start();


if (isset($_SESSION['id'])) {
	$id2 = $_SESSION['id'];
    header("Location: profile.php?id=$id2");
}

if ($_POST['email']) {


$email = stripslashes($_POST['email']);
$email = strip_tags($email);
$email = mysqli_real_escape_string($conn, $email);
$password = preg_replace("[^A-Za-z0-9]", "", $_POST['password']); 
$password = md5($password);

$sql = mysqli_query($conn, "SELECT * FROM members WHERE email='$email' AND password='$password' "); 
$login_check = mysqli_num_rows($sql);
if($login_check > 0){ 
    while($row = mysqli_fetch_array($sql)){ 
        
        $_SESSION['id'] = $row["id"];
		$id = $row["id"];
        
        
	    $_SESSION['username'] = $row["username"];  
       
        
        
        mysqli_query("UPDATE members SET lastlogin=now() WHERE id='$id'"); 
       
		header("location: profile.php?id=$id"); 
		exit();
    } 
} else {

  print '<br /><br /><font color="#FF0000">No user with that mail or password. :/ </font><br />
<br /><a href="login.php">Try again.</a>';
  exit();
}
} 
?>

<html>
<head>
<link href="favicon.ico" rel="icon" type="image/x-icon" />
<title><?php echo $prijavi_me; ?></title>
<script type="text/javascript">

function validate_form ( ) { 
valid = true; 
if ( document.logform.email.value == "" ) { 
alert ( "Unesite Vš mail!" ); 
valid = false;
}
if ( document.logform.pass.value == "" ) { 
alert ( "Unesite lozinku!" ); 
valid = false;
}
return valid;
}

</script>
   
</head>
<body>
<link rel="stylesheet" type="text/css" href="css.css">
     <table width="600" align="center" cellpadding="4" border="0" style="margin-top:5%;">
  <tr>
    <td ><a href="index.php" ><img src="logo/logo_color_white.png" style="width:300px;"></a></td>
	
  </tr>
</table>
     <table width="600" align="center" cellpadding="4" border="0">
      <form action="login.php" method="post" enctype="multipart/form-data" name="logform" id="logform" onsubmit="return validate_form ( );">
        <tr>
          <td><input  class="search" name="email" type="text" id="email" placeholder="Vaš mail" /></td>
        </tr>  
        <tr>
         
          <td><input  class="search" name="password" type="password" id="password"  placeholder="Lozinka"/></td>
        </tr>
        <tr>
         
          <td><input class="main_btn"  name="Submit" type="submit" value="Prijavi se" /></td>
        </tr>
      </form>
    </table>
</body>
</html>