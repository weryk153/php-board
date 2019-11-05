<?php
  require_once('./conn.php');

  if (
    isset($_POST['comment_id']) && 
    isset($_POST['user_id']) && 
    !empty($_POST['comment_id']) &&
    !empty($_POST['user_id'])
  ) {
    $id = $_POST['comment_id'];
    $user_id = $_POST['user_id'];
    $sql = "DELETE FROM k_comments WHERE id = $id AND user_id = $user_id";
    if ($conn->query($sql)) {
      $arr = array('result' => 'success');
      echo json_encode($arr);
      //header('Location: ./index.php');
    } else {
      echo "failed: " . $conn->error;
    }
    $conn->close();
  }
?>