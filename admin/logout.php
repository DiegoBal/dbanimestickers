<?php
session_start();
session_unset($_SESSION['Username']); 
session_unset($_SESSION['Password']); 
session_destroy();
header("Location: ../index.php");
?>