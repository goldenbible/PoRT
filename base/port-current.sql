CREATE TABLE `forums` (
  `id` int(11) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `is_read_only` bit(1) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO `forums` (`id`, `title`, `is_read_only`, `sort`) VALUES
(1, 'Administration', b'1', 1),
(2, 'Projects', NULL, 3),
(3, 'Suggestions', NULL, 4),
(4, 'Hanging Out', NULL, 6),
(5, 'Directorate', NULL, 2),
(6, 'Countries', NULL, 5);
CREATE TABLE `forum_replies` (
  `id` int(11) NOT NULL,
  `topic_id` int(11) DEFAULT NULL,
  `entry` varchar(5000) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `inserted` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `forum_topics` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `post` varchar(5000) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `subforum_id` int(11) DEFAULT NULL,
  `inserted` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `closed` datetime DEFAULT NULL,
  `closed_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `opened_by` int(11) DEFAULT NULL,
  `pinned` datetime DEFAULT NULL,
  `pinned_by` int(11) DEFAULT NULL,
  `unpinned_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `from_user_id` int(11) DEFAULT NULL,
  `to_user_id` int(11) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `message` varchar(5000) DEFAULT NULL,
  `inserted` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `when_read` datetime DEFAULT NULL,
  `from_deleted` datetime DEFAULT NULL,
  `to_deleted` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `roles` (`id`, `name`, `code`) VALUES
(1, 'Administrator', 'admin'),
(2, 'Moderator', 'moderator'),
(3, 'Programmer', 'programmer'),
(4, 'Honored Community Member', 'honored_community_me'),
(5, 'Community Member', 'common_community_mem'),
(6, 'Director', 'director'),
(0, 'Owner', 'owner');

CREATE TABLE `social_networks` (
  `id` int(11) NOT NULL,
  `network_name` varchar(50) DEFAULT NULL,
  `base_url` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `social_networks` (`id`, `network_name`, `base_url`) VALUES
(1, 'Facebook', 'https://www.facebook.com/'),
(2, 'Google+', 'https://plus.google.com/'),
(3, 'Vkontakte', 'https://vk.com/');

CREATE TABLE `subforums` (
  `id` int(11) NOT NULL,
  `forum_id` int(11) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `is_read_only` bit(1) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `subforums` (`id`, `forum_id`, `title`, `is_read_only`, `sort`) VALUES
(1, 1, 'Welcome', NULL, 1),
(2, 1, 'Messages of the Day', NULL, 3),
(3, 1, 'Rules', NULL, 2),
(4, 2, 'Gold Bible', NULL, 1),
(5, 2, 'E-Library', NULL, 2),
(6, 3, 'Gold Bible', NULL, 1),
(7, 3, 'E-Library', NULL, 2),
(8, 3, 'Other Suggestions', NULL, 3),
(9, 4, 'Hanging Out', NULL, 1),
(10, 4, 'Fun Is Here', NULL, 2),
(11, 5, 'Messages of the Day', NULL, 1),
(12, 5, 'Discussions', NULL, 2),
(13, 6, 'North America', NULL, 1),
(14, 6, 'Latin America', NULL, 2),
(15, 6, 'Oceania', NULL, 3),
(16, 6, 'Europe', NULL, 4),
(17, 6, 'Asia', NULL, 5);

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nickname` varchar(30) DEFAULT NULL,
  `full_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `secret_question` varchar(200) DEFAULT NULL,
  `secret_answer` varchar(50) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `last_hit` datetime DEFAULT NULL,
  `inserted` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `timezone` varchar(50) DEFAULT NULL,
  `verification_code` varchar(36) DEFAULT NULL,
  `remote_addr` varchar(50) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `topics_per_page` int(11) DEFAULT NULL,
  `posts_per_page` int(11) DEFAULT NULL,
  `messages_per_page` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `nickname`, `full_name`, `email`, `password`, `secret_question`, `secret_answer`, `role_id`, `last_hit`, `inserted`, `updated`, `deleted`, `timezone`, `verification_code`, `remote_addr`, `updated_by`, `deleted_by`, `topics_per_page`, `posts_per_page`, `messages_per_page`) VALUES
(1, 'Joy', 'Stanislav Demchenko', 'angel_of_the_light@zoho.com', '34ebb97d5c634483c2d51bd47e39a724', 'Where are the cookies?', 'Somewhere in system folder', 1, '2017-03-05 13:04:09', NULL, '2017-03-02 08:18:34', NULL, 'America/Boa_Vista', NULL, '127.0.0.1', 1, NULL, NULL, NULL, NULL)
;
CREATE TABLE `users_socials` (
  `user_id` int(11) DEFAULT NULL,
  `social_network_id` int(11) DEFAULT NULL,
  `page_id` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users_socials` (`user_id`, `social_network_id`, `page_id`) VALUES
(1, 2, '115380489639432555966');

ALTER TABLE `forums`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `forum_replies`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `forum_topics`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `social_networks`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `subforums`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `forums`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

ALTER TABLE `social_networks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `subforums`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
