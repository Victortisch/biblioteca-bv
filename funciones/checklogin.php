<?php	 
	/* start the session */
	session_start();
	 
	?>
	 
	<!DOCTYPE html>
	<html lang="en">
	 
	<head>
	 <title>Check Login</title>
	 <meta charset = "utf8" />
	</head>
	 
	<?php
	 
	$host_db = "localhost";
    $user_db = "root";
    $pass_db = "";
    $db_name = "biplogin";
    $tbl_name = "users";
	 
	// Connect to server and select databse.
	mysql_connect("$host_db", "$user_db", "$pass_db")or die("Cannot Connect to DataBase.");
	 
	mysql_select_db("$db_name")or die("Cannot Select DataBase");
	 
	// sent from form
	$username = $_POST['username'];
	$password = $_POST['password'];
	$password = base64_encode($password);
	 
	$sql= "SELECT * FROM $tbl_name WHERE username = '$username' and password='$password'";
	 
	$result=mysql_query($sql);
	 
	// counting table row
	$count = mysql_num_rows($result);
	// If result matched $username and $password
	 
	if($count == 1){
	 
	$_SESSION['loggedin'] = true;
	$_SESSION['username'] = $username;
	$_SESSION['start'] = time();
	$_SESSION['expire'] = $_SESSION['start'] + (15 * 60) ;
    $sql = "UPDATE `users` SET `last_session` = now() WHERE `username` = '".$_SESSION['username']."';";
    mysql_query($sql)or die(mysql_error());
	 
	header("Location:../index.php");	
	 
	}
	 else { ?>
	 <script> 
		function redirecciona(){
		var miform= document.getElementById('miformulario');
		miform.submit();
		}
		</script>

		<body onload="redirecciona();">
		<form id="miformulario" action="../login.php" method="POST">
		<input type="hidden" name="message" value="Usuario o contraseña incorrectos. Por favor vuelva a intentar.">
		</form>	
		</body>
	<?php
	}
	 
	?>
	</html>