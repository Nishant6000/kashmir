-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2025 at 08:25 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kashmir_tourism`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `post_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `description`, `post_date`) VALUES
(5, 'nishanth', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque euismod, urna eget scelerisque volutpat, \n            arcu lectus egestas felis, et vehicula nisl metus sed orci. Vivamus euismod justo at purus tristique, ut \n            condimentum lectus ornare. Duis venenatis, purus sit amet cursus fringilla, arcu mi fringilla magna, id \n            interdum urna ipsum a arcu. Sed bibendum leo vel sapien luctus gravida. Fusce sed urna et urna tempor \n            facilisis. Nulla facilisi.\n            Integer euismod, ligula eu hendrerit dapibus, lorem odio fermentum ligula, id volutpat libero risus nec leo. \n            Suspendisse potenti. Sed cursus justo sit amet arcu vehicula, nec ultrices sapien vestibulum. Donec vestibulum \n            metus vel lacus pharetra, id fermentum turpis volutpat.\n', '2025-01-20');

-- --------------------------------------------------------

--
-- Table structure for table `blog_images`
--

CREATE TABLE `blog_images` (
  `id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `blog_images`
--

INSERT INTO `blog_images` (`id`, `blog_id`, `image_path`) VALUES
(4, 5, 'images/k1.jpg'),
(5, 5, 'images/k1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `adults` int(11) NOT NULL,
  `children_below_5` int(11) NOT NULL,
  `children_above_5` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `total_cost` decimal(10,2) NOT NULL,
  `package_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `hotel_id` int(11) NOT NULL,
  `uid` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `adults`, `children_below_5`, `children_above_5`, `email`, `phone`, `total_cost`, `package_id`, `car_id`, `hotel_id`, `uid`, `created_at`) VALUES
(4, 2, 2, 0, 'shopemet@yahoo.com', '9113539263', '44.00', 6, 3, 3, '1740676284519', '2025-02-27 17:11:37'),
(5, 2, 2, 0, 'shopemet@yahoo.com', '9113539263', '44.00', 6, 3, 3, '1740676360890', '2025-02-27 17:12:51'),
(6, 2, 1, 0, 'shopemet@yahoo.com', '9113539263', '44.00', 6, 3, 3, '1740676436615', '2025-02-27 17:14:25'),
(7, 2, 1, 0, 'shopemet@yahoo.com', '9113539263', '44.00', 6, 3, 3, '1740676772138', '2025-02-27 17:19:34'),
(8, 2, 1, 0, 'shopemet@yahoo.com', '9113539263', '44.00', 6, 3, 3, '1740676880825', '2025-02-27 17:21:22'),
(9, 2, 2, 2, 'shopemet@yahoo.com', '9113539263', '82060.00', 6, 3, 3, '1740677093419', '2025-02-27 17:24:53'),
(10, 2, 2, 2, 'shopemet@yahoo.com', '9113539263', '82060.00', 6, 3, 3, '1740677145111', '2025-02-27 17:25:45'),
(11, 2, 2, 1, 'shopemet@yahoo.com', '9113539263', '70950.00', 6, 3, 3, '1740677236692', '2025-02-27 17:27:16'),
(12, 2, 2, 1, 'shopemet@yahoo.com', '9113539263', '70950.00', 6, 3, 3, '1740677240770', '2025-02-27 17:27:20'),
(13, 2, 1, 1, 'shopemet@yahoo.com', '9113539263', '55550.00', 6, 3, 3, '1740677336349', '2025-02-27 17:28:56'),
(14, 2, 2, 2, 'shopemet@yahoo.com', '9113539263', '82060.00', 6, 3, 3, '1740677721882-907', '2025-02-27 17:35:21'),
(15, 2, 2, 2, 'shopemet@yahoo.com', '9113539263', '82060.00', 6, 3, 3, '1740677952857-468', '2025-02-27 17:39:12'),
(16, 2, 2, 2, 'shopemet@yahoo.com', '9113539263', '82060.00', 6, 3, 3, '1740682303689-649', '2025-02-27 18:51:43'),
(17, 2, 2, 1, 'shopemet@yahoo.com', '9113539263', '70950.00', 6, 3, 3, '1740682888501-392', '2025-02-27 19:01:28'),
(18, 2, 2, 1, 'shopemet@yahoo.com', '9113539263', '70950.00', 6, 3, 3, '1740683082291-60', '2025-02-27 19:04:42'),
(19, 1, 1, 0, 'shopemet@yahoo.com', '9113539263', '22220.00', 6, 3, 3, '1740683300741-92', '2025-02-27 19:08:20'),
(20, 1, 1, 1, 'shopemet@yahoo.com', '9113539263', '33330.00', 6, 3, 3, '1740683374637-71', '2025-02-27 19:09:34'),
(21, 1, 1, 1, 'shopemet@yahoo.com', '9113539263', '33330.00', 6, 3, 3, '1740683426347-252', '2025-02-27 19:10:26'),
(22, 1, 1, 1, 'shopemet@yahoo.com', '9113539263', '33330.00', 6, 3, 3, '1740683518753-64', '2025-02-27 19:11:58'),
(23, 1, 2, 2, 'shopemet@yahoo.com', '9113592632', '59840.00', 6, 3, 3, '1740683801442-576', '2025-02-27 19:16:41'),
(24, 1, 1, 1, 'shopemet@yahoo.com', '9113539263', '33330.00', 6, 3, 3, '1740683942957-132', '2025-02-27 19:19:02');

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `model` varchar(255) NOT NULL,
  `status` enum('available','occupied') DEFAULT 'available',
  `price` decimal(10,2) DEFAULT NULL,
  `capacity` int(2) NOT NULL DEFAULT 4,
  `image` varchar(255) DEFAULT NULL,
  `destination_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `model`, `status`, `price`, `capacity`, `image`, `destination_id`) VALUES
(3, 'hyndai Santro Lx', 'available', '2200.00', 4, NULL, 10);

-- --------------------------------------------------------

--
-- Table structure for table `cars_images`
--

CREATE TABLE `cars_images` (
  `id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cars_images`
--

INSERT INTO `cars_images` (`id`, `car_id`, `image_path`) VALUES
(3, 3, 'uploads/awards.png'),
(4, 3, 'uploads/bg_2.png');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `author` varchar(255) NOT NULL,
  `comment_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `author`, `comment_text`, `created_at`) VALUES
