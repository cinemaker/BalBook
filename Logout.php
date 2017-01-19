<!DOCTYPE html>
<html>
<head>
	<title>Logout</title>
</head>
<body>
	<?php 
		session_id($_GET["id"]);
		session_start();
		session_destroy();

		
		header("Location: Loginscreen.php");
	 ?>
</body>
</html>