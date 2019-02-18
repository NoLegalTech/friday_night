CREATE TABLE IF NOT EXISTS `lv_usuario` (
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

CREATE TABLE IF NOT EXISTS `lv_email` (
`id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `lv_telefono` (
`id` int(11) NOT NULL,
  `telefono` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `lv_usuario` (`id`, `email`, `activation_token`, `password`, `nombre`, `apellidos`, `dni`, `cp`, `oposicion_ideologia`, `oposicion_propaganda_fijo`, `oposicion_propaganda_movil`, `oposicion_propaganda_email`) VALUES
(1, 'usuario@listaviernes.es', NULL, 'a6449be1c42c7ad827d4a99e937b9d75', 'Usuario', 'de Prueba', '12345678X', '08080', 1, 1, 1, 1);
-- password: "merda"

INSERT INTO `lv_email` (`id`, `email`, `hash`, `id_usuario`) VALUES
(1, 'usuario@listaviernes.es', 'de326a2bb50111f541752936140ea4f2', 1),
(2, 'otro_email@listaviernes.es', '4ff446271c867998ff444d8cbecb1dd5', 1);

INSERT INTO `lv_telefono` (`id`, `telefono`, `hash`, `id_usuario`) VALUES
(1, '600123456', '390876e3b3f6ac5552291fb81f173ca3', 1),
(2, '881881881', 'fed84af4500b9fb2e3ceceb64a469b13', 1);


ALTER TABLE `lv_usuario` ADD PRIMARY KEY (`id`);
ALTER TABLE `lv_usuario` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
ALTER TABLE `lv_email` ADD PRIMARY KEY (`id`);
ALTER TABLE `lv_email` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
ALTER TABLE `lv_telefono` ADD PRIMARY KEY (`id`);
ALTER TABLE `lv_telefono` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;

--

INSERT INTO `lv_migrations` (`id`) VALUES (1);
