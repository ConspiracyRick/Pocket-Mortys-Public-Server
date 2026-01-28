-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 28, 2026 at 04:56 AM
-- Server version: 10.3.39-MariaDB-0ubuntu0.20.04.2
-- PHP Version: 7.4.3-4ubuntu2.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `private_server_pocket_mortys`
--

-- --------------------------------------------------------

--
-- Table structure for table `decks`
--

CREATE TABLE `decks` (
  `id` int(11) NOT NULL,
  `player_id` text DEFAULT NULL,
  `deck_id` int(11) DEFAULT NULL,
  `owned_morty_ids` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `decks`
--

INSERT INTO `decks` (`id`, `player_id`, `deck_id`, `owned_morty_ids`) VALUES
(1, '5f2a57c8-ebf7-4edc-a6ac-3a6f9fc5eb51', 0, '[\"55513ff0-6fc3-48c1-b1d8-19bb9a023e6e\"]'),
(2, 'e7c784d7-1e96-4e47-b0dc-c97e1d94b918', 0, '[\"bd1bf62e-9735-4ee7-b037-113887a8e7bb\"]');

-- --------------------------------------------------------

--
-- Table structure for table `friend_list`
--

CREATE TABLE `friend_list` (
  `id` int(11) NOT NULL,
  `player_id_a` text DEFAULT NULL,
  `player_id_b` text DEFAULT NULL,
  `pending` text DEFAULT NULL,
  `direction` text DEFAULT NULL,
  `created` text NOT NULL,
  `modified` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `friend_list`
--

INSERT INTO `friend_list` (`id`, `player_id_a`, `player_id_b`, `pending`, `direction`, `created`, `modified`) VALUES
(6, '5f2a57c8-ebf7-4edc-a6ac-3a6f9fc5eb51', 'e7c784d7-1e96-4e47-b0dc-c97e1d94b918', 'true', 'false', '2026-01-28T03:40:29.055Z', '2026-01-28T03:40:29.055Z');

-- --------------------------------------------------------

--
-- Table structure for table `mortydex`
--

CREATE TABLE `mortydex` (
  `id` int(11) NOT NULL,
  `player_id` text DEFAULT NULL,
  `morty_id` text DEFAULT NULL,
  `caught` tinytext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mortydex`
--

INSERT INTO `mortydex` (`id`, `player_id`, `morty_id`, `caught`) VALUES
(1, '5f2a57c8-ebf7-4edc-a6ac-3a6f9fc5eb51', 'MortyDefault', 'true'),
(2, 'e7c784d7-1e96-4e47-b0dc-c97e1d94b918', 'MortyDefault', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `owned_attacks`
--

CREATE TABLE `owned_attacks` (
  `id` int(11) NOT NULL,
  `owned_morty_id` varchar(255) DEFAULT NULL,
  `attack_id` text DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `pp` int(11) DEFAULT NULL,
  `pp_stat` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `owned_attacks`
--

INSERT INTO `owned_attacks` (`id`, `owned_morty_id`, `attack_id`, `position`, `pp`, `pp_stat`) VALUES
(1, '55513ff0-6fc3-48c1-b1d8-19bb9a023e6e', 'AttackOutburst', 0, 12, 12),
(2, 'bd1bf62e-9735-4ee7-b037-113887a8e7bb', 'AttackOutburst', 0, 12, 12);

-- --------------------------------------------------------

--
-- Table structure for table `owned_avatars`
--

CREATE TABLE `owned_avatars` (
  `id` int(11) NOT NULL,
  `player_id` text DEFAULT NULL,
  `player_avatar_id` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `owned_avatars`
--

INSERT INTO `owned_avatars` (`id`, `player_id`, `player_avatar_id`) VALUES
(1, '5f2a57c8-ebf7-4edc-a6ac-3a6f9fc5eb51', '[\"AvatarRickDefault\"]'),
(2, 'e7c784d7-1e96-4e47-b0dc-c97e1d94b918', '[\"AvatarRickDefault\"]');

-- --------------------------------------------------------

--
-- Table structure for table `owned_items`
--

CREATE TABLE `owned_items` (
  `id` int(11) NOT NULL,
  `player_id` text DEFAULT NULL,
  `item_id` text DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `owned_items`
--

INSERT INTO `owned_items` (`id`, `player_id`, `item_id`, `quantity`) VALUES
(1, '5f2a57c8-ebf7-4edc-a6ac-3a6f9fc5eb51', 'ItemMortyChip', 1),
(2, '5f2a57c8-ebf7-4edc-a6ac-3a6f9fc5eb51', 'ItemSerum', 1),
(3, 'e7c784d7-1e96-4e47-b0dc-c97e1d94b918', 'ItemMortyChip', 1),
(4, 'e7c784d7-1e96-4e47-b0dc-c97e1d94b918', 'ItemSerum', 1);

-- --------------------------------------------------------

--
-- Table structure for table `owned_morties`
--

CREATE TABLE `owned_morties` (
  `id` int(11) NOT NULL,
  `player_id` text DEFAULT NULL,
  `owned_morty_id` text DEFAULT NULL,
  `morty_id` text DEFAULT NULL,
  `level` bigint(100) DEFAULT NULL,
  `xp` bigint(255) DEFAULT NULL,
  `hp` bigint(255) DEFAULT NULL,
  `hp_stat` bigint(255) DEFAULT NULL,
  `attack_stat` bigint(255) DEFAULT NULL,
  `defence_stat` bigint(255) DEFAULT NULL,
  `variant` text DEFAULT NULL,
  `speed_stat` bigint(255) DEFAULT NULL,
  `is_locked` varchar(255) DEFAULT NULL,
  `is_trading_locked` varchar(255) DEFAULT NULL,
  `fight_pit_id` varchar(255) DEFAULT NULL,
  `evolution_points` bigint(255) DEFAULT NULL,
  `xp_lower` bigint(255) DEFAULT NULL,
  `xp_upper` bigint(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `owned_morties`
--

INSERT INTO `owned_morties` (`id`, `player_id`, `owned_morty_id`, `morty_id`, `level`, `xp`, `hp`, `hp_stat`, `attack_stat`, `defence_stat`, `variant`, `speed_stat`, `is_locked`, `is_trading_locked`, `fight_pit_id`, `evolution_points`, `xp_lower`, `xp_upper`) VALUES
(1, '5f2a57c8-ebf7-4edc-a6ac-3a6f9fc5eb51', '55513ff0-6fc3-48c1-b1d8-19bb9a023e6e', 'MortyDefault', 5, 125, 20, 20, 11, 10, 'Normal', 10, 'false', 'false', 'null', 0, 125, 216),
(2, 'e7c784d7-1e96-4e47-b0dc-c97e1d94b918', 'bd1bf62e-9735-4ee7-b037-113887a8e7bb', 'MortyDefault', 5, 125, 20, 20, 11, 10, 'Normal', 10, 'false', 'false', 'null', 0, 125, 216);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `created` date NOT NULL DEFAULT current_timestamp(),
  `secret` varchar(255) NOT NULL,
  `player_id` text DEFAULT NULL,
  `username` text DEFAULT NULL,
  `session_id` text DEFAULT NULL,
  `player_avatar_id` text DEFAULT NULL,
  `level` bigint(255) DEFAULT NULL,
  `xp` bigint(255) DEFAULT NULL,
  `streak` int(5) DEFAULT NULL,
  `wins` bigint(255) NOT NULL DEFAULT 0,
  `losses` bigint(255) NOT NULL DEFAULT 0,
  `active_deck_id` int(10) DEFAULT NULL,
  `decks_owned` int(11) DEFAULT NULL,
  `tags` text DEFAULT NULL,
  `xp_lower` bigint(255) DEFAULT NULL,
  `xp_upper` bigint(255) DEFAULT NULL,
  `donation_request` text DEFAULT NULL,
  `online` text NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `created`, `secret`, `player_id`, `username`, `session_id`, `player_avatar_id`, `level`, `xp`, `streak`, `wins`, `losses`, `active_deck_id`, `decks_owned`, `tags`, `xp_lower`, `xp_upper`, `donation_request`, `online`) VALUES
(1, '2026-01-27', '7368c405-d2f2-4110-bb4d-b952f38dd196', '5f2a57c8-ebf7-4edc-a6ac-3a6f9fc5eb51', 'Jackieboy', '8c1c1d04-b4e5-4e4d-9b50-50aab7b68d10', 'AvatarRickDefault', 1, 27, 0, 0, 0, 0, 3, '[]', 27, 64, NULL, 'false'),
(2, '2026-01-27', '6b94b149-cbed-40b7-9475-efbe77d37612', 'e7c784d7-1e96-4e47-b0dc-c97e1d94b918', 'BadassMotorboat', '25af1d62-4162-4c69-891e-7ed94073f267', 'AvatarRickDefault', 1, 27, 0, 0, 0, 0, 3, '[]', 27, 64, NULL, 'false');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `decks`
--
ALTER TABLE `decks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `friend_list`
--
ALTER TABLE `friend_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mortydex`
--
ALTER TABLE `mortydex`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `owned_attacks`
--
ALTER TABLE `owned_attacks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `owned_avatars`
--
ALTER TABLE `owned_avatars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `owned_items`
--
ALTER TABLE `owned_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `owned_morties`
--
ALTER TABLE `owned_morties`
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
-- AUTO_INCREMENT for table `decks`
--
ALTER TABLE `decks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `friend_list`
--
ALTER TABLE `friend_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `mortydex`
--
ALTER TABLE `mortydex`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `owned_attacks`
--
ALTER TABLE `owned_attacks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `owned_avatars`
--
ALTER TABLE `owned_avatars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `owned_items`
--
ALTER TABLE `owned_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `owned_morties`
--
ALTER TABLE `owned_morties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
