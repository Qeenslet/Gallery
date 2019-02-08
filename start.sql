CREATE TABLE `user` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(255) NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `auth_key` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `status` TINYINT(4) NOT NULL DEFAULT '10',
  `created_at` INT(11) NOT NULL,
  `updated_at` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email` (`email`),
  UNIQUE INDEX `username` (`username`)
)
  COLLATE='utf8_general_ci'
ENGINE=InnoDB;

CREATE TABLE `picture` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `filename` VARCHAR(255) NOT NULL,
  `user_id` INT(11) NOT NULL,
  `thumbname` VARCHAR(255) NOT NULL,
  `birthname` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `filename` (`filename`),
  UNIQUE INDEX `thumbname` (`thumbname`),
  INDEX `FK_picture_user` (`user_id`),
  CONSTRAINT `FK_picture_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE
)
  COLLATE='utf8_general_ci'
ENGINE=InnoDB
;