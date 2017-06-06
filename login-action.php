<?php
    require_once('config.php');
    session_start();
    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    
    header('Content-Type: application/json');
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    /* Check if user exists. */
    $stmt = $conn->prepare("SELECT * FROM $userTable WHERE username = ?");
    $stmt->bind_param("s", $username);
    
    $username = $_POST['username'];
    $stmt->execute();
    
    $stmt->store_result();
    if ($stmt->num_rows == 0) {
        echo json_encode(array('error' => 'Korisničko ime ne postoji'));
        $stmt->close();
        $conn->close();
        return;
    }
    $stmt->close();
    /* Check if it is valid password. */
    $stmt = $conn->prepare("SELECT * FROM $userTable WHERE username = ? AND password = sha2(?,256)");
    $stmt->bind_param("ss", $username, $password);
    
    $username = $_POST['username'];
    $password = $_POST['password'];
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows == 0) {
        echo json_encode(array('error' => 'Pogrešna zaporuka'));
        $stmt->close();
        $conn->close();
        die();
    }

   
    /* Check if user has needed permissions. */
    //$result = $stmt->get_result();
    $row = $res->fetch_array(MYSQLI_ASSOC);
    if ($row['level'] > 1) {
        $_SESSION['admin-login'] = $username;
        echo json_encode(array('error' => 'no'));
    }
    else {
        echo json_encode(array('error' => 'Nedozvoljen pristup'));
    }
    $stmt->close();
    $conn->close();
?>