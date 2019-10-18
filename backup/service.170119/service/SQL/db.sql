CREATE DATABASE `service`;
USE SERVICE;

CREATE TABLE `users`
(
	id INT PRIMARY KEY AUTO_INCREMENT,
	fio CHAR(30),
	login CHAR(12),
	password CHAR(50),
	rights TINYINT UNSIGNED;
)