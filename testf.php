<?php
require_once('pdodb.php');
//take information from xml
$rss_url = 'https://rss.nytimes.com/services/xml/rss/nyt/World.xml';
$rss = simplexml_load_file($rss_url);
$items = array();
//take data publication
foreach ($rss->channel->item as $item) {
    $pubDate = strtotime($item->pubDate); 
    $dateTime = new DateTime($item->pubDate);
    $day = $dateTime->format('Y-m-d');
    $items[$day][] = array(
        'pubDate' => $dateTime,
        'item' => $item
    );
}
// verify search
if (isset($_GET['search'])) {
    $searchResults = array();
    foreach ($items as $day => $dayItems) {
        foreach ($dayItems as $itemData) {
            $item = $itemData['item'];
            if (stripos($item->title, $_GET['search']) !== false || stripos($item->description, $_GET['search']) !== false) {
                $searchResults[$day][] = $itemData;
            }
        }
    }
}
 else {
    $searchResults = $items;
}

//generate uniq id
foreach ($rss->channel->item as $item){
$id = 'NYT-'    . md5($day . $item->title);
  $items[$day][$pubDate][$id] = $item; 
}
?>

<!DOCTYPE html>
<html>
<head>

<script src="script.js"></script>
    <link rel="stylesheet" href="styles.css">
    <title>New-York Times</title>
</head>
<body>
  <header>
        <h1 class="title-h1"><br>New-York Times News</h1>
        <div class="container-box">
            <form action="" class="search-bar">
            <!--<p class=search-p>search your favorite article<p> -->
                <div class="src-container">
                    <input type="search" placeholder="Search.." name="search">
                    <button class="search-btn" type="submit">
                        <span>Search</span>
                    </button>
                </div>
            </form>
            <a href="favorite.php" class="art-btn">Favorite Articles</a>
            <a href="testf.php" class="art-btn">Main Page</a>
        </div>
  </header>
    <div class="container-box st-main">
        <h2><?php echo isset($_GET['search']) ? 'Search Results' : 'Latest News'; ?></h2>
        <?php if (empty($searchResults)) : ?>
          <p>No results found for : "<?php echo $_GET['search']; ?>"</p>
        <?php else : ?>
        <ul>
            <?php foreach($searchResults as $day => $dayItems) : ?>
                <li class="day-heading"><h1 class="rls-h1">Released at:<h1> <?php echo $day ?></li>
                <?php 
                    // sort articles by time
                    usort($dayItems, function($a, $b) {
                        return $b['pubDate'] <=> $a['pubDate'];
                    });
                ?>
                <?php foreach($dayItems as $itemData) : 
                    
                    $item = $itemData['item']; 
                
                    // check if article is already in favorites
                    $id = 'NYT-' . md5($day . $item->title);
                    $sql = "SELECT * FROM news_articles WHERE news_id = '$id'";
                    $stmt= $pdo->prepare($sql);
                    $stmt->execute();
                    $num_rows =$stmt->rowCount(); 
                ?>
                <li>
                    <h2><?php echo $item->title; ?></h2>
                    <p><?php echo $item->description; ?></p>
                    <p>Release date: <?php echo $itemData['pubDate']->format('Y-m-d H:i:s'); ?></p>
                    <!-- <p>ID: <?php echo $id; ?></p>  -->
                    <a class="rdm-a" href="<?php echo $item->link; ?>">Read more...</a>
                    <?php if ($num_rows == 0) : ?>
                    <form method="post" action="adauga_news.php">
                        <input type="hidden" name="title" value="<?php echo $item->title; ?>">
                        <input type="hidden" name="description" value="<?php echo $item->description; ?>">
                        <input type="hidden" name="release_date" value="<?php echo $itemData['pubDate']->format('Y-m-d H:i:s'); ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="link" value="<?php echo $item->link; ?>">
                        <button class="adauga-btn" type="submit">ADD to favorite</button>
                    </form>
                    <?php endif; ?>
                </li>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>
    <?php require_once('footer.php');?>
</body>
</html>

