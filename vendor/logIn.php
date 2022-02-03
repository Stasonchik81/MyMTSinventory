<?php 
$login = "stasonchik1101@gmail.com";
$password = "Stas1101";

if($login == $_POST['login'] && $password == $_POST['password']){
	// auth
	session_start();
	$_SESSION['login'] = $login;
	$_SESSION['password'] = $password;
	header('Location: ../content/Main.html');
}
else{
	echo "BAD!";
}

 ?>