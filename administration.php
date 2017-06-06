<?php
    require_once('config.php');
    session_start();
    
    if (!isset($_SESSION['admin-login'])) {
        header('Location: login.php');
        die();
    }
    
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Administracija</title>
		<meta charset="UTF-8"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="style.css"/>
	</head>
	<body>
		<main>
            <nav>
                <ul>
                    <li><a href="login.php">Administration</a></li>
                    <li><a href="access.php">Quiz</a></li>
                    <?php
                        if (isset($_SESSION['admin-login'])) {
                            echo "<li><a href='logout.php'>Logout</a></li>";
                        }
                    ?>
                </ul>
            </nav>
            <div class="clear"></div>
            <section>
                <form id="quizForm" name="quiz" action="questions-action.php" method="POST">
                    <h2><label for="pollName">Poll name:</label><input type="text" required="required" id="pollName"/></h2>
                    <?php
                        echo "<select id='pollCategory'>";
                        $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    
                    
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }
                        $stmt = $conn->prepare("SELECT * FROM $categoryTable ORDER BY id");
                        
                        $stmt->execute();
                        $res = $stmt->get_result();
                        while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
                            $cid = $row['id'];
                            $cname = $row['name'];
                            echo "<option value='$cid'>$cname</option>";
                        }
                    
                        echo "</select>";
                        $stmt->close();
                        $conn->close();
                    ?>
                    <br/>
                    <label for="accessCode">Access code:</label><input type="text" required="required" id="accessCode"/>
                    <div id="questionsContainer"></div>
                    <button type="button" id="addQuestionBtn">Add question</button><br/>
                    <input class="button" type="submit" name="submit" value="Submit"/>
                </form>
            </section>
		</main>
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="js/questions.js"></script>
	</body>
</html>