<?php

include ('connection.php');

ini_set('memory_limit', '-1');

// sql to create table
$sql1 = "CREATE TABLE `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(100) NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `username` VARCHAR(100) NOT NULL,
  `password` VARCHAR(100) NOT NULL,
  `phone_number` VARCHAR(100) NOT NULL,
  `gender` VARCHAR(100) NOT NULL,
  `is_active` INT(11) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),
  PRIMARY KEY (id)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4;
";

if (mysqli_query($conn, $sql1)) {
  echo "Table users created successfully";
} else {
  echo "Error creating table: " . mysqli_error($conn);
}



$sql1 = "CREATE TABLE `upload_songs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `song_title` varchar(100) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `file_format` varchar(100) NOT NULL,
  `is_active` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";

if (mysqli_query($conn, $sql1)) {
  echo "Table upload_songs created successfully";
} else {
  echo "Error creating table: " . mysqli_error($conn);
}

mysqli_close($conn);
