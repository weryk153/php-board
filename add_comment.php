<?php
  require_once('./conn.php');
  
  if (isset($_POST['content']) && !empty($_POST['content'])) {
    $content = $_POST['content'];
    $user_id = $_POST['user_id'];
    $parent_id = $_POST['parent_id'];

    $sql = "INSERT INTO k_comments(content, user_id, parent_id) VALUE('$content', $user_id, $parent_id)";
    $conn->query($sql);
    
    $sql = "SELECT * FROM k_comments WHERE user_id = $user_id order by id desc limit 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $comment_id = $row['id'];
      $created_at = $row['created_at'];
    }
    
    $conn->close();
    if ($parent_id == 0) {
      $arr = array('result' => 'success', 'comment_id' => $comment_id, 'created_at' => $created_at);
      echo json_encode($arr);
    } else {
      header('Location: ./index.php');
    }
  }
?>