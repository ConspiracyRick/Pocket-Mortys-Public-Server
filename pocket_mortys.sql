-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 30, 2026 at 03:13 PM
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
-- Database: `pocket_mortys`
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
(1, 'f8a69ceb-1ef8-4d0b-81dc-d6d59e425163', 0, '[\"a3e20258-48f8-4602-af17-ad0348c2fbcb\"]');

-- --------------------------------------------------------

--
-- Table structure for table `event_queue`
--

CREATE TABLE `event_queue` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_id` varchar(64) NOT NULL,
  `event_name` varchar(64) NOT NULL,
  `payload_json` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_queue`
--

INSERT INTO `event_queue` (`id`, `room_id`, `event_name`, `payload_json`, `created_at`) VALUES
(1, '76092cc3-d968-4d2d-8c54-98ed0817bc5a', 'room:initialized', '{\"world_id\":\"1\",\"zone_id\":\"[13-15]\",\"_created\":\"2026-01-30T18:13:24.000Z\"}', '2026-01-30 18:13:24'),
(2, '76092cc3-d968-4d2d-8c54-98ed0817bc5a', 'room:pickup-added', '{\"contents\":[{\"type\":\"ITEM\",\"amount\":1,\"item_id\":\"ItemSerum\",\"rarity\":100}],\"placement\":[41,2],\"pickup_id\":\"159fc229-eb12-491f-96a3-4bda07cf82e8\"}', '2026-01-30 18:13:24'),
(3, '76092cc3-d968-4d2d-8c54-98ed0817bc5a', 'room:pickup-added', '{\"contents\":[{\"type\":\"ITEM\",\"amount\":1,\"item_id\":\"ItemSerum\",\"rarity\":100}],\"placement\":[33,3],\"pickup_id\":\"1153b4cd-fe0c-44b2-8c73-96c65e9ec107\"}', '2026-01-30 18:13:24'),
(4, '76092cc3-d968-4d2d-8c54-98ed0817bc5a', 'room:pickup-added', '{\"contents\":[{\"type\":\"ITEM\",\"amount\":1,\"item_id\":\"ItemCircuitBoard\",\"rarity\":100},{\"type\":\"COIN\",\"amount\":233}],\"placement\":[61,63],\"pickup_id\":\"d1b9d175-69b4-41af-85a3-90f801e3efd7\"}', '2026-01-30 18:13:24'),
(5, '76092cc3-d968-4d2d-8c54-98ed0817bc5a', 'room:pickup-added', '{\"contents\":[{\"type\":\"ITEM\",\"amount\":1,\"item_id\":\"ItemSerum\",\"rarity\":100},{\"type\":\"COIN\",\"amount\":76}],\"placement\":[60,9],\"pickup_id\":\"1f19dab0-2c05-4e23-8e14-6751c6ce02d1\"}', '2026-01-30 18:13:24'),
(6, '76092cc3-d968-4d2d-8c54-98ed0817bc5a', 'room:pickup-added', '{\"contents\":[{\"type\":\"ITEM\",\"amount\":1,\"item_id\":\"ItemCircuitBoard\",\"rarity\":100}],\"placement\":[33,74],\"pickup_id\":\"f607c82f-4c21-4682-9613-f98a4c6d7c86\"}', '2026-01-30 18:13:24'),
(7, '76092cc3-d968-4d2d-8c54-98ed0817bc5a', 'room:pickup-added', '{\"contents\":[{\"type\":\"ITEM\",\"amount\":1,\"item_id\":\"ItemPlutonicRock\",\"rarity\":100}],\"placement\":[37,51],\"pickup_id\":\"76f87737-0ade-4a6f-bdda-c457d7413e95\"}', '2026-01-30 18:13:24'),
(8, '76092cc3-d968-4d2d-8c54-98ed0817bc5a', 'room:wild-morty-added', '{\"morty_id\":\"MortyPrisoner\",\"placement\":[2,2],\"state\":\"WORLD\",\"division\":4,\"variant\":\"Normal\",\"shiny_if_potion\":false,\"_created\":\"2026-01-30T18:13:24.000Z\",\"_updated\":\"2026-01-30T18:13:24.000Z\",\"wild_morty_id\":\"5244fb13-c4f4-45da-af01-8daae944e656\"}', '2026-01-30 18:13:24'),
(9, '76092cc3-d968-4d2d-8c54-98ed0817bc5a', 'room:wild-morty-added', '{\"morty_id\":\"MortyNoEye\",\"placement\":[11,34],\"state\":\"WORLD\",\"division\":1,\"variant\":\"Normal\",\"shiny_if_potion\":false,\"_created\":\"2026-01-30T18:13:24.000Z\",\"_updated\":\"2026-01-30T18:13:24.000Z\",\"wild_morty_id\":\"0651a6dc-c9d2-43ab-bc84-702f7a8bb67f\"}', '2026-01-30 18:13:24'),
(10, '76092cc3-d968-4d2d-8c54-98ed0817bc5a', 'room:wild-morty-added', '{\"morty_id\":\"MortyNoEye\",\"placement\":[31,37],\"state\":\"WORLD\",\"division\":4,\"variant\":\"Normal\",\"shiny_if_potion\":false,\"_created\":\"2026-01-30T18:13:24.000Z\",\"_updated\":\"2026-01-30T18:13:24.000Z\",\"wild_morty_id\":\"f96e3334-a371-4aa7-bdf5-f5313c416b78\"}', '2026-01-30 18:13:24'),
(11, '76092cc3-d968-4d2d-8c54-98ed0817bc5a', 'room:wild-morty-added', '{\"morty_id\":\"MortyNoEye\",\"placement\":[48,77],\"state\":\"WORLD\",\"division\":3,\"variant\":\"Normal\",\"shiny_if_potion\":true,\"_created\":\"2026-01-30T18:13:24.000Z\",\"_updated\":\"2026-01-30T18:13:24.000Z\",\"wild_morty_id\":\"f2d05987-dae0-4db7-b57a-c86bd2c099d8\"}', '2026-01-30 18:13:24'),
(12, '76092cc3-d968-4d2d-8c54-98ed0817bc5a', 'room:wild-morty-added', '{\"morty_id\":\"MortyNoEye\",\"placement\":[10,44],\"state\":\"WORLD\",\"division\":2,\"variant\":\"Shiny\",\"shiny_if_potion\":true,\"_created\":\"2026-01-30T18:13:24.000Z\",\"_updated\":\"2026-01-30T18:13:24.000Z\",\"wild_morty_id\":\"27086f94-324c-413f-9c66-786eb3d178bb\"}', '2026-01-30 18:13:25'),
(13, '76092cc3-d968-4d2d-8c54-98ed0817bc5a', 'room:bot-added', '{\"username\":\"Loxodromy\",\"player_avatar_id\":\"AvatarRickSuperFan\",\"state\":\"WORLD\",\"level\":5,\"owned_morties\":[{\"morty_id\":\"MortyAndroid\",\"variant\":\"Normal\",\"hp\":1,\"owned_morty_id\":\"80700000-0000-0000-0000-000000000000\"}],\"zone\":{\"player\":[3,5],\"bots\":{\"count\":10,\"morty_count\":{\"min\":1,\"max\":1},\"morty_hp_handicap\":{\"min\":0.4,\"max\":0.6}},\"zone_id\":\"[3-5]\"},\"streak\":0,\"_created\":\"2026-01-30T18:13:25.000Z\",\"_updated\":\"2026-01-30T18:13:25.000Z\",\"bot_id\":\"ce0f5f72-7a8f-4012-8592-77947e84a647\"}', '2026-01-30 18:13:25'),
(14, '76092cc3-d968-4d2d-8c54-98ed0817bc5a', 'room:bot-added', '{\"username\":\"Carpedge\",\"player_avatar_id\":\"AvatarRickSuperFan\",\"state\":\"WORLD\",\"level\":5,\"owned_morties\":[{\"morty_id\":\"MortyPoorHouse\",\"variant\":\"Normal\",\"hp\":1,\"owned_morty_id\":\"80700000-0000-0000-0000-000000000000\"}],\"zone\":{\"player\":[4,4],\"bots\":{\"count\":8,\"morty_count\":{\"min\":1,\"max\":1},\"morty_hp_handicap\":{\"min\":0.4,\"max\":0.6}},\"zone_id\":\"[4-4]\"},\"streak\":0,\"_created\":\"2026-01-30T18:13:25.000Z\",\"_updated\":\"2026-01-30T18:13:25.000Z\",\"bot_id\":\"09daebce-d9ca-4845-b4ea-86ba5af07edb\"}', '2026-01-30 18:13:25'),
(15, '76092cc3-d968-4d2d-8c54-98ed0817bc5a', 'room:bot-added', '{\"username\":\"Loxodromy\",\"player_avatar_id\":\"AvatarBeth\",\"state\":\"WORLD\",\"level\":5,\"owned_morties\":[{\"morty_id\":\"MortyTyrantLizard\",\"variant\":\"Normal\",\"hp\":1,\"owned_morty_id\":\"80700000-0000-0000-0000-000000000000\"}],\"zone\":{\"player\":[1,2],\"bots\":{\"count\":11,\"morty_count\":{\"min\":1,\"max\":1},\"morty_hp_handicap\":{\"min\":0.4,\"max\":0.6}},\"zone_id\":\"[1-2]\"},\"streak\":0,\"_created\":\"2026-01-30T18:13:25.000Z\",\"_updated\":\"2026-01-30T18:13:25.000Z\",\"bot_id\":\"bb6258dd-7abd-4c28-93ba-e200a71f4575\"}', '2026-01-30 18:13:25'),
(16, '76092cc3-d968-4d2d-8c54-98ed0817bc5a', 'room:bot-added', '{\"username\":\"Barbirdation\",\"player_avatar_id\":\"AvatarTeacherRick\",\"state\":\"WORLD\",\"level\":5,\"owned_morties\":[{\"morty_id\":\"MortyAndroid\",\"variant\":\"Normal\",\"hp\":1,\"owned_morty_id\":\"80700000-0000-0000-0000-000000000000\"}],\"zone\":{\"player\":[2,4],\"bots\":{\"count\":6,\"morty_count\":{\"min\":1,\"max\":1},\"morty_hp_handicap\":{\"min\":0.4,\"max\":0.6}},\"zone_id\":\"[2-4]\"},\"streak\":0,\"_created\":\"2026-01-30T18:13:25.000Z\",\"_updated\":\"2026-01-30T18:13:25.000Z\",\"bot_id\":\"53d6e0ef-275a-4542-a67a-6b4a193ccba8\"}', '2026-01-30 18:13:25'),
(17, '76092cc3-d968-4d2d-8c54-98ed0817bc5a', 'room:user-added', '{\"player_id\":\"f8a69ceb-1ef8-4d0b-81dc-d6d59e425163\",\"username\":\"ConspiracyRick\",\"player_avatar_id\":\"AvatarRickDefault\",\"level\":1,\"owned_morties\":[{\"owned_morty_id\":\"a3e20258-48f8-4602-af17-ad0348c2fbcb\",\"morty_id\":\"MortyDefault\",\"hp\":20,\"variant\":\"Normal\",\"is_locked\":false,\"is_trading_locked\":false,\"fight_pit_id\":null}],\"state\":\"WORLD\"}', '2026-01-30 18:13:25'),
(18, '76092cc3-d968-4d2d-8c54-98ed0817bc5a', 'shard:raid-boss-state-changed', '{\"raid_event_id\":\"RaidBossKillerAsteroid_2025\",\"shard_id\":\"78496e72-fb88-11f0-b2fd-8b24d97da62f\",\"current_state\":\"build_up\",\"world_id\":1,\"spawn_location\":\"37,58\",\"boss_id\":\"killer_asteroid\",\"asset_id\":\"RaidBossKillerAsteroid\",\"threat_lvl\":10,\"total_damage\":\"0\",\"initial_health\":30860800,\"max_health_bars\":60275,\"event_state_next_timestamp\":\"2026-01-30T14:00:00.000Z\",\"has_ran\":false,\"permit_start\":50,\"permit_buy_in\":1,\"ticket_buy_in\":0}', '2026-01-30 18:13:25'),
(19, '76092cc3-d968-4d2d-8c54-98ed0817bc5a', 'room:user-added', '{\"player_id\":\"f8a69ceb-1ef8-4d0b-81dc-d6d59e425163\",\"username\":\"ConspiracyRick\",\"player_avatar_id\":\"AvatarRickDefault\",\"level\":1,\"owned_morties\":[{\"owned_morty_id\":\"a3e20258-48f8-4602-af17-ad0348c2fbcb\",\"morty_id\":\"MortyDefault\",\"hp\":20,\"variant\":\"Normal\",\"is_locked\":false,\"is_trading_locked\":false,\"fight_pit_id\":null}],\"state\":\"WORLD\"}', '2026-01-30 19:30:07'),
(20, '76092cc3-d968-4d2d-8c54-98ed0817bc5a', 'shard:raid-boss-state-changed', '{\"raid_event_id\":\"RaidBossKillerAsteroid_2025\",\"shard_id\":\"78496e72-fb88-11f0-b2fd-8b24d97da62f\",\"current_state\":\"build_up\",\"world_id\":1,\"spawn_location\":\"37,58\",\"boss_id\":\"killer_asteroid\",\"asset_id\":\"RaidBossKillerAsteroid\",\"threat_lvl\":10,\"total_damage\":\"0\",\"initial_health\":30860800,\"max_health_bars\":60275,\"event_state_next_timestamp\":\"2026-01-30T14:00:00.000Z\",\"has_ran\":false,\"permit_start\":50,\"permit_buy_in\":1,\"ticket_buy_in\":0}', '2026-01-30 19:30:08'),
(21, '76092cc3-d968-4d2d-8c54-98ed0817bc5a', 'room:user-added', '{\"player_id\":\"f8a69ceb-1ef8-4d0b-81dc-d6d59e425163\",\"username\":\"ConspiracyRick\",\"player_avatar_id\":\"AvatarRickDefault\",\"level\":1,\"owned_morties\":[{\"owned_morty_id\":\"a3e20258-48f8-4602-af17-ad0348c2fbcb\",\"morty_id\":\"MortyDefault\",\"hp\":20,\"variant\":\"Normal\",\"is_locked\":false,\"is_trading_locked\":false,\"fight_pit_id\":null}],\"state\":\"WORLD\"}', '2026-01-30 19:33:12'),
(22, '76092cc3-d968-4d2d-8c54-98ed0817bc5a', 'shard:raid-boss-state-changed', '{\"raid_event_id\":\"RaidBossKillerAsteroid_2025\",\"shard_id\":\"78496e72-fb88-11f0-b2fd-8b24d97da62f\",\"current_state\":\"build_up\",\"world_id\":1,\"spawn_location\":\"37,58\",\"boss_id\":\"killer_asteroid\",\"asset_id\":\"RaidBossKillerAsteroid\",\"threat_lvl\":10,\"total_damage\":\"0\",\"initial_health\":30860800,\"max_health_bars\":60275,\"event_state_next_timestamp\":\"2026-01-30T14:00:00.000Z\",\"has_ran\":false,\"permit_start\":50,\"permit_buy_in\":1,\"ticket_buy_in\":0}', '2026-01-30 19:33:12');

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
(1, 'f8a69ceb-1ef8-4d0b-81dc-d6d59e425163', 'MortyDefault', 'true');

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
(1, 'a3e20258-48f8-4602-af17-ad0348c2fbcb', 'AttackOutburst', 0, 12, 12);

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
(1, 'f8a69ceb-1ef8-4d0b-81dc-d6d59e425163', '[\"AvatarRickDefault\"]');

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
(1, 'f8a69ceb-1ef8-4d0b-81dc-d6d59e425163', 'ItemMortyChip', 1),
(2, 'f8a69ceb-1ef8-4d0b-81dc-d6d59e425163', 'ItemSerum', 1);

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
(1, 'f8a69ceb-1ef8-4d0b-81dc-d6d59e425163', 'a3e20258-48f8-4602-af17-ad0348c2fbcb', 'MortyDefault', 5, 125, 20, 20, 11, 10, 'Normal', 10, 'false', 'false', 'null', 0, 125, 216);

