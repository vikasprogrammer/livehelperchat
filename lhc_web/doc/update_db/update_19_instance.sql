SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = 'SYSTEM';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `lh_instance`;
CREATE TABLE `lh_instance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `remote_instance_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

ALTER TABLE `lh_departament`
ADD `instance_id` int NOT NULL,
COMMENT='';

ALTER TABLE `lh_users`
ADD `all_instances` tinyint(1) NOT NULL,
COMMENT='';

CREATE TABLE `lh_instance_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `instance_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `instance_id` (`instance_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB;

ALTER TABLE `lh_chat`
ADD `instance_id` int(11) NOT NULL,
COMMENT='';

ALTER TABLE `lh_transfer`
ADD `to_instance_id` int(11) NOT NULL,
COMMENT='';