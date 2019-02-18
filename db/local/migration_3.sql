CREATE TABLE IF NOT EXISTS `admin` (
`id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NULL
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `admin` (`id`, `email`, `password`) VALUES
(1, 'admin@listaviernes.es', 'c8de333441a1201f1d394cf76bd5c33d'),

ALTER TABLE `admin` ADD PRIMARY KEY (`id`);
ALTER TABLE `admin` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;

--

INSERT INTO `migrations` (`id`) VALUES (3);
