<?php 
// require_once 'vendor/connect.php';

$login = "stasonchik1101@gmail.com";
$password = "Stas1101";
session_start();
// if($_SESSION['login'] === $login && $_SESSION['password'] === $password){
// 	header('Location: content/Main.html');
// }
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="node_modules\bootstrap\dist\css\bootstrap-grid.css" rel="stylesheet">
  <link href="SingStyle+.css" rel="stylesheet">
	<style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
	<title>Document</title>
</head>
<body>
	<form action="vendor/logIn.php" method="POST">
    <img src="img/mts_logo.png" alt="mts" height="100">
    <h1 class="h3 mb-3 fw-normal">Вход в MTS My Admin</h1>

    <div class="form-floating">
      <input type="email" name ='login'class="form-control" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">Email address</label>
    </div>
    <div class="form-floating">
      <input type="password" name ='password' class="form-control" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Password</label>
    </div>

    <div class="checkbox mb-3">
      <label>
        <input type="checkbox" value="remember-me"> Remember me
      </label>
    </div>
    <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
    <p class="mt-5 mb-3 text-muted">© 2017–2021</p>
  </form>
</body>
</html> 