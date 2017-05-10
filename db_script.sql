-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 16, 2017 at 01:44 PM
-- Server version: 5.6.33
-- PHP Version: 7.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `multi`
--
CREATE DATABASE IF NOT EXISTS `multi` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `multi`;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `mi` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `eucharist` bit(1) DEFAULT NULL,
  `penance` bit(1) DEFAULT NULL,
  `confirmation` bit(1) DEFAULT NULL,
  `grade` varchar(255) DEFAULT NULL,
  `date_birth` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `student`
--

TRUNCATE TABLE `student`;
--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `email`, `first_name`, `mi`, `last_name`, `eucharist`, `penance`, `confirmation`, `grade`, `date_birth`) VALUES
(1, 'sergio.cintra@gmail.com', 'Pedro', 'P', 'Cintra', b'1', b'1', b'1', '12th Grade', '0000-00-00'),
(2, 'sergio.cintra@gmail.com', 'João', '', 'Silva', b'1', b'1', b'0', 'Pre-Kindergarten', '0000-00-00'),
(4, 'sergio.cintra@gmail.com', 'Juca', 'K', 'Fouri', b'1', b'1', b'1', '3rd Grade', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `email` varchar(255) NOT NULL,
  `father_name` varchar(255) DEFAULT NULL,
  `father_family_name` varchar(255) DEFAULT NULL,
  `mother_name` varchar(255) DEFAULT NULL,
  `mother_family_name` varchar(255) DEFAULT NULL,
  `father_resides_at_home` bit(1) NOT NULL,
  `father_deceased` bit(1) NOT NULL,
  `mother_resides_at_home` bit(1) NOT NULL,
  `mother_deceased` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `user`
--

TRUNCATE TABLE `user`;
--
-- Dumping data for table `user`
--

INSERT INTO `user` (`email`, `father_name`, `father_family_name`, `mother_name`, `mother_family_name`, `father_resides_at_home`, `father_deceased`, `mother_resides_at_home`, `mother_deceased`) VALUES
('sergio.cintra@gmail.com', 'Sergio', 'Cintra ', 'Nely', 'Cintra', b'1', b'1', b'1', b'1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;