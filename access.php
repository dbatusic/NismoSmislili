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
            <!--<b>Fill in the code to access the quiz.</b>
            <form action="quiz.php" method="post">
                <input type="text" name="code" id="code">
                <input type="submit" name="submit" id="submit" value="Start">
            </form>-->
            <?php
                require_once('config.php');
                session_start();
                
                $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                
                if (isset($_POST['pollName'])) {
                    $stmt = $conn->prepare("SELECT * FROM $pollsTable WHERE name = ? AND accessCode = ?");
                    $stmt->bind_param("ss", $pollName, $accessCode);
    
                    $pollName = $_POST['pollName'];
                    $accessCode = $_POST['code'];
                    
                    $stmt->execute();
                    $res = $stmt->get_result();
                    if ($res->num_rows != 0) {
                        $_SESSION['pollName'] = $pollName;
                        header('Location:view-poll.php');
                        $stmt->close();
                        $conn->close();
                        die();
                    }
                    else {
                        echo "<p>Wrong access code! Please try again.</p>";
                    }
                    
                    $stmt->close();
                }
                
                $stmt = $conn->prepare("SELECT * FROM $pollsTable ORDER BY id");

                $stmt->execute();
                
                $res = $stmt->get_result();
                if ($res->num_rows == 0) {
                    $stmt->close();
                    $conn->close();
                    return;
                }
                
                
                
                echo "<table border='1'>";
                echo "<tr><th>Category</th><th>Quiz</th><th>Code</th><th>&nbsp;</th></tr>";

                while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
                    $name = $row['name'];
                    $categoryId = $row['categoryId'];
                    
                    
                    $cStmt = $conn->prepare("SELECT * FROM $categoryTable WHERE id = ?");
                    $cStmt->bind_param("i", $categoryId);
                    
                    $cStmt->execute();
                    $cRes = $cStmt->get_result();
                    $cRow = $cRes->fetch_array(MYSQLI_ASSOC);
                    $cStmt->close();
                    
                    $category = $cRow['name'];
                    echo "<form method='post' action='access.php'>";
                    echo "<input type='hidden' name='pollName' value='$name'/>";
                    echo "<tr><td>$category</td><td>$name</td><td><input type='text' name='code'/></td><td><input type='submit' value='Access'/></td></tr>";
                    echo "</form>";
                }
                echo "</table>";
                $stmt->close();
                $conn->close();
            ?>
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
