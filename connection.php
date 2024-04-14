<?php
   $server = 'localhost';
   $user = 'root';
   $pass = '';
   $dbname = 'stamatis';
   
$con = mysqli_connect($server,$user,$pass,$dbname);

// Έλεγχος επιτυχούς σύνδεσης με τη βάση 

if(!$con)
	die("Η Βάση αντιμετώπισε κάποιο σφάλμα !!!");
else
mysqli_select_db($con, $dbname);

mysqli_set_charset($con,'utf8');
?>