<?php
    require_once('config.php');
    session_start();
    if (!isset($_SESSION['pollName'])) {
        header('Location: access.php');
        die();
    }
?>
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
                <form action="answer-action.php" method="post">
                <?php
                    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    
                    
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    
                    $stmt = $conn->prepare("SELECT * FROM $pollsTable WHERE name = ?");
                    $stmt->bind_param("s", $pollName);
                    
                    $pollName = $_SESSION['pollName'];
                    $stmt->execute();
                    
                    $res = $stmt->get_result();
                    if ($res->num_rows == 0) {
                        //echo json_encode(array('error' => 'Korisničko ime ne postoji'));
                        echo 'kriva zaporuka kviza';
                        $stmt->close();
                        $conn->close();
                        die();
                    }
                    $row = $res->fetch_array(MYSQLI_ASSOC);
                    $pname = $row['name'];
                    $pid = $row['id'];
                    $stmt->close();
                    $stmt = $conn->prepare("SELECT * FROM $categoryTable WHERE id = ?");
                    $stmt->bind_param("i", $row['categoryId']);
                    
                    $stmt->execute();
                    $res = $stmt->get_result();
                    $row = $res->fetch_array(MYSQLI_ASSOC);
                    $stmt->close();
                    
                    $pcategory = $row['name'];
                    
                    echo "<p>Category: $pcategory</p>";
                    echo "<p>Quiz: $pname</p>";
                    
                    $qStmt = $conn->prepare("SELECT * FROM $questionsTable WHERE pollId = ? ORDER BY id");
                    $qStmt->bind_param("i", $pid);
                    
                    $qStmt->execute();
                    
                    $qRes = $qStmt->get_result();
                    if ($qRes->num_rows == 0) {
                    //handle no questions
                    }
                    $qno = 1;
                    while ($qRow = $qRes->fetch_array(MYSQLI_ASSOC)) {
                        //qRow:id,pollId,type,question,isAnon
                        $qid = $qRow['id'];
                        $qQuestion = $qRow['question'];
                        echo "<div class='userQContainer'>";
                        echo "<p>Question No. $qno</p>";
                        $msg = "Question ";
                        if ($qRow['isAnon'])
                            $msg .= 'is';
                        else
                            $msg .= 'is not';
                        $msg .= ' anonymous.';
                        echo "<p>$msg</p>";
                        echo "<label>Question</label><p>$qQuestion</p>";
                        $aStmt = $conn->prepare("SELECT * FROM $answersTable WHERE questionId = ? ORDER BY id");
                        $aStmt->bind_param("i", $qid);
                        $aStmt->execute();
                        $aRes = $aStmt->get_result();
                        //
                        if ($aRes->num_rows == 0) {
                        // handle no answers
                        }
                        while ($aRow = $aRes->fetch_array(MYSQLI_ASSOC)) {
                            //aRow:id,questionId,type,answer
                            $ans = $aRow['answer'];
                            if ($aRow['type'] == 'text') {
                                echo "<input placeholder='Short answer' type='text'/><br/>";
                            }
                            else if ($aRow['type'] == 'checkbox') {
                                echo "<input type='checkbox'/><label>$ans</label><br/>";
                            }
                            else if ($aRow['type'] == 'radio') {
                                echo "<input type='radio'/><label>$ans</label><br/>";
                            }
                        }
                        echo "</div>";
                        $aStmt->close();
                        $qno++;
                    }
                    $qStmt->close();
                    $conn->close();
                ?>
                    <input type="submit" value="Post"/>
                </form>
            </div>
		</main>
	</body>
</html>