(1, 5, 'Nishanth S', 'Great post! I really enjoyed reading it. The insights on this topic are very informative. Looking forward to more posts like this!', '2025-01-27 14:50:11'),
(2, 5, 'Nishanth S', 'Great post! I really enjoyed reading it. The insights on this topic are very informative. Looking forward to more posts like this!', '2025-01-27 14:51:17');

-- --------------------------------------------------------

--
-- Table structure for table `destinations`
--

CREATE TABLE `destinations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `destinations`
--

INSERT INTO `destinations` (`id`, `name`, `description`, `image`) VALUES
(10, 'gulmarg', 'midst the stunning valley of Kashmir, a vibrant tapestry of flowers adds a burst of color to the lush landscape. The vivid blooms against the backdrop of serene mountains and flowing river create a breathtaking scene of nature’s artistry.\r\n', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `destination_images`
--

CREATE TABLE `destination_images` (
  `id` int(11) NOT NULL,
  `destination_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `destination_images`
--

INSERT INTO `destination_images` (`id`, `destination_id`, `image_path`, `created_at`) VALUES
(8, 9, 'uploads/Capture.PNG', '2025-01-12 18:48:54'),
(9, 9, 'uploads/check3n4.PNG', '2025-01-12 18:48:54'),
(10, 10, 'images/k1.jpg', '2025-01-16 20:27:27'),
(11, 10, 'images/k1.jpg', '2025-01-16 20:27:27');

-- --------------------------------------------------------

--
-- Table structure for table `hotels`
--

CREATE TABLE `hotels` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` enum('occupied','available') DEFAULT 'available',
  `image` varchar(255) DEFAULT NULL,
  `rating` float DEFAULT 3,
  `detailed_description` text DEFAULT NULL,
  `other_features` varchar(500) DEFAULT NULL,
  `hotel_star_rating` decimal(1,0) NOT NULL DEFAULT 3,
  `destination_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hotels`
--

INSERT INTO `hotels` (`id`, `name`, `location`, `description`, `price`, `status`, `image`, `rating`, `detailed_description`, `other_features`, `hotel_star_rating`, `destination_id`) VALUES
(3, 'gulmarg 3 star', 'NEAR ALPONSE GARDEN', 'Watch the first few minutes of Kitty\'s second semester in Korea — with a special introduction from the cast. New episodes of the teen rom-com are coming soon', '6889.00', 'available', NULL, 3, NULL, NULL, '3', 10);

-- --------------------------------------------------------

--
-- Table structure for table `hotel_images`
--

CREATE TABLE `hotel_images` (
  `id` int(11) NOT NULL,
  `hotel_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hotel_images`
--

INSERT INTO `hotel_images` (`id`, `hotel_id`, `image_path`) VALUES
(3, 3, 'uploads/bg_2.png'),
(4, 3, 'uploads/kashmir-meridian.png'),
(5, 3, 'uploads/kashmir-meridian2.png');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `destination_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_trending` tinyint(1) NOT NULL DEFAULT 0,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `rating` decimal(3,1) NOT NULL DEFAULT 5.0,
  `is_honeymoon` tinyint(1) NOT NULL DEFAULT 0,
  `is_adventure` tinyint(1) NOT NULL DEFAULT 0,
  `is_premium` tinyint(1) NOT NULL DEFAULT 0,
  `is_budget` tinyint(1) NOT NULL DEFAULT 0,
  `reviews` decimal(5,0) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `name`, `description`, `duration`, `price`, `destination_id`, `image`, `is_trending`, `is_featured`, `rating`, `is_honeymoon`, `is_adventure`, `is_premium`, `is_budget`, `reviews`) VALUES
(6, 'gulmarg 3 star', 'wssdsds\r\nsddsd\r\n', '6 Night & 7 Days', '22220.00', 10, NULL, 0, 0, '5.0', 0, 0, 0, 0, '12200');

-- --------------------------------------------------------

--
-- Table structure for table `packages_images`
--

CREATE TABLE `packages_images` (
  `id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `packages_images`
