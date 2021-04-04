-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 03, 2021 at 07:17 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eaglemotors`
--


-- --------------------------------------------------------
--
-- Delete tables if they exist
--
DROP TABLE IF EXISTS `appointments`;
DROP TABLE IF EXISTS `clients`;
DROP TABLE IF EXISTS `images`;
DROP TABLE IF EXISTS `inventory`;
DROP TABLE IF EXISTS `carclassification`;



-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `client_first_name` varchar(50) NOT NULL,
  `client_phone_number` varchar(20) DEFAULT NULL,
  `client_id` int(10) UNSIGNED DEFAULT NULL,
  `inv_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Table structure for table `carclassification`
--

CREATE TABLE `carclassification` (
  `classification_id` int(11) NOT NULL,
  `classification_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `carclassification`
--

INSERT INTO `carclassification` (`classification_id`, `classification_name`) VALUES
(1, 'SUV'),
(2, 'Classic'),
(3, 'Sports'),
(4, 'Trucks'),
(5, 'Used');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `client_id` int(10) UNSIGNED NOT NULL,
  `client_first_name` varchar(15) NOT NULL,
  `client_last_name` varchar(25) NOT NULL,
  `client_email` varchar(40) NOT NULL,
  `client_password` varchar(255) NOT NULL,
  `client_level` enum('1','2','3') NOT NULL DEFAULT '1',
  `comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `img_id` int(10) UNSIGNED NOT NULL,
  `inv_id` int(11) UNSIGNED NOT NULL,
  `img_name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `img_path` varchar(150) CHARACTER SET latin1 NOT NULL,
  `img_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `img_primary` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`img_id`, `inv_id`, `img_name`, `img_path`, `img_date`, `img_primary`) VALUES
