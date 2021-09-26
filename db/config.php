<?php
   define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'DATABASE USER NAME');
   define('DB_PASSWORD', 'DATABASE USER PASSWORD');
   define('DB_DATABASE', 'DATABASE NAME');
   $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
   // Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
} 

// Add path up to the folder in which you have placed code
define("BASE_URL" , 'http://wastickermaker.iblinfotech.work/');

define("SERVER_PATH" , $_SERVER["DOCUMENT_ROOT"] );
?>