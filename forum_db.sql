-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 13, 2023 at 11:55 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `forum_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(30) NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `date_updated`) VALUES
(11, 'Mathematics', 'Algebra', '2023-12-13 13:53:37');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(30) NOT NULL,
  `topic_id` int(30) NOT NULL,
  `user_id` int(30) NOT NULL,
  `comment` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `topic_id`, `user_id`, `comment`, `date_created`, `date_updated`) VALUES
(1, 2, 1, 'Sample Comment', '2020-10-16 16:55:39', '2020-10-16 16:55:39'),
(2, 2, 2, 'test', '2020-10-16 17:04:34', '2020-10-16 17:04:34'),
(3, 2, 1, 'sample', '2020-10-17 08:54:46', '2020-10-17 08:54:46'),
(4, 2, 1, 'asdasd', '2020-10-17 09:42:04', '2020-10-17 09:42:04'),
(5, 2, 1, 'gah', '2023-12-13 08:59:07', '2023-12-13 08:59:07'),
(6, 2, 6, 'hi', '2023-12-13 10:35:30', '2023-12-13 10:35:30'),
(7, 13, 1, 'hknn', '2023-12-13 10:56:15', '2023-12-13 10:56:15'),
(8, 3, 1, 'bobo&lt;p&gt;ka&lt;/p&gt;', '2023-12-13 11:16:41', '2023-12-13 11:16:58'),
(9, 3, 1, 'hi', '2023-12-13 11:25:30', '2023-12-13 11:25:30'),
(10, 18, 6, 'science?', '2023-12-13 11:29:58', '2023-12-13 11:29:58'),
(11, 19, 1, 'hajs', '2023-12-13 12:02:19', '2023-12-13 12:02:19'),
(12, 20, 1, 'hi', '2023-12-13 13:51:37', '2023-12-13 13:51:37'),
(13, 20, 1, 'jjadgavdb', '2023-12-13 13:52:07', '2023-12-13 13:52:07'),
(14, 21, 6, 'grade 2', '2023-12-13 13:56:51', '2023-12-13 13:56:51');

-- --------------------------------------------------------

--
-- Table structure for table `forum_views`
--

CREATE TABLE `forum_views` (
  `id` int(30) NOT NULL,
  `topic_id` int(30) NOT NULL,
  `user_id` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `forum_views`
--

INSERT INTO `forum_views` (`id`, `topic_id`, `user_id`) VALUES
(1, 2, 2),
(2, 2, 1),
(3, 2, 3),
(4, 2, 4),
(5, 2, 6),
(6, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE `replies` (
  `id` int(30) NOT NULL,
  `comment_id` int(30) NOT NULL,
  `reply` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `replies`
--

INSERT INTO `replies` (`id`, `comment_id`, `reply`, `user_id`, `date_created`, `date_updated`) VALUES
(1, 1, 'sample reply', 1, '2020-10-17 09:48:06', '0000-00-00 00:00:00'),
(2, 2, '&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-size: 16px; text-align: justify;&quot;&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec elementum nunc bibendum, luctus diam id, tincidunt nisl. Vestibulum turpis arcu, fringilla sed lacus in, eleifend vulputate purus. Mauris sollicitudin metus in risus finibus fringilla.&lt;/span&gt;&lt;br&gt;', 1, '2020-10-17 09:48:57', '0000-00-00 00:00:00'),
(3, 1, 'asdasd&lt;p&gt;asdasd&lt;/p&gt;', 1, '2020-10-17 09:52:02', '0000-00-00 00:00:00'),
(4, 1, 's', 1, '2020-10-17 10:01:00', '0000-00-00 00:00:00'),
(5, 1, 'asdaasd', 1, '2020-10-17 10:01:06', '0000-00-00 00:00:00'),
(6, 1, 'asdasd&lt;p&gt;&lt;br&gt;&lt;/p&gt;', 1, '2020-10-17 10:01:53', '0000-00-00 00:00:00'),
(7, 1, 'asdsdsd', 1, '2020-10-17 10:16:09', '0000-00-00 00:00:00'),
(8, 1, '1', 1, '2020-10-17 10:16:13', '0000-00-00 00:00:00'),
(9, 1, '2', 1, '2020-10-17 10:16:17', '0000-00-00 00:00:00'),
(10, 5, 'go', 1, '2023-12-13 08:59:20', '0000-00-00 00:00:00'),
(11, 9, 'hello', 1, '2023-12-13 11:25:43', '0000-00-00 00:00:00'),
(12, 10, 'hindi', 6, '2023-12-13 11:30:08', '0000-00-00 00:00:00'),
(13, 11, 'hi', 1, '2023-12-13 12:02:30', '0000-00-00 00:00:00'),
(14, 12, 'hello', 1, '2023-12-13 13:51:54', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `id` int(30) NOT NULL,
  `category_ids` text NOT NULL,
  `title` varchar(250) NOT NULL,
  `content` text NOT NULL,
  `user_id` int(30) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `category_ids`, `title`, `content`, `user_id`, `date_created`) VALUES
(3, '2', 'ehe', 'huhu', 6, '2023-12-13 10:36:09'),
(18, '2,10', 'hipo', 'Physical j', 6, '2023-12-13 11:29:43'),
(19, '10', 'hi', 'hajhs', 1, '2023-12-13 12:02:08'),
(20, '10', 'Physical Science', 'Biosystem', 1, '2023-12-13 13:51:14'),
(21, '11', 'Grade 1', 'Addition', 6, '2023-12-13 13:56:28');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 3 COMMENT '1=Admin,2=Staff, 3= subscriber'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `type`) VALUES
(1, 'Administrator', 'admin', '0192023a7bbd73250516f069df18b500', 1),
(6, 'gabw', 'gab', '827ccb0eea8a706c4c34a16891f84e7b', 2),
(7, 'Kevin Gabriel', 'kevin', '827ccb0eea8a706c4c34a16891f84e7b', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forum_views`
--
ALTER TABLE `forum_views`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `forum_views`
--
ALTER TABLE `forum_views`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
