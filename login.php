<!DOCTYPE html>
<html>
	<head>
		<title> Početna </title>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<main id="welcome">
		<nav>
			<ul>
				<li><a href="login.php">Administration</a></li>
				<li><a href="access.php">Quiz</a></li>
			</ul>
		</nav>
		<div class="clear"></div>
		<div class="middle">
		<h1>Login</h1>
		<form action="administration.php" method="post">
			Username<input type="text" name="username" class="unos" id="username">
			<br/>
			Password<input type="password" class="unos" name="password" id="password">
			<br/>
			<input type="submit" name="submit" id="submit" value="Log in">
		</form>
		</div>
		</main>
	</body>
</html>