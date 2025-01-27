-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 18, 2021 at 06:23 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `petlovers`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `username` varchar(500) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `username`, `password`) VALUES
(1, 'Admin', 'admin', 'a29c57c6894dee6e8251510d58c07078ee3f49bf');

-- --------------------------------------------------------

--
-- Table structure for table `advertisement`
--

CREATE TABLE `advertisement` (
  `add_id` int(11) NOT NULL,
  `pet_cat` int(11) NOT NULL,
  `district_id` int(11) NOT NULL,
  `post_title` varchar(500) NOT NULL,
  `pet_age` varchar(200) NOT NULL,
  `owner_name` varchar(500) NOT NULL,
  `owner_contact` int(10) NOT NULL,
  `owner_address` varchar(500) NOT NULL,
  `price` int(11) NOT NULL,
  `description` varchar(500) NOT NULL,
  `status` int(11) NOT NULL,
  `pay_status` int(11) NOT NULL,
  `published_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `package_id` int(11) DEFAULT NULL,
  `posted_date` date NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `advertisement`
--

INSERT INTO `advertisement` (`add_id`, `pet_cat`, `district_id`, `post_title`, `pet_age`, `owner_name`, `owner_contact`, `owner_address`, `price`, `description`, `status`, `pay_status`, `published_date`, `end_date`, `package_id`, `posted_date`, `user_id`) VALUES
(13, 1, 2, '0784402852dfghjkl;', '2 Months', 'Test', 784402852, 'test', 20000, 'ssss', 1, 1, '2021-09-12', '2021-09-19', 1, '2021-09-10', 6),
(15, 1, 1, '0784402852', '2 Months', 'Test', 784402852, 'ddd', 20000, '   ssssss', 1, 1, '2021-09-12', '2021-09-19', 1, '2021-09-10', 6),
(16, 1, 2, '0784402852', '2 Months', 'Test', 784402852, 'test', 20000, 'ssss', 1, 1, '2021-09-12', '2021-09-19', 1, '2021-09-10', 6),
(17, 1, 2, '0784402852dfghjkl;', '2 Months', 'Test', 784402852, 'test', 20000, 'ssss', 1, 1, '2021-09-12', '2021-09-19', 1, '2021-09-10', 6),
(18, 1, 1, '0784402852', '2 Months', 'Test', 784402852, 'ddd', 20000, '   ssssss', 1, 1, '2021-09-12', '2021-09-19', 1, '2021-09-10', 6),
(19, 1, 2, '0784402852', '2 Months', 'Test', 784402852, 'test', 20000, 'ssss', 1, 1, '2021-09-12', '2021-09-19', 1, '2021-09-10', 6),
(20, 1, 2, '0784402852dfghjkl;', '2 Months', 'Test', 784402852, 'test', 20000, 'ssss', 1, 1, '2021-09-12', '2021-09-19', 1, '2021-09-10', 6),
(21, 1, 1, '0784402852', '2 Months', 'Test', 784402852, 'ddd', 20000, '   ssssss', 1, 1, '2021-09-12', '2021-09-19', 1, '2021-09-10', 6),
(22, 1, 2, '0784402852', '2 Months', 'Test', 784402852, 'test', 20000, 'ssss', 1, 1, '2021-09-12', '2021-09-19', 1, '2021-09-10', 6),
(23, 1, 2, '0784402852dfghjkl;', '2 Months', 'Test', 784402852, 'test', 20000, 'ssss', 1, 1, '2021-09-12', '2021-09-19', 1, '2021-09-10', 6);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_name`) VALUES
(1, 'Dogs & Puppies'),
(2, 'Cats & Kittens'),
(3, 'Aquarium Fish'),
(4, 'Birds'),
(5, 'Rabbits & Bunnies'),
(6, 'Small Furries'),
(7, 'Horses/Ponies');

-- --------------------------------------------------------

--
-- Table structure for table `district`
--

CREATE TABLE `district` (
  `district_id` int(11) NOT NULL,
  `district_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `district`
--

INSERT INTO `district` (`district_id`, `district_name`) VALUES
(1, 'Ampara'),
(2, 'Anuradhapura'),
(3, 'Badulla'),
(4, 'Batticoloa'),
(5, 'Colombo'),
(6, 'Galle'),
(7, 'Gampaha'),
(8, 'Hambantota'),
(9, 'Jaffna'),
(10, 'Kalutara'),
(11, 'Kandy'),
(12, 'Kegalle'),
(13, 'Kilinochchi'),
(14, 'Kurunegala'),
(15, 'Mannar'),
(16, 'Matale'),
(17, 'Matara'),
(18, 'Monaragala'),
(19, 'Mullaitivu'),
(20, 'Nuwara Eliya'),
(21, 'Polonnaruwa'),
(22, 'Puttalam'),
(23, 'Rathnapura'),
(24, 'Trincomalee'),
(25, 'Vavuniya');

-- --------------------------------------------------------

--
-- Table structure for table `donation`
--

CREATE TABLE `donation` (
  `donate_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `donation`
--

INSERT INTO `donation` (`donate_id`, `amount`, `user_id`) VALUES
(1, 500, 6);

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

CREATE TABLE `package` (
  `package_id` int(11) NOT NULL,
  `package_name` varchar(500) NOT NULL,
  `package_price` int(11) NOT NULL,
  `package_description` text NOT NULL,
  `package_validity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`package_id`, `package_name`, `package_price`, `package_description`, `package_validity`) VALUES
(1, 'Silver', 500, 'Post will live for 7 days', 7),
(2, 'Gold', 750, 'Post will live for 15 days', 15),
(3, 'Platinum', 1000, 'Post will live for 30 days', 30);

-- --------------------------------------------------------

--
-- Table structure for table `post_image`
--

CREATE TABLE `post_image` (
  `img_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `image` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `service_id` int(11) NOT NULL,
  `service_title` varchar(500) NOT NULL,
  `district` int(11) NOT NULL,
  `stype_id` int(11) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `lat` double NOT NULL,
  `service_address` varchar(500) NOT NULL,
  `contact` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `lng` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`service_id`, `service_title`, `district`, `stype_id`, `description`, `lat`, `service_address`, `contact`, `user_id`, `lng`) VALUES
(5, '0784402852', 7, 1, 'dddd', 7.0712727719477675, 'test', 784402852, 6, 79.95991702901105),
(6, '0784402852', 5, 1, 'dddd', 6.951326886751, 'test', 784402852, 6, 79.83906741963605),
(8, '0784402852', 4, 1, 'dddd', 7.6923002499315265, 'test service', 784402852, 6, 81.68477054463605),
(9, '0784402852', 7, 1, 'dddd', 7.0712727719477675, 'test', 784402852, 6, 79.95991702901105),
(10, '0784402852', 5, 1, 'dddd', 6.951326886751, 'test', 784402852, 6, 79.83906741963605),
(12, '0784402852', 4, 1, 'dddd', 7.6923002499315265, 'test service', 784402852, 6, 81.68477054463605),
(13, '0784402852', 7, 1, 'dddd', 7.0712727719477675, 'test', 784402852, 6, 79.95991702901105),
(14, '0784402852', 5, 1, 'dddd', 6.951326886751, 'test', 784402852, 6, 79.83906741963605),
(16, '0784402852', 4, 1, 'dddd', 7.6923002499315265, 'test service', 784402852, 6, 81.68477054463605),
(17, '0784402852', 7, 1, 'dddd', 7.0712727719477675, 'test', 784402852, 6, 79.95991702901105),
(18, '0784402852', 5, 1, 'dddd', 6.951326886751, 'test', 784402852, 6, 79.83906741963605);

-- --------------------------------------------------------

--
-- Table structure for table `service_book`
--

CREATE TABLE `service_book` (
  `booking_id` int(11) NOT NULL,
  `booked_date` date NOT NULL,
  `service_id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `contact` int(11) NOT NULL,
  `address` varchar(500) NOT NULL,
  `email` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `service_book`
--

INSERT INTO `service_book` (`booking_id`, `booked_date`, `service_id`, `name`, `contact`, `address`, `email`) VALUES
(1, '2021-09-11', 3, 'Randika', 784402852, 'test', 'randika.hasheen.1996@gmail.com'),
(2, '2021-09-12', 3, 'Randika', 784402852, 'test', 'randika.hasheen.1996@gmail.com'),
(3, '2021-09-12', 3, '0784402852', 784402852, 'test', 'randika.hasheen.1996@gmail.com'),
(4, '2021-09-12', 9, 'Test test', 784402852, 'test', 'randika.hasheen.1996@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `service_type`
--

CREATE TABLE `service_type` (
  `stype_id` int(11) NOT NULL,
  `service_name` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `service_type`
--

INSERT INTO `service_type` (`stype_id`, `service_name`) VALUES
(1, 'Transportation'),
(2, 'Veterinarian'),
(3, 'Pet Care Center'),
(4, 'Pet Food');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(500) NOT NULL,
  `last_name` varchar(500) NOT NULL,
  `email` varchar(500) NOT NULL,
  `password` text NOT NULL,
  `status` int(11) NOT NULL,
  `mobile` int(10) NOT NULL,
  `address` varchar(500) NOT NULL,
  `postal_code` int(11) NOT NULL,
  `for_advertise` int(11) NOT NULL,
  `for_services` int(11) NOT NULL,
  `reset_token` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `email`, `password`, `status`, `mobile`, `address`, `postal_code`, `for_advertise`, `for_services`, `reset_token`) VALUES
(1, 'Randika', 'Hasheen', 'test@test.com', 'dddd5d7b474d2c78ebbb833789c4bfd721edf4bf', 1, 784402852, 'test', 11000, 1, 0, ''),
(2, 'Randika', 'Hasheen', 'test@test.com1', 'dddd5d7b474d2c78ebbb833789c4bfd721edf4bf', 1, 784402852, 'test', 11000, 1, 0, ''),
(4, 'sssss', 'ssss', 'testsss@test.com', 'c95ff08b31f403df71c60ed7cca159f380ce1123', 1, 784402852, 'test', 11000, 1, 0, ''),
(6, 'Randika ', 'Hasheen', 'randika.hasheen.1996@gmail.com', 'c95ff08b31f403df71c60ed7cca159f380ce1123', 1, 784402852, 'test', 11000, 1, 1, ''),
(7, 'ssss', 'ssss', 'test5@test.com', '94ba69fdd6ac7c1576e4b079514aa04004822824', 1, 784402852, 'test', 11000, 1, 0, ''),
(8, '0784402852', 'test@test.com', 'test12@test.com', '94ba69fdd6ac7c1576e4b079514aa04004822824', 1, 784402852, 'test', 11000, 1, 0, ''),
(9, '0784402852', 'test@test.com', 'test123d@test.com', '94ba69fdd6ac7c1576e4b079514aa04004822824', 1, 784402852, 'test', 11000, 1, 0, ''),
(10, 'testt', 'ssss', 'test@test.comqq', '94ba69fdd6ac7c1576e4b079514aa04004822824', 1, 784402852, 'test', 11000, 1, 1, ''),
(11, 'FFFFF', 'sss', 'teszt@test.comzzz', '94ba69fdd6ac7c1576e4b079514aa04004822824', 1, 784402852, 'test', 11000, 0, 1, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `advertisement`
--
ALTER TABLE `advertisement`
  ADD PRIMARY KEY (`add_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `district`
--
ALTER TABLE `district`
  ADD PRIMARY KEY (`district_id`);

--
-- Indexes for table `donation`
--
ALTER TABLE `donation`
  ADD PRIMARY KEY (`donate_id`);

--
-- Indexes for table `package`
--
ALTER TABLE `package`
  ADD PRIMARY KEY (`package_id`);

--
-- Indexes for table `post_image`
--
ALTER TABLE `post_image`
  ADD PRIMARY KEY (`img_id`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `service_book`
--
ALTER TABLE `service_book`
  ADD PRIMARY KEY (`booking_id`);

--
-- Indexes for table `service_type`
--
ALTER TABLE `service_type`
  ADD PRIMARY KEY (`stype_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `advertisement`
--
ALTER TABLE `advertisement`
  MODIFY `add_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `district`
--
ALTER TABLE `district`
  MODIFY `district_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `donation`
--
ALTER TABLE `donation`
  MODIFY `donate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `package`
--
ALTER TABLE `package`
  MODIFY `package_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `post_image`
--
ALTER TABLE `post_image`
  MODIFY `img_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `service_book`
--
ALTER TABLE `service_book`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `service_type`
--
ALTER TABLE `service_type`
  MODIFY `stype_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
