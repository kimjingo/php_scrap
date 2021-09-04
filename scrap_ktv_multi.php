<?php
require_once "dbconnect.php";
$table = "ktvprograms";
$sql = "CREATE TABLE IF NOT EXISTS $table (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
program_name VARCHAR(50) NOT NULL,
title VARCHAR(50) NOT NULL,
link VARCHAR(255) DEFAULT NULL,
channel VARCHAR(20) NOT NULL,
created_at datetime DEFAULT current_timestamp(),
updated_at datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
inactive tinyint,
UNIQUE KEY(program_name, title, link)
)";

if ($con->query($sql) === TRUE) {
    echo "Table MyGuests created successfully";
} else {
    echo "Error creating table: " . $con->error;
}

function crawl_page($url, $depth = 5)
{
    static $seen = array();
    if (isset($seen[$url]) || $depth === 0) {
        return;
    }

    $seen[$url] = true;

    $dom = new DOMDocument('1.0');
    @$dom->loadHTMLFile($url);

    $anchors = $dom->getElementsByTagName('a');
    foreach ($anchors as $element) {
        $href = $element->getAttribute('href');
        if (0 !== strpos($href, 'http')) {
            $path = '/' . ltrim($href, '/');
            if (extension_loaded('http')) {
                $href = http_build_url($url, array('path' => $path));
            } else {
                $parts = parse_url($url);
                $href = $parts['scheme'] . '://';
                if (isset($parts['user']) && isset($parts['pass'])) {
                    $href .= $parts['user'] . ':' . $parts['pass'] . '@';
                }
                $href .= $parts['host'];
                if (isset($parts['port'])) {
                    $href .= ':' . $parts['port'];
                }
                $href .= dirname($parts['path'], 1).$path;
            }
        }
        crawl_page($href, $depth - 1);
    }
    echo "URL:",$url,PHP_EOL,"CONTENT:",PHP_EOL,$dom->saveHTML(),PHP_EOL,PHP_EOL;
}
crawl_page("http://kfoodot.com", 2);

// $ip_addr = $_SERVER['REMOTE_ADDR'] . (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])? ' from '.$_SERVER['HTTP_X_FORWARDED_FOR']:'');

// $curr = time();
// $qry = "SELECT * FROM {$table} ORDER BY id DESC LIMIT 1";
// if($QR = $con->query($qry)){
//   $QD = $QR->fetch_assoc();
//   if( ($QD['created_at'] > ($curr-50) ) && ($QD['ip_addr'] == $ip_addr) ){
//     $message = "Please try again later";
//     // require('contact.php');
//     exit;
//   }
// } else {
//   echo "Error: " . $qry . $con->error;
// }

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
