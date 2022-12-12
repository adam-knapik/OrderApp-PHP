-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Czas generowania: 12 Gru 2022, 15:32
-- Wersja serwera: 5.5.45
-- Wersja PHP: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `order_db`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `company_details`
--

CREATE TABLE `company_details` (
  `detail_id` int(11) NOT NULL,
  `detail_shortname` varchar(255) NOT NULL,
  `detail_name` varchar(255) NOT NULL,
  `detail_street` varchar(255) NOT NULL,
  `detail_building_number` int(11) NOT NULL,
  `detail_premises_number` int(11) DEFAULT NULL,
  `detail_zip_code` varchar(6) NOT NULL,
  `detail_city` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `company_details`
--

INSERT INTO `company_details` (`detail_id`, `detail_shortname`, `detail_name`, `detail_street`, `detail_building_number`, `detail_premises_number`, `detail_zip_code`, `detail_city`) VALUES
(1, 'Hurtownia', 'Hurt-Jan', 'Miła', 1, NULL, '60-543', 'Poznań');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `contractors`
--

CREATE TABLE `contractors` (
  `contractor_id` int(11) NOT NULL,
  `contractor_name` varchar(255) NOT NULL,
  `contractor_street` varchar(255) NOT NULL,
  `contractor_building_number` int(11) NOT NULL,
  `contractor_premises_number` int(11) DEFAULT NULL,
  `contractor_zip_code` varchar(6) NOT NULL,
  `contractor_city` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `contractors`
--

INSERT INTO `contractors` (`contractor_id`, `contractor_name`, `contractor_street`, `contractor_building_number`, `contractor_premises_number`, `contractor_zip_code`, `contractor_city`) VALUES
(1, 'Firma X', 'ul. Opolska', 1, 0, '61-001', 'Poznań'),
(2, 'Firma Y', 'ul. Ilżańska', 12, 0, '61-355', 'Poznań');


-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `order_contractor` int(11) NOT NULL,
  `order_user` int(11) NOT NULL,
  `order_company` int(11) NOT NULL,
  `order_destination` enum('Biuro', 'Magazyn') NOT NULL,
  `order_value_net` varchar(255) NOT NULL,
  `order_date` varchar(20) NOT NULL,
  `order_payment_method` enum('Przedpłata','Za pobraniem','Przelew 7 dni','Przelew 14 dni','Przelew 21 dni','Przelew 30dni','Przelew 45 dni','Przelew 60 dni','Karta online') DEFAULT NULL,
  `order_delivery_date` varchar(20) DEFAULT NULL,
  `order_delivery` enum('Usługa','Po stronie sprzedającego','Po stronie kupującego') DEFAULT NULL,
  `order_note` varchar(255) DEFAULT NULL,
  `order_type` enum('Produkt','Usługa') DEFAULT 'Produkt'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `order_items`
--

CREATE TABLE `order_items` (
  `item_id` int(11) NOT NULL,
  `item_order_id` int(11) DEFAULT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_quantity` float NOT NULL,
  `item_price` varchar(255) NOT NULL,
  `item_subtotal` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_surname` varchar(255) NOT NULL,
  `user_shortname` varchar(8) DEFAULT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_office` varchar(20) DEFAULT NULL,
  `user_mobile` varchar(20) DEFAULT NULL,
  `user_role` enum('user','admin') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_surname`, `user_shortname`, `user_email`, `user_password`, `user_office`, `user_mobile`, `user_role`) VALUES
(1, 'admin', 'admin', 'adm', 'admin@admin.pl', '1111', '+48 660 660 660', '+48 606 606 606', 'admin'),
(2, 'Jan', 'Nowak', 'JN', 'jan@nowak.pl', 'JNowak1', '+48 661 661 661', '+48 616 616 616', 'user');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `company_details`
--
ALTER TABLE `company_details`
  ADD PRIMARY KEY (`detail_id`);

--
-- Indeksy dla tabeli `contractors`
--
ALTER TABLE `contractors`
  ADD PRIMARY KEY (`contractor_id`);

--
-- Indeksy dla tabeli `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indeksy dla tabeli `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `contractors`
--
ALTER TABLE `contractors`
  MODIFY `contractor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT dla tabeli `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT dla tabeli `order_items`
--
ALTER TABLE `order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
