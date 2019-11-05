<div class='post'>
  <?php if ($user_id == $row_comment['user_id']) { ?>
    <div class='post-edit'>
      <form class="edit" method="POST" action="./update_comment.php">
        <input type="hidden" name="user_id" value="<?= $user_id ?>">
        <input type="hidden" name="comment_id" value="<?= $row_comment['id'] ?>">
        <input type='submit' class='btn' value='編輯'>
      </form>
      <form class="edit-delete" method="POST" action="./delete_comment.php">
        <input type="hidden" name="user_id" value="<?= $user_id ?>">
        <input type="hidden" name="comment_id" value="<?= $row_comment['id'] ?>">
        <input type='submit' class='btn' value='刪除'>
      </form>
    </div>
    <?php } ?>
    <div class='post-header'>
      <div class='post-author'><?= escape($row_comment['nickname']) ?></div>
      <div class='post-timestamp'><?= $row_comment['created_at'] ?></div>
    </div>
    <div class='post-content'><?= $content_with_br ?></div>
    
    <div class="post__childs">
    <?php
      $parent_id = $row_comment['id'];
      $sql_sub = "SELECT c.content, c.created_at, c.id, c.user_id, k_users.nickname 
        FROM k_comments as c JOIN k_users ON c.user_id = k_users.id 
        WHERE c.parent_id = $parent_id 
        ORDER BY created_at 
        DESC LIMIT $limit_start, $num";
        
      $result_sub_c = $conn->query($sql_sub);
      if ($result_sub_c->num_rows > 0) {
        while ($row_sub_c = $result_sub_c->fetch_assoc()) {
          $chr_escape = escape($row_sub_c['content']);
          $content_with_br = str_replace(chr(13).chr(10), "<br />", $chr_escape);
    ?>
    <?php 
      if ($row_comment['user_id'] === $row_sub_c['user_id']) {
        echo "<div class='same-post__child'>";
      } else {
        echo "<div class='post__child'>";
      }
    ?>
    <?php if ($user_id == $row_sub_c['user_id']) { ?>
      <div class='post-edit'>
        <form class="edit" method="POST" action="./update_comment.php">
          <input type="hidden" name="user_id" value="<?= $user_id ?>">
          <input type="hidden" name="comment_id" value="<?= $row_sub_c['id'] ?>">
          <input type='submit' class='btn' value='編輯'>
        </form>
        <form class="edit-delete" method="POST" action="./delete_comment.php">
          <input type="hidden" name="user_id" value="<?= $user_id ?>">
          <input type="hidden" name="comment_id" value="<?= $row_sub_c['id'] ?>">
          <input type='submit' class='btn' value='刪除'>
        </form>
      </div>
    <?php } ?>
      <div class='post-header'>
        <div class='post-author'><?= escape($row_sub_c['nickname']) ?></div>
        <div class='post-timestamp'><?= $row_sub_c['created_at'] ?></div>
      </div>
      <div class='post-content'><?= $content_with_br ?></div>
    </div>
    <?php }} ?>
    <?php if ($is_login) { ?>
      <form class="sub-board-comment" method="POST" action="./add_comment.php">
        <textarea name="content" class="sub-textarea" placeholder="留言內容" style="outline:none;"></textarea>
        <input type="hidden" name="user_id" value="<?= $user_id ?>">
        <input type="hidden" name="parent_id" value="<?= $parent_id ?>">
        <input type='submit' class='btn' value='送出'>
      </form>
    <?php } ?>
  </div>
</div>