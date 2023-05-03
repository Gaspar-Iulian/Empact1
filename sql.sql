CREATE TABLE `news_articles` (
  `title` text NOT NULL,
  `description` text NOT NULL,
  `realease_date` datetime NOT NULL,
  `news_id` varchar(300) NOT NULL,
  `link` varchar(3000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `news_articles` (`title`, `description`, `realease_date`, `news_id`, `link`) VALUES
('Live Updates: Russia Claims It Foiled a Ukrainian Drone Attack on the Kremlin', 'Russia accused Ukraine of launching drones at the Kremlin aimed at killing President Vladimir V. Putin. The Ukrainian president denied the claim, and officials in Kyiv warned that Russia could use it to launch “a large-scale terrorist provocation.”', '2023-05-03 18:36:20', 'NYT-1669d79590968f4f7f412e0e6b3816ff', 'https://www.nytimes.com/live/2023/05/03/world/russia-ukraine-news');

ALTER TABLE `news_articles`
  ADD PRIMARY KEY (`news_id`);
COMMIT;
