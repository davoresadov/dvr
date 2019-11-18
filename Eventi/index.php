<?php
include('connection.php');
session_start(); 
if (isset($_SESSION['id'])) {
	
    $userid = $_SESSION['id'];
    $username = $_SESSION['username'];
}




?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
	

        <title><?php echo $name; ?></title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css.css">
		</head>
		<body>
		      
		     <div class="header">
			 <table id="menu">
			 <tr>
			 <td style="width:50%;">
  <img src="logo/logo_color_white.png" width="250px">
  </td>
  <td style="width:50%;text-align:right;">
  <?php
	if (isset($_SESSION['id'])) {
	echo '<a href="logout.php">'.$log_out.'</a>';
	} else {echo '<a href="login.php">'.$log_in.'</a>
					 &nbsp; &nbsp;
					<a href="reg.php">'.$sign_up.'</a>';}
	?>
  </td>
  </tr>
  </table>
</div>
<div class="content">
<div id="options">
	<button id="show_c" class="show_c"><img src="logo/city1.png" width="450px"></button>
	<button id="show_e" class="show_e"><img src="logo/event1.png" width="450px"></button>
	<button id="show_p" class="show_p"><img src="logo/profile1.png" width="450px"></button>
</div>
<div id="city_s" style="display: none;">
<form action="">

<select name="city" class="search" >
<option  value="" disabled selected hidden>Odaberi grad</option>
  <option value="Vinkovci">Vinkovci</option>
  <option value="Županja">Županja</option>
  <option value="Vukovar">Vukovar</option>
  <option value="Osijek">Osijek</option>
</select>
<br>
<br>
<input class="search" name="date" type="text" placeholder="Klikni i odaberi datum" onfocus="(this.type='date')" onblur="(this.type='text')">
<br>
<input name="submit" type="submit" class="main_btn" value="Traži">

</form>
<button id="hide_c" class="hide_btn">Vrati me nazad</button>
</div>	
<div id="event_s" style="display: none;">
<form action="searchbox.php">
      <input type="text" class="search" id="search" placeholder="Pronađi događaje po nazivu"/>
	  <input type="hidden" value="event" />
<div id="display">
</div>
        <button type="submit" class="main_btn">Pronađi</button>
    </form>
<button id="hide_e" class="hide_btn">Vrati me nazad</button>
</div>
<div id="profile_s" style="display: none;">
<form action="searchbox.php">
      <input type="text" class="search" id="search" placeholder="Pronađi organizatore"/>
	  <input type="hidden" value="profile" />
<div id="display">
</div>
      <button type="submit" class="main_btn">Pronađi</button>
    </form>
<button id="hide_p" class="hide_btn">Vrati me nazad</button>
</div>

<div class="footer">

</div>	
	</div>	
	
	<script>
$(document).ready(function(){
    $("#show_c").click(function(){
        $("#city_s").show();
		$("#options").hide();
    });
	$("#show_e").click(function(){
        $("#event_s").show();
		$("#options").hide();
    });
	$("#show_p").click(function(){
        $("#profile_s").show();
		$("#options").hide();
    });
	
	$("#hide_c").click(function(){
        $("#city_s").hide();
		$("#options").show();
    });
	$("#hide_e").click(function(){
        $("#event_s").hide();
		$("#options").show();
    });
	$("#hide_p").click(function(){
        $("#profile_s").hide();
		$("#options").show();
    });
});
</script>
<script>
function showDiv(elem){
   if(elem.value == 1)
      document.getElementById('hidden_div').style.display = "block";
}
</script>
		</body>
		</html>