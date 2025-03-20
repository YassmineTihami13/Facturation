<?php
session_start(); 
session_unset(); 
session_destroy(); 
header("Location: ../IHM/connexion.php");
exit(); 
?>
