--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`name`)
    VALUES  ('user'),
            ('admin'),
            ('superadmin');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`role_id`,`name`,`email`,`password`)
    VALUES  (1,'Common user','test@mail.com','$2y$10$mm2HSgdHcOr2K8jpeE5tCuVUPtMUW0DVy0nlTGbZ0gervFD4tR/qK'),
            (2,'Admin','admin@mail.com','$2y$10$mm2HSgdHcOr2K8jpeE5tCuVUPtMUW0DVy0nlTGbZ0gervFD4tR/qK'),
            (3,'Superadmin','super@mail.com','$2y$10$mm2HSgdHcOr2K8jpeE5tCuVUPtMUW0DVy0nlTGbZ0gervFD4tR/qK');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
