<?php
require_once('pdodb.php');

$data = [
    'title' => $_POST['title'],
    'description' => $_POST['description'],
    'realease_date' => $_POST['release_date'],
    'news_id' => $_POST['id'],
    'link' => $_POST['link']
];
$sql = "INSERT INTO news_articles (title, description, realease_date, news_id, link) VALUES (:title, :description, :realease_date, :news_id, :link)";
$stmt= $pdo->prepare($sql);
$stmt->execute($data);

header("Location: {$_SERVER['HTTP_REFERER']}");
exit();
?>