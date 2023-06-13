-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 13 Cze 2023, 23:17
-- Wersja serwera: 10.4.27-MariaDB
-- Wersja PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `studentolx`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `accounts`
--

CREATE TABLE `accounts` (
  `accountid` int(11) NOT NULL,
  `login` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL,
  `account_type` varchar(3) NOT NULL DEFAULT '222',
  `verified` tinyint(1) NOT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(150) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `phone` varchar(9) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `codezip` varchar(6) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `accounts`
--

INSERT INTO `accounts` (`accountid`, `login`, `password`, `account_type`, `verified`, `firstname`, `lastname`, `email`, `phone`, `address`, `codezip`, `city`, `country`) VALUES
(1, 'Gandalf', '$argon2id$v=19$m=65536,t=4,p=1$MGpNTmV5V3gxeEpnbmwuRA$4EAcazJJNXYstsdtmz3UPJPZi+ngwKWMOcRWACWGGaM', '101', 1, 'Gandalf', 'Szary', 'gandalf@example.com', '123456789', 'Mroczna Dolina 1', '12-345', 'Minas Tirith', 'Gondor'),
(2, 'Frodo', '$argon2id$v=19$m=65536,t=4,p=1$MGpNTmV5V3gxeEpnbmwuRA$4EAcazJJNXYstsdtmz3UPJPZi+ngwKWMOcRWACWGGaM', '222', 1, 'Frodo', 'Baggins', 'frodo@example.com', '987654321', 'Hobbiton 2', '98-765', 'Shire', 'Middle-earth'),
(3, 'Yennefer', '$argon2id$v=19$m=65536,t=4,p=1$MGpNTmV5V3gxeEpnbmwuRA$4EAcazJJNXYstsdtmz3UPJPZi+ngwKWMOcRWACWGGaM', '222', 1, 'Yennefer', 'z Vengerbergu', 'yennefer@example.com', '555555555', 'Wyzima 3', '54-321', 'Redania', 'Księstwo Redanii'),
(4, 'Geralt', '$argon2id$v=19$m=65536,t=4,p=1$MGpNTmV5V3gxeEpnbmwuRA$4EAcazJJNXYstsdtmz3UPJPZi+ngwKWMOcRWACWGGaM', '101', 1, 'Geralt', 'z Rivii', 'geralt@example.com', '777777777', 'Kaer Morhen 4', '01-234', 'Temeria', 'Królestwo Temerii'),
(5, 'MikeW', '$argon2id$v=19$m=65536,t=4,p=1$NkxzSEhHQVkyblFlRWRrZw$ZhSvsxgQsVLjuwJCQcet8AmVJIbX9+dZzJGWavYzroc', '222', 0, 'Mike', 'Wazowski', 'mike@wazowski.com', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `auctions`
--

CREATE TABLE `auctions` (
  `auctionid` int(11) NOT NULL,
  `accountid` int(11) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `used` tinyint(1) DEFAULT NULL,
  `private` tinyint(1) DEFAULT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `veryfied` int(1) NOT NULL DEFAULT 0,
  `whover` int(3) NOT NULL,
  `selled` tinyint(1) DEFAULT 0,
  `buyerid` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `waluta` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `auctions`
--

INSERT INTO `auctions` (`auctionid`, `accountid`, `categoryid`, `title`, `description`, `used`, `private`, `date_start`, `date_end`, `veryfied`, `whover`, `selled`, `buyerid`, `price`, `waluta`) VALUES
(1, 1, 1, 'Miecz Glamdring', 'Potężny miecz używany przez Gandalfa w walce ze złem.', 0, 0, '2023-06-01', '2023-06-10', 1, 0, 0, NULL, 100, 'Srebro'),
(2, 2, 2, 'Jeden Pierścień', 'Tajemniczy pierścień o ogromnej mocy.', 1, 0, '2023-06-02', '2023-06-11', 1, 0, 0, NULL, 200, 'Złoto'),
(3, 3, 3, 'Amulet Yennefer', 'Magiczny amulet zwiększający moc czarów. xD', 0, 0, '2023-06-03', '2023-06-12', 1, 4, 0, NULL, 150, 'Złoto'),
(4, 4, 4, 'Medalion Wiedźmina', 'Tajemniczy medalion dający wiedźminowi nadnaturalne zdolności.', 1, 1, '2023-06-04', '2023-06-13', 2, 4, 0, NULL, 120, 'Srebro'),
(5, 1, 1, 'kawa', '1,2,3 i jest', 0, 1, '2023-06-13', '0000-00-00', 2, 4, 0, NULL, NULL, NULL),
(11, 4, 2, 'Strój Wiedźmina', 'Najnowszy model, kompletny. Niezbędny każdemu Wiedźminowi.', NULL, 1, '2023-06-13', '2023-06-13', 1, 4, 0, NULL, NULL, NULL),
(16, 5, 2, 'Zmienione ogłoszenie', 'yu2', NULL, NULL, '2023-06-13', '0000-00-00', 1, 4, 0, NULL, NULL, NULL),
(17, 4, 0, 'Koń Wiedźmina', 'Mały przebieg, podzespoły sprawne, silnik na owies.', NULL, NULL, '2023-06-13', '0000-00-00', 0, 0, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `category`
--

CREATE TABLE `category` (
  `categoryid` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `in_tree` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `category`
--

INSERT INTO `category` (`categoryid`, `name`, `in_tree`) VALUES
(1, 'Motoryzacja', 0),
(3, 'Praca', 0),
(4, 'Zdrowie i Uroda', 0),
(5, 'Elektronika', 0),
(6, 'Moda', 0),
(7, 'Zwierzęta', 0),
(8, 'Wypożyczalnia', 0),
(9, 'Sport', 0),
(10, 'Hobby', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `file_to_auction`
--

CREATE TABLE `file_to_auction` (
  `file_id` int(11) NOT NULL,
  `auctionid` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `mlid` int(11) NOT NULL,
  `auctionid` int(11) NOT NULL,
  `buyerid` int(3) NOT NULL,
  `answer` tinyint(1) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `message`
--

INSERT INTO `message` (`id`, `mlid`, `auctionid`, `buyerid`, `answer`, `date`, `description`) VALUES
(1, 1, 1, 1, 0, '2023-06-06 00:00:00', 'Czy miecz Glamdring nadal jest dostępny?'),
(2, 2, 1, 1, 1, '2023-06-07 00:00:00', 'Tak, miecz Glamdring jest wciąż dostępny. Czy jesteś zainteresowany zakupem?'),
(3, 3, 1, 1, 0, '2023-06-07 00:00:00', 'Tak, jestem zainteresowany. Czy mogę obejrzeć miecz przed zakupem?'),
(4, 4, 1, 1, 1, '2023-06-08 00:00:00', 'Oczywiście, możemy umówić się na spotkanie. Gdzie mogę Cię spotkać?'),
(5, 5, 2, 2, 0, '2023-06-06 00:00:00', 'Czy ten Jeden Pierścień jest oryginalny?'),
(6, 6, 2, 1, 1, '2023-06-07 00:00:00', 'Tak, ten Pierścień jest oryginalny i posiada potężne moce. Czy chcesz go kupić?'),
(7, 7, 2, 4, 0, '2023-06-07 00:00:00', 'Tak, jestem zainteresowany. Czy mogę go przetestować przed zakupem?'),
(8, 8, 2, 3, 1, '2023-06-08 00:00:00', 'Niestety, nie można przetestować tego Pierścienia. Ale mogę zapewnić Cię, że jest w doskonałym stanie.'),
(9, 9, 3, 2, 0, '2023-06-06 00:00:00', 'Czy amulet Yennefer jest nadal dostępny?'),
(10, 10, 3, 1, 1, '2023-06-07 00:00:00', 'Tak, amulet Yennefer jest nadal dostępny. Czy chciałbyś go zakupić?'),
(11, 11, 3, 4, 0, '2023-06-07 00:00:00', 'Tak, jestem zainteresowany. Czy mogę obejrzeć amulet osobiście?'),
(12, 12, 3, 3, 1, '2023-06-08 00:00:00', 'Oczywiście, możemy się spotkać. Gdzie chciałbyś się spotkać?'),
(13, 13, 4, 2, 0, '2023-06-06 00:00:00', 'Czy medalion Wiedźmina jest wciąż dostępny?'),
(14, 14, 4, 1, 1, '2023-06-07 00:00:00', 'Tak, medalion Wiedźmina jest nadal dostępny. Czy jesteś zainteresowany zakupem?'),
(15, 15, 4, 4, 0, '2023-06-07 00:00:00', 'Tak, jestem zainteresowany. Czy mogę obejrzeć medalion przed zakupem?'),
(16, 16, 4, 3, 1, '2023-06-08 00:00:00', 'Oczywiście, możemy umówić się na spotkanie. Gdzie chciałbyś się spotkać?'),
(22, 0, 11, 4, 1, '2023-06-13 00:00:00', 'Dzień dobry jestem zainteresowany produktem');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `message_link`
--

CREATE TABLE `message_link` (
  `mlid` int(11) NOT NULL,
  `auctionid` int(11) NOT NULL,
  `sellerid` int(11) NOT NULL,
  `buyerid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `message_link`
--

INSERT INTO `message_link` (`mlid`, `auctionid`, `sellerid`, `buyerid`) VALUES
(1, 1, 1, 1),
(2, 2, 2, 1),
(3, 3, 3, 1),
(4, 4, 4, 1),
(5, 1, 1, 2),
(6, 2, 2, 1),
(7, 3, 3, 4),
(8, 4, 4, 3),
(9, 1, 1, 2),
(10, 2, 2, 1),
(11, 3, 3, 4),
(12, 4, 4, 3),
(13, 1, 1, 2),
(14, 2, 2, 1),
(15, 3, 3, 4),
(16, 4, 4, 3);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `type`
--

CREATE TABLE `type` (
  `type_id` varchar(3) NOT NULL,
  `type_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `type`
--

INSERT INTO `type` (`type_id`, `type_name`) VALUES
('101', 'Administrator'),
('222', 'Użytkownik');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`accountid`);

--
-- Indeksy dla tabeli `auctions`
--
ALTER TABLE `auctions`
  ADD PRIMARY KEY (`auctionid`);

--
-- Indeksy dla tabeli `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`categoryid`);

--
-- Indeksy dla tabeli `file_to_auction`
--
ALTER TABLE `file_to_auction`
  ADD PRIMARY KEY (`file_id`),
  ADD KEY `auctionid` (`auctionid`);

--
-- Indeksy dla tabeli `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auctionid` (`auctionid`);

--
-- Indeksy dla tabeli `message_link`
--
ALTER TABLE `message_link`
  ADD PRIMARY KEY (`mlid`),
  ADD KEY `auctionid` (`auctionid`),
  ADD KEY `sellerid` (`sellerid`),
  ADD KEY `buyerid` (`buyerid`);

--
-- Indeksy dla tabeli `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`type_id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `accounts`
--
ALTER TABLE `accounts`
  MODIFY `accountid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `auctions`
--
ALTER TABLE `auctions`
  MODIFY `auctionid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT dla tabeli `category`
--
ALTER TABLE `category`
  MODIFY `categoryid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT dla tabeli `file_to_auction`
--
ALTER TABLE `file_to_auction`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT dla tabeli `message_link`
--
ALTER TABLE `message_link`
  MODIFY `mlid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `file_to_auction`
--
ALTER TABLE `file_to_auction`
  ADD CONSTRAINT `file_to_auction_ibfk_1` FOREIGN KEY (`auctionid`) REFERENCES `auctions` (`auctionid`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`auctionid`) REFERENCES `auctions` (`auctionid`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `message_link`
--
ALTER TABLE `message_link`
  ADD CONSTRAINT `message_link_ibfk_1` FOREIGN KEY (`auctionid`) REFERENCES `auctions` (`auctionid`) ON DELETE CASCADE,
  ADD CONSTRAINT `message_link_ibfk_2` FOREIGN KEY (`sellerid`) REFERENCES `accounts` (`accountid`),
  ADD CONSTRAINT `message_link_ibfk_3` FOREIGN KEY (`buyerid`) REFERENCES `accounts` (`accountid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
