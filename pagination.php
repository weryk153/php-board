<?php 
  if (!isset($_GET['page'])) {
    $page = 0;
  } else {
    $page = $_GET['page'];
  }
  $num = 20;
  $limit_start = $page * $num;
  $next = $page + 1;
  $pre = $page - 1;
  $sql = "SELECT * FROM k_comments ORDER BY created_at DESC";
  $result = $conn->query($sql);
  $total = $result->num_rows;
  $pages = ceil($total / $num);
?>
