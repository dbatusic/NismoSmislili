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
		<form action="quiz.php" method="post" name="myForm" onclick="validateForm()">
			<input type="text" name="code" id="code">
			<input type="submit" name="submit" id="submit" value="Start">
		</form>
		</div>
		</main>
	</body>
</html>

<script type="text/javascript">
	function validateForm() {
		var poljecode = document.getElementById("code");
		var x = document.forms["myForm"]["code"].value;
		if (x == "") {
		poljecode.style.border="1px solid red";
		document.getElementById("code").innerHTML="Unesite kod!<br>";		
		return false;
		}
		
		
}
</script>
