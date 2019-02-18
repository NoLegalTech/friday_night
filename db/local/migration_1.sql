CREATE TABLE IF NOT EXISTS `usuario` (
`id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `activation_token` varchar(255) COLLATE utf8_unicode_ci NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NULL,
  `apellidos` varchar(255) COLLATE utf8_unicode_ci NULL,
  `dni` varchar(15) COLLATE utf8_unicode_ci NULL,
  `cp` varchar(10) COLLATE utf8_unicode_ci NULL,
  `oposicion_ideologia` tinyint(1) NOT NULL DEFAULT '0',
  `oposicion_propaganda_fijo` tinyint(1) NOT NULL DEFAULT '0',
  `oposicion_propaganda_movil` tinyint(1) NOT NULL DEFAULT '0',
  `oposicion_propaganda_email` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `email` (
`id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `telefono` (
`id` int(11) NOT NULL,
  `telefono` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `usuario` (`id`, `email`, `activation_token`, `password`, `nombre`, `apellidos`, `dni`, `cp`, `oposicion_ideologia`, `oposicion_propaganda_fijo`, `oposicion_propaganda_movil`, `oposicion_propaganda_email`) VALUES
(1, 'pepellou@gmail.com', NULL, 'a6449be1c42c7ad827d4a99e937b9d75', 'Pepe', 'Doval', '44474770S', '15895', 1, 1, 1, 1);

INSERT INTO `email` (`id`, `email`, `id_usuario`) VALUES
(1, 'pepellou@gmail.com', 1),
(2, 'thefuckingmaster@nolegaltech.com', 1);

INSERT INTO `telefono` (`id`, `telefono`, `id_usuario`) VALUES
(1, '650795886', 1),
(2, '881817077', 1);


ALTER TABLE `usuario` ADD PRIMARY KEY (`id`);
ALTER TABLE `usuario` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
ALTER TABLE `email` ADD PRIMARY KEY (`id`);
ALTER TABLE `email` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
ALTER TABLE `telefono` ADD PRIMARY KEY (`id`);
ALTER TABLE `telefono` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;

--

INSERT INTO `migrations` (`id`) VALUES (1);
