<?php
require_once "dbconnect.php";
$table = "test2";
$sql = "CREATE TABLE IF NOT EXISTS $table (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
firstname VARCHAR(30) NOT NULL,
lastname VARCHAR(30) NOT NULL
)";

if ($con->query($sql) === TRUE) {
    echo "Table MyGuests created successfully";
} else {
    echo "Error creating table: " . $con->error;
}

// $ip_addr = $_SERVER['REMOTE_ADDR'] . (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])? ' from '.$_SERVER['HTTP_X_FORWARDED_FOR']:'');

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
