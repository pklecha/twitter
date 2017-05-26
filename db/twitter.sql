-- phpMyAdmin SQL Dump
-- version 4.6.6deb1+deb.cihar.com~xenial.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 26, 2017 at 08:35 PM
-- Server version: 5.7.18-0ubuntu0.16.04.1
-- PHP Version: 7.0.15-0ubuntu0.16.04.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `twitter`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `creation_date` int(11) NOT NULL,
  `tweet_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` varchar(140) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `creation_date`, `tweet_id`, `user_id`, `comment`) VALUES
(2, 1495557276, 1, 6, 'Pierwszy komentarz'),
(3, 1495557276, 2, 6, 'Drugi komentarz'),
(4, 1495557276, 3, 1, 'Pierwszy komentarz do tweeta'),
(5, 1495557276, 3, 1, 'Drugi komentarz do tweeta'),
(6, 1495665949, 1, 6, 'test'),
(7, 1495665975, 1, 6, 'test2'),
(8, 1495666028, 1, 6, 'test3'),
(9, 1495666056, 1, 6, 'test4'),
(10, 1495666110, 1, 6, 'test5'),
(11, 1495667997, 6, 6, 'test 1'),
(12, 1495667999, 6, 6, 'test 2'),
(13, 1495668010, 4, 6, 'test test 1'),
(14, 1495731066, 5, 6, 'test test 3444'),
(15, 1495731068, 5, 6, 'yryryryry'),
(16, 1495749652, 7, 6, 'testowy comment'),
(17, 1495797196, 3, 6, 'kolejny komentarz'),
(18, 1495815331, 7, 6, 'test'),
(19, 1495815360, 7, 6, '9999'),
(20, 1495815409, 5, 6, 'ggg');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `recipient_id` int(11) DEFAULT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `creation_date` int(11) NOT NULL,
  `is_read` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `recipient_id`, `sender_id`, `message`, `creation_date`, `is_read`) VALUES
(1, 1, 6, 'Wiadomosc testowa', 1495557276, 0),
(2, 6, 1, 'Wiadomosc testowa', 1495557276, 1),
(5, 6, 8, 'test message', 1495557276, 1),
(6, 6, 1, 'another test message', 1495557276, 1),
(7, 6, 3, 'test message', 1495557276, 1),
(8, 8, 6, 'test message', 1495557276, 0),
(9, 8, 6, 'another test message', 1495557276, 1),
(11, 3, 6, 'test reply', 1495820794, 0),
(12, 3, 6, 'test reply 2', 1495821599, 0),
(13, 3, 6, 'test', 1495821636, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tweet`
--

CREATE TABLE `tweet` (
  `id` int(11) NOT NULL,
  `text` varchar(140) NOT NULL,
  `user_id` int(11) NOT NULL,
  `creation_date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tweet`
--

INSERT INTO `tweet` (`id`, `text`, `user_id`, `creation_date`) VALUES
(1, 'Testowy tweet lorem ipsum dolor', 1, 1495557276),
(2, 'Drugi testowy tweet', 6, 1495557307),
(3, 'Trzeci testowy tweet', 6, 1495557308),
(4, 'test', 6, 1495667786),
(5, 'test test', 6, 1495667921),
(6, 'Juz dziala w porzadku', 6, 1495667931),
(7, 'testowy tlit', 6, 1495749646);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `username`, `password`) VALUES
(1, 'pawe3l@ecstaticcreation.com', 'pawel3', '$2y$10$IsDwP6gX7T5VVVKTLumaXufOV8kFLFfy2UaQ07FbtHa7qnhRbNrDe'),
(3, 'pawel.klecha2@gmail.com', 'pawel1', '$2y$10$5CZwiqvtYTKBe/6U2pe0lu5XFFkRH7gP36OOl5tohYhpsk5P1nHNe'),
(4, 'pawel@ecstaticcreation.com', 'pawel2', '$2y$10$jYww3Z.BkiqV86BT4UPGteVsQQLNFzKNqx4ICz.Yc7xmyX3srznle'),
(6, 'pawel452@klecha.com', 'pawe4', '$2y$10$8qu3r9mrfP0pBXJ8d.wCWuufsvvTr9XeC7Z9AICiEfN0mdCpp/mLy'),
(7, 'pawel5@gmail.com', 'pawel5', '$2y$10$pJy5FKHJJBV5dW8M/0WZ3u/yaQcx0BiT/WVSk1RsC3ADjAhxfW8Sm'),
(8, 'pawel6@gmail.com', 'pawel6', '$2y$10$GzaoF1mez1/4DjgiAp31cO9YEP7bbpHTuQZmuRlM8qNtWsBKxYUia');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_tweet_id_fk` (`tweet_id`),
  ADD KEY `comment_user_id_fk` (`user_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `message_user_sender_fk` (`sender_id`),
  ADD KEY `message_user_recipient_fk` (`recipient_id`);

--
-- Indexes for table `tweet`
--
ALTER TABLE `tweet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tweet_user_id_fk` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `tweet`
--
ALTER TABLE `tweet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_tweet_id_fk` FOREIGN KEY (`tweet_id`) REFERENCES `tweet` (`id`),
  ADD CONSTRAINT `comment_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_user_recipient_fk` FOREIGN KEY (`recipient_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `message_user_sender_fk` FOREIGN KEY (`sender_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `tweet`
--
ALTER TABLE `tweet`
  ADD CONSTRAINT `tweet_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
