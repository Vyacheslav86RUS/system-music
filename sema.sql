-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Мар 09 2016 г., 16:25
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `sema`
--

-- --------------------------------------------------------

--
-- Структура таблицы `concert`
--

CREATE TABLE IF NOT EXISTS `concert` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time_start` varchar(255) NOT NULL,
  `time_end` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `concert`
--

INSERT INTO `concert` (`id`, `time_start`, `time_end`) VALUES
(1, '1457520648', '1457524248'),
(2, '1457522753', '1457522753'),
(3, '1457524565', '1457524565'),
(4, '1457524930', '2147483647'),
(5, '1457526163', '1457608920');

-- --------------------------------------------------------

--
-- Структура таблицы `songs`
--

CREATE TABLE IF NOT EXISTS `songs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `author` text NOT NULL,
  `genre` text NOT NULL,
  `year` varchar(128) NOT NULL,
  `album` text NOT NULL,
  `lang` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `songs`
--

INSERT INTO `songs` (`id`, `name`, `author`, `genre`, `year`, `album`, `lang`) VALUES
(1, 'Ой мороз', 'Не известный', 'Народные', '1970', 'Народные хиты 70', 'Русский'),
(2, 'Прости, прощай, не вспоминай...', 'Стрелки', 'Pop, Dance', '2016', 'Прости, прощай, не вспоминай... ', 'Русский'),
(3, 'Just Dance', 'Lady GaGa', 'Поп-музыка', '2010', 'Gaga Takeover', 'Английский');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(32) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(128) NOT NULL DEFAULT '',
  `priv` int(11) NOT NULL DEFAULT '0' COMMENT '1-admin, 0-user',
  `vote` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `email`, `priv`, `vote`) VALUES
(1, 'admin', 'YWRtaW4=', 'admin@admin.com', 1, 0),
(2, 'test', 'cXdlcnQ=', 'test@mail.ru', 0, 0),
(3, 'gans', 'cXdlcnQ=', 'gans@gmail.com', 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `vote`
--

CREATE TABLE IF NOT EXISTS `vote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL COMMENT 'id голосования',
  `sid` int(11) NOT NULL COMMENT 'id песни',
  `uid` int(11) NOT NULL COMMENT 'id пользователя',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `vote`
--

INSERT INTO `vote` (`id`, `cid`, `sid`, `uid`) VALUES
(1, 0, 0, 0),
(2, 1, 2, 2),
(3, 1, 3, 3),
(4, 2, 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
