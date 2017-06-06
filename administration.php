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
                <form id="quiz" name="quiz" action="skripta.php" method="POST">
                    <div id="firstQuestion" data-qid="1">
                        <h3>Question</h3>
                        <textarea name="question" rows="5" cols="50"></textarea>
                        <br/>
                        <br/>
                        <h3>Question type</h3>
                        <select id="questionType" name="questionType">
                            <option value="check">Checkbox</option>
                            <option value="radio">Radiobutton</option>
                            <option value="text">Text</option>
                        </select>
                        <br/>
                        <br/>
                        <div id="answerSheet">
                        
                        </div>
                    </div>
                    <input class="button" type="submit" name="submit" value="Submit"/>
                </form>
            </section>
		</main>
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="js/questions.js"></script>
	</body>
</html>