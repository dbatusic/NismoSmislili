<!DOCTYPE html>
<html>
	<head>
		<title> Index </title>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<main>
		<nav>
	
			<ul>
				<li><a href="login.php">Administration</a></li>
				<li><a href="access.php">Quiz</a></li>
			</ul>
		</nav>
		<div class="clear"></div>
		<section>
		<form id="quiz" name="quiz" action="skripta.php" method="POST">
			<h3> Question </h3>
			<textarea name="question" rows="5" cols="50"></textarea>
			<h3> Answers </h3>
			<?php
			//pitanja admin mora sam dodavati
			?>
			<br/><br/>
			<h3> Question type </h3><br/>
			<select name="type">
			  <option value="check">Checkbox</option>
			  <option value="radio">Radiobutton</option>
			  <option value="text">Text</option>
			</select>
			<br/>
			<br/>
			<input class="button" type="submit" name="submit" value="Submit">
		</form>
		</section>
		</main>
	</body>
</html>