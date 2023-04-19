-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Apr 17, 2023 at 02:33 PM
-- Server version: 8.0.32
-- PHP Version: 8.1.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ApiDBTest`
--
DROP DATABASE `ApiDB`;
CREATE DATABASE IF NOT EXISTS `ApiDB` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `ApiDB`;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deadline` date NOT NULL,
  `performer` int NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `comment` varchar(1000) DEFAULT NULL,
  `closing_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `description`, `created_at`, `deadline`, `performer`, `status`, `comment`, `closing_date`) VALUES
(1, 'Styling', 'Improve CSS styles in mini-project #2', '2023-04-15 15:34:41', '2023-04-22', 1, 1, NULL, NULL),
(2, 'Form validation', 'Write code to validate the form in mini-project #2', '2023-04-15 15:41:01', '2023-04-23', 2, 0, NULL, NULL),
(3, 'API', 'Write code to process API requests for mini-project #3', '2023-04-15 15:41:54', '2023-04-24', 3, 0, NULL, NULL),
(4, 'Testing', 'Write code to test converters in mini-project #1', '2023-04-15 16:10:49', '2023-04-19', 3, 0, NULL, NULL),
(5, 'Frontend', 'Write frontend code for mini-project #3', '2023-04-15 16:23:01', '2023-04-26', 1, 0, NULL, NULL),
(6, 'Apache', 'Adjust Apache settings for more efficient communication between frontend and backend', '2023-04-15 16:29:41', '2023-04-27', 2, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`) VALUES
(1, 'Ivan', 'Pudin', 'ivan.pudin@edu.bc.fi', '2c42e5cf1cdbafea04ed267018ef1511'),
(2, 'Shree', 'Bhusal', 'shree.bhusal@edu.bc.fi', 'a3e477de6d99a79b1472069f0911f203'),
(3, 'Arseniiy', 'Kapshtyk', 'arseniy.kapshtyk@edu.bc.fi', 'c73c16b4a2bb2f06b3b845124a539087');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`performer`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
