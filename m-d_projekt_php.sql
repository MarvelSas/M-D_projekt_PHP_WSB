-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 09 Sty 2022, 10:52
-- Wersja serwera: 10.4.6-MariaDB
-- Wersja PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `m-d_projekt_php`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `burger_order`
--

CREATE TABLE `burger_order` (
  `Id` int(11) NOT NULL,
  `Name` varchar(60) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Surname` varchar(60) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Street` varchar(60) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `HouseNumber` varchar(60) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `City` varchar(60) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `State` varchar(60) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Zip` varchar(6) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `UserId` int(11) NOT NULL,
  `Date` datetime NOT NULL,
  `SummaryPrice` double NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `burger_order`
--

INSERT INTO `burger_order` (`Id`, `Name`, `Surname`, `Street`, `HouseNumber`, `City`, `State`, `Zip`, `UserId`, `Date`, `SummaryPrice`, `Status`) VALUES
(231, 'Jacek', 'BÄ…k', 'PoznaÅ„ska', '12a', 'PoznaÅ„', 'Wielkopolska', '22-333', 22, '2022-01-09 10:51:51', 12.52, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `burger_order_line`
--

CREATE TABLE `burger_order_line` (
  `Id` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `OrderId` int(11) NOT NULL,
  `ProductId` int(11) NOT NULL,
  `ProductName` varchar(100) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `ProductPrice` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `burger_order_line`
--

INSERT INTO `burger_order_line` (`Id`, `Quantity`, `OrderId`, `ProductId`, `ProductName`, `ProductPrice`) VALUES
(9, 2, 183, 37, 'burger', 123),
(14, 1, 185, 37, 'burger', 123),
(15, 1, 185, 38, 'frytki', 12),
(16, 1, 185, 39, 'b', 421),
(17, 1, 185, 40, 'we', 45),
(18, 1, 186, 37, 'burger', 123),
(19, 1, 187, 37, 'burger', 123),
(20, 1, 188, 56, '7567', 567),
(21, 1, 189, 37, 'burger', 123),
(22, 1, 189, 44, '4', 4),
(23, 2, 190, 37, 'burger', 123),
(24, 1, 190, 40, 'we', 45),
(25, 1, 191, 37, 'burger', 123),
(26, 1, 192, 60, 'a', 123),
(27, 1, 193, 37, 'burger', 123),
(28, 1, 194, 37, 'burger', 123),
(29, 1, 195, 38, 'frytki', 12),
(30, 1, 196, 37, 'burger', 123),
(31, 1, 196, 40, 'we', 45),
(32, 1, 197, 37, 'burger', 123),
(33, 1, 198, 38, 'frytki', 12),
(34, 1, 199, 38, 'frytki', 12),
(35, 1, 200, 37, 'burger', 123),
(36, 1, 201, 37, 'burger', 123),
(37, 1, 202, 37, 'burger', 123),
(38, 1, 203, 37, 'burger', 123),
(39, 1, 204, 37, 'burger', 123),
(40, 1, 205, 37, 'burger', 123),
(41, 1, 207, 40, 'we', 45),
(42, 1, 208, 37, 'burger', 123),
(43, 1, 209, 37, 'burger', 123),
(44, 1, 210, 37, 'burger', 123),
(45, 1, 212, 37, 'burger', 123),
(46, 1, 213, 37, 'burger', 123),
(47, 1, 214, 37, 'burger', 123),
(48, 1, 215, 37, 'burger', 123),
(49, 1, 216, 37, 'burger', 123),
(53, 1, 218, 37, 'burger', 122),
(54, 1, 219, 38, 'frytki', 12),
(55, 1, 220, 37, 'burger', 122),
(56, 1, 221, 37, 'burger', 122),
(57, 1, 222, 37, 'burger', 122),
(58, 1, 222, 40, 'we', 45),
(59, 2, 223, 37, 'burger', 123),
(60, 1, 223, 48, '8', 8),
(61, 1, 224, 64, 'Zestaw z frytkami KrzyÅ›', 1223.12),
(63, 1, 226, 68, 'f', 1),
(64, 1, 227, 68, 'f', 1),
(65, 1, 227, 69, 'g', 1),
(66, 1, 227, 70, 'h', 1),
(67, 1, 227, 74, 'w', 1),
(68, 1, 227, 75, 'q', 1),
(69, 1, 227, 76, 'r', 1),
(70, 1, 227, 77, 't', 1),
(71, 1, 227, 78, 'y', 1),
(72, 1, 227, 79, 'u', 1),
(73, 1, 228, 68, 'f', 1),
(74, 1, 228, 69, 'g', 1),
(75, 1, 228, 70, 'h', 1),
(76, 1, 228, 71, 'i', 1),
(77, 1, 228, 72, 'j', 1),
(78, 1, 228, 73, 'k', 4),
(79, 1, 228, 74, 'w', 1),
(80, 1, 228, 75, 'q', 1),
(81, 1, 228, 76, 'r', 1),
(82, 1, 228, 77, 't', 1),
(83, 1, 228, 78, 'y', 1),
(84, 1, 228, 79, 'u', 1),
(85, 1, 229, 68, 'f', 1),
(86, 1, 230, 68, 'f', 1),
(87, 1, 230, 69, 'g', 1),
(88, 1, 230, 70, 'h', 1),
(89, 1, 230, 71, 'i', 1),
(90, 1, 230, 72, 'j', 1),
(91, 1, 230, 73, 'k', 4),
(92, 1, 230, 74, 'w', 1),
(93, 1, 230, 75, 'q', 1),
(94, 1, 231, 80, 'Burger', 12.52);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `products`
--

CREATE TABLE `products` (
  `Id` int(11) NOT NULL,
  `Name` varchar(100) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Price` double NOT NULL,
  `PhotoName` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `products`
--

INSERT INTO `products` (`Id`, `Name`, `Price`, `PhotoName`) VALUES
(80, 'Burger', 12.52, 'Burger.png'),
(82, 'Frytki', 5, 'Frytki.png');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `Id` int(11) NOT NULL,
  `Login` varchar(20) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Password` varchar(100) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Mail` varchar(25) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `PhoneNumber` varchar(11) COLLATE utf8mb4_polish_ci NOT NULL,
  `Role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`Id`, `Login`, `Password`, `Mail`, `PhoneNumber`, `Role`) VALUES
(22, 'burgerBuyer', 'e807f1fcf82d132f9bb018ca6738a19f', 'burgerbuyer@gmail.com', '222-333-444', 0),
(23, 'burgerSeller', 'e807f1fcf82d132f9bb018ca6738a19f', 'burgerseller@gmail.com', '111-333-444', 1);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `burger_order`
--
ALTER TABLE `burger_order`
  ADD PRIMARY KEY (`Id`);

--
-- Indeksy dla tabeli `burger_order_line`
--
ALTER TABLE `burger_order_line`
  ADD PRIMARY KEY (`Id`);

--
-- Indeksy dla tabeli `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`Id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `burger_order`
--
ALTER TABLE `burger_order`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=232;

--
-- AUTO_INCREMENT dla tabeli `burger_order_line`
--
ALTER TABLE `burger_order_line`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT dla tabeli `products`
--
ALTER TABLE `products`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
