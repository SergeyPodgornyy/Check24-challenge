--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id`          int(32)  NOT NULL        AUTO_INCREMENT,
  `name`        varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `role_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id`          int(32)  NOT NULL        AUTO_INCREMENT,
  `role_id`     int(32)      NULL,
  `name`        varchar(255) NULL,
  `email`       varchar(255) NOT NULL,
  `password`    varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `user_email` (`email`),
  FOREIGN KEY (`role_id`)
    REFERENCES `roles`(`id`)
    ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id`          int(32)         NOT NULL    AUTO_INCREMENT,
  `title`       varchar(255)    NOT NULL,
  `text`        text            NOT NULL,
  `author_id`   int(32)         NOT NULL,
  `created_at`  timestamp       NULL        DEFAULT NULL,
  `updated_at`  timestamp       NULL        DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`author_id`)
    REFERENCES `users`(`id`)
    ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `article_comments`
--

CREATE TABLE IF NOT EXISTS `article_comments` (
  `id`          int(32)         NOT NULL    AUTO_INCREMENT,
  `article_id`  int(32)         NOT NULL,
  `user_id`     int(32)         NULL,
  `name`        varchar(255)    NOT NULL,
  `email`       varchar(255)    NULL,
  `url`         varchar(255)    NULL,
  `ip`          varchar(32)     NULL,
  `text`        text            NOT NULL,
  `created_at`  timestamp       NULL        DEFAULT NULL,
  `updated_at`  timestamp       NULL        DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`article_id`)
    REFERENCES `articles`(`id`)
    ON DELETE CASCADE,
  FOREIGN KEY (`user_id`)
    REFERENCES `users`(`id`)
    ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