-- --------------------------------------------------------

--
-- Table structure for table `room_presence`
--

CREATE TABLE `room_presence` (
  `player_id` varchar(64) NOT NULL,
  `room_id` varchar(64) NOT NULL,
  `username` varchar(64) NOT NULL,
  `avatar_id` varchar(64) DEFAULT NULL,
  `world_id` varchar(64) DEFAULT NULL,
  `zone_id` varchar(64) DEFAULT NULL,
  `level` int(11) NOT NULL DEFAULT 1,
  `state` varchar(32) NOT NULL DEFAULT 'WORLD',
  `last_seen` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_presence`
--

INSERT INTO `room_presence` (`player_id`, `room_id`, `username`, `avatar_id`, `world_id`, `zone_id`, `level`, `state`, `last_seen`) VALUES
('f8a69ceb-1ef8-4d0b-81dc-d6d59e425163', '76092cc3-d968-4d2d-8c54-98ed0817bc5a', 'ConspiracyRick', 'AvatarRickDefault', NULL, NULL, 1, 'WORLD', '2026-01-30 19:34:09');

-- --------------------------------------------------------

--
-- Table structure for table `room_stream_cursor`
--

CREATE TABLE `room_stream_cursor` (
  `player_id` varchar(64) NOT NULL,
  `room_id` varchar(64) NOT NULL,
  `last_event_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_stream_cursor`
--

INSERT INTO `room_stream_cursor` (`player_id`, `room_id`, `last_event_id`, `updated_at`) VALUES
('f8a69ceb-1ef8-4d0b-81dc-d6d59e425163', '76092cc3-d968-4d2d-8c54-98ed0817bc5a', 22, '2026-01-30 19:34:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `created` date NOT NULL DEFAULT current_timestamp(),
  `recover_code` text NOT NULL,
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

INSERT INTO `users` (`id`, `created`, `recover_code`, `secret`, `player_id`, `username`, `session_id`, `player_avatar_id`, `level`, `xp`, `streak`, `wins`, `losses`, `active_deck_id`, `decks_owned`, `tags`, `xp_lower`, `xp_upper`, `donation_request`, `online`) VALUES
(1, '2026-01-30', '9623326395', '4f0b1131-08d0-449c-9f6e-c70241b8cb70', 'f8a69ceb-1ef8-4d0b-81dc-d6d59e425163', 'ConspiracyRick', '47634620-0e0e-4cab-9c1a-ada2a20485c3', 'AvatarRickDefault', 1, 27, 0, 0, 0, 0, 3, '[]', 27, 64, NULL, 'false');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `decks`
--
ALTER TABLE `decks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_queue`
--
ALTER TABLE `event_queue`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_id` (`room_id`,`id`),
  ADD KEY `created_at` (`created_at`);

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
-- Indexes for table `room_presence`
--
ALTER TABLE `room_presence`
  ADD PRIMARY KEY (`player_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `last_seen` (`last_seen`);

--
-- Indexes for table `room_stream_cursor`
--
ALTER TABLE `room_stream_cursor`
  ADD PRIMARY KEY (`player_id`,`room_id`),
  ADD KEY `room_id` (`room_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `event_queue`
--
ALTER TABLE `event_queue`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `friend_list`
--
ALTER TABLE `friend_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mortydex`
--
ALTER TABLE `mortydex`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `owned_attacks`
--
ALTER TABLE `owned_attacks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `owned_avatars`
--
ALTER TABLE `owned_avatars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `owned_items`
--
ALTER TABLE `owned_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `owned_morties`
--
ALTER TABLE `owned_morties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
