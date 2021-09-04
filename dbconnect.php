<?php

require_once('config.php');

$con = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);


if (mysqli_connect_error()) {
    die("Database connection failed: " . mysqli_connect_error());
}