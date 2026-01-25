<?php
// db.php - Connessione a PostgreSQL

$host = "localhost";
$port = "5432";
$dbname = "gruppo26";  // nome del database
$user = "www";
$password = "www";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if(!$conn) {
    die("Connessione fallita: " . pg_last_error());
} else {
    echo "Connessione riuscita!";
}
?>