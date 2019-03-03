DROP TABLE IF EXISTS `migrations`;

CREATE TABLE IF NOT EXISTS `migrations` (
`id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `migrations` ADD PRIMARY KEY (`id`);

--

INSERT INTO `migrations` (`id`) VALUES (0);
