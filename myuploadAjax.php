<?php

include 'db.php';
session_start(); // Starting Session
 
$s_uid = $_SESSION["s_uid"];
$itype = $_POST["itype"];
$msg='';
$status=0;
$link = "";
$valid_formats = array("jpg", "png", "jpeg", "gif", "zip", "bmp");
$max_file_size = 500*500; //100 kb
$path = "pic/"; // Upload directory
$count = 0;

function clean($string) {
	$string = str_replace(' ', '_', $string); // Replaces all spaces with hyphens.

	return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

if($itype=='pic')
{




if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
	// Loop $_FILES to execute all files
	foreach ($_FILES['files']['name'] as $f => $name) {

		
		$newname = $s_uid.clean($uname).'.png';		
		if(file_exists($newname)) {
			chmod($newname,0755); //Change the file permissions if allowed
			unlink($newname); //remove the file
		}
		
		
		if ($_FILES['files']['error'][$f] == 4) {
			continue; // Skip file if any error found
		}
		if ($_FILES['files']['error'][$f] == 0) {
			if ($_FILES['files']['size'][$f] > $max_file_size) {
				$message[] = "$name is too large!.";
				continue; // Skip large files
			}
			elseif( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
				$message[] = "$name is not a valid format";
				continue; // Skip invalid file formats
			}
			
			
			else{ // No error found! Move uploaded files
				if(move_uploaded_file($_FILES["files"]["tmp_name"][$f], $path.$newname)) {
					$count++; // Number of successfully uploaded files
				}
			}
		}
	}
}
$pic = $path.$newname;

$sql = "UPDATE `tolly_user` SET `pic`='".$pic."'  WHERE  `uid`=".$s_uid;
//$status = $sql;
$result = mysqli_query ( $conn, $sql );

if ( $result > 0) {
	$msg= "Image Uploaded Successfully ";	 
}

header('Location: myprofile.php'); 
}


$arr = array('msg' => $msg, 'status' => $status);
echo json_encode($arr);



?>


<head>
	<meta charset="UTF-8" />
	<title>Multiple File Upload with PHP - Demo</title>
<style type="text/css">
a{ text-decoration: none; color: #333}
h1{ font-size: 1.9em; margin: 10px 0}
p{ margin: 8px 0}
*{
	margin: 0;
	padding: 0;
	box-sizing: border-box;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	-webkit-font-smoothing: antialiased;
	-moz-font-smoothing: antialiased;
	-o-font-smoothing: antialiased;
	font-smoothing: antialiased;
	text-rendering: optimizeLegibility;
}
body{
	font: 12px Arial,Tahoma,Helvetica,FreeSans,sans-serif;
	text-transform: inherit;
	color: #333;
	background: #e7edee;
	width: 100%;
	line-height: 18px;
}
.wrap{
	width: 500px;
	margin: 15px auto;
	padding: 20px 25px;
	background: white;
	border: 2px solid #DBDBDB;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	overflow: hidden;
	text-align: center;
}
.status{
	/*display: none;*/
	padding: 8px 35px 8px 14px;
	margin: 20px 0;
	text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
	color: #468847;
	background-color: #dff0d8;
	border-color: #d6e9c6;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
}
input[type="submit"] {
	cursor:pointer;
	width:100%;
	border:none;
	background:#991D57;
	background-image:linear-gradient(bottom, #8C1C50 0%, #991D57 52%);
	background-image:-moz-linear-gradient(bottom, #8C1C50 0%, #991D57 52%);
	background-image:-webkit-linear-gradient(bottom, #8C1C50 0%, #991D57 52%);
	color:#FFF;
	font-weight: bold;
	margin: 20px 0;
	padding: 10px;
	border-radius:5px;
}
input[type="submit"]:hover {
	background-image:linear-gradient(bottom, #9C215A 0%, #A82767 52%);
	background-image:-moz-linear-gradient(bottom, #9C215A 0%, #A82767 52%);
	background-image:-webkit-linear-gradient(bottom, #9C215A 0%, #A82767 52%);
	-webkit-transition:background 0.3s ease-in-out;
	-moz-transition:background 0.3s ease-in-out;
	transition:background-color 0.3s ease-in-out;
}
input[type="submit"]:active {
	box-shadow:inset 0 1px 3px rgba(0,0,0,0.5);
}
</style>

</head>
<div class="wrap">
		<h1><a href="http://www.w3bees.com/2013/02/multiple-file-upload-with-php.html">Multiple File Upload with PHP</a></h1>
		<?php
		# error messages
		if (isset($message)) {
			foreach ($message as $msg) {
				printf("<p class='status'>%s</p></ br>\n", $msg);
			}
		}
		# success message
		if($count !=0){
			printf("<p class='status'>%d files added successfully!</p>\n", $count);
		}
		?>
		<p>Max file size 100kb, Valid formats jpg, png, gif</p>
		<br />
		<br />
		<H1><a href="actordata.php">BACK</a></H1>
		
</div>