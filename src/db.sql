-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Май 05 2025 г., 12:49
-- Версия сервера: 8.0.26-17
-- Версия PHP: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `lemo376_yxzps`
--

-- --------------------------------------------------------

--
-- Структура таблицы `accounts`
--

CREATE TABLE `accounts` (
  `insertID` int NOT NULL,
  `accountID` int NOT NULL,
  `userName` varchar(20) NOT NULL,
  `gjp2` varchar(255) CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL,
  `email` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `clanID` int DEFAULT NULL,
  `time` int NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `stats` text NOT NULL,
  `icons` text NOT NULL,
  `settings` text NOT NULL,
  `roles` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

-- --------------------------------------------------------

--
-- Структура таблицы `bans`
--

CREATE TABLE `bans` (
  `insertID` int NOT NULL,
  `accountID` int NOT NULL,
  `userName` varchar(20) NOT NULL,
  `ban_time` int NOT NULL,
  `ban_ends_at` int NOT NULL,
  `ip` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

-- --------------------------------------------------------

--
-- Структура таблицы `blocks`
--

CREATE TABLE `blocks` (
  `insertID` int NOT NULL,
  `accountID` int NOT NULL,
  `target_accountID` int NOT NULL,
  `time` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

-- --------------------------------------------------------

--
-- Структура таблицы `cache`
--

CREATE TABLE `cache` (
  `insertID` int NOT NULL,
  `type` int NOT NULL,
  `attrs` text CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL,
  `time` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

-- --------------------------------------------------------

--
-- Структура таблицы `clans`
--

CREATE TABLE `clans` (
  `insertID` int NOT NULL,
  `clanID` int NOT NULL,
  `clan_name` varchar(20) CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL,
  `clan_tag` varchar(7) CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL,
  `ownerID` int NOT NULL,
  `levels` text,
  `time` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `insertID` int NOT NULL,
  `accountID` int NOT NULL,
  `level_or_listID` int DEFAULT NULL,
  `comment` varchar(255) NOT NULL,
  `likes` int NOT NULL DEFAULT '0',
  `time` int NOT NULL,
  `percent` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

-- --------------------------------------------------------

--
-- Структура таблицы `friends`
--

CREATE TABLE `friends` (
  `insertID` int NOT NULL,
  `accountID` int NOT NULL,
  `target_accountID` int NOT NULL,
  `time` int NOT NULL,
  `is_new` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

-- --------------------------------------------------------

--
-- Структура таблицы `friend_requests`
--

CREATE TABLE `friend_requests` (
  `insertID` int NOT NULL,
  `accountID` int NOT NULL,
  `target_accountID` int NOT NULL,
  `message` varchar(255) NOT NULL,
  `time` int NOT NULL,
  `is_new` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

-- --------------------------------------------------------

--
-- Структура таблицы `logs`
--

CREATE TABLE `logs` (
  `insertID` int NOT NULL,
  `ip` varchar(255) NOT NULL,
  `type` int NOT NULL,
  `attrs` text CHARACTER SET cp1251 COLLATE cp1251_general_ci,
  `time` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `insertID` int NOT NULL,
  `accountID` int NOT NULL,
  `target_accountID` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `time` int NOT NULL,
  `is_new` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `roleID` int NOT NULL,
  `display_name` varchar(15) CHARACTER SET cp1251 COLLATE cp1251_general_ci DEFAULT NULL,
  `priority` int NOT NULL DEFAULT '0',
  `color` varchar(11) NOT NULL DEFAULT '000,000,000',
  `mod_badge_level` tinyint NOT NULL DEFAULT '0',
  `perms_commands` text CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL,
  `perms_actions` text CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL,
  `perms_dashboard` text CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

-- --------------------------------------------------------

--
-- Структура таблицы `save_data`
--

CREATE TABLE `save_data` (
  `insertID` int NOT NULL,
  `account_or_levelID` int NOT NULL,
  `save_data` mediumtext NOT NULL,
  `time` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`insertID`),
  ADD UNIQUE KEY `userName` (`userName`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `accountID` (`accountID`);

--
-- Индексы таблицы `bans`
--
ALTER TABLE `bans`
  ADD PRIMARY KEY (`insertID`);

--
-- Индексы таблицы `blocks`
--
ALTER TABLE `blocks`
  ADD PRIMARY KEY (`insertID`);

--
-- Индексы таблицы `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`insertID`);

--
-- Индексы таблицы `clans`
--
ALTER TABLE `clans`
  ADD PRIMARY KEY (`insertID`),
  ADD UNIQUE KEY `clanID` (`clanID`),
  ADD UNIQUE KEY `clanName` (`clan_name`),
  ADD UNIQUE KEY `clanTag` (`clan_tag`),
  ADD UNIQUE KEY `ownerID` (`ownerID`);

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`insertID`);

--
-- Индексы таблицы `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`insertID`);

--
-- Индексы таблицы `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD PRIMARY KEY (`insertID`);

--
-- Индексы таблицы `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`insertID`);

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`insertID`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`roleID`),
  ADD UNIQUE KEY `priority` (`priority`);

--
-- Индексы таблицы `save_data`
--
ALTER TABLE `save_data`
  ADD PRIMARY KEY (`insertID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `accounts`
--
ALTER TABLE `accounts`
  MODIFY `insertID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `bans`
--
ALTER TABLE `bans`
  MODIFY `insertID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `blocks`
--
ALTER TABLE `blocks`
  MODIFY `insertID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `cache`
--
ALTER TABLE `cache`
  MODIFY `insertID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `clans`
--
ALTER TABLE `clans`
  MODIFY `insertID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `insertID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `friends`
--
ALTER TABLE `friends`
  MODIFY `insertID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `friend_requests`
--
ALTER TABLE `friend_requests`
  MODIFY `insertID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `logs`
--
ALTER TABLE `logs`
  MODIFY `insertID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `insertID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `save_data`
--
ALTER TABLE `save_data`
  MODIFY `insertID` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
