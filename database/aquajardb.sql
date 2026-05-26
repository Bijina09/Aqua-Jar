-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2026 at 06:02 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aquajardb`
--

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `distributor_id` int(11) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `reply` varchar(255) DEFAULT NULL,
  `status` varchar(30) DEFAULT 'OPEN',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `resolved_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `order_id`, `customer_id`, `distributor_id`, `message`, `image`, `reply`, `status`, `created_at`, `resolved_at`) VALUES
(6, 8, 9, 3, 'Jar was damaged.', '/Aqua-Jar/backend/uploads/1779386095_Sae975d209b1f44b5bf3c8f6daf63f226U.jpg', 'New jar will be sent', 'resolved', '2026-05-21 17:54:55', NULL),
(7, 10, 9, 3, 'Jar broken', '/Aqua-Jar/backend/uploads/1779504486_Screenshot (1).png', 'We will ressent it', 'resolved', '2026-05-23 02:48:06', '2026-05-26 14:00:30'),
(8, 11, 9, 3, 'Number of jar less', '/Aqua-Jar/backend/uploads/1779508962_Screenshot 2024-11-21 115432.png', 'We will send it', 'resolved', '2026-05-23 04:02:42', NULL),
(9, 12, 9, 3, 'Wrong Location', '/Aqua-Jar/backend/uploads/1779516922_Screenshot 2024-11-21 122437.png', 'New dispatched', 'resolved', '2026-05-23 06:15:22', NULL),
(10, 13, 11, 3, 'Jar broken', '/Aqua-Jar/backend/uploads/1779519667_Screenshot 2024-11-22 094421.png', 'We will resend it', 'resolved', '2026-05-23 07:01:07', NULL),
(11, 11, 9, 3, 'there is a problem', NULL, 'OK', 'resolved', '2026-05-26 14:06:35', '2026-05-26 14:06:51'),
(12, 12, 9, 3, 'I need a problem', NULL, 'You can get the problem', 'resolved', '2026-05-26 14:19:27', '2026-05-26 14:20:05');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password_hashed` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `name`, `address`, `phone`, `email`, `password_hashed`) VALUES
(9, 'Bijina Khatri', 'Baneshwor', '9876543211', 'bijina@gmail.com', '$2y$10$6tZPVvdHiehAf4Sx3NqEEOafxArfpgGcUZuUFn5QmErLWzT7qtSFW'),
(10, 'Rinkesh Chaudhary', 'Baneshwor', '9876543210', 'rinkesh@gmail.com', '$2y$10$/REMrc90gSW2jC3BlPi1TerHjNhPcGW09wSyVb50tdbH2c2EbNaLO'),
(11, 'Amrit', 'Bhaktapur', '9876543213', 'amrit@gmail.com', '$2y$10$AjKDphpfK7owyAXvTMJ0KeHORq6el8Yh4h4qayUM5s0om4uOtBd0i');

-- --------------------------------------------------------

--
-- Table structure for table `distributor`
--

CREATE TABLE `distributor` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `PAN_NO` varchar(255) DEFAULT NULL,
  `supplier` varchar(255) DEFAULT NULL,
  `supplier_PAN` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password_hashed` varchar(255) DEFAULT NULL,
  `service_area` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `distributor`
--

INSERT INTO `distributor` (`id`, `name`, `address`, `phone`, `PAN_NO`, `supplier`, `supplier_PAN`, `email`, `password_hashed`, `service_area`) VALUES
(3, 'Shishir Ghimire', 'KTM', '9876543212', 'ASDFG1234A', 'pani', 'QWERT1234Q', 'shishir@gmail.com', '$2y$10$QCKZfHMVQG2DlTYtNCqByeEHE39nsLWc3jEtuKxQxUYgq8K9IS8da', 'Baneshwor'),
(4, 'Aqua World', 'Koteshwor', '9876543213', 'ZXCVB1234Z', 'Deepsikha Pradhan', 'MNBVC1234M', 'deepsi@gmail.com', '$2y$10$zO9.s5lq2Q66Pb.pT8YUy.HN.VqfMOA50JXl3zpzP25NjUXcs8FQ.', 'koteshwor');

