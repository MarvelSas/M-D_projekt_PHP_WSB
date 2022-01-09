<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "m-d_projekt_php";



//Utworznie obiektu połączenie od bazy danych
$connect = new mysqli($servername, $username, $password,$dbname);

//Weryfikacja poprawności połączenia do bazy danych
if ($connect->connect_error) {
  die("Błąd połącznia: " . $connect->connect_error);
}



?>