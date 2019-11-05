<?php
  require_once('./conn.php');

  if (
    isset($_POST['comment_id']) && 
    !empty($_POST['comment_id']) &&
    isset($_POST['user_id']) && 
    !empty($_POST['user_id']) 
  ) {
    $comment_id = $_POST['comment_id'];
    $user_id = $_POST['user_id'];
    $sql = "SELECT * FROM k_comments WHERE id = '$comment_id' AND user_id = $user_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
    } else {
      header('Location: ./index.php');
    }
  } else {
    header('Location: ./index.php');
  }
  $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="./style.css" />
  <title>K-hw2、3</title>
</head>
<body>
  <div class="container__index">
    <h2 class="board-title">編輯留言</h2>
    <form class="board" method="POST" action="./handle_update_comment.php">
      <div class="board-comment">
        <?php
          echo "<textarea type='text' name='content' class='textarea' style='outline:none;'>" . $row['content'] . "</textarea>";
          echo "<input type='hidden' name='comment_id' value='" . $row['id'] . "'>";
          echo "<input type='hidden' name='user_id' value='" . $user_id . "'>";
        ?>
        <input type="submit" value="送出">
      </div>
    </form>
  </div>
</body>
</html>