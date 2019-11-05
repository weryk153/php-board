<?php
  session_start();  
  $is_login = false;
  $user_id = '';

  if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    $is_login = true;
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM k_users WHERE username = ?";    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $nickname = $row['nickname'];
    $user_id = $row['id'];
  }
?>