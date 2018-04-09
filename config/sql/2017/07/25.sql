CREATE TABLE `promociones` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`nombre` varchar(255),
	`url` varchar(255),
	`vigencia_inicio` datetime,
	`vigencia_fin` datetime,
	`orden` int(11),
	`status` int(11),
	`created` datetime,
	`modified` datetime,
	`deleted` tinyint(1) DEFAULT 0,
	PRIMARY KEY (`id`)
) COMMENT='';

ALTER TABLE `banners` 
	ADD COLUMN `status` tinyint(1) DEFAULT 0 AFTER `url`, 
	ADD COLUMN `created` datetime AFTER `status`,
	ADD COLUMN `modified` datetime AFTER `created`, 
	ADD COLUMN `deleted` tinyint(1) DEFAULT 0 AFTER `modified`;

ALTER TABLE `banners` 
	DROP COLUMN `contenido`, 
	DROP COLUMN `principal`, 
	ADD COLUMN `vigencia_inicio` date AFTER `nombre`, 
	ADD COLUMN `vigencia_fin` date AFTER `vigencia_inicio`, 
	ADD COLUMN `orden` int(11) AFTER `vigencia_fin`;

CREATE TABLE `sucursales` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(255),
	`url` varchar(255),
	`estado_id` int(11),
	`municipio_id` int(11),
	`created` datetime,
	`modified` datetime,
	`deleted` tinyint(1) DEFAULT 0,
	PRIMARY KEY (`id`)
) COMMENT='';


ALTER TABLE `categorias` ADD COLUMN `url` varchar(255) AFTER `image`;

ALTER TABLE `subcategorias` ADD COLUMN `url` varchar(255) AFTER `deleted`;

ALTER TABLE `categorias` ADD COLUMN `other_url` varchar(255) AFTER `url`;


CREATE TABLE `ofertas` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`titulo` varchar(250),
	`color_fondo` varchar(10),
	`color_fuente` varchar(10),
	`producto_id` int(11),
	`precio_lista` tinyint(1) DEFAULT 0,
	`meses_sin_intereses` tinyint(1) DEFAULT 0,
	`precio_promocion` tinyint(1),
	`descuento_promocion` tinyint(1) DEFAULT 0,
	`vigencia_inicio` date,
	`vigencia_fin` date,
	`status` int(11) DEFAULT 0,
	`created` datetime,
	`modified` datetime,
	`deleted` tinyint(1) DEFAULT 0,
	PRIMARY KEY (`id`)
) COMMENT='';

CREATE TABLE `oferta_tipos` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(255),
	PRIMARY KEY (`id`)
) COMMENT='';