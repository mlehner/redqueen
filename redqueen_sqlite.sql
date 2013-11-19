CREATE TABLE IF NOT EXISTS `cards` (
  `id` bigint(20) primary key autoincrement,
  `member_id` int(11) NOT NULL,
  `code` varchar(6) NOT NULL,
  `pin` varchar(32) NOT NULL,
  `created_at` datetime NOT NULL
);

CREATE TABLE IF NOT EXISTS `members` (
  `id` bigint(20) primary key autoincrement,
  `name` varchar(255) NOT NULL unique,
  `username` varchar(255) NOT NULL unique,
  `email` varchar(255) NOT NULL,
  `gender` int(1) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
);
