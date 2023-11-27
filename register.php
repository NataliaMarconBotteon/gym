<?php
session_start();

require_once('util/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  $sql = "INSERT INTO users (name, email, password, type) VALUES ('$name', '$email', '$hashed_password', 'client')";

  if ($conn->query($sql) === TRUE) {
    echo "Usuário inserido com sucesso!";
  } else {
    echo "Erro ao inserir usuário: " . $conn->error;
  }

  $conn->close();
}

?>


<?php include('util/header.php'); ?>
<main class="form-signin w-100 m-auto">
  <form method="post">
    <img class="mb-4" src="assets/bootstrap-logo.svg" alt="" width="72" height="57">
    <h1 class="h3 mb-3 fw-normal">Cadastre-se na plataforma</h1>

    <div class="form-floating mb-2">
      <input name="name" type="string" class="form-control" id="floatingName" placeholder="nome">
      <label for="floatingName">Nome </label>
    </div>
    <div class="form-floating mb-2">
      <input name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">E-mail </label>
    </div>
    <div class="form-floating mb-2">
      <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Senha</label>
    </div>

    <button class="btn btn-primary w-100 py-2" type="submit">Cadastre-se</button>
    <p class="mt-5 mb-3 text-body-secondary">&copy; 2017–2023</p>
  </form>
</main>
<?php include('util/footer.php'); ?>