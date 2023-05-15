<?php
$host = 'localhost'; // o la dirección IP del servidor
$dbname = 'lignum';
$username = 'postgres';
$password = '1234';

try {
  $conn = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
  echo "Conexión exitosa";
} catch (PDOException $e) {
  echo "Error de conexión: " . $e->getMessage();
}
