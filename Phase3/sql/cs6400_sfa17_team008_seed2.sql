DROP DATABASE IF EXISTS `cs6400_sfa17_team008`; 
/* 
Optional: MySQL centric items 
MySQL: DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
MySQL Storage Engines: SET default_storage_engine=InnoDB;
Note: "IF EXISTS" is not universal, and the "IF NOT EXISTS" is uncommonly supported, so this functionaly may not work if outside MySQL RDBMS.

Resources:
https://dev.mysql.com/doc/refman/5.7/en/storage-engines.html
https://bitnami.com/stacks/infrastructure
https://www.jetbrains.com/phpstorm/
http://www.w3schools.com/
*/

SET default_storage_engine=InnoDB;

CREATE DATABASE IF NOT EXISTS cs6400_sfa17_team008 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE cs6400_sfa17_team008;

-- --------------------------------------------------------

--
-- Table structure for table `Add`
--

CREATE TABLE `Add` (
  `clerk_username` varchar(80) NOT NULL,
  `tool_id` int(16) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Add`
--

INSERT INTO `Add` (`clerk_username`, `tool_id`) VALUES
('Flora', 1),
('Flora', 2),
('Flora', 3),
('Flora', 4),
('Flora', 5),
('Flora', 6),
('Flora', 7),
('Flora', 8),
('Flora', 9),
('Flora', 10),
('Flora', 11),
('Flora', 12),
('Flora', 13),
('Flora', 14),
('Flora', 15),
('Flora', 16),
('Flora', 17),
('Flora', 18),
('Flora', 19),
('Flora', 20),
('Flora', 21),
('Flora', 22),
('Flora', 23),
('Flora', 24),
('Flora', 25),
('Flora', 26),
('Flora', 27);

-- --------------------------------------------------------

--
-- Table structure for table `Air_Compressor`
--

CREATE TABLE `Air_Compressor` (
  `tool_id` int(16) UNSIGNED NOT NULL,
  `tank_size` varchar(80) NOT NULL,
  `pressure_rating` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Air_Compressor`
--

INSERT INTO `Air_Compressor` (`tool_id`, `tank_size`, `pressure_rating`) VALUES
(21, '7', '25000'),
(22, '7', ' ');

-- --------------------------------------------------------

--
-- Table structure for table `Clerk`
--

CREATE TABLE `Clerk` (
  `username` varchar(80) NOT NULL,
  `clerk_id` int(16) UNSIGNED DEFAULT NULL,
  `date_of_hire` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Clerk`
--

INSERT INTO `Clerk` (`username`, `clerk_id`, `date_of_hire`) VALUES
('Arsenio', 6, '2017-03-14'),
('Christopher', 3, '2017-04-06'),
('Dalton', 5, '2017-08-22'),
('Dolan', 2, '2017-09-12'),
('Flora', 11, '2015-05-05'),
('Henry', 7, '2016-09-12'),
('Kelsie', 10, '2017-03-10'),
('Lionel', 8, '2017-05-25'),
('Micah', 4, '2017-05-15'),
('Porter', 1, '2017-01-27'),
('Tara', 9, '2016-12-26');

-- --------------------------------------------------------

--
-- Table structure for table `Customer`
--

CREATE TABLE `Customer` (
  `username` varchar(80) NOT NULL,
  `phone_number` varchar(80) NOT NULL,
  `credit_card_number` varchar(80) NOT NULL,
  `name_on_card` varchar(80) NOT NULL,
  `expiration_date` date NOT NULL,
  `CVC_number` varchar(80) NOT NULL,
  `customer_id` int(16) UNSIGNED DEFAULT NULL,
  `address` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Customer`
--

INSERT INTO `Customer` (`username`, `phone_number`, `credit_card_number`, `name_on_card`, `expiration_date`, `CVC_number`, `customer_id`, `address`) VALUES
('Audrey', '444-772-9871', '4556239316925530', 'Lani Hayden', '2031-07-00', '203', 7, '993-460 In Ave, Snellegem, 1151'),
('Chava', '758-942-6459', '4929831401709413', 'Candice Bender', '2018-04-00', '810', 10, '826-9624 Morbi Rd., Dendermonde, 4779'),
('Flora', '123-456-7890', '1234567891123457', 'Xiaohua Cao', '2020-11-00', '678', 11, '7900 Cambridge Street, Houston, Texas, 77054'),
('Jane', '780-602-9596', '4716466093320331', 'Grace Barnes', '2030-11-00', '789', 6, '2867 Faucibus Av., Villa Agnedo, 46846-075'),
('Kaseem', '215-779-7485', '4916975583579642', 'August Bird', '2030-11-00', '789', 8, '196 Per Ave, Borghetto di Borbera, 66859-982'),
('Kasimir', '101-141-9092', '4485513780629471', 'Serena Combs', '2030-06-00', '567', 1, 'Ap #748-156 Mauris. Road, Sluizen, 976500'),
('Logan', '314-454-2777', '4556961742246823', 'Ralph Benton', '2019-05-00', '678', 4, 'Ap #498-9610 Mi Road, Bovigny, V3C 7S1'),
('Nathaniel', '444-154-4146', '4916121768385782', 'Fiona Ward', '2020-11-00', '456', 2, '733-2163 Donec Rd., Perk, ZY5B 9QT'),
('Owen', '449-594-2020', '4716217022968', 'Ignatius Powers', '2020-11-00', '678', 5, '272-5386 Morbi Road, Purral, 165'),
('Quynn', '667-880-9043', '4532891940432660', 'Genevieve Gregory', '2025-11-00', '567', 9, 'Ap #765-7007 Odio. Av., Blieskastel, 73-188'),
('Selma', '775-411-5413', '4929384332083383', 'Bree Rivas', '2027-11-00', '456', 3, '993-460 In Ave, Snellegem, 1151');

-- --------------------------------------------------------

--
-- Table structure for table `Digger`
--

CREATE TABLE `Digger` (
  `tool_id` int(16) UNSIGNED NOT NULL,
  `blade_width` varchar(80) DEFAULT NULL,
  `blade_length` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Digger`
--

INSERT INTO `Digger` (`tool_id`, `blade_width`, `blade_length`) VALUES
(9, '9-3/4', '6-1/2');

-- --------------------------------------------------------

--
-- Table structure for table `Drill`
--

CREATE TABLE `Drill` (
  `tool_id` int(16) UNSIGNED NOT NULL,
  `adjustable_clutch` varchar(5) NOT NULL,
  `min_torque_rating` varchar(80) NOT NULL,
  `max_torque_rating` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Drill`
--

INSERT INTO `Drill` (`tool_id`, `adjustable_clutch`, `min_torque_rating`, `max_torque_rating`) VALUES
(17, 'true', '80.0', '120.2'),
(18, 'true', '80.0', '120.2'),
(27, 'true', '80.0', '120.2');

-- --------------------------------------------------------

--
-- Table structure for table `DropOff`
--

CREATE TABLE `DropOff` (
  `clerk_username` varchar(80) NOT NULL,
  `reservation_id` int(16) UNSIGNED NOT NULL,
  `tool_id` int(16) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `DropOff`
--

INSERT INTO `DropOff` (`clerk_username`, `reservation_id`, `tool_id`) VALUES
('Dalton', 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `GardenTools`
--

CREATE TABLE `GardenTools` (
  `tool_id` int(16) UNSIGNED NOT NULL,
  `handle_material` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `GardenTools`
--

INSERT INTO `GardenTools` (`tool_id`, `handle_material`) VALUES
(9, 'poly'),
(10, 'fiberglass'),
(11, 'fiberglass'),
(12, 'wooden'),
(13, 'wooden'),
(14, 'wooden');

-- --------------------------------------------------------

--
-- Table structure for table `Generator`
--

CREATE TABLE `Generator` (
  `tool_id` int(16) UNSIGNED NOT NULL,
  `power_rating` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Generator`
--

INSERT INTO `Generator` (`tool_id`, `power_rating`) VALUES
(25, '18.0');

-- --------------------------------------------------------

--
-- Table structure for table `Gun`
--

CREATE TABLE `Gun` (
  `tool_id` int(16) UNSIGNED NOT NULL,
  `gauge_rating` varchar(80) DEFAULT NULL,
  `capacity` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Gun`
--

INSERT INTO `Gun` (`tool_id`, `gauge_rating`, `capacity`) VALUES
(7, '22', '20');

-- --------------------------------------------------------

--
-- Table structure for table `Hammer`
--

CREATE TABLE `Hammer` (
  `tool_id` int(16) UNSIGNED NOT NULL,
  `anti_vibration` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Hammer`
--

INSERT INTO `Hammer` (`tool_id`, `anti_vibration`) VALUES
(8, 'false');

-- --------------------------------------------------------

--
-- Table structure for table `HandTools`
--

CREATE TABLE `HandTools` (
  `tool_id` int(16) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `HandTools`
--

INSERT INTO `HandTools` (`tool_id`) VALUES
(1),
(2),
(3),
(4),
(5),
(6),
(7),
(8);

-- --------------------------------------------------------

--
-- Table structure for table `Ladders`
--

CREATE TABLE `Ladders` (
  `tool_id` int(16) UNSIGNED NOT NULL,
  `step_count` int(16) DEFAULT NULL,
  `weight_capacity` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Mixer`
--

CREATE TABLE `Mixer` (
  `tool_id` int(16) UNSIGNED NOT NULL,
  `motor_rating` varchar(80) NOT NULL,
  `drum_size` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Mixer`
--

INSERT INTO `Mixer` (`tool_id`, `motor_rating`, `drum_size`) VALUES
(23, '1/2', '3.5'),
(24, '1/2', '3.5');

-- --------------------------------------------------------

--
-- Table structure for table `Order`
--

CREATE TABLE `Order` (
  `tool_id` int(16) UNSIGNED NOT NULL,
  `reservation_id` int(16) UNSIGNED NOT NULL,
  `customer_username` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Phone`
--

CREATE TABLE `Phone` (
  `phone_type` varchar(80) DEFAULT NULL,
  `phone_number` varchar(80) NOT NULL,
  `area_code` varchar(80) DEFAULT NULL,
  `extension` varchar(80) DEFAULT NULL,
  `username` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Phone`
--

INSERT INTO `Phone` (`phone_type`, `phone_number`, `area_code`, `extension`, `username`) VALUES
('home_phone', '101-141-9092', '101', '488', 'Kasimir'),
('home_phone', '123-456-7890', '123', '234', 'Flora'),
('work_phone', '215-779-7485', '215', '952', 'Kaseem'),
('work_phone', '234-123-4567', '234', '234', 'Flora'),
('home_phone', '314-454-2777', '314', '787', 'Logan'),
('cell_phone', '345-134-5678', '345', '255', 'Flora'),
('home_phone', '444-154-4146', '444', '961', 'Nathaniel'),
('cell_phone', '444-772-9871', '444', '391', 'Audrey'),
('home_phone', '449-594-2020', '449', '755', 'Owen'),
('work_phone', '667-880-9043', '667', '908', 'Quynn'),
('cell_phone', '758-942-6459', '758', '265', 'Chava'),
('home_phone', '775-411-5413', '775', '271', 'Selma'),
('home_phone', '780-602-9596', '780', '931', 'Jane');

-- --------------------------------------------------------

--
-- Table structure for table `PickUp`
--

CREATE TABLE `PickUp` (
  `clerk_username` varchar(80) NOT NULL,
  `reservation_id` int(16) UNSIGNED NOT NULL,
  `tool_id` int(16) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `PickUp`
--

INSERT INTO `PickUp` (`clerk_username`, `reservation_id`, `tool_id`) VALUES
('Micah', 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `Pliers`
--

CREATE TABLE `Pliers` (
  `tool_id` int(16) UNSIGNED NOT NULL,
  `adjustable` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Pliers`
--

INSERT INTO `Pliers` (`tool_id`, `adjustable`) VALUES
(6, 'true');

-- --------------------------------------------------------

--
-- Table structure for table `PowerTools`
--

CREATE TABLE `PowerTools` (
  `tool_id` int(16) UNSIGNED NOT NULL,
  `volt_rating` varchar(80) NOT NULL,
  `amp_rating` varchar(80) NOT NULL,
  `min_rpm_rating` varchar(80) NOT NULL,
  `max_rpm_rating` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `PowerTools`
--

INSERT INTO `PowerTools` (`tool_id`, `volt_rating`, `amp_rating`, `min_rpm_rating`, `max_rpm_rating`) VALUES
(17, '110', '22', '23', '44'),
(18, '', '33', '33', '22'),
(19, '120', '22', '22', '22'),
(20, '', '33', '33', '33'),
(21, '', '22', '22', '22'),
(22, '120', '33', '33', '33'),
(23, '110', '2', '22', '22'),
(24, '', '2', '2', '2'),
(25, '', '2', '22', '22'),
(26, '220', '2', '22', '22'),
(27, '', '2', '22', '34');

-- --------------------------------------------------------

--
-- Table structure for table `Power_Accessories`
--

CREATE TABLE `Power_Accessories` (
  `tool_id` int(16) UNSIGNED NOT NULL,
  `battery_type` varchar(80) NOT NULL,
  `quantity` int(16) NOT NULL,
  `accerssory_description` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Power_Accessories`
--

INSERT INTO `Power_Accessories` (`tool_id`, `battery_type`, `quantity`, `accerssory_description`) VALUES
(17, '', 2, 'safety '),
(18, '2 NiCd 7.2 V', 1, 'Safety, battery'),
(19, '', 2, 'electirc power pource'),
(20, '1 Li-Ion 7.2 V', 2, 'cordless'),
(21, '', 2, 'gas'),
(22, '', 3, 'ELECTRIC'),
(23, '', 2, 'mixer electric'),
(24, '', 2, 'mixer gas'),
(25, '', 3, 'generator'),
(26, '', 2, 'sander a/c'),
(27, '4 NiMH 7.2 V', 2, 'Drill');

-- --------------------------------------------------------

--
-- Table structure for table `Pruner`
--

CREATE TABLE `Pruner` (
  `tool_id` int(16) UNSIGNED NOT NULL,
  `blade_material` varchar(80) DEFAULT NULL,
  `blade_length` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Pruner`
--

INSERT INTO `Pruner` (`tool_id`, `blade_material`, `blade_length`) VALUES
(10, 'titanium', '5-1/8');

-- --------------------------------------------------------

--
-- Table structure for table `Rakes`
--

CREATE TABLE `Rakes` (
  `tool_id` int(16) UNSIGNED NOT NULL,
  `tine_count` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Rakes`
--

INSERT INTO `Rakes` (`tool_id`, `tine_count`) VALUES
(11, 14);

-- --------------------------------------------------------

--
-- Table structure for table `Ratchet`
--

CREATE TABLE `Ratchet` (
  `tool_id` int(16) UNSIGNED NOT NULL,
  `drive_size` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Ratchet`
--

INSERT INTO `Ratchet` (`tool_id`, `drive_size`) VALUES
(3, '3/8');

-- --------------------------------------------------------

--
-- Table structure for table `Rented`
--

CREATE TABLE `Rented` (
  `rented_reservation_id` int(16) UNSIGNED NOT NULL,
  `customer_username` varchar(80) NOT NULL,
  `tool_id` int(16) UNSIGNED NOT NULL,
  `rented_start_date` date NOT NULL,
  `rented_end_date` date NOT NULL,
  `times_rented` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Reservation`
--

CREATE TABLE `Reservation` (
  `reservation_id` int(16) UNSIGNED NOT NULL,
  `customer_username` varchar(80) NOT NULL,
  `tool_id` int(16) UNSIGNED NOT NULL,
  `reservation_start_date` date DEFAULT NULL,
  `reservation_end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Reservation`
--

INSERT INTO `Reservation` (`reservation_id`, `customer_username`, `tool_id`, `reservation_start_date`, `reservation_end_date`) VALUES
(1, 'Flora', 1, '2017-11-01', '2017-11-10'),
(1, 'Flora', 2, '2017-11-01', '2017-11-10'),
(1, 'Flora', 3, '2017-11-01', '2017-11-10'),
(1, 'Flora', 25, '2017-11-01', '2017-11-10');

-- --------------------------------------------------------

--
-- Table structure for table `SaleOrder`
--

CREATE TABLE `SaleOrder` (
  `sale_id` int(16) UNSIGNED NOT NULL,
  `clerk_username` varchar(80) DEFAULT NULL,
  `customer_username` varchar(80) NOT NULL,
  `tool_id` int(16) UNSIGNED NOT NULL,
  `for_sale_date` date NOT NULL,
  `sold_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Sander`
--

CREATE TABLE `Sander` (
  `tool_id` int(16) UNSIGNED NOT NULL,
  `dust_bag` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Sander`
--

INSERT INTO `Sander` (`tool_id`, `dust_bag`) VALUES
(20, 'false'),
(26, 'false');

-- --------------------------------------------------------

--
-- Table structure for table `Saw`
--

CREATE TABLE `Saw` (
  `tool_id` int(16) UNSIGNED NOT NULL,
  `blade_size` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Saw`
--

INSERT INTO `Saw` (`tool_id`, `blade_size`) VALUES
(19, '7-3/4');

-- --------------------------------------------------------

--
-- Table structure for table `ScrewDriver`
--

CREATE TABLE `ScrewDriver` (
  `tool_id` int(16) UNSIGNED NOT NULL,
  `screw_size` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ScrewDriver`
--

INSERT INTO `ScrewDriver` (`tool_id`, `screw_size`) VALUES
(1, '#2');

-- --------------------------------------------------------

--
-- Table structure for table `ServiceOrder`
--

CREATE TABLE `ServiceOrder` (
  `service_id` int(16) UNSIGNED NOT NULL,
  `clerk_username` varchar(80) DEFAULT NULL,
  `tool_id` int(16) UNSIGNED NOT NULL,
  `service_start_date` date NOT NULL,
  `service_end_date` date NOT NULL,
  `repair_cost` double UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Socket`
--

CREATE TABLE `Socket` (
  `tool_id` int(16) UNSIGNED NOT NULL,
  `drive_size` varchar(80) NOT NULL,
  `sae_size` varchar(80) NOT NULL,
  `deep_socket` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Socket`
--

INSERT INTO `Socket` (`tool_id`, `drive_size`, `sae_size`, `deep_socket`) VALUES
(2, '1/2', '1/4', 'false');

-- --------------------------------------------------------

--
-- Table structure for table `Step`
--

CREATE TABLE `Step` (
  `tool_id` int(16) UNSIGNED NOT NULL,
  `pail_shelf` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Step`
--

INSERT INTO `Step` (`tool_id`, `pail_shelf`) VALUES
(16, 'false');

-- --------------------------------------------------------

--
-- Table structure for table `Straight`
--

CREATE TABLE `Straight` (
  `tool_id` int(16) UNSIGNED NOT NULL,
  `rubber_feet` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Straight`
--

INSERT INTO `Straight` (`tool_id`, `rubber_feet`) VALUES
(15, 'true');

-- --------------------------------------------------------

--
-- Table structure for table `Striking`
--

CREATE TABLE `Striking` (
  `tool_id` int(16) UNSIGNED NOT NULL,
  `head_weight` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Striking`
--

INSERT INTO `Striking` (`tool_id`, `head_weight`) VALUES
(14, '3.5');

-- --------------------------------------------------------

--
-- Table structure for table `Toolinfo`
--

CREATE TABLE `Toolinfo` (
  `tool_id` int(16) UNSIGNED NOT NULL,
  `tool_type` varchar(80) NOT NULL,
  `tool_subtype` varchar(80) NOT NULL,
  `tool_suboption` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Toolinfo`
--

INSERT INTO `Toolinfo` (`tool_id`, `tool_type`, `tool_subtype`, `tool_suboption`) VALUES
(1, 'Hand Tool', 'Screwdriver', 'phillips'),
(2, 'Hand Tool', 'Socket', 'deep'),
(3, 'Hand Tool', 'Ratchet', 'adjustable'),
(4, 'Hand Tool', 'Wrench', 'crescent'),
(5, 'Hand Tool', 'Wrench', 'crescent'),
(6, 'Hand Tool', 'Pliers', 'crimper'),
(7, 'Hand Tool', 'Gun', 'nail'),
(8, 'Hand Tool', 'Hammer', 'framing'),
(9, 'Garden Tool', 'Digger', 'flat shovel'),
(10, 'Garden Tool', 'Pruner', 'sheer'),
(11, 'Garden Tool', 'Rakes', 'leaf'),
(12, 'Garden Tool', 'Wheelbarrows', '1-wheel'),
(13, 'Garden Tool', 'Wheelbarrows', '2-wheel'),
(14, 'Garden Tool', 'Striking', 'bar pry'),
(15, 'Ladder', 'Straight', 'telescoping'),
(16, 'Ladder', 'Step', 'multi-position'),
(17, 'Power Tool', 'Drill', 'driver'),
(18, 'Power Tool', 'Drill', 'hammer'),
(19, 'Power Tool', 'Saw', 'circular'),
(20, 'Power Tool', 'Sander', 'finish'),
(21, 'Power Tool', 'Air-Compressor', 'reciprocating'),
(22, 'Power Tool', 'Air-Compressor', 'reciprocating'),
(23, 'Power Tool', 'Mixer', 'concrete'),
(24, 'Power Tool', 'Mixer', 'concrete'),
(25, 'Power Tool', 'Generator', 'electric'),
(26, 'Power Tool', 'Sander', 'random orbital'),
(27, 'Power Tool', 'Drill', 'hammer');

-- --------------------------------------------------------

--
-- Table structure for table `Tools`
--

CREATE TABLE `Tools` (
  `tool_id` int(16) UNSIGNED NOT NULL,
  `manufacturer` varchar(80) NOT NULL,
  `material` varchar(80) DEFAULT NULL,
  `weight` varchar(80) NOT NULL,
  `width_or_diameter` varchar(80) NOT NULL,
  `length` varchar(80) NOT NULL,
  `purchase_price` double NOT NULL,
  `power_source` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Tools`
--

INSERT INTO `Tools` (`tool_id`, `manufacturer`, `material`, `weight`, `width_or_diameter`, `length`, `purchase_price`, `power_source`) VALUES
(1, 'China', 'mental', '1', '3-1/4 inches', '3-3/8 inches', 2, 'manual'),
(2, 'China', 'plastic', '2', '1-1/4 inches', '2-1/4 inches', 3, 'manual'),
(3, 'USA', 'metal', '2', '2-3/8 inches', '2-3/8 inches', 2, 'manual'),
(4, 'China', 'metal', '2', '3-3/8 inches', '2-3/8 inches', 2, 'manual'),
(5, 'Japan', 'metal', '3', '6-1/2 inches', '6-1/8 inches', 3.9, 'manual'),
(6, 'China', 'metal', '2', '4-3/8 inches', '5-3/8 inches', 5, 'manual'),
(7, 'China', 'plastic', '2', '2-1/4 inches', '3-1/4 inches', 6.9, 'manual'),
(8, 'Taiwan', 'wooden', '2', '4-3/8 inches', '2-3/8 inches', 3.9, 'manual'),
(9, 'China', 'metal', '2', '2-1/4 inches', '3-1/8 inches', 3, 'manual'),
(10, 'USA', 'wooden', '1', '2-1/4 inches', '3-1/8 inches', 2.2, 'manual'),
(11, 'China', 'plastic', '2', '3-1/4 inches', '2-1/8 inches', 2, 'manual'),
(12, 'China', 'wooden', '2', '2-1/4 inches', '3-3/8 inches', 2, 'manual'),
(13, 'USA', 'metal', '1', '2-3/4 inches', '3-1/8 inches', 2, 'manual'),
(14, 'France', 'metal', '2', '2-1/4 inches', '3-1/4 inches', 44, 'manual'),
(15, 'China', 'metal', '23', '45-1/4 inches', '22-1/8 inches', 34, 'manual'),
(16, 'China', 'wooden', '23', '23-3/8 inches', '33-1/4 inches', 233, 'manual'),
(17, 'USA', 'metal', '2', '2-1/4 inches', '3-1/4 inches', 34, 'electric(A/C)'),
(18, 'China', 'plastic', '23', '2-3/8 inches', '3-1/4 inches', 34, 'cordless(D/C)'),
(19, 'China', 'metal', '2', '2-1/8 inches', '3-1/4 inches', 2, 'electric(A/C)'),
(20, 'USA', 'metal', '2', '2-1/4 inches', '3-3/8 inches', 2, 'cordless(D/C)'),
(21, 'USA', 'plastic', '2', '2-1/8 inches', '3-1/4 inches', 2, 'gas'),
(22, 'USA', 'metal', '23', '2-3/8 inches', '3-1/4 inches', 45, 'electric(A/C)'),
(23, 'China', 'metal', '2', '2-3/8 inches', '4-1/4 inches', 23, 'electric(A/C)'),
(24, 'China', 'plastic', '2', '2-1/2 inches', '4-1/4 inches', 2, 'gas'),
(25, 'China', 'metal', '4', '2-3/8 inches', '4-3/8 inches', 22, 'gas'),
(26, 'France', 'metal', '2', '2-1/4 inches', '3-1/4 inches', 3, 'electric(A/C)'),
(27, 'China', 'metal', '2', '2-1/4 inches', '3-3/8 inches', 2, 'cordless(D/C)');

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `username` varchar(80) NOT NULL,
  `email` varchar(80) NOT NULL,
  `first_name` varchar(80) NOT NULL,
  `middle_name` varchar(80) DEFAULT NULL,
  `last_name` varchar(80) NOT NULL,
  `password` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`username`, `email`, `first_name`, `middle_name`, `last_name`, `password`) VALUES
('Adrienne', 'libero.nec@mauris.ca', 'Alisa', 'Yoshio', 'Bowen', '3666'),
('Amery', 'natoque.penatibus@lobortis.ca', 'Farrah', 'Malcolm', 'Greene', '2763'),
('Anjolie', 'erat@sagittissemperNam.org', 'Daquan', 'Lillian', 'Ramos', '6063'),
('Arsenio', 'et@necmauris.com', 'Hanae', 'Angelica', 'Maxwell', '1683'),
('Audrey', 'mi.Duis.risus@antelectus.com', 'Lani', 'Holmes', 'Hayden', '8791'),
('Basia', 'ut@erosnon.ca', 'Ferdinand', 'MacKenzie', 'Rojas', '1164'),
('Basil', 'Fusce@nonmagnaNam.com', 'Victoria', 'Martena', 'Lloyd', '8103'),
('Benjamin', 'enim@Suspendisse.ca', 'Samantha', 'Alma', 'Olson', '6697'),
('Brianna', 'sem@anequeNullam.co.uk', 'Melvin', 'Ella', 'Young', '9358'),
('Brock', 'diam.luctus@miDuisrisus.edu', 'Desirae', 'Francis', 'Delacruz', '9396'),
('Bruno', 'ut.cursus.luctus@feugiatmetussit.edu', 'Alika', 'Delilah', 'Powell', '2327'),
('Carolyn', 'Suspendisse.non.leo@felisadipiscing.net', 'Lynn', 'Nora', 'Cervantes', '3666'),
('Chava', 'adipiscing@Quisque.edu', 'Candice', 'Celeste', 'Bender', '1469'),
('Chester', 'euismod@at.edu', 'Hanae', 'Maia', 'Bartlett', '6647'),
('Christopher', 'nibh.sit.amet@mus.com', 'Aiko', 'Claire', 'Aguilar', '9901'),
('Clio', 'justo@dolor.net', 'Suki', 'Kylynn', 'Russell', '3288'),
('Colette', 'enim@nuncrisusvarius.net', 'Tana', 'Joel', 'Frazier', '7751'),
('Dakota', 'massa.lobortis.ultrices@MaurisnullaInteger.edu', 'Yuri', 'Maile', 'Guerra', '1306'),
('Dalton', 'sem@tristiquesenectuset.edu', 'Stuart', 'Brielle', 'Prince', '5056'),
('Deacon', 'eget.dictum.placerat@Morbi.com', 'Bree', 'Aquila', 'Case', '5787'),
('Declan', 'bibendum.fermentum@eleifend.edu', 'Upton', 'Malik', 'Conley', '3514'),
('Demetria', 'pretium@elitpellentesquea.com', 'Marvin', 'Carson', 'Lynch', '7554'),
('Dexter', 'imperdiet.ullamcorper.Duis@vitaeeratvel.ca', 'Mercedes', 'Melodie', 'Velez', '9515'),
('Dillon', 'nisl.sem.consequat@duisemperet.com', 'Veronica', 'Catherine', 'Carver', '5934'),
('Dolan', 'tempor.arcu.Vestibulum@Curae.org', 'Carly', 'Leroy', 'Hurley', '8482'),
('Emerald', 'rutrum.non@doloregestasrhoncus.ca', 'Rudyard', 'Davis', 'Gutierrez', '8618'),
('Fiona', 'diam@eu.edu', 'Megan', 'Leonard', 'Fields', '6846'),
('Fleur', 'odio@Duis.net', 'Ali', 'Anjolie', 'Guthrie', '3915'),
('Flora', 'xcao67@gatech.edu', 'Xiaohua', '', 'Cao', '123'),
('Gannon', 'quam.a.felis@velvulputateeu.ca', 'Asher', 'Hu', 'Cunningham', '9189'),
('Hector', 'tincidunt.neque.vitae@diam.co.uk', 'Sylvester', 'Leah', 'Rose', '5280'),
('Henry', 'Praesent.eu.dui@ac.org', 'Yuli', 'Kadeem', 'Hall', '5314'),
('Hilel', 'Cum@idsapien.co.uk', 'Catherine', 'Aristotle', 'Barnes', '4712'),
('Hope', 'eros@nisisemsemper.org', 'Beverly', 'Cole', 'Fischer', '9017'),
('Idola', 'consectetuer@Utnecurna.com', 'Giacomo', 'Nicole', 'Allen', '9753'),
('Inez', 'Sed.auctor@congue.edu', 'Hu', 'Sonia', 'Hammond', '5815'),
('Ivory', 'Nunc.ullamcorper.velit@risusQuisquelibero.edu', 'Brenda', 'Vivian', 'Olson', '4703'),
('Jamal', 'mauris.ut.mi@atrisus.co.uk', 'Quinn', 'Charlotte', 'Merritt', '9271'),
('Jane', 'Donec@perconubianostra.ca', 'Grace', 'Paula', 'Barnes', '4634'),
('Jerry', 'Ut.nec.urna@maurissagittisplacerat.net', 'Sara', 'Aquila', 'Buchanan', '4438'),
('Jonas', 'gravida@Donectempuslorem.edu', 'Emery', 'Jessica', 'Arnold', '5396'),
('Judah', 'sit.amet@In.edu', 'Geraldine', 'Oliver', 'Dennis', '6698'),
('Kaseem', 'orci@orcitincidunt.ca', 'August', 'Autumn', 'Bird', '1621'),
('Kasimir', 'a.aliquet.vel@pharetrafeliseget.org', 'Serena', 'Farrah', 'Combs', '2561'),
('Kathleen', 'fermentum.fermentum@Craseget.co.uk', 'Neve', 'Jaime', 'Jones', '5337'),
('Keaton', 'gravida.sit.amet@imperdiet.com', 'Camden', 'Maisie', 'Stanton', '7818'),
('Kelsie', 'Duis.a.mi@magnaPraesentinterdum.co.uk', 'Iliana', 'James', 'Barrera', '2648'),
('Kenyon', 'auctor@Sed.co.uk', 'Meredith', 'Rhoda', 'Blair', '7089'),
('Lacey', 'venenatis.lacus@Vivamusnisi.org', 'Maryam', 'Caldwell', 'Stephens', '2708'),
('Lacota', 'In.mi@magnaPraesentinterdum.ca', 'Kane', 'Quentin', 'Black', '2975'),
('Latifah', 'Cras@utmiDuis.org', 'Drake', 'Sheila', 'English', '5846'),
('Leila', 'nec.tempus.mauris@arcuVestibulum.org', 'Phillip', 'Vladimir', 'Pruitt', '2690'),
('Lenore', 'Donec.vitae@Integer.org', 'Alec', 'Judah', 'Reese', '6655'),
('Lila', 'condimentum.eget@cursuseteros.ca', 'Kibo', 'Lareina', 'Schroeder', '4975'),
('Lionel', 'Nunc.sollicitudin.commodo@blanditcongue.net', 'Zephr', 'Christopher', 'Colon', '3253'),
('Logan', 'mauris.ut.mi@felisorciadipiscing.ca', 'Ralph', 'Amelia', 'Benton', '6319'),
('Madaline', 'eu@lobortis.net', 'Hakeem', 'Erica', 'Decker', '1566'),
('Margaret', 'penatibus.et@risusMorbimetus.net', 'Amir', 'Ivory', 'Witt', '7033'),
('Mark', 'arcu.Vestibulum@lobortistellusjusto.org', 'Gil', 'Urielle', 'Chen', '4614'),
('Marvin', 'ligula@sit.org', 'Xandra', 'Knox', 'Beasley', '1870'),
('Mercedes', 'dui@suscipit.org', 'William', 'Victor', 'Carney', '3519'),
('Micah', 'dictum@metuseuerat.edu', 'Anthony', 'Jelani', 'Schmidt', '9582'),
('Nathaniel', 'vitae@justonec.ca', 'Fiona', 'Ulla', 'Ward', '3622'),
('Octavius', 'lorem.vitae.odio@imperdietdictum.net', 'Oscar', 'Gemma', 'Rios', '6581'),
('Otto', 'odio@necurnaet.ca', 'Veronica', 'Ivan', 'Stewart', '2471'),
('Owen', 'tellus.imperdiet.non@Nunc.edu', 'Ignatius', 'Kamal', 'Powers', '5541'),
('Philip', 'senectus@diamSed.org', 'Ryder', 'Abel', 'Schwartz', '5222'),
('Porter', 'cursus@Crasdictum.ca', 'Basil', 'Shaeleigh', 'Pacheco', '4091'),
('Portia', 'libero@aliquet.co.uk', 'Charity', 'Zahir', 'Vargas', '9761'),
('Prescott', 'tristique.senectus@enimEtiam.net', 'Flynn', 'Channing', 'Briggs', '3695'),
('Quynn', 'auctor@ipsum.com', 'Genevieve', 'Chiquita', 'Gregory', '4729'),
('Rahim', 'et.netus.et@nonvestibulum.org', 'Gisela', 'Magee', 'Solomon', '9331'),
('Raya', 'blandit@lacusAliquamrutrum.com', 'Lars', 'Iola', 'Heath', '3633'),
('Richard', 'lectus@consequatdolorvitae.edu', 'Lane', 'Xyla', 'Lancaster', '1883'),
('Samantha', 'malesuada.ut@quisdiamPellentesque.net', 'Caldwell', 'Colorado', 'Leach', '8352'),
('Scarlet', 'erat@tempusscelerisquelorem.co.uk', 'Zachery', 'Virginia', 'Benton', '9680'),
('Selma', 'aliquet.molestie.tellus@Nulla.com', 'Bree', 'Tate', 'Rivas', '4957'),
('Shad', 'In@molestieSed.co.uk', 'Jarrod', 'Gray', 'Richards', '7900'),
('Shaeleigh', 'libero.mauris.aliquam@nislsemconsequat.com', 'Scott', 'Kamal', 'Burris', '4533'),
('Shaine', 'arcu.Curabitur@Mauris.co.uk', 'Nolan', 'Miranda', 'Mejia', '8035'),
('Stacy', 'quis.urna@musProin.com', 'Dacey', 'Quinn', 'Carter', '5153'),
('Tara', 'primis@nec.net', 'Kadeem', 'Davis', 'Vinson', '8539'),
('Tatyana', 'vitae@Fuscemi.org', 'Kathleen', 'Daniel', 'Dickson', '8266'),
('Tiger', 'Cras.vehicula.aliquet@dictum.org', 'Laith', 'Macon', 'Roman', '5528'),
('Tyrone', 'ac@in.co.uk', 'Ruth', 'Keith', 'Osborne', '9058'),
('Vivien', 'at@est.net', 'Kalia', 'Michael', 'Sawyer', '9323'),
('Wayne', 'Integer.vulputate@Nam.ca', 'Dorian', 'Craig', 'Golden', '4690'),
('Yoshi', 'felis@In.com', 'Kiayada', 'Dean', 'Burks', '5118'),
('Zachery', 'tristique.aliquet.Phasellus@gravida.ca', 'Lucius', 'Charde', 'Serrano', '4095'),
('Zahir', 'id.risus@rhoncus.org', 'Wyatt', 'Astra', 'Flowers', '3777'),
('Zeph', 'turpis.vitae.purus@blanditcongueIn.net', 'Henry', 'Britanni', 'Albert', '4841');

-- --------------------------------------------------------

--
-- Table structure for table `Wheelbarrows`
--

CREATE TABLE `Wheelbarrows` (
  `tool_id` int(16) UNSIGNED NOT NULL,
  `bin_material` varchar(80) NOT NULL,
  `bin_volume` varchar(80) DEFAULT NULL,
  `wheel_count` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Wheelbarrows`
--

INSERT INTO `Wheelbarrows` (`tool_id`, `bin_material`, `bin_volume`, `wheel_count`) VALUES
(12, 'steel', '5.9', 2),
(13, 'fiberglass', '5.9', 1);

-- --------------------------------------------------------

--
-- Table structure for table `With`
--

CREATE TABLE `With` (
  `rented_reservation_id` int(16) UNSIGNED NOT NULL,
  `customer_username` varchar(80) NOT NULL,
  `tool_id` int(16) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Wrench`
--

CREATE TABLE `Wrench` (
  `tool_id` int(16) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Wrench`
--

INSERT INTO `Wrench` (`tool_id`) VALUES
(4),
(5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Add`
--
ALTER TABLE `Add`
  ADD PRIMARY KEY (`clerk_username`,`tool_id`),
  ADD KEY `FK_Add_tool_id_Tools_tool_id` (`tool_id`);

--
-- Indexes for table `Air_Compressor`
--
ALTER TABLE `Air_Compressor`
  ADD PRIMARY KEY (`tool_id`);

--
-- Indexes for table `Clerk`
--
ALTER TABLE `Clerk`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `Customer`
--
ALTER TABLE `Customer`
  ADD PRIMARY KEY (`username`),
  ADD KEY `FK_Customer_phone_number_Phone_phone_number` (`phone_number`);

--
-- Indexes for table `Digger`
--
ALTER TABLE `Digger`
  ADD PRIMARY KEY (`tool_id`);

--
-- Indexes for table `Drill`
--
ALTER TABLE `Drill`
  ADD PRIMARY KEY (`tool_id`);

--
-- Indexes for table `DropOff`
--
ALTER TABLE `DropOff`
  ADD UNIQUE KEY `clerk_username` (`clerk_username`,`reservation_id`),
  ADD KEY `FK_DropOff_reservation_id_Reservation_reservation_id` (`reservation_id`),
  ADD KEY `FK_DropOff_tool_id_Tools_tool_id` (`tool_id`);

--
-- Indexes for table `GardenTools`
--
ALTER TABLE `GardenTools`
  ADD PRIMARY KEY (`tool_id`);

--
-- Indexes for table `Generator`
--
ALTER TABLE `Generator`
  ADD PRIMARY KEY (`tool_id`);

--
-- Indexes for table `Gun`
--
ALTER TABLE `Gun`
  ADD PRIMARY KEY (`tool_id`);

--
-- Indexes for table `Hammer`
--
ALTER TABLE `Hammer`
  ADD PRIMARY KEY (`tool_id`);

--
-- Indexes for table `HandTools`
--
ALTER TABLE `HandTools`
  ADD PRIMARY KEY (`tool_id`);

--
-- Indexes for table `Ladders`
--
ALTER TABLE `Ladders`
  ADD PRIMARY KEY (`tool_id`);

--
-- Indexes for table `Mixer`
--
ALTER TABLE `Mixer`
  ADD PRIMARY KEY (`tool_id`);

--
-- Indexes for table `Order`
--
ALTER TABLE `Order`
  ADD PRIMARY KEY (`reservation_id`,`tool_id`,`customer_username`),
  ADD KEY `FK_Order_tool_id_Tools_tool_id` (`tool_id`),
  ADD KEY `FK_Order_customer_username_Customer_username` (`customer_username`);

--
-- Indexes for table `Phone`
--
ALTER TABLE `Phone`
  ADD PRIMARY KEY (`phone_number`),
  ADD KEY `FK_Phone_username_User_username` (`username`);

--
-- Indexes for table `PickUp`
--
ALTER TABLE `PickUp`
  ADD UNIQUE KEY `tool_id` (`tool_id`,`reservation_id`),
  ADD KEY `FK_PickUp_clerk_username_Clerk_username` (`clerk_username`),
  ADD KEY `FK_PickUp_reservation_id_Reservation_reservation_id` (`reservation_id`);

--
-- Indexes for table `Pliers`
--
ALTER TABLE `Pliers`
  ADD PRIMARY KEY (`tool_id`);

--
-- Indexes for table `PowerTools`
--
ALTER TABLE `PowerTools`
  ADD PRIMARY KEY (`tool_id`);

--
-- Indexes for table `Power_Accessories`
--
ALTER TABLE `Power_Accessories`
  ADD PRIMARY KEY (`tool_id`,`battery_type`,`quantity`,`accerssory_description`);

--
-- Indexes for table `Pruner`
--
ALTER TABLE `Pruner`
  ADD PRIMARY KEY (`tool_id`);

--
-- Indexes for table `Rakes`
--
ALTER TABLE `Rakes`
  ADD PRIMARY KEY (`tool_id`);

--
-- Indexes for table `Ratchet`
--
ALTER TABLE `Ratchet`
  ADD PRIMARY KEY (`tool_id`);

--
-- Indexes for table `Rented`
--
ALTER TABLE `Rented`
  ADD PRIMARY KEY (`tool_id`,`rented_reservation_id`);

--
-- Indexes for table `Reservation`
--
ALTER TABLE `Reservation`
  ADD PRIMARY KEY (`reservation_id`,`tool_id`),
  ADD KEY `FK_Reservation_customer_username_Customer_username` (`customer_username`),
  ADD KEY `FK_Reservation_tool_id_Tools_tool_id` (`tool_id`);

--
-- Indexes for table `SaleOrder`
--
ALTER TABLE `SaleOrder`
  ADD PRIMARY KEY (`tool_id`,`sale_id`),
  ADD KEY `FK_SaleOrder_clerk_username_Clerk_username` (`clerk_username`);

--
-- Indexes for table `Sander`
--
ALTER TABLE `Sander`
  ADD PRIMARY KEY (`tool_id`);

--
-- Indexes for table `Saw`
--
ALTER TABLE `Saw`
  ADD PRIMARY KEY (`tool_id`);

--
-- Indexes for table `ScrewDriver`
--
ALTER TABLE `ScrewDriver`
  ADD PRIMARY KEY (`tool_id`);

--
-- Indexes for table `ServiceOrder`
--
ALTER TABLE `ServiceOrder`
  ADD PRIMARY KEY (`tool_id`,`service_id`),
  ADD KEY `FK_ServiceOrder_clerk_username_Clerk_username` (`clerk_username`);

--
-- Indexes for table `Socket`
--
ALTER TABLE `Socket`
  ADD PRIMARY KEY (`tool_id`);

--
-- Indexes for table `Step`
--
ALTER TABLE `Step`
  ADD PRIMARY KEY (`tool_id`);

--
-- Indexes for table `Straight`
--
ALTER TABLE `Straight`
  ADD PRIMARY KEY (`tool_id`);

--
-- Indexes for table `Striking`
--
ALTER TABLE `Striking`
  ADD PRIMARY KEY (`tool_id`);

--
-- Indexes for table `Toolinfo`
--
ALTER TABLE `Toolinfo`
  ADD PRIMARY KEY (`tool_id`,`tool_type`);

--
-- Indexes for table `Tools`
--
ALTER TABLE `Tools`
  ADD PRIMARY KEY (`tool_id`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `Wheelbarrows`
--
ALTER TABLE `Wheelbarrows`
  ADD PRIMARY KEY (`tool_id`);

--
-- Indexes for table `With`
--
ALTER TABLE `With`
  ADD PRIMARY KEY (`rented_reservation_id`,`tool_id`,`customer_username`),
  ADD KEY `FK_With_customer_username_Customer_username` (`customer_username`),
  ADD KEY `FK_With_tool_id_Tools_tool_id` (`tool_id`);

--
-- Indexes for table `Wrench`
--
ALTER TABLE `Wrench`
  ADD PRIMARY KEY (`tool_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Reservation`
--
ALTER TABLE `Reservation`
  MODIFY `reservation_id` int(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Tools`
--
ALTER TABLE `Tools`
  MODIFY `tool_id` int(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `With`
--
ALTER TABLE `With`
  MODIFY `rented_reservation_id` int(16) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Add`
--
ALTER TABLE `Add`
  ADD CONSTRAINT `FK_Add_clerk_username_Clerk_username` FOREIGN KEY (`clerk_username`) REFERENCES `Clerk` (`username`),
  ADD CONSTRAINT `FK_Add_tool_id_Tools_tool_id` FOREIGN KEY (`tool_id`) REFERENCES `Tools` (`tool_id`);

--
-- Constraints for table `Air_Compressor`
--
ALTER TABLE `Air_Compressor`
  ADD CONSTRAINT `FK_Air_Compressor_tool_id_Tools_tool_id` FOREIGN KEY (`tool_id`) REFERENCES `Tools` (`tool_id`);

--
-- Constraints for table `Clerk`
--
ALTER TABLE `Clerk`
  ADD CONSTRAINT `FK_Clerk_username_User_username` FOREIGN KEY (`username`) REFERENCES `User` (`username`);

--
-- Constraints for table `Customer`
--
ALTER TABLE `Customer`
  ADD CONSTRAINT `FK_Customer_phone_number_Phone_phone_number` FOREIGN KEY (`phone_number`) REFERENCES `Phone` (`phone_number`),
  ADD CONSTRAINT `FK_Customer_username_User_username` FOREIGN KEY (`username`) REFERENCES `User` (`username`);

--
-- Constraints for table `Digger`
--
ALTER TABLE `Digger`
  ADD CONSTRAINT `FK_Digger_tool_id_Tools_tool_id` FOREIGN KEY (`tool_id`) REFERENCES `Tools` (`tool_id`);

--
-- Constraints for table `Drill`
--
ALTER TABLE `Drill`
  ADD CONSTRAINT `FK_Drill_tool_id_Tools_tool_id` FOREIGN KEY (`tool_id`) REFERENCES `Tools` (`tool_id`);

--
-- Constraints for table `DropOff`
--
ALTER TABLE `DropOff`
  ADD CONSTRAINT `FK_DropOff_clerk_username_Clerk_username` FOREIGN KEY (`clerk_username`) REFERENCES `Clerk` (`username`),
  ADD CONSTRAINT `FK_DropOff_reservation_id_Reservation_reservation_id` FOREIGN KEY (`reservation_id`) REFERENCES `Reservation` (`reservation_id`),
  ADD CONSTRAINT `FK_DropOff_tool_id_Tools_tool_id` FOREIGN KEY (`tool_id`) REFERENCES `Tools` (`tool_id`);

--
-- Constraints for table `GardenTools`
--
ALTER TABLE `GardenTools`
  ADD CONSTRAINT `FK_GardenTools_tool_id_Tools_tool_id` FOREIGN KEY (`tool_id`) REFERENCES `Tools` (`tool_id`);

--
-- Constraints for table `Generator`
--
ALTER TABLE `Generator`
  ADD CONSTRAINT `FK_Generator_tool_id_Tools_tool_id` FOREIGN KEY (`tool_id`) REFERENCES `Tools` (`tool_id`);

--
-- Constraints for table `Gun`
--
ALTER TABLE `Gun`
  ADD CONSTRAINT `FK_Gun_tool_id_Tools_tool_id` FOREIGN KEY (`tool_id`) REFERENCES `Tools` (`tool_id`);

--
-- Constraints for table `Hammer`
--
ALTER TABLE `Hammer`
  ADD CONSTRAINT `FK_Hammer_tool_id_Tools_tool_id` FOREIGN KEY (`tool_id`) REFERENCES `Tools` (`tool_id`);

--
-- Constraints for table `HandTools`
--
ALTER TABLE `HandTools`
  ADD CONSTRAINT `FK_HandTools_tool_id_Tools_tool_id` FOREIGN KEY (`tool_id`) REFERENCES `Tools` (`tool_id`);

--
-- Constraints for table `Ladders`
--
ALTER TABLE `Ladders`
  ADD CONSTRAINT `FK_Ladders_tool_id_Tools_tool_id` FOREIGN KEY (`tool_id`) REFERENCES `Tools` (`tool_id`);

--
-- Constraints for table `Mixer`
--
ALTER TABLE `Mixer`
  ADD CONSTRAINT `FK_Mixer_tool_id_Tools_tool_id` FOREIGN KEY (`tool_id`) REFERENCES `Tools` (`tool_id`);

--
-- Constraints for table `Order`
--
ALTER TABLE `Order`
  ADD CONSTRAINT `FK_Order_customer_username_Customer_username` FOREIGN KEY (`customer_username`) REFERENCES `Customer` (`username`),
  ADD CONSTRAINT `FK_Order_reservation_id_Reservation_reservation_id` FOREIGN KEY (`reservation_id`) REFERENCES `Reservation` (`reservation_id`),
  ADD CONSTRAINT `FK_Order_tool_id_Tools_tool_id` FOREIGN KEY (`tool_id`) REFERENCES `Tools` (`tool_id`);

--
-- Constraints for table `Phone`
--
ALTER TABLE `Phone`
  ADD CONSTRAINT `FK_Phone_username_User_username` FOREIGN KEY (`username`) REFERENCES `User` (`username`);

--
-- Constraints for table `PickUp`
--
ALTER TABLE `PickUp`
  ADD CONSTRAINT `FK_PickUp_clerk_username_Clerk_username` FOREIGN KEY (`clerk_username`) REFERENCES `Clerk` (`username`),
  ADD CONSTRAINT `FK_PickUp_reservation_id_Reservation_reservation_id` FOREIGN KEY (`reservation_id`) REFERENCES `Reservation` (`reservation_id`),
  ADD CONSTRAINT `FK_PickUp_tool_id_Tools_tool_id` FOREIGN KEY (`tool_id`) REFERENCES `Tools` (`tool_id`);

--
-- Constraints for table `Pliers`
--
ALTER TABLE `Pliers`
  ADD CONSTRAINT `FK_Pliers_tool_id_Tools_tool_id` FOREIGN KEY (`tool_id`) REFERENCES `Tools` (`tool_id`);

--
-- Constraints for table `PowerTools`
--
ALTER TABLE `PowerTools`
  ADD CONSTRAINT `FK_PowerTools_tool_id_Tools_tool_id` FOREIGN KEY (`tool_id`) REFERENCES `Tools` (`tool_id`);

--
-- Constraints for table `Power_Accessories`
--
ALTER TABLE `Power_Accessories`
  ADD CONSTRAINT `FK_Power_Accessories_tool_id_Tools_tool_id` FOREIGN KEY (`tool_id`) REFERENCES `Tools` (`tool_id`);

--
-- Constraints for table `Pruner`
--
ALTER TABLE `Pruner`
  ADD CONSTRAINT `FK_Pruner_tool_id_Tools_tool_id` FOREIGN KEY (`tool_id`) REFERENCES `Tools` (`tool_id`);

--
-- Constraints for table `Rakes`
--
ALTER TABLE `Rakes`
  ADD CONSTRAINT `FK_Rakes_tool_id_Tools_tool_id` FOREIGN KEY (`tool_id`) REFERENCES `Tools` (`tool_id`);

--
-- Constraints for table `Ratchet`
--
ALTER TABLE `Ratchet`
  ADD CONSTRAINT `FK_Ratchet_tool_id_Tools_tool_id` FOREIGN KEY (`tool_id`) REFERENCES `Tools` (`tool_id`);

--
-- Constraints for table `Rented`
--
ALTER TABLE `Rented`
  ADD CONSTRAINT `FK_Rented_customer_username_Customer_username` FOREIGN KEY (`customer_username`) REFERENCES `Customer` (`username`);

--
-- Constraints for table `Reservation`
--
ALTER TABLE `Reservation`
  ADD CONSTRAINT `FK_Reservation_customer_username_Customer_username` FOREIGN KEY (`customer_username`) REFERENCES `Customer` (`username`),
  ADD CONSTRAINT `FK_Reservation_tool_id_Tools_tool_id` FOREIGN KEY (`tool_id`) REFERENCES `Tools` (`tool_id`);

--
-- Constraints for table `SaleOrder`
--
ALTER TABLE `SaleOrder`
  ADD CONSTRAINT `FK_SaleOrder_clerk_username_Clerk_username` FOREIGN KEY (`clerk_username`) REFERENCES `Clerk` (`username`),
  ADD CONSTRAINT `FK_SaleOrder_tool_id_Tools_tool_id` FOREIGN KEY (`tool_id`) REFERENCES `Tools` (`tool_id`);

--
-- Constraints for table `Sander`
--
ALTER TABLE `Sander`
  ADD CONSTRAINT `FK_Sander_tool_id_Tools_tool_id` FOREIGN KEY (`tool_id`) REFERENCES `Tools` (`tool_id`);

--
-- Constraints for table `Saw`
--
ALTER TABLE `Saw`
  ADD CONSTRAINT `FK_Saw_tool_id_Tools_tool_id` FOREIGN KEY (`tool_id`) REFERENCES `Tools` (`tool_id`);

--
-- Constraints for table `ScrewDriver`
--
ALTER TABLE `ScrewDriver`
  ADD CONSTRAINT `FK_ScrewDriver_tool_id_Tools_tool_id` FOREIGN KEY (`tool_id`) REFERENCES `Tools` (`tool_id`);

--
-- Constraints for table `ServiceOrder`
--
ALTER TABLE `ServiceOrder`
  ADD CONSTRAINT `FK_ServiceOrder_clerk_username_Clerk_username` FOREIGN KEY (`clerk_username`) REFERENCES `Clerk` (`username`),
  ADD CONSTRAINT `FK_ServiceOrder_tool_id_Tools_tool_id` FOREIGN KEY (`tool_id`) REFERENCES `Tools` (`tool_id`);

--
-- Constraints for table `Socket`
--
ALTER TABLE `Socket`
  ADD CONSTRAINT `FK_Socket_tool_id_Tools_tool_id` FOREIGN KEY (`tool_id`) REFERENCES `Tools` (`tool_id`);

--
-- Constraints for table `Step`
--
ALTER TABLE `Step`
  ADD CONSTRAINT `FK_Step_tool_id_Tools_tool_id` FOREIGN KEY (`tool_id`) REFERENCES `Tools` (`tool_id`);

--
-- Constraints for table `Straight`
--
ALTER TABLE `Straight`
  ADD CONSTRAINT `FK_Straight_tool_id_Tools_tool_id` FOREIGN KEY (`tool_id`) REFERENCES `Tools` (`tool_id`);

--
-- Constraints for table `Striking`
--
ALTER TABLE `Striking`
  ADD CONSTRAINT `FK_Striking_tool_id_Tools_tool_id` FOREIGN KEY (`tool_id`) REFERENCES `Tools` (`tool_id`);

--
-- Constraints for table `Toolinfo`
--
ALTER TABLE `Toolinfo`
  ADD CONSTRAINT `FK_Toolinfo_tool_id_Tools_tool_id` FOREIGN KEY (`tool_id`) REFERENCES `Tools` (`tool_id`);

--
-- Constraints for table `Wheelbarrows`
--
ALTER TABLE `Wheelbarrows`
  ADD CONSTRAINT `FK_Wheelbarrows_tool_id_Tools_tool_id` FOREIGN KEY (`tool_id`) REFERENCES `Tools` (`tool_id`);

--
-- Constraints for table `With`
--
ALTER TABLE `With`
  ADD CONSTRAINT `FK_With_customer_username_Customer_username` FOREIGN KEY (`customer_username`) REFERENCES `Customer` (`username`),
  ADD CONSTRAINT `FK_With_tool_id_Tools_tool_id` FOREIGN KEY (`tool_id`) REFERENCES `Tools` (`tool_id`);

--
-- Constraints for table `Wrench`
--
ALTER TABLE `Wrench`
  ADD CONSTRAINT `FK_Wrench_tool_id_Tools_tool_id` FOREIGN KEY (`tool_id`) REFERENCES `Tools` (`tool_id`);
