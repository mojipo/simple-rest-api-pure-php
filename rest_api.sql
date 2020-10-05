CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `username` varchar(60) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `name`, `username`, `password`) VALUES
(1, 'Mojtaba Matboyi', 'admin', '$2y$10$vGD9GFuRJz/F39qTgjrFPOTHYVzS9IOgFh6uWtDVFxCuhqgxBtN42');