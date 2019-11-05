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
  <div class="container">
    <h3 class="board-title">本站為練習用網站，因教學用途刻意忽略資安的實作，註冊時請勿使用任何真實的帳號或密碼</h3>
    <form class="register-page" method="POST" action="./handle_register.php">
      <div class="register-block">
        暱稱：<input type="text" name="nickname">
      </div>
      <div class="register-block">
        帳號：<input type="text" name="username">
      </div>
      <div class="register-block">
        密碼：<input type="password" name="password">
      </div>
      <div class="register-block">
        <a href="./index.php" class="">回到首頁</a>
        <input type="submit" value="註冊">
      </div>
    </form>
  </div>
</body>
</html>