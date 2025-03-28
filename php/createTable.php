<?php

require_once("db_conn.php");

$sql1 = "CREATE TABLE IF NOT EXISTS PetListingTable (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    petName varchar(255) NOT NULL, 
    species ENUM('cats','dogs','kittens','puppies') NOT NULL, 
    age varchar(255) NOT NULL, 
    gender ENUM('male','female') NOT NULL, 
    description varchar(255) NOT NULL, 
    status ENUM('available','pending','adopted') NOT NULL,
    image varchar(255) NOT NULL
    )";

$sql2 = "CREATE TABLE IF NOT EXISTS VolunteerTable (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title varchar(255) NOT NULL,
    requirements varchar(255) NOT NULL,
    description varchar(255) NOT NULL,
    date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    image varchar(255)
    )";

$sql3 = "CREATE TABLE IF NOT EXISTS AdoptionRequestTable (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    petName varchar(255) NOT NULL, 
    adopterName varchar(255) NOT NULL, 
    adopterEmail varchar(255) NOT NULL, 
    adopterPhone varchar(255) NOT NULL, 
    adopterAddress varchar(255) NOT NULL, 
    reasons varchar(255) NOT NULL,
    ownedPetsBefore ENUM('yes','no') NOT NULL, 
    requestDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    status varchar(20) NOT NULL
    )";

$sql4 = "CREATE TABLE IF NOT EXISTS VolunteerApplicationTable (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title varchar(255) NOT NULL,
    volunteerName varchar(255) NOT NULL,
    volunteerEmail varchar(255) NOT NULL,
    volunteerPhone varchar(255) NOT NULL,
    volunteerAddress varchar(255) NOT NULL,
    reasons varchar(255) NOT NULL,
    experienced ENUM('yes','no') NOT NULL,
    applyDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    status varchar(255)
    )";

$sql5 = "CREATE TABLE IF NOT EXISTS User (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL ,
    password VARCHAR(255) NOT NULL ,
    role ENUM('adopter','shelter','admin','volunteer') NOT NULL ,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL
    )";

if (mysqli_query($conn, $sql1)) {
    echo "Table PetListingTable created successfully";
  } else {
    echo "Error creating table: " . mysqli_error($conn);
  }

  if (mysqli_query($conn, $sql2)) {
    echo "Table VolunteerTable created successfully";
  } else {
    echo "Error creating table: " . mysqli_error($conn);
  }

  if (mysqli_query($conn, $sql3)) {
    echo "Table adoptionRequestTable created successfully";
  } else {
    echo "Error creating table: " . mysqli_error($conn);
  }

  if (mysqli_query($conn, $sql4)) {
    echo "Table volunteerApplicationTable created successfully";
  } else {
    echo "Error creating table: " . mysqli_error($conn);
  }

  if (mysqli_query($conn, $sql5)) {
    echo "Table users created successfully";
  } else {
    echo "Error creating table: " . mysqli_error($conn);
  }
  
  mysqli_close($conn);
  ?>