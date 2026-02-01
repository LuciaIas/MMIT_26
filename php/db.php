<?php
$host = "localhost";
$port = "5432";
$dbname = "gruppo26";
$user = "www";
$password = "www";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password") or die('Impossibile connettersi al database: ' . pg_last_error());
?>