<?php
include('connection.php');
if($_POST)
{
	
//present events based on the form user used	
	
if($s=='city')	{
	
	
	$city=$_POST['city'];
	$date=$_POST['date'];
	header('Location: date.php?date='.$date.'&city='.$city.'');
	
}
	
$s=$_POST['s'];	
	
if($s=='profile')	{	

$q=mysqli_real_escape_string($conn,($_POST['searchword']));
$sql_res1=mysqli_query($conn, "select * from members where (name like '%$q%') order by id LIMIT 5");
$count1 = mysqli_num_rows($sql_res1);
while($row1=mysqli_fetch_array($sql_res1))
{
$fname1=$row1['name'];
$img=$row1['profile_img'];
$re_fname1='<b>'.$q.'</b>';

$final_fname1 = str_ireplace($q, $re_fname1, $fname1);

echo'
<div class="display_box" align="left">
<img src="
'.$img.'" />
'.$final_fname1.'&nbsp;

</div>

';
}

}	
	
if($s=='event')	{	

$q=mysqli_real_escape_string($conn,($_POST['searchword']));	
$sql_res2=mysqli_query($conn, "select * from events where (name like '%$q%') order by id LIMIT 5");
$count2 = mysqli_num_rows($sql_res2);
if ($count2!==0) {
	echo '<hr>';
	}
while($row2=mysqli_fetch_array($sql_res2))
{
$fname2=$row2['name'];
$img2=$row2['picture'];
$re_fname2='<b>'.$q.'</b>';

$final_fname2 = str_ireplace($q, $re_fname2, $fname2);

echo'
<div class="display_box" align="left">
<img src="
'.$img2.'" />
'.$final_fname2.'&nbsp;

</div>
';
}
}
}
else
{}
?>
