DROP TABLE IF EXISTS `lv_migrations`;

CREATE TABLE IF NOT EXISTS `lv_migrations` (
`id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `lv_migrations` ADD PRIMARY KEY (`id`);

--

INSERT INTO `lv_migrations` (`id`) VALUES (0);
