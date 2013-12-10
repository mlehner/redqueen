CREATE TABLE `cards` (
  `id` integer primary key AUTOINCREMENT,
  `member_id` int(11) NOT NULL,
  `code` varchar(6) NOT NULL,
  `pin` varchar(32) NOT NULL,
  `created_at` datetime NOT NULL
);
CREATE TABLE `members` (
  `id` integer primary key AUTOINCREMENT,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender` int(1) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
);
CREATE TABLE log ( id integer primary key autoincrement, card_id integer, code text not null, valid_pin integer not null, datetime integer not null);
