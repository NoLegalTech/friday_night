CREATE TABLE IF NOT EXISTS `lv_partido` (
`id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `lv_partido` (`id`, `email`, `password`) VALUES
(1, 'partido@listaviernes.es', 'a832706874838cf19b7a754c8d810d39'),

ALTER TABLE `lv_partido` ADD PRIMARY KEY (`id`);
ALTER TABLE `lv_partido` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;

--

INSERT INTO `lv_migrations` (`id`) VALUES (2);
