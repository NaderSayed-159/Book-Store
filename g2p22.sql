-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 24, 2021 at 02:26 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `g2p22`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `book_name` char(80) NOT NULL,
  `book_category` int(11) DEFAULT NULL,
  `describtion` varchar(300) NOT NULL,
  `Download` varchar(300) NOT NULL,
  `coverPic` char(60) NOT NULL,
  `book_adder` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `book_name`, `book_category`, `describtion`, `Download`, `coverPic`, `book_adder`) VALUES
(1, ' petroleum geophysics', 2, 'we are going to  discuss the petroleum industry', 'https://codepen.io/search/', '  6409806951626994342.jpg', 1),
(112, ' petroleum geophysic', 2, 'we are going to  discuss the petroleum industry', 'https://codepen.io/search/', '   17497390301626994353.jpg', 1),
(113, 'after earth', 2, 'zombies after earth', 'https://codepen.io/search/', '18066700341626994504.jpg', 26);

-- --------------------------------------------------------

--
-- Table structure for table `bookscategory`
--

CREATE TABLE `bookscategory` (
  `id` int(11) NOT NULL,
  `book_category` char(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bookscategory`
--

INSERT INTO `bookscategory` (`id`, `book_category`) VALUES
(1, 'Geology'),
(2, 'Geophysics');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `event_name` char(60) NOT NULL,
  `event_describtion` varchar(200) NOT NULL,
  `eventDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `event_logo` varchar(110) NOT NULL,
  `event_submiter` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `event_name`, `event_describtion`, `eventDate`, `event_logo`, `event_submiter`) VALUES
(27, ' petroleum geophysi', 'we are going to  discuss the petroleum industry', '2021-07-30 19:00:00', '3933706501627063142.jpg', 1),
(28, 'petroleum geophysics', 'we are going to  discuss the petroleum industry', '2021-07-24 17:55:00', '19185492421627062957.jpg', 1),
(29, 'petroleum geophysics', 'we are going to  discuss the petroleum industry', '2021-07-23 21:06:37', '19185492421627062957.jpg', 58),
(30, 'petroleum geophysics', 'we are going to  discuss the petroleum industry', '2021-07-24 17:55:00', '19185492421627062957.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `events_check`
--

CREATE TABLE `events_check` (
  `id` int(11) NOT NULL,
  `event_name` char(100) NOT NULL,
  `event_desc` varchar(500) NOT NULL,
  `e_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `event_submiter` int(11) DEFAULT NULL,
  `e_logo` char(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events_check`
--

INSERT INTO `events_check` (`id`, `event_name`, `event_desc`, `e_date`, `event_submiter`, `e_logo`) VALUES
(4, 'petroleum geophysics', 'we are going to  discuss the petroleum industry', '2021-07-31 21:22:00', 1, '20405789651627064635.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `e_reservation`
--

CREATE TABLE `e_reservation` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `enroller` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `e_reservation`
--

INSERT INTO `e_reservation` (`id`, `event_id`, `enroller`) VALUES
(1, 27, 58),
(2, 29, 26),
(3, 28, 26);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` int(11) NOT NULL,
  `content` int(11) NOT NULL,
  `image` int(11) NOT NULL,
  `adder` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `payments_methods`
--

CREATE TABLE `payments_methods` (
  `id` int(11) NOT NULL,
  `acc_number` int(50) NOT NULL,
  `acc_serial` int(50) NOT NULL,
  `payments_owner` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` char(100) NOT NULL,
  `content` varchar(400) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `post_submiter` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `publications`
--

CREATE TABLE `publications` (
  `id` int(11) NOT NULL,
  `paper_title` char(50) NOT NULL,
  `puplisher_name` char(50) NOT NULL,
  `publisher_id` int(11) DEFAULT NULL,
  `describtion` varchar(200) NOT NULL,
  `paper_category` int(11) DEFAULT NULL,
  `paper_file` char(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `publications_category`
--

CREATE TABLE `publications_category` (
  `id` int(11) NOT NULL,
  `publication_categ` char(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `question` char(100) NOT NULL,
  `question_asker` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `q_answers`
--

CREATE TABLE `q_answers` (
  `id` int(11) NOT NULL,
  `answer` varchar(600) NOT NULL,
  `question_id` int(11) DEFAULT NULL,
  `replier_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` char(50) NOT NULL,
  `email` char(80) NOT NULL,
  `password` char(50) NOT NULL,
  `phone` int(11) NOT NULL,
  `gender` char(40) NOT NULL,
  `user_type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `gender`, `user_type`) VALUES
(1, 'Nader bauomi', 'nadersayed001@gmail.com', '2bc92bfef16f612ffac1dbefcb4aab47b0016062', 1099412326, 'male', 1),
(26, 'rehab bauom', 'rehabsayed001@gmail.com', 'd135b5130cd6b446693ecb1cfe81e3721f66079f', 1283165508, 'female', 2),
(55, 'nadersayed0', 'nadersay@gmail.com', 'beed8d5dbfe66bc625d3b733abff0036dcd4a7f9', 1099411326, 'female', 3),
(56, 'rawan khouder', 'rkhouder@gmail.com', 'dd108f601142a1e57f402a97fa9ae8dbef8af333', 1112365466, 'female', 1),
(58, 'rawan nasser', 'rawan@gmail.com', '316e876288a1ade387b62cee77e68f30c5a51a46', 1016139685, 'female', 2),
(59, 'nader', 'nader@gmail.com', '123456789', 1113279567, 'male', 3),
(60, 'naders', 'delking90@gmail.com', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 1113275667, 'male', 3),
(61, 'nader', 'nase@gmail.com', '2bc92bfef16f612ffac1dbefcb4aab47b0016062', 1113269576, 'male', 3),
(62, 'root', 'root@admin.com', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 1111111111, 'male', 1);

-- --------------------------------------------------------

--
-- Table structure for table `userstypes`
--

CREATE TABLE `userstypes` (
  `id` int(11) NOT NULL,
  `user_type` char(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `userstypes`
--

INSERT INTO `userstypes` (`id`, `user_type`) VALUES
(1, 'Admin'),
(2, 'Company'),
(3, 'Standard');

-- --------------------------------------------------------

--
-- Table structure for table `users_media`
--

CREATE TABLE `users_media` (
  `id` int(11) NOT NULL,
  `profile_pic` char(60) NOT NULL,
  `CV` char(100) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` int(11) NOT NULL,
  `Video_name` char(100) NOT NULL,
  `Video_file` char(60) NOT NULL,
  `video_submiter` int(11) DEFAULT NULL,
  `video_cat` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `video_category`
--

CREATE TABLE `video_category` (
  `id` int(11) NOT NULL,
  `video category` char(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_category` (`book_category`),
  ADD KEY `book_adder` (`book_adder`);

--
-- Indexes for table `bookscategory`
--
ALTER TABLE `bookscategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_submiter` (`event_submiter`);

--
-- Indexes for table `events_check`
--
ALTER TABLE `events_check`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_submiter` (`event_submiter`);

--
-- Indexes for table `e_reservation`
--
ALTER TABLE `e_reservation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `events reservation` (`event_id`),
  ADD KEY `enroller` (`enroller`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `adder` (`adder`);

--
-- Indexes for table `payments_methods`
--
ALTER TABLE `payments_methods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `acc_number` (`acc_number`),
  ADD KEY `id_user_pay` (`payments_owner`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_submiter` (`post_submiter`);

--
-- Indexes for table `publications`
--
ALTER TABLE `publications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `publish_id` (`publisher_id`),
  ADD KEY `paper_category` (`paper_category`);

--
-- Indexes for table `publications_category`
--
ALTER TABLE `publications_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `publication_categ` (`publication_categ`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_asker` (`question_asker`);

--
-- Indexes for table `q_answers`
--
ALTER TABLE `q_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`),
  ADD KEY `replier_id` (`replier_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD KEY `user_type` (`user_type`);

--
-- Indexes for table `userstypes`
--
ALTER TABLE `userstypes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_type` (`user_type`);

--
-- Indexes for table `users_media`
--
ALTER TABLE `users_media`
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `video_cat` (`video_cat`),
  ADD KEY `video_submiter` (`video_submiter`);

--
-- Indexes for table `video_category`
--
ALTER TABLE `video_category`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `bookscategory`
--
ALTER TABLE `bookscategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `events_check`
--
ALTER TABLE `events_check`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `e_reservation`
--
ALTER TABLE `e_reservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments_methods`
--
ALTER TABLE `payments_methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `publications`
--
ALTER TABLE `publications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `publications_category`
--
ALTER TABLE `publications_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `q_answers`
--
ALTER TABLE `q_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `userstypes`
--
ALTER TABLE `userstypes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video_category`
--
ALTER TABLE `video_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `book adder` FOREIGN KEY (`book_adder`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `book category` FOREIGN KEY (`book_category`) REFERENCES `bookscategory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `user submiter` FOREIGN KEY (`event_submiter`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `events_check`
--
ALTER TABLE `events_check`
  ADD CONSTRAINT `event admin check` FOREIGN KEY (`event_submiter`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `e_reservation`
--
ALTER TABLE `e_reservation`
  ADD CONSTRAINT `event user enroller ` FOREIGN KEY (`enroller`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `events reservation` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news adder` FOREIGN KEY (`adder`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payments_methods`
--
ALTER TABLE `payments_methods`
  ADD CONSTRAINT `payments_owner` FOREIGN KEY (`payments_owner`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `post_submiter` FOREIGN KEY (`post_submiter`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `publications`
--
ALTER TABLE `publications`
  ADD CONSTRAINT `publication Category` FOREIGN KEY (`paper_category`) REFERENCES `publications_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `publisher` FOREIGN KEY (`publisher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `question_asker` FOREIGN KEY (`question_asker`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `q_answers`
--
ALTER TABLE `q_answers`
  ADD CONSTRAINT `questions and answers` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `replier ` FOREIGN KEY (`replier_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_types` FOREIGN KEY (`user_type`) REFERENCES `userstypes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users_media`
--
ALTER TABLE `users_media`
  ADD CONSTRAINT `user_media` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `video category` FOREIGN KEY (`video_cat`) REFERENCES `video_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `video submiter` FOREIGN KEY (`video_submiter`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
