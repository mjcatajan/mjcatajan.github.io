-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2023 at 05:53 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `infosec`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id_comments` int(10) NOT NULL,
  `id_post` int(10) NOT NULL,
  `id_user` int(10) NOT NULL,
  `comments` varchar(500) NOT NULL,
  `date_comment` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id_comments`, `id_post`, `id_user`, `comments`, `date_comment`) VALUES
(154, 84, 12, 'asdasdsada', 'January 10, 2023'),
(155, 84, 12, 'hehehe', 'January 10, 2023');

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id_game` int(10) NOT NULL,
  `id_genre` int(10) NOT NULL,
  `game_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id_game`, `id_genre`, `game_name`) VALUES
(1, 0, 'League of Legends'),
(2, 0, 'Call of Duty'),
(5, 0, 'Call of Duty: Mobile');

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

CREATE TABLE `genre` (
  `id_genre` int(10) NOT NULL,
  `genre` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id_post` int(10) NOT NULL,
  `id_user` int(10) NOT NULL,
  `title_post` varchar(50) DEFAULT NULL,
  `date_post` varchar(50) DEFAULT NULL,
  `game_name` varchar(100) DEFAULT NULL,
  `content_post` varchar(600) DEFAULT NULL,
  `bg` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id_post`, `id_user`, `title_post`, `date_post`, `game_name`, `content_post`, `bg`) VALUES
(82, 12, 'asdsadasdsaasasdasd', 'January 10, 2023', 'League of Legends', 'asdasdasdasdasasasdasdasdasdasdsa', 'background: linear-gradient(90deg, rgba(193,255,194,1) 0%, rgba(157,255,110,1) 35%, rgba(255,255,255,1) 100%)'),
(83, 12, 'asdasdasasasasasasasasasasasasasasasasasasasasasas', 'January 10, 2023', 'League of Legends', 'asdasdasdasdsadasasdasdsadasdasdasdasdasas', 'background: linear-gradient(90deg, rgba(255,172,195,1) 0%, rgba(200,255,167,1) 35%, rgba(255,255,255,1) 100%)'),
(84, 12, '123123123123123123123123123123123123', 'January 10, 2023', 'League of Legends', 'asdasdasdsaasdasdsadasdasdasdasdas', 'background: linear-gradient(90deg, rgba(255,207,172,1) 0%, rgba(255,176,176,1) 35%, rgba(255,255,255,1) 100%)');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(300) NOT NULL,
  `country` varchar(100) DEFAULT NULL,
  `fav_game` varchar(150) DEFAULT NULL,
  `date_joined` varchar(50) DEFAULT NULL,
  `bio` varchar(50) DEFAULT NULL,
  `dp` varchar(50) DEFAULT NULL,
  `cover` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `gender`, `first_name`, `last_name`, `email`, `password`, `country`, `fav_game`, `date_joined`, `bio`, `dp`, `cover`) VALUES
(11, 'Male', 'Jomark', 'Amante', 'jomarkamante@gmail.com', '$2y$10$/s2CSItHOi.GGcJ.jXS/b.NWaFxnVpiRCD85hgU8R.mKOqa1kmy8e', 'PH', NULL, 'Jan 5, 2023', 'Laban lang!', '3', '7'),
(12, 'Female', 'Kitty', 'Min', 'kittymin@gmail.com', '$2y$10$Eu.zhPo59O.1g4jt433sN.awj1eMlQFdQdG/ZY9gYiMoLwVOQlCbq', 'PH', NULL, 'Jan 5, 2023', 'Fight fight fight!', '5', '12'),
(33, 'Female', 'Syljie', 'Canete', 'syljiecanete@gmail.com', '$2y$10$0f2rNWXhG2n86PulK1VP4OcDfwnykxfY3lxr6pQxNAdXWwtRscSRm', 'PH', NULL, 'January 5, 2023', NULL, '1', '1'),
(34, 'Female', 'Razenbelle', 'Ureta', 'razenbelleureta@gmail.com', '$2y$10$hPSp9n/UKnaKC/QU78qY4eCB7zxkq4QJex2OGJ8ASDrQiIkwzDgWe', 'PH', NULL, 'January 5, 2023', NULL, '13', '5'),
(35, 'Male', 'Rogel', 'Labanan', 'rogellabanan@gmail.com', '$2y$10$KuIRzL57x0UcSHXYXfI1TeYXVxcaBzlq14W8DgQyCGWvDtBD1FXra', 'PH', NULL, 'January 9, 2023', NULL, '17', '5');

-- --------------------------------------------------------

--
-- Table structure for table `verification`
--

CREATE TABLE `verification` (
  `id` int(10) NOT NULL,
  `id_user` int(10) DEFAULT NULL,
  `verify` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `verification`
--

INSERT INTO `verification` (`id`, `id_user`, `verify`) VALUES
(1, 12, 2),
(2, 11, 2),
(3, 33, 1),
(4, 34, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id_comments`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id_game`);

--
-- Indexes for table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id_genre`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id_post`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `verification`
--
ALTER TABLE `verification`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id_comments` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id_game` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id_post` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
