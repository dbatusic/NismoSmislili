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
                <div id="errorContainer">
                    <p id="errorMessage"></p>
                </div>
                <form action="login-action.php" id="loginForm" method="post"  name="myForm" onclick="validateForm()">
                    <label for="username">Username</label>
                    <input type="text" name="username" class="unos" id="username"/>
                    <br/>
                    <label for="password">Password</label>
                    <input type="password" class="unos" name="password" id="password"/>
                    <br/>
                    <input type="submit" name="submit" id="submit" value="Log in"/>
                </form>
            </div>
		</main>
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="js/login.js"></script>
	</body>
</html>

<script type="text/javascript">
	function validateForm() {
		var poljeusername = document.getElementById("username");
		var x = document.forms["myForm"]["username"].value;
		if (x == "") {
		poljeusername.style.border="1px solid red";
		document.getElementById("username").innerHTML="Unesite nadimak!<br>";		
		return false;
		}
		var poljepassword = document.getElementById("password");
		var y = document.forms["myForm"]["password"].value;
		if (y == "") {
		poljepassword.style.border="1px solid red";
		document.getElementById("password").innerHTML="Unesite password!<br>";		
		return false;
		}
		
}
</script>
