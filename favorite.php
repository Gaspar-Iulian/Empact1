<?php
require_once('pdodb.php');

$stmt = $pdo->query('SELECT * FROM news_articles ORDER BY realease_date DESC');
$articles = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html>
<head>
	<title>Your Favorite Articles</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
	<header>
		<h1 class="title-h1">Your Favorite Articles</h1>
        <a href="testf.php" class="art-btn">Main Page</a>
	</header>
	<main>
		<?php
			foreach ($articles as $article) {
				echo '<div class="container-box">';
				echo '<h3>' . $article['title'] . '</h3>';
				echo '<p>' . $article['description'] . '</p>';
				echo '<p>Release date: ' . $article['realease_date'] . '</p>';
                echo '<p>' . $article['news_id'] . '</p>';
				echo '<a class="rdm-a" href="' . $article['link'] . '">Read more...</a>';
                echo '<form method="post" action="sterge.php">';
                echo '<input type="hidden" name="news_id" value="' . $article['news_id'] . '">';
                echo '<input class="adauga-btn" type="submit" name="submit" value="DELETE">';
                echo '</form>';
				echo '</div>';
			}
            
		?>
	</main>
    <?php require_once('footer.php');?>
</body>
</html>
