-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2023. Ápr 16. 21:12
-- Kiszolgáló verziója: 10.4.27-MariaDB
-- PHP verzió: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `testdb`
--
CREATE DATABASE IF NOT EXISTS `testdb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `testdb`;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `forumId` int(11) NOT NULL,
  `postId` int(11) NOT NULL,
  `comment` varchar(4096) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `comments`
--

INSERT INTO `comments` (`id`, `userId`, `forumId`, `postId`, `comment`) VALUES
(1, 1, 1, 2, 'Tényleg kék?');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `forums`
--

CREATE TABLE `forums` (
  `id` int(11) NOT NULL,
  `creatorId` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `description` varchar(2048) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `forums`
--

INSERT INTO `forums` (`id`, `creatorId`, `name`, `description`) VALUES
(1, 1, 'Mari néni muskátlija', 'Ezen a fórumon olvashatok a muskátli nevelés fortélyairól.'),
(2, 2, 'Ez a saját valaki fórumom', 'Fóruuuuuum');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `permission`
--

CREATE TABLE `permission` (
  `userId` int(11) NOT NULL,
  `level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `permission`
--

INSERT INTO `permission` (`userId`, `level`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `permission_level`
--

CREATE TABLE `permission_level` (
  `id` int(11) NOT NULL,
  `type` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `permission_level`
--

INSERT INTO `permission_level` (`id`, `type`) VALUES
(1, 'admin'),
(2, 'moderator');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `forumId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  `description` varchar(2048) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `posts`
--

INSERT INTO `posts` (`id`, `forumId`, `userId`, `title`, `description`) VALUES
(2, 1, 1, 'Kék muskátli', 'Szép a muskátlim'),
(3, 2, 2, 'Valaki posztolgat', 'De ki?');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(128) NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `mobile` varchar(20) NOT NULL DEFAULT '',
  `description` text NOT NULL DEFAULT '',
  `newsletter` tinyint(1) NOT NULL DEFAULT 1,
  `username_public` tinyint(1) NOT NULL DEFAULT 1,
  `email_public` tinyint(1) DEFAULT 1,
  `name_public` tinyint(1) NOT NULL DEFAULT 1,
  `mobile_public` tinyint(1) NOT NULL DEFAULT 1,
  `description_public` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `name`, `mobile`, `description`, `newsletter`, `username_public`, `email_public`, `name_public`, `mobile_public`, `description_public`) VALUES
(1, 'cica', 'cica@cmail.com', '$2y$10$2IJEzAZdRjP1mfL.WIqHr.S/gAzU9vxxDdJfsf36.duF0UU3CXDfi', 'Cirmos Cirmi', ' 36201111111', 'Az MNCP Magyar Nemzeti Cica Párt jelöltjeként próbálom felhívni a figyelmet a cicatartás gazdasági előnyeire. Ön tudta, hogy azokban az országokban ahol az egy főre eső GCQ (Gross Cat Quantity) nagyobb mint 2 a minimálbér is legalább dupla akkora mint ahol a GCQ csak 1.', 1, 1, 1, 1, 1, 1),
(2, 'valaki', 'valaki@gmail.com', '$2y$10$0lMbhI6CbN1d9EjV6VOJCexir55Gm3bEeM8/FtJw.CA0eghkOBhTa', 'Valaki Ferenc', ' 36209992245', 'Valaki vagyok. Sokan kérdeztékmár, hogy hívnak de amikor mondom, hogy Valaki vagyok mindig olyan furán néznek rám és visszakérdeznek, hogy de ki. Úgy nem értem miért.', 1, 1, 0, 1, 0, 1);

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`,`forumId`,`postId`),
  ADD KEY `forumId` (`forumId`),
  ADD KEY `postId` (`postId`);

--
-- A tábla indexei `forums`
--
ALTER TABLE `forums`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creatorId` (`creatorId`);

--
-- A tábla indexei `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`userId`),
  ADD KEY `level` (`level`);

--
-- A tábla indexei `permission_level`
--
ALTER TABLE `permission_level`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `forumId` (`forumId`),
  ADD KEY `userId` (`userId`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT a táblához `forums`
--
ALTER TABLE `forums`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `permission_level`
--
ALTER TABLE `permission_level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`forumId`) REFERENCES `forums` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`postId`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `forums`
--
ALTER TABLE `forums`
  ADD CONSTRAINT `forums_ibfk_1` FOREIGN KEY (`creatorId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `permission`
--
ALTER TABLE `permission`
  ADD CONSTRAINT `permission_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_ibfk_4` FOREIGN KEY (`level`) REFERENCES `permission_level` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`forumId`) REFERENCES `forums` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
