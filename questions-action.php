<?php
    require_once('config.php');
    session_start();
    
    if (!isset($_SESSION['admin-login'])) {
        header('Location: login.php');
    }
    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    
    header('Content-Type: application/json');
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    
    $pollData = json_decode(file_get_contents('php://input'));
    
    $data = $pollData->questions;
    $pStmt = $conn->prepare("INSERT INTO polls (name,categoryId,accessCode) VALUES (?,?,?)");
    $pStmt->bind_param("sss", $pollData->name, $pollData->category, $pollData->code);
    $pStmt->execute();
    $pid = $conn->insert_id;
    $pStmt->close();
    
    $qStmt = $conn->prepare("INSERT INTO questions (pollId,type,question,isAnon) VALUES (?,?,?,?)");
    $qStmt->bind_param("issi", $pid,$qType, $qQuestion, $qIsAnon);
    
    $n = count($data);
    for ($i = 0; $i < $n; $i++) {
        $qType = $data[$i]->type;
        $qQuestion = $data[$i]->desc;
        $qIsAnon = $data[$i]->anon;
        $qStmt->execute();
        $an = count($data[$i]->answers);
        
        $qid = $conn->insert_id;
        
        $aStmt = $conn->prepare("INSERT INTO answers (questionId,type,answer) VALUES (?,?,?)");
        $aStmt->bind_param("iss", $aQid, $aType, $aAnswer);
        for ($j = 0; $j < $an; $j++) {
            $aQid = $qid;
            $aType = $qType;
            $aAnswer = $data[$i]->answers[$j]->desc;
            $aStmt->execute();
        }
        $aStmt->close();
    }
    
    
    $qStmt->close();
    $conn->close();
?>