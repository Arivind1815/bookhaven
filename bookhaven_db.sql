-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jul 02, 2025 at 12:16 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookhaven_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `user_id`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
(1, 1, 'Arivindhaan Yogaraj', 'arivindhaan@gmail.com', 'ijoio', 'ijojo', '2025-06-25 22:19:14');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `number` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `method` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `total_products` text DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT 'pending',
  `placed_on` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `payment_status`, `placed_on`) VALUES
(1, 1, 'Arivindhaan Yogaraj', '0182991402', 'arivindhaan@gmail.com', 'Cash on Delivery', 'Flat No. NO 149, JALAN SERI MAMBAU A6, TAMAN SERI MAMBAU, SEREMBAN, Negeri Sembilan, Malaysia - 70300', 'Holy Ghosts (2)', 22.00, 'Completed', '2025-06-25 20:00:54'),
(2, 1, 'Arivindhaan Yogaraj', '0182991402', 'arivindhaan@gmail.com', 'Cash on Delivery', 'Flat No. NO 149, JALAN SERI MAMBAU A6, TAMAN SERI MAMBAU, TAMAN SERI MAMBAU, SEREMBAN, Negeri Sembilan, Malaysia - 70300', 'Atomic Habitss (1)', 25.00, 'pending', '2025-06-25 23:44:27'),
(4, 2, 'Aravind Raj', '0142709793', 'aravindraj5151@gmail.com', 'Cash on Delivery', 'Flat No. 9657, Jalan KaSAWARI 11, KULAIJAYA, jOHOR, Malaysia - 81000', 'The Silent Patient (1), Clever Lands (1)', 125.00, 'pending', '2025-06-26 02:50:25');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `mem_price` decimal(10,2) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `genre` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `release_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `mem_price`, `stock`, `genre`, `description`, `image`, `author`, `release_date`) VALUES
(1, 'The Silent Patient', 29.90, 25.00, 25, 'Horror', 'A psychological thriller about a woman\'s silence after a traumatic event.', 'silent_patient.jpeg', 'Alex Michaelides', '2019-02-05'),
(4, 'Dune', 25.00, 22.00, 100, 'Historical', 'Epic science fiction novel set on the desert planet Arrakis.', 'dune.jpeg', 'Frank Herbert', '1965-08-01'),
(6, 'Atomic Habits', 30.00, 25.00, 50, 'Historical', 'A guide to building good habits and breaking bad ones.', '1750882589_atomic.jpg', 'James Clear', '2018-10-16'),
(7, 'Clever Lands', 123.00, 100.00, 50, 'Romance', 'bijbiubi', 'clever_lands.jpg', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `phone`, `password`, `reset_token`) VALUES
(1, 'Arivindhaan', 'Arivind15', 'arivindhaan@gmail.com', '0182991402', '$2y$10$WVwDFn29uw8glozJkGfWWevj1zUyaZu4biW8sAezPtnTKVEw1DkM2', NULL),
(2, 'Aravind Raj', 'D20221101834', 'aravindraj5151@gmail.com', '0142709793', '$2y$10$wHKsvt7acr6/37lk5PkbJeg3e0YrN/f0VvBfoEQlaXRr6LGZWx/IW', NULL),
(3, 'sufi', 'sufi', 'sufil123@gmail.com', '0143007459', '$2y$10$z8ZXkkEZ5th5jfFtldDgdeWrW/UjpVGhrjjwZ.SzOwbKU3LrrL3kS', NULL),
(5, 'hakimi', 'hakimi', 'hakimi@gmail.com', '01127597786', '$2y$10$woKJ1LWtfZmrCHnDnnubA.aScsHif/T9QguZKvbJ.I5kJ6dIBKTrK', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
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
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
