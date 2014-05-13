<?php

/**
 * Connect to the database
 *
 * I haven't done this for a long time, I prefer something like: https://github.com/joelvardy/database
 */
return new mysqli('localhost', 'root', 'password', 'store');

/**
 * SQL for the targets table
CREATE TABLE `targets` (
	`id` int UNSIGNED NOT NULL AUTO_INCREMENT,
	`added` int UNSIGNED NOT NULL,
	`ip` varchar(256) NOT NULL,
	`email` varchar(255) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
 */
