-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 04, 2019 at 10:08 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `id` int(11) NOT NULL,
  `brand` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id`, `brand`) VALUES
(2, 'Gooloo'),
(10, 'ACDelco '),
(11, 'Callahan'),
(12, 'ENA'),
(13, 'Pedal Commander'),
(14, 'K&amp;N');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `items` text COLLATE utf8_unicode_ci NOT NULL,
  `expire_date` datetime NOT NULL,
  `paid` tinyint(4) NOT NULL DEFAULT '0',
  `shipped` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `items`, `expire_date`, `paid`, `shipped`) VALUES
(51, '[{\"id\":\"48\",\"myquant\":\"\",\"quantity\":\"1\"}]', '2019-06-03 05:55:01', 0, 0),
(52, '[{\"id\":\"49\",\"myquant\":\"\",\"quantity\":\"1\"}]', '2019-06-03 06:07:23', 0, 0),
(53, '[{\"id\":\"57\",\"myquant\":\"\",\"quantity\":\"1\"},{\"id\":\"54\",\"myquant\":\"\",\"quantity\":4},{\"id\":\"48\",\"myquant\":\"\",\"quantity\":5}]', '2019-06-03 08:26:14', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `parent`) VALUES
(1, 'Replacement Parts', 0),
(2, 'Performance Parts', 0),
(3, 'Interior Accessories', 0),
(4, 'Exterior Accessories', 0),
(5, 'Brake system', 1),
(6, 'Engine and Engine parts', 1),
(7, 'Exhaust and emissions', 1),
(9, 'Filters', 2),
(10, 'Engine Cooling', 2),
(11, 'Batteries and Accessories', 2),
(13, 'Floor Mats ', 3),
(14, 'Seat covers ', 3),
(16, 'Covers', 4),
(21, 'Grilles and gaurds', 4);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `list_price` decimal(10,0) NOT NULL,
  `brand` int(11) NOT NULL,
  `categories` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `featured` tinyint(4) NOT NULL DEFAULT '0',
  `myquant` int(11) NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  `threshold` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `price`, `list_price`, `brand`, `categories`, `image`, `description`, `featured`, `myquant`, `deleted`, `threshold`) VALUES
(47, 'GOOLOO jump starter', '70', '78', 2, '11', '/online_store/img/product/1f5d6b8cf136347dde49064af727b3c5.jpg,/online_store/img/product/430bf8f9298a399624b394f206b2f5f6.jpg,/online_store/img/product/6feadca1597b38b7ecb05ea9cf6f8693.jpg,/online_store/img/product/5c76bb052df88688952204f21ada974c.jpg', 'Super Safe-- Equipped with 8 protections for safer use.\r\nMultifunction jump starter with 800A peak current for 12V car battery .\r\n18,000mAh External Battery Charger with Quick Charge - Equipped with QC3.0 Output, this battery jump starter can fully charge your cellphones, tablets, kindle and other devices at lightning speed.\r\nBright LED Flashlight: It is built-in LED flashlight with Strobe functions and SOS for emergency situations.\r\n12V/10A Output - It can power your auto products like the tire inflator and car refrigerator, the cigarette lighter is not included.\r\nIt is compact enough to store in a glove box\r\nEasy to use', 1, 2, 0, 2),
(48, 'ACDelco Front Disc Brake Rotor', '33', '35', 10, '5', '/online_store/img/product/5416bf30b7b8dc57ef9451cec0c0a754.jpg,/online_store/img/product/d85e5ae857f96cfd3aefc17464313843.jpg,/online_store/img/product/7028ace46c9b7baa1293de39c80b46c3.jpg', 'Manufactured with multiple alloys for improved heat dissipation and performance\r\nMill-balanced for proper rotor function; no extra weights are needed\r\nQuality validated for proper metallurgy and correct brake plate thickness\r\nRounded radius for added strength', 0, 0, 0, 2),
(49, 'Callahan Drilled &amp; Slotted Lug Rotors', '121', '135', 11, '5', '/online_store/img/product/f4a3d2a9a6fcc4cf20f83a63e910446a.jpg,/online_store/img/product/73d8d259f6c5252f4615e80c38ad5dd7.jpg', '\r\nGUARANTEED ONLY to fit vehicles in Description - See below. Original design ensures 100% proper fit.\r\nINCREASED STOPPING POWER due to improved heat dissipation. Guaranteed to perform better or equal to OE parts.\r\nDRILLED &amp; SLOTTED ROTORS immensely improve stopping power. Designed for peak performance under all conditions.\r\nKIT INCLUDES TWO FRONT 5 Lug Drilled &amp; Slotted Premium Brake Rotors: Diameter=344 mm, Vented.', 1, 5, 0, 2),
(50, 'Engine Motor Trans Mount Set', '90', '100', 12, '6', '/online_store/img/product/5f3e11a7e237ab3334e2954313190ffa.jpg,/online_store/img/product/bfbdcb8c31854da55897faaad06c828e.jpg,/online_store/img/product/31757c4a93f35a07038d25a1730e5498.jpg', 'Brand New, Low Price Guaranteed and Easy Installation\r\nDIRECT REPLACEMENT/ UPGRADE over your original stock motor and transmission mount OEM set. We only use the highest grade materials. This makes our product durable and reliable under extreme conditions while providing noise reduction, reducing vibration, resistantance to Corrosion and Abrasion.\r\nHigh Quality Aftermarket Product', 1, 4, 0, 2),
(51, 'Throttle Response Controller', '251', '260', 13, '6', '/online_store/img/product/1c92264132a43ac2660eddd291443aa6.jpg,/online_store/img/product/05788f14772454977bbcafb49c379e8d.jpg,/online_store/img/product/25d0a3e8a4599213228a6492a37f931f.jpg', 'ELIMINATE RESPONSE DELAYS in your vehicle&#039;s acceleration.\r\nEASY plug-&amp;-play installation that DOES NOT void your warranty\r\n4 adjustable modes: Eco, City, Sport, Sport+ total 36 variation (ECO mode can also be used for better traction in snow or off-road)\r\nImprove FUEL ECONOMY up to 20% with ECO mode', 1, 3, 0, 2),
(52, 'Exhaust Gas Recirculation Valve', '30', '39', 10, '7', '/online_store/img/product/602528c0d3c942d212845a7053cdd150.jpg,/online_store/img/product/5d98d25631833b3fcd427397d3f661c4.jpg,/online_store/img/product/a8c897e7de6d10f07a47b76a74642905.jpg', 'Direct replacement for a proper fit every time\r\nMeets or exceeds OE specifications\r\nEasy Plug and Play Design\r\nIncludes New EGR Valve Gasket\r\nReplaces Original Equipment (OE) number: 25620-74330', 0, 5, 0, 2),
(53, 'Complete Engine, Fuel and Exhaust System Cleaner', '28', '30', 11, '7', '/online_store/img/product/e4074ac2c8976ced6aa8820eff514be9.jpg,/online_store/img/product/e84bef48c45c6cb03b18231b23266ecd.jpg,/online_store/img/product/2969462db47e1eadfb719526cb1fc415.jpg', 'Using Cataclean can lower your total hydrocarbon emissions by up to 50 percent\r\nReduces carbon build-up in catalytic converter, oxygen sensors, fuel injectors and cylinder heads which results in improved fuel efficiency\r\nImproves overall vehicle performance-including driveability issues such as power reduction, hesitation, rough idle, hard starts and lost fuel economy', 0, 5, 1, 2),
(54, 'Aerosol Recharger Filter ', '13', '14', 14, '9', '/online_store/img/product/393dbb3b37aa1d4515b3ed6a9f84c216.jpg,/online_store/img/product/8c97781c253c6a172547e0057aaae28e.jpg,/online_store/img/product/7a3eb835b0fe0c4331f2abf7775c134e.jpg', 'Includes 6.5 oz. air filter oil, 12 oz. filter cleaner\r\nWeight of the recharger kit is 2 lb (0.9 kg.)\r\nAir filter oil prevents dirt from entering your engine and works to dissolve the dirt build up and oil', 1, 0, 0, 2),
(55, 'Universal Clamp-On Air Filter', '13', '15', 12, '9', '/online_store/img/product/061854fae300fd82d055ad99d385ba87.jpg,/online_store/img/product/71ef62a09ec38f97013d914ce3ed50d0.jpg', 'High flow racing filter designed to fit 3 inch intake tube applications\r\nEngineered for increased flow and greater performance\r\nFactory pre-oiled and ready to use\r\nHigh-quality materials used throughout including washable synthetic media, urethane, and steel mesh\r\nUse part number HPR4820 AccuCharge kit to clean and re-oil the filter', 0, 5, 1, 2),
(56, 'Deep Cycle Marine Battery', '175', '180', 14, '11', '/online_store/img/product/0f99c522271591b6e92e0846edd73771.jpg,/online_store/img/product/8539832f1e72039affc22e1feb2b5ed3.jpg,/online_store/img/product/7bb1b41de785c5a2ac5da2bcb65d5456.jpg', '2-Volt, 750 Cold Cranking Amps, Size: 10 inches x 6 7/8 inches x 7 13/16 inches tall, Weight: 43.5 pounds, Dual SAE &amp; 5/16 inches Stainless Steel Stud Posts. 55 Ah C20 capacity\r\nOptimal starting power even in bad weather\r\nMountable in virtually any position. Works well as a boat battery or RV battery\r\nFifteen times more resistant to vibration for durability\r\nReserve capacity of 120 minutes for constant performance\r\nCranking Amps - 870 Ampere / Marine Cranking Amps - 870 ampere', 0, 6, 1, 2),
(57, 'SuperStat Thermostat ', '5', '7', 13, '10', '/online_store/img/product/d791dd0704f61ebfceae5e535123a7c0.jpg,/online_store/img/product/249e3fe38e8f67fa8fe31f7941e5523b.jpg', 'SuperStat exceeds OE performance\r\nContains larger piston and springs that OE themostats\r\nBetter flow control than OE themostats\r\nStainless steel flange for longer life and strength\r\nUse when you want 195 Degrees Fahrenheit', 1, 4, 0, 2),
(58, 'FlexTough Contour Liners', '28', '30', 11, '13', '/online_store/img/product/dc4c33e01947b367f05ab5dddfc7ac34.jpg,/online_store/img/product/986cea485d8346df345515b0aaa3e643.jpg,/online_store/img/product/b04460248b34daa67eb2ce3ed4748200.jpg', 'Flex Tough &ndash; Our Advanced Performance Rubber Polymers are Tested for Extreme Conditions to Ensure they Don&#039;t Crack, Split or Deform\r\nNo-Slip Grip &ndash; Rubberized Nibs on the Bottom so the Mat Does not Move &ndash; Ergonomic Grooves on Top to Give your Foot Traction &amp; Comfort\r\nBuilt for Protection &ndash; Guard Against Spills, or Debris &ndash; Built to Last through Rain, Snow, Mud and More\r\nDesigned for Compatibility &ndash; Made to be Trimble to Fit your Vehicle&rsquo;s Floor Contours with only a Pair of Scissors', 0, 4, 0, 2),
(59, 'Car Seat Protector', '20', '23', 10, '14', '/online_store/img/product/28aed0866d3bf4ab9663cdafc513c5dc.jpg,/online_store/img/product/5dc99aaee6c42506c992d793701324fc.jpg', 'Our Car Seat Protector Is Made Out Of Durable Material To A Very High Standard Which Gives The Car Seat Protector A Super Long Life. Easy To Wipe Clean. Simple And Easy To Install With The One Piece Design, And No Worry To Keep Track On Spare Parts', 0, 3, 0, 2),
(60, 'Car Cover UV Protection', '30', '34', 2, '16', '/online_store/img/product/87d20710326c4f66867eb84b1f24f5a1.jpg,/online_store/img/product/fed03ad010a35018e4be8fbb8b780e4e.jpg,/online_store/img/product/3686ca4e14ea7bb263954ea26506d1d9.jpg', 'MATERIAL- With air hole, breathable material will repel moisture, keep your car dry. Environmentally friendly biodegradable material.\r\nPROTECTION- Perfect for indoor and outdoor use. Protects for your vehicle from harmful UV rays, dirt, dust, industrial pollutants and bird droppings.\r\nWINDPROOF- straps and buckle at the bottom to protect your car cover in heavy wind from blowing off.\r\nFITMENT- Elastic hem around the bottoms for snug fit. The below car models in description are for reference.', 0, 4, 0, 2),
(61, 'Mesh Grill Insert', '18', '21', 12, '21', '/online_store/img/product/ad06ab1234544e30817dbe1f830bbb59.jpg,/online_store/img/product/f6480026177934d2f9ac007136558cc6.jpg', '[CONSTRUCTION]:Crafted from durable ABS plastic and will never rust,corrode or peel and will not fall down. Also could protect the condenser or radiator behind the grille from the big stone or rock.\r\n[UNIQUE DESIGN]:Use it to add some style and attitude to your Jeep Definitely a cool and inexpensive modification to any Jeep,it&#039;ll enhances the look of any Jeep!\r\n[EASY INSTRALLATION]:Easy Install with Self-Adhesive 3M Tape.Without drilling or toolsNo Drilling Required.\r\n[FITMENT]:For Off Road 2&amp;4 Doors Jeep Wrangler &amp; Unlimited 2007-2018 Rubicon Sahara sports JK JKU.', 0, 4, 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `charge_id` varchar(255) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(175) NOT NULL,
  `street` varchar(255) NOT NULL,
  `street2` varchar(255) NOT NULL,
  `city` varchar(175) NOT NULL,
  `state` varchar(175) NOT NULL,
  `zip_code` varchar(50) NOT NULL,
  `country` varchar(175) NOT NULL,
  `sub_total` decimal(10,0) NOT NULL,
  `tax` decimal(10,0) NOT NULL,
  `grand_total` decimal(10,0) NOT NULL,
  `description` text NOT NULL,
  `txn_type` varchar(255) NOT NULL,
  `txn_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `charge_id`, `cart_id`, `full_name`, `email`, `street`, `street2`, `city`, `state`, `zip_code`, `country`, `sub_total`, `tax`, `grand_total`, `description`, `txn_type`, `txn_date`) VALUES
