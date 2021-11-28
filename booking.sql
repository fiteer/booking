-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 27 نوفمبر 2021 الساعة 16:54
-- إصدار الخادم: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `booking`
--

-- --------------------------------------------------------

--
-- بنية الجدول `bookies`
--

CREATE TABLE `bookies` (
  `ID` int(11) NOT NULL,
  `Item_id` int(11) NOT NULL,
  `Member_id` int(11) NOT NULL,
  `UserName` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Card_ID` varchar(255) NOT NULL,
  `stat_date` date DEFAULT NULL,
  `Date` date NOT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `bookies`
--

INSERT INTO `bookies` (`ID`, `Item_id`, `Member_id`, `UserName`, `Email`, `Card_ID`, `stat_date`, `Date`, `end_date`) VALUES
(1, 6, 3, 'assad alkamil', 'assad@gmail.com', '123452345', NULL, '2021-11-05', NULL),
(2, 4, 1, 'assad alkamil', 'assad@gmail.com', '4364757646786', NULL, '2021-11-05', NULL),
(3, 4, 1, 'assad alkamil', 'assad@gmail.com', '4364757646786', NULL, '2021-11-05', NULL),
(4, 4, 1, 'assad alkamil', 'assad@gmail.com', '7090987097', NULL, '2021-11-05', NULL),
(5, 10, 1, 'fiteer alqiadi', 'fiteer@gmail.com', '123456784567878', NULL, '2021-11-07', NULL),
(6, 10, 1, 'fiteer alqiadi', 'fiteer@gmail.com', '16076125', NULL, '2021-11-24', NULL),
(7, 9, 1, 'fiteer alqiadi', 'fiteer@gmail.com', '16076125', NULL, '2021-11-24', NULL),
(8, 13, 3, 'fiteer alqiadi', 'fiteer@gmail.com', '19777361', '0000-00-00', '2021-11-24', NULL),
(9, 5, 3, 'assad alkamil', 'assad@gmail.com', '19643107', '0000-00-00', '2021-11-25', NULL),
(10, 15, 3, 'fiteer alqiadi', 'fiteer@gmail.com', '17742247', '0000-00-00', '2021-11-27', NULL),
(11, 15, 3, 'assad alkamil', 'assad@gmail.com', '17742247', '0000-00-00', '2021-11-27', NULL),
(12, 16, 3, 'assad alkamil', 'assad@gmail.com', '16076125', '2021-11-19', '2021-11-27', '2021-11-18'),
(13, 17, 3, 'assad alkamil', 'assad@gmail.com', '16076125', '2021-11-27', '2021-11-27', '2021-11-30');

-- --------------------------------------------------------

--
-- بنية الجدول `comments`
--

CREATE TABLE `comments` (
  `C_ID` int(11) NOT NULL,
  `user_review` varchar(255) NOT NULL,
  `rating_data` int(11) DEFAULT NULL,
  `Comment_Date` date NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `comments`
--

INSERT INTO `comments` (`C_ID`, `user_review`, `rating_data`, `Comment_Date`, `item_id`, `user_id`) VALUES
(1, 'this is very goods', 5, '2021-11-26', 14, 1),
(2, 'this is nice ', 3, '2021-11-26', 14, 3),
(3, 'very good', 5, '2021-11-26', 14, 3),
(4, 'good', 2, '2021-11-26', 14, 3),
(6, 'this is very good', 5, '2021-11-27', 13, 3),
(8, 'this is very good', 3, '2021-11-27', 15, 3),
(9, 'good', 3, '2021-11-27', 13, 3);

-- --------------------------------------------------------

--
-- بنية الجدول `items`
--

CREATE TABLE `items` (
  `Item_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Price` varchar(255) NOT NULL,
  `type_item` varchar(255) DEFAULT NULL,
  `Add_Date` date NOT NULL,
  `Member_ID` int(11) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `items`
--

INSERT INTO `items` (`Item_ID`, `Name`, `Description`, `Price`, `type_item`, `Add_Date`, `Member_ID`, `avatar`, `status`) VALUES
(2, 'Phone Not 9', 'this is the past electronics', '$300', 'rooms', '2021-11-03', 1, '49508_1476_706_تنزيل.jpg', 0),
(3, 'Luxury Rooms', 'Luxury Rooms Luxury Rooms Luxury Rooms', '$300', 'rooms', '2021-11-04', 3, '84388_3.jpg', 0),
(4, 'Luxury Hotels', 'Luxury Hotels Luxury Hotels Luxury Hotels', '$200', 'rooms', '2021-11-04', 1, '96463_4.jpg', 0),
(5, 'Luxury Hotels', 'Luxury Hotels Luxury Hotels Luxury Hotels', '$400', 'hotels', '2021-11-04', 3, '47406_5.jpg', 1),
(6, 'Luxury Room', 'The Best Rooms In Saudi Arabia Are Located In Riyadh', '$350', 'hotels', '2021-11-04', 3, '69455_hotel_astro_resort.jpg', 0),
(7, 'Luxury Hotels ', 'The Best Hotels In Saudi Arabia Are Located In Riyadh', '$500', 'hotels', '2021-11-04', 2, '17538_hotel_the_paradise.jpg', 0),
(8, 'Fantastic Resort', 'Fantastic Resort Fantastic Resort Fantastic Resort', '200', 'rooms', '2021-11-06', 1, '76008_hotel_the_enchanted_garden.jpg', 0),
(9, 'Fantastic Resort', 'Fantastic Resort', '100', 'hotels', '2021-11-06', 1, '79799_hero_background.jpg', 1),
(10, 'Fantastic Resort ', 'Fantastic Resort Resort  Resort ', '150', 'rooms', '2021-11-06', 1, '957_hotel_astro_resort.jpg', 1),
(13, 'Fantastic Resort', 'This Game Is Very Good And Vary Nice', '100', 'hotels', '2021-11-06', 3, '11405_hero_background.jpg', 1),
(14, 'Phone Not 10 ', 'This Game Is Very Good And Vary Nice', '$344', 'hotels', '2021-11-25', 3, '51416_3.jpg', 0),
(15, 'very room', 'this is the room very good', '$400', 'rooms', '2021-11-25', 3, '9794_62440_Magic Mouse.jpg', 1),
(16, ' Hotel rooms ', '20 years ago were twice as large as some of today&#39;s offering', '300', 'hotels', '2021-11-26', 3, '64753_hot1.jpg', 1),
(17, 'Phone Not 10 ', 'This Game Is Very Good And Vary Nice', '200', 'rooms', '2021-11-27', 3, '74940_room1.jpg', 1);

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `users`
--

INSERT INTO `users` (`UserID`, `FullName`, `Email`, `Password`, `gender`, `avatar`, `GroupID`) VALUES
(1, 'fiteer alqiadi', 'fiteer@gmail.com', '2778cb15047b69e5e1e166cbb0d8c4323c9595c6', NULL, '', 2),
(2, 'ahmed alqiadi', 'ahmed@gmail.com', '6eeafaef013319822a1f30407a5353f778b59790', 'Male', '67722_room4.jpg', 0),
(3, 'assad alkamil', 'assad@gmail.com', '6eeafaef013319822a1f30407a5353f778b59790', 'Male', '40390_hot1.jpg', 1),
(4, 'abdualrhman', 'abdualrhman@gmail.com', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', NULL, '', 2),
(5, 'mohammed', 'moham@gmail.com', '6eeafaef013319822a1f30407a5353f778b59790', 'Male', '71284_hot1.jpg', 1),
(6, 'mohammed amin', 'moham@gmail.com', '01b307acba4f54f55aafc33bb06bbbf6ca803e9a', 'Male', '2687_4.jpg', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookies`
--
ALTER TABLE `bookies`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `book4` (`Item_id`),
  ADD KEY `book5` (`Member_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`C_ID`),
  ADD KEY `com1` (`item_id`),
  ADD KEY `com2` (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`Item_ID`),
  ADD KEY `item1` (`Member_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookies`
--
ALTER TABLE `bookies`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `C_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `Item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- قيود الجداول المحفوظة
--

--
-- القيود للجدول `bookies`
--
ALTER TABLE `bookies`
  ADD CONSTRAINT `book4` FOREIGN KEY (`Item_id`) REFERENCES `items` (`Item_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `book5` FOREIGN KEY (`Member_id`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- القيود للجدول `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `com1` FOREIGN KEY (`item_id`) REFERENCES `items` (`Item_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `com2` FOREIGN KEY (`user_id`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- القيود للجدول `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `item1` FOREIGN KEY (`Member_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
