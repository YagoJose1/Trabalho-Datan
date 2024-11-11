<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "logados";

// Conexão com o banco de dados
$con = mysqli_connect($host, $user, $pass, $db);

// Verificar se a conexão foi bem-sucedida
if (!$con) {
  die("Conexão falhou: " . mysqli_connect_error());
}

// Receber os dados do formulário
$email = $_POST['email'];
$senha = $_POST['senha'];

// Variável para armazenar a mensagem
$message = "";
$messageClass = "";

// Verificar se o email já está cadastrado
$checkEmailQuery = "SELECT * FROM users WHERE email = ?";
$stmt = mysqli_prepare($con, $checkEmailQuery);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Se o email já existir, informar o usuário
if (mysqli_num_rows($result) > 0) {
  $message = "Erro: Este email já está cadastrado.";
  $messageClass = "error"; // Classe CSS para erro
} else {
  // Preparar a consulta para inserir um novo usuário
  $insertQuery = "INSERT INTO users (email, senha) VALUES (?, ?)";
  $stmt = mysqli_prepare($con, $insertQuery);
  mysqli_stmt_bind_param($stmt, "ss", $email, $senha);

  // Executar a consulta e verificar se foi bem-sucedida
  if (mysqli_stmt_execute($stmt)) {
    $message = "Usuário criado com sucesso!";
    $messageClass = "success"; // Classe CSS para sucesso
  } else {
    $message = "Erro ao criar o usuário: " . mysqli_error($con);
    $messageClass = "error"; // Classe CSS para erro
  }
}

// Fechar a consulta e a conexão com o banco de dados
mysqli_stmt_close($stmt);
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro de Usuário</title>
  <link rel="stylesheet" href="../style/mensagem.css">
</head>
<body>

<!-- Exibir a mensagem, se existir -->
<?php if ($message): ?>
  <div class="message <?php echo $messageClass; ?>">
    <?php echo $message; ?>
  </div>
<?php endif; ?>

</body>
</html>