(27, 'ch_1EWGaCCRxGUmyfavGf7sjhaq', 53, 'Test Testerson', 'test@test.com', '800 W Campbell Rd', '', 'Richardson', 'Texas', '75080', 'USA', '350', '30', '380', '5 items from Online Store.', 'charge', '2019-05-04 05:38:49'),
(28, 'ch_1EWHneCRxGUmyfavY8IuxwDC', 53, 'Saraswathi Shanmugamoorthy', 'sxs170165@utdallas.edu', '280 W Renner Road', '', 'Richardson', 'Texas', '75080', 'USA', '222', '19', '241', '10 items from Online Store.', 'charge', '2019-05-04 06:56:47');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(175) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `join_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` datetime NOT NULL,
  `permissions` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `join_date`, `last_login`, `permissions`) VALUES
(1, 'Sara Moorthy', 'sara@gmail.com', '$2y$10$u/l18FsIDS9BEAcg6ieANOTG3mCBGEQOfR6DSSKVaTGgg2NeIG7BG', '2017-09-19 08:44:17', '2019-05-04 07:52:17', 'admin, editor'),
(4, 'Karen Minasyan', 'karenminas10@gmail.com', '$2y$10$z1BO2Bfe6YVEyQ.chZG.ceWRqDKIDiYEchZFaPS3QS1eZQPR1it.y', '2017-09-20 06:42:03', '2017-09-23 17:58:52', 'editor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
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
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
