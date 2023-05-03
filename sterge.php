<?php
if(isset($_POST['submit'])) {
  require_once('pdodb.php');

  $id = isset($_POST['news_id']) ? $_POST['news_id'] : null;


  $stmt = $pdo->prepare('DELETE FROM news_articles WHERE news_id = ?');
  $stmt->execute([$id]);


  header('Location: favorite.php');
  exit();
}
?>