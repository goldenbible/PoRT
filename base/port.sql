create table users
(
	id int auto_increment primary key,
	nickname varchar(30),
	full_name varchar(50),
	email varchar(100) unique,
	password varchar(32),
	secret_question varchar(200),
	secret_answer varchar(50),
	last_hit datetime,
	role_id int,
	timezone varchar(50),
	inserted datetime,
	updated datetime,
	updated_by int,
	deleted datetime,
	deleted_by int,
	verification_code varchar(36) unique,
	remote_addr varchar(50),
	google_plus varchar(),
	facebook varchar(),
	topics_per_page int,
	posts_per_page int,
	messages_per_page int
);

create table social_networks
(
	id int auto_increment primary key,
	network_name varchar(50) unique,
	base_url varchar(50) unique
);

insert into social_networks (network_name, base_url) values ('Facebook', 'https://www.facebook.com/'),
	('Google+', 'https://plus.google.com/'), ('Vkontakte', 'https://vk.com/');

create table users_socials
(
	user_id int,
	social_network_id int,
	page_id varchar(100)
);

create table roles
(
		id int auto_increment primary key,
		name varchar(50) unique,
		code varchar(20) unique
);
insert into roles (name, code) values('Administrator', 'admin'), ('Moderator', 'moderator'), ('Programmer', 'programmer'), ('Honored Community Member', 'honored_community_member'), ('Community Member', 'common_community_member');
INSERT INTO `roles` (`id`, `name`, `code`) VALUES ('0', 'Owner', 'owner');

create table forums
(
	id int auto_increment primary key,
	title varchar(50) unique,
	is_read_only bit,
	sort int
);

create table subforums
(
	id int auto_increment primary key,
	forum_id int,
	title varchar(50),
	is_read_only bit,
	sort int
);

create table forum_topics
(
	id int auto_increment primary key,
	subforum_id int,
	title varchar(100),
	post varchar(5000),
	user_id int,
	inserted datetime,
	updated datetime,
	updated_by int,
	deleted datetime,
	deleted_by int,
	closed datetime,
	closed_by int,
	opened_by int,
	pinned datetime,
	pinned_by int,
	unpinned_by int
);

create table forum_replies
(
	id int auto_increment primary key,
	topic_id int,
	entry varchar(5000),
	user_id int,
	inserted datetime,
	updated datetime,
	updated_by int,
	deleted datetime,
	deleted_by int,
);

create table messages
(
	id int auto_increment primary key,
	from_user_id int,
	to_user_id int,
	subject varchar(100),
	message varchar(5000),
	inserted datetime,
	deleted datetime,
	from_deleted datetime,
	to_deleted datetime,
	read bit
);