-- --------------------------------------------------------

--
-- Table structure for table `jar`
--

CREATE TABLE `jar` (
  `id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `distributor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jar`
--

INSERT INTO `jar` (`id`, `quantity`, `price`, `unit`, `distributor_id`) VALUES
(1, 100, 30.00, 'per Jar', 3),
(3, 50, 80.00, 'per 3 jars', 3),
(4, 30, 150.00, 'per 6 Jars', 3),
(5, 30, 40.00, 'per jar', 4),
(6, 25, 55.00, 'per 2 jar', 3),
(7, 100, 45.00, 'per jar', 3),
(8, 50, 80.00, 'Per 2 Jar', 3),
(9, 30, 85.00, 'Per 2 Jar', 3),
(10, 25, 30.00, 'Per Jar', 3);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `delivery_datetime` datetime DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `distributor_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `status` varchar(30) DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `delivered_at` timestamp NULL DEFAULT NULL,
  `jar_id` int(11) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `delivery_datetime`, `location`, `customer_id`, `distributor_id`, `quantity`, `status`, `created_at`, `delivered_at`, `jar_id`, `unit_price`, `total_price`) VALUES
(8, '2026-05-23 17:35:00', 'Parvati Hostel, Buddhanagar', 9, 3, 2, 'delivered', '2026-05-21 11:50:54', '2026-05-21 11:55:31', 1, 30.00, 60.00),
(9, '2026-05-23 17:54:00', 'Sweet Hostel, Anamnagar', 9, 4, 3, 'out for delivery', '2026-05-21 12:10:42', NULL, 5, 40.00, 120.00),
(10, '2026-05-28 08:29:00', 'Putalisadak', 9, 3, 2, 'delivered', '2026-05-23 02:45:13', '2026-05-23 02:46:08', 8, 80.00, 160.00),
(11, '2026-05-28 09:46:00', 'Kanitpur', 9, 3, 3, 'delivered', '2026-05-23 04:01:21', '2026-05-23 04:02:05', 9, 85.00, 255.00),
(12, '2026-05-25 11:56:00', 'KCC', 9, 3, 3, 'delivered', '2026-05-23 06:12:25', '2026-05-23 06:14:43', 1, 30.00, 90.00),
(13, '2026-05-25 12:38:00', 'Putalisadak', 11, 3, 2, 'delivered', '2026-05-23 06:53:35', '2026-05-23 06:55:26', 10, 30.00, 60.00),
(14, '2026-05-28 18:28:00', 'iplex mall, Baneshwor', 9, 3, 3, 'delivered', '2026-05-26 12:43:38', '2026-05-26 15:43:05', 3, 80.00, 240.00),
(15, '2026-05-27 21:27:00', 'Kanitpur', 9, 3, 1, 'delivered', '2026-05-26 15:42:27', '2026-05-26 15:45:15', 6, 55.00, 55.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `distributor_id` (`distributor_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `distributor`
--
ALTER TABLE `distributor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jar`
--
ALTER TABLE `jar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `distributor_id` (`distributor_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `distributor_id` (`distributor_id`),
  ADD KEY `jar_id` (`jar_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `distributor`
--
ALTER TABLE `distributor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jar`
--
ALTER TABLE `jar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `complaints_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `complaints_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`),
  ADD CONSTRAINT `complaints_ibfk_3` FOREIGN KEY (`distributor_id`) REFERENCES `distributor` (`id`);

--
-- Constraints for table `jar`
--
ALTER TABLE `jar`
  ADD CONSTRAINT `jar_ibfk_1` FOREIGN KEY (`distributor_id`) REFERENCES `distributor` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`distributor_id`) REFERENCES `distributor` (`id`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`jar_id`) REFERENCES `jar` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