--

INSERT INTO `packages_images` (`id`, `package_id`, `image`) VALUES
(5, 6, 'images/k1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `package_details`
--

CREATE TABLE `package_details` (
  `id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `destination_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `hotel_id` int(11) NOT NULL,
  `itinerary` text NOT NULL,
  `inclusions` text NOT NULL,
  `exclusions` text NOT NULL,
  `charges_for_exclusions` decimal(10,2) DEFAULT NULL,
  `terms_and_conditions` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `package_details`
--

INSERT INTO `package_details` (`id`, `package_id`, `destination_id`, `car_id`, `hotel_id`, `itinerary`, `inclusions`, `exclusions`, `charges_for_exclusions`, `terms_and_conditions`, `created_at`) VALUES
(2, 6, 10, 3, 3, 'Day 1: Arrival in Leh\nArrive in Leh, where our representative will greet you at the airport and transfer you to the hotel. Spend the day acclimatizing to the high altitude.,Day 2: Leh - Local Sightseeing\nVisit the famous Shanti Stupa, Leh Palace, and the bustling Leh Market. Return to the hotel in the evening.,Day 3: Leh to Nubra Valley\nDrive through the Khardung La Pass to reach Nubra Valley. Visit Diskit Monastery and enjoy a camel ride in the sand dunes.', 'Accommodation in 3-star hotels\r\nDaily breakfast and dinner\r\nAirport transfers\r\nAll sightseeing tours by private cab\r\nInner line permits', 'Airfare\r\nLunch \r\nAny personal expenses\r\nTravel insurance', '800.00', 'Please read the following terms and conditions carefully before booking the tour. By booking, you agree to all the terms mentioned below.', '2025-01-31 14:38:31'),
(3, 6, 10, 3, 3, 'Day 1: Arrival in Leh\nArrive in Leh, where our representative will greet you at the airport and transfer you to the hotel. Spend the day acclimatizing to the high altitude.*Day 2: Leh - Local Sightseeing\nVisit the famous Shanti Stupa, Leh Palace, and the bustling Leh Market. Return to the hotel in the evening.*Day 3: Leh to Nubra Valley\nDrive through the Khardung La Pass to reach Nubra Valley. Visit Diskit Monastery and enjoy a camel ride in the sand dunes.', 'Accommodation in 3-star hotels\r\nDaily breakfast and dinner\r\nAirport transfers\r\nAll sightseeing tours by private cab\r\nInner line permits', 'Airfare\r\nLunch \r\nAny personal expenses\r\nTravel insurance', '800.00', 'Please read the following terms and conditions carefully before booking the tour. By booking, you agree to all the terms mentioned below.', '2025-01-31 14:41:19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`) VALUES
(1, 'admin', '$2y$10$QwJKfCneJNqjQ.htWhc.FOjzRcJMewn1n5/OD8zyeKYxVnGrk/TZ.', NULL, 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_images`
--
ALTER TABLE `blog_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cars_images`
--
ALTER TABLE `cars_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `destinations`
--
ALTER TABLE `destinations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `destination_images`
--
ALTER TABLE `destination_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hotel_images`
--
ALTER TABLE `hotel_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hotel_id` (`hotel_id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages_images`
--
ALTER TABLE `packages_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `package_id` (`package_id`);

--
-- Indexes for table `package_details`
--
ALTER TABLE `package_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `blog_images`
--
ALTER TABLE `blog_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cars_images`
--
ALTER TABLE `cars_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `destinations`
--
ALTER TABLE `destinations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `destination_images`
--
ALTER TABLE `destination_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `hotels`
--
ALTER TABLE `hotels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hotel_images`
--
ALTER TABLE `hotel_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `packages_images`
--
ALTER TABLE `packages_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `package_details`
--
ALTER TABLE `package_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cars_images`
--
ALTER TABLE `cars_images`
  ADD CONSTRAINT `cars_images_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hotel_images`
--
ALTER TABLE `hotel_images`
  ADD CONSTRAINT `hotel_images_ibfk_1` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
