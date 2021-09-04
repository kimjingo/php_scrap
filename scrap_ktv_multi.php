<?php
require_once "dbconnect.php";
$table = "ktvprograms";
$sql = "CREATE TABLE IF NOT EXISTS $table (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `program_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `title` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `channel` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `inactive` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`program_name`,`title`,`link`)
);
// $sql = "CREATE TABLE IF NOT EXISTS $table (
//   `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
//   `program_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '',
//   `title` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '',
//   `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
//   `channel` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
//   `created_at` datetime DEFAULT current_timestamp(),
//   `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
//   `inactive` tinyint DEFAULT NULL,
//   PRIMARY KEY (`id`),
//   UNIQUE KEY `unique` (`program_name`,`title`,`link`)
// ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if ($con->query($sql) === TRUE) {
    echo "Table MyGuests created successfully";
} else {
    echo "Error creating table: " . $con->error;
}

// $ip_addr = $_SERVER['REMOTE_ADDR'] . (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])? ' from '.$_SERVER['HTTP_X_FORWARDED_FOR']:'');
/*
$curr = time();
$qry = "SELECT * FROM {$table} ORDER BY id DESC LIMIT 1";
if($QR = $con->query($qry)){
  $QD = $QR->fetch_assoc();
  if( ($QD['created_at'] > ($curr-50) ) && ($QD['ip_addr'] == $ip_addr) ){
    $message = "Please try again later";
    // require('contact.php');
    exit;
  }
} else {
  echo "Error: " . $qry . $con->error;
}
*/
// $stmt = $con->prepare("INSERT INTO contacts(first_name, last_name, email, division, subject, message, ip_addr) VALUES (?, ?, ?, ?, ?, ?, ?)");
// $stmt->bind_param('sssssss', $first_name, $last_name, $email, $division, $subject, $message, $ip_addr);

// $stmt->execute();


/* using mysqli
  // Include config file
  // Prepare an insert statement
  $ip = $_SERVER['REMOTE_ADDR'];
  $sql = "INSERT INTO users (username, password, ip_addr) VALUES (?, ?, ?)";
  
  if($stmt = mysqli_prepare($link, $sql)){
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password, $ip);
      
      // Set parameters
      $param_username = $username;
      $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
      
      // Attempt to execute the prepared statement
      if(mysqli_stmt_execute($stmt)){
          // Redirect to login page
          header("location: login.php");
      } else{
          // echo $stmt->error;
          echo "Something went wrong. Please try again later.";
      }

      // Close statement
      mysqli_stmt_close($stmt);
  }
  
  mysqli_close($link);
*/
$con->close();
?>
