-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Апр 27 2025 г., 22:31
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
-- Индексы таблицы `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`insertID`);

--
-- Индексы таблицы `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`insertID`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`roleID`);

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
-- AUTO_INCREMENT для таблицы `cache`
--
ALTER TABLE `cache`
  MODIFY `insertID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `logs`
--
ALTER TABLE `logs`
  MODIFY `insertID` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
