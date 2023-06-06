SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `todos`;
CREATE TABLE `todos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Ожидает проверки',
  `edited` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `todos` (`id`, `name`, `email`, `description`, `status`, `edited`) VALUES
(1,	'admin',	'vam@test.com',	'Описание задачи',	'Выполнено',	0),
(2,	'user',	'vam1@test.com',	'Описание задачи 1',	'Выполнено',	1),
(3,	'admin2',	'vam2@test.com',	'Описание задачи 2',	'Выполняется',	0),
(4,	'user3',	'vam@test.com',	'Описание задачи 3',	'Ожидает проверки',	0),
(5,	'test',	'vamshop@gmail.com',	'описание',	'Ожидает проверки',	0),
(6,	'vam',	'vam@test.com',	'fgdgdfgd',	'Ожидает проверки',	0),
(7,	'vamshop',	'aaa@test.com',	'dfsffsfd',	'Ожидает проверки',	0),
(8,	'bbb',	'bbb@test.com',	'bbbbb',	'Ожидает проверки',	0),
(9,	'aaa',	'vvv@test.com',	'ddfggfdggfd',	'Ожидает проверки',	0),
(10,	'ccc',	'sdfsdsd@sdfs.com',	'описание',	'Ожидает проверки',	0),
(11,	'ddd',	'sdfsf@sdfsfddf.com',	'43534534345',	'Выполнено',	1),
(12,	'test',	'test@test.com',	'test job',	'Ожидает проверки',	0),
(13,	'<b>test</b><script>alert();</script>12',	'vam@test.com',	'<b>test</b><script>alert();</script>',	'Выполнено',	1);

-- 2023-06-06 17:53:49