(95, 1, 'jeep-wrangler.jpg', 'images/vehicles/jeep-wrangler.jpg', '2021-03-22 19:39:41', 1),
(96, 1, 'jeep-wrangler-tn.jpg', 'images/vehicles/jeep-wrangler-tn.jpg', '2021-03-22 19:39:41', 1),
(97, 1, 'jeep-wrangler-2.jpeg', 'images/vehicles/jeep-wrangler-2.jpeg', '2021-03-22 19:40:13', 0),
(98, 1, 'jeep-wrangler-2-tn.jpeg', 'images/vehicles/jeep-wrangler-2-tn.jpeg', '2021-03-22 19:40:13', 0),
(99, 2, 'ford-modelt.jpg', 'images/vehicles/ford-modelt.jpg', '2021-03-22 19:40:34', 1),
(100, 2, 'ford-modelt-tn.jpg', 'images/vehicles/ford-modelt-tn.jpg', '2021-03-22 19:40:34', 1),
(101, 3, 'lambo-Adve.jpg', 'images/vehicles/lambo-Adve.jpg', '2021-03-22 19:40:52', 1),
(102, 3, 'lambo-Adve-tn.jpg', 'images/vehicles/lambo-Adve-tn.jpg', '2021-03-22 19:40:52', 1),
(103, 3, 'lamborghini-ave-2.jpeg', 'images/vehicles/lamborghini-ave-2.jpeg', '2021-03-22 19:41:08', 0),
(104, 3, 'lamborghini-ave-2-tn.jpeg', 'images/vehicles/lamborghini-ave-2-tn.jpeg', '2021-03-22 19:41:08', 0),
(105, 3, 'lamborghini-ave-3.jpeg', 'images/vehicles/lamborghini-ave-3.jpeg', '2021-03-22 19:41:25', 0),
(106, 3, 'lamborghini-ave-3-tn.jpeg', 'images/vehicles/lamborghini-ave-3-tn.jpeg', '2021-03-22 19:41:25', 0),
(107, 3, 'lamborghini-ave-4.jpeg', 'images/vehicles/lamborghini-ave-4.jpeg', '2021-03-22 19:41:39', 0),
(108, 3, 'lamborghini-ave-4-tn.jpeg', 'images/vehicles/lamborghini-ave-4-tn.jpeg', '2021-03-22 19:41:39', 0),
(109, 4, 'monster.jpg', 'images/vehicles/monster.jpg', '2021-03-22 19:41:55', 1),
(110, 4, 'monster-tn.jpg', 'images/vehicles/monster-tn.jpg', '2021-03-22 19:41:55', 1),
(111, 5, 'mechanic.jpg', 'images/vehicles/mechanic.jpg', '2021-03-22 19:42:09', 1),
(112, 5, 'mechanic-tn.jpg', 'images/vehicles/mechanic-tn.jpg', '2021-03-22 19:42:09', 1),
(115, 7, 'mm.jpg', 'images/vehicles/mm.jpg', '2021-03-22 19:42:34', 1),
(116, 7, 'mm-tn.jpg', 'images/vehicles/mm-tn.jpg', '2021-03-22 19:42:34', 1),
(117, 8, 'fire-truck.jpg', 'images/vehicles/fire-truck.jpg', '2021-03-22 19:42:49', 1),
(118, 8, 'fire-truck-tn.jpg', 'images/vehicles/fire-truck-tn.jpg', '2021-03-22 19:42:49', 1),
(119, 9, 'crown-vic.jpg', 'images/vehicles/crown-vic.jpg', '2021-03-22 19:43:01', 1),
(120, 9, 'crown-vic-tn.jpg', 'images/vehicles/crown-vic-tn.jpg', '2021-03-22 19:43:01', 1),
(121, 10, 'camaro.jpg', 'images/vehicles/camaro.jpg', '2021-03-22 19:43:17', 1),
(122, 10, 'camaro-tn.jpg', 'images/vehicles/camaro-tn.jpg', '2021-03-22 19:43:17', 1),
(123, 10, 'camaro-2.jpeg', 'images/vehicles/camaro-2.jpeg', '2021-03-22 19:43:47', 0),
(124, 10, 'camaro-2-tn.jpeg', 'images/vehicles/camaro-2-tn.jpeg', '2021-03-22 19:43:47', 0),
(125, 10, 'camaro-3.jpeg', 'images/vehicles/camaro-3.jpeg', '2021-03-22 19:44:06', 0),
(126, 10, 'camaro-3-tn.jpeg', 'images/vehicles/camaro-3-tn.jpeg', '2021-03-22 19:44:06', 0),
(127, 11, 'escalade.jpg', 'images/vehicles/escalade.jpg', '2021-03-22 19:44:16', 1),
(128, 11, 'escalade-tn.jpg', 'images/vehicles/escalade-tn.jpg', '2021-03-22 19:44:16', 1),
(129, 12, 'hummer.jpg', 'images/vehicles/hummer.jpg', '2021-03-22 19:44:27', 1),
(130, 12, 'hummer-tn.jpg', 'images/vehicles/hummer-tn.jpg', '2021-03-22 19:44:27', 1),
(131, 13, 'aerocar.jpg', 'images/vehicles/aerocar.jpg', '2021-03-22 19:44:35', 1),
(132, 13, 'aerocar-tn.jpg', 'images/vehicles/aerocar-tn.jpg', '2021-03-22 19:44:35', 1),
(133, 14, 'fbi.jpg', 'images/vehicles/fbi.jpg', '2021-03-22 19:44:44', 1),
(134, 14, 'fbi-tn.jpg', 'images/vehicles/fbi-tn.jpg', '2021-03-22 19:44:44', 1),
(135, 15, 'no-image.png', 'images/vehicles/no-image.png', '2021-03-22 19:44:55', 1),
(136, 15, 'no-image-tn.png', 'images/vehicles/no-image-tn.png', '2021-03-22 19:44:55', 1),
(137, 30, 'delorean.jpg', 'images/vehicles/delorean.jpg', '2021-03-22 19:45:19', 1),
(138, 30, 'delorean-tn.jpg', 'images/vehicles/delorean-tn.jpg', '2021-03-22 19:45:19', 1);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `inv_id` int(11) UNSIGNED NOT NULL,
  `inv_make` varchar(30) NOT NULL,
  `inv_model` varchar(30) NOT NULL,
  `inv_description` text DEFAULT NULL,
  `inv_price` decimal(10,2) NOT NULL,
  `inv_stock` smallint(6) NOT NULL,
  `inv_color` varchar(20) NOT NULL,
  `classification_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`inv_id`, `inv_make`, `inv_model`, `inv_description`, `inv_price`, `inv_stock`, `inv_color`, `classification_id`) VALUES
(1, 'Jeep ', 'Wrangler', 'The Jeep Wrangler is small and compact with enough power to get you where you want to go. Its great for everyday driving as well as offroading weather that be on the the rocks or in the mud!', '28045.00', 4, 'Orange', 1),
(2, 'Ford', 'Model T', 'The Ford Model T can be a bit tricky to drive. It was the first car to be put into production. You can get it in any color you want as long as it\'s black.', '30000.00', 2, 'Black', 2),
(3, 'Lamborghini', 'Adventador', 'This V-12 engine packs a punch in this sporty car. Make sure you wear your seatbelt and obey all traffic laws. ', '417650.00', 5, 'White', 3),
(4, 'Monster', 'Truck', 'Most trucks are for working, this one is for fun. this beast comes with 60in tires giving you tracktions needed to jump and roll in the mud.', '150000.00', 3, 'purple', 4),
(5, 'Mechanic', 'Special', 'Not sure where this car came from. however with a little tlc it will run as good a new.', '100.00', 200, 'Rust', 5),
(7, 'Mystery', 'Machine', 'Scooby and the gang always found luck in solving their mysteries because of there 4 wheel drive Mystery Machine. This Van will help you do whatever job you are required to with a success rate of 100%.', '10000.00', 12, 'Green', 1),
(8, 'Spartan', 'Fire Truck', 'Emergencies happen often. Be prepared with this Spartan fire truck. Comes complete with 1000 ft. of hose and a 1000 gallon tank.', '50000.00', 2, 'Red', 4),
(9, 'Ford', 'Crown Victoria', 'After the police force updated their fleet these cars are now available to the public! These cars come equiped with the siren which is convenient for college students running late to class.', '10000.00', 5, 'White', 5),
(10, 'Chevy', 'Camaro', 'If you want to look cool this is the ar you need! This car has great performance at an affordable price. Own it today!', '25000.00', 10, 'Silver', 3),
(11, 'Cadilac', 'Escalade', 'This stylin car is great for any occasion from going to the beach to meeting the president. The luxurious inside makes this car a home away from home.', '75195.00', 4, 'Black', 1),
(12, 'GM', 'Hummer', 'Do you have 6 kids and like to go offroading? The Hummer gives you the small interiors with an engine to get you out of any muddy or rocky situation.', '58800.00', 5, 'Yellow', 5),
(13, 'Aerocar International', 'Aerocar', 'Are you sick of rushhour trafic? This car converts into an airplane to get you where you are going fast. Only 6 of these were made, get them while they last!', '1000000.00', 6, 'Red', 2),
(14, 'FBI', 'Survalence Van', 'do you like police shows? You\'ll feel right at home driving this van, come complete with survalence equipments for and extra fee of $2,000 a month. ', '20000.00', 1, 'Green', 1),
(15, 'Dog ', 'Car', 'Do you like dogs? Well this car is for you straight from the 90s from Aspen, Colorado we have the orginal Dog Car complete with fluffy ears.  ', '35000.00', 1, 'Brown', 2),
(30, 'DCM', 'Delorean', '3 Cup holders\r\nSuperman doors\r\nFuzzy dice!', '1000.00', 1, 'grey', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `appointments_fk_1` (`inv_id`);

--
-- Indexes for table `carclassification`
--
ALTER TABLE `carclassification`
  ADD PRIMARY KEY (`classification_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`client_id`),
  ADD UNIQUE KEY `client_email` (`client_email`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`img_id`),
  ADD UNIQUE KEY `img_name` (`img_name`),
  ADD UNIQUE KEY `img_path` (`img_path`),
  ADD KEY `images_fk_1` (`inv_id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`inv_id`),
  ADD UNIQUE KEY `inv_make` (`inv_make`,`inv_model`),
  ADD KEY `inventory_fk_1` (`classification_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `carclassification`
--
ALTER TABLE `carclassification`
  MODIFY `classification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `client_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `img_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `inv_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_fk_1` FOREIGN KEY (`inv_id`) REFERENCES `inventory` (`inv_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_fk_1` FOREIGN KEY (`inv_id`) REFERENCES `inventory` (`inv_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_fk_1` FOREIGN KEY (`classification_id`) REFERENCES `carclassification` (`classification_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
