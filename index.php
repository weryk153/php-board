<?php
  require_once('./conn.php');
  require_once('./utils.php');
  require_once('./check_login.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css" />
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <title>K-hw2、3</title>
    <script>
      function escapeHtml(unsafe) {
        return unsafe
         .replace(/&/g, "&amp;")
         .replace(/</g, "&lt;")
         .replace(/>/g, "&gt;")
         .replace(/"/g, "&quot;")
         .replace(/'/g, "&#039;");
      }

      $(document).ready(() => {
        $('.board-comment').submit((e) => {
          e.preventDefault();
          const content = $(e.target).find('textarea[name=content]').val();
          const userId = $(e.target).find('input[name=user_id]').val();
          const parentId = $(e.target).find('input[name=parent_id]').val();
          $(e.target).find('textarea[name=content]').val('');
          $.ajax({
            type: 'POST',
            url: 'add_comment.php',
            data: {
              content: content,
              user_id: userId,
              parent_id: parentId
            },
            success: function(resp) {
              let res = JSON.parse(resp);
              if (res.result === 'success') {
                const escapeContent = escapeHtml(content);
                $('.board-message').prepend(`
                  <div class='post'>
                    <div class='post-edit'>
                      <form class="edit" method="POST" action="./update_comment.php">
                        <input type="hidden" name="user_id" value="<?= $user_id ?>">
                        <input type="hidden" name="comment_id" value="${res.comment_id}">
                        <input type='submit' class='btn' value='編輯'>
                      </form>
                      <form class="edit-delete" method="POST" action="./delete_comment.php">
                        <input type="hidden" name="user_id" value="<?= $user_id ?>">
                        <input type="hidden" name="comment_id" value="${res.comment_id}">
                        <input type='submit' class='btn btn-delete' value='刪除'>
                      </form>
                    </div>
                    <div class='post-header'>
                      <div class='post-author'><?= escape($nickname) ?></div>
                      <div class='post-timestamp'>${res.created_at}</div>
                    </div>
                    <div class='post-content'>${escapeContent}</div>
                    <div class="post__childs">
                      <form class="sub-board-comment" method="POST" action="./add_comment.php">
                        <textarea name="content" class="sub-textarea" placeholder="留言內容" style="outline:none;"></textarea>
                        <input type="hidden" name="user_id" value="<?= $user_id ?>">
                        <input type="hidden" name="parent_id" value="${res.comment_id}">
                        <input type='submit' class='btn' value='送出'>
                      </form>
                    </div>
                  </div>   
                `);
              }
            }
          });
        });
        $('.board-message').submit((e) => {
          if ($(e.target).hasClass('edit-delete')) {
            e.preventDefault();
            const commentId = $(e.target).find('input[name=comment_id]').val();
            const userId = $(e.target).find('input[name=user_id]').val();
            $.ajax({
              type: 'POST',
              url: 'delete_comment.php',
              data: {
                comment_id: commentId,
                user_id: userId
              },
              success: function(resp) {
                let res = JSON.parse(resp);
                if (res.result === 'success') {
                $(e.target).parent().parent().remove();
                }
              }
            });
          }
        });
      });
    </script>
  </head>
  <body>
    <?php include_once('templates/navbar.php'); ?>
    <h1 class="board-title">本站為練習用網站，因教學用途刻意忽略資安的實作，註冊時請勿使用任何真實的帳號或密碼</h1>
    <div class="board">
      <form class="board-comment" method="POST" action="./add_comment.php">
        <textarea name="content" class="textarea" placeholder="留言內容" style="outline:none;"></textarea>
        <input type="hidden" name="user_id" value="<?= $user_id ?>">
        <input type="hidden" name="parent_id" value="0">
        <?php 
          if ($is_login) {
            echo "<input type='submit' class='btn' value='送出'>";
          } else {
            echo "<input type='submit' class='btn' value='請先登入' disabled>";
          }
        ?>
      </form>
      <div class="board-message">
      <?php
        include_once('pagination.php');
    
        $sql = "SELECT c.content, c.created_at, c.id, c.user_id, k_users.nickname FROM k_comments as c JOIN k_users ON c.user_id = k_users.id WHERE c.parent_id = 0 ORDER BY created_at DESC LIMIT $limit_start, $num";
        $result_comment = $conn->query($sql);
        if ($result_comment->num_rows > 0) {
          while ($row_comment = $result_comment->fetch_assoc()) {
            $chr_escape = escape($row_comment['content']);
            $content_with_br = str_replace(chr(13).chr(10), "<br />", $chr_escape);
            require('template_comment.php');
      ?>
      <?php }} ?>
      </div>
      <div class='board-pagination'>
      <?php
        if ($page > 0 ) {
          echo   "<a href='./index.php?page=" . $pre . "'>上一頁</li>";
        }
        if ($page + 1 < $pages) {
          echo   "<a href='./index.php?page=" . $next . "'>下一頁</li>";
        }
        $conn->close();
      ?>
      </div>
    </div>
  </body>
</html>