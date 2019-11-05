<nav class="nav">
  <?php
    if ($is_login) {
      echo "<ul>";
      echo   "<li><a href='./register.php'>註冊</a></li>";
      echo   "<li>" . escape($nickname) . "您好" . "</li>";
      echo   "<li><a href='./logout.php'>登出</a></li>";
      echo "</ul>";     
    } else {
      echo "<ul>";
      echo   "<li><a href='./register.php'>註冊</a></li>";
      echo   "<li><a href='./login.php'>登入</a></li>";
      echo "</ul>";
    }
  ?>
</nav>