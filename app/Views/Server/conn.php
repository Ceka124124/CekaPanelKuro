<?php

$servername = "localhost";
$dbname = "lrpoaimi_Owner";
$username = "lrpoaimi_Owner";
$password = "lrpoaimi_Owner";

$conn = mysqli_connect($servername,$username,$password,$dbname);

if(!$conn) {

die(" PROBLEM WITH CONNECTION : " . mysqli_connect_error());

}
  
?>