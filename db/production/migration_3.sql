CREATE TABLE IF NOT EXISTS `lv_admin` (
`id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NULL
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `lv_admin` (`id`, `email`, `password`) VALUES
(1, 'admin@listaviernes.es', '40e1494fdf8ff66ff29f45790c28b4a0');
-- password: "admin"

ALTER TABLE `lv_admin` ADD PRIMARY KEY (`id`);
ALTER TABLE `lv_admin` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;

--

INSERT INTO `lv_migrations` (`id`) VALUES (3);
