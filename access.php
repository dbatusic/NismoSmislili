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
		<b>Fill in the code to access the quiz.</b>
		<form action="quiz.php" method="post">
			<input type="text" name="code" id="code">
			<input type="submit" name="submit" id="submit" value="Start">
		</form>
		</div>
		</main>
	</body>
</html>