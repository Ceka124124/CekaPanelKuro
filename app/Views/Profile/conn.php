<?php

$servername = "localhost";
$dbname = "zadlrbyg_PRINCE";
$username = "zadlrbyg_PRINCE";
$password = "zadlrbyg_PRINCE";

$conn = mysqli_connect($servername,$username,$password,$dbname);

if(!$conn) {

die(" PROBLEM WITH CONNECTION : " . mysqli_connect_error());

}
  
?>