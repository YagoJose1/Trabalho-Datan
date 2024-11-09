<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "logados";

$con = mysqli_connect($host, $user, $pass, $db);

if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}

$email = $_POST['email'];
$senha = $_POST['senha'];

$query = "INSERT INTO users (email, senha) VALUES ('$email', '$senha')";

if (mysqli_query($con, $query)) {
  echo "Usuário criado com sucesso!";
} else {
  echo "Erro ao criar o usuário: " . mysqli_error($con);
}

mysqli_close($con);
?>