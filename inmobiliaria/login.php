<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);
session_start();


$host = 'localhost';
$user = 'root';
$password = '';
$database = 'inmobiliaria';



// Conecta a la base de datos.
$mysqli = new mysqli($host, $user, $password, $database);

// Verifica si hay errores de conexión.
if ($mysqli->connect_error) {
  die('Error de conexión (' . $mysqli->connect_error . ') ' . $mysqli->connect_error);
}

// Verifica si el formulario ha sido enviado.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Obtiene el nombre de usuario y la contraseña enviados por el formulario.
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Escapa las variables para evitar inyección SQL.
  $username = $mysqli->real_escape_string($username);
  $password = $mysqli->real_escape_string($password);

  // Busca el usuario en la base de datos.
  $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
  $result = $mysqli->query($query);

  // Verifica si el usuario existe y si la contraseña es correcta.
  if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();

    // Establece una sesión para el usuario.
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    // Redirige al usuario al archivo HTML correspondiente.
    if ($user['role'] == 'admin') {
      header('Location: admin.html');
    } else {
      header('Location: index.html');
    }
  } else {
    // Si el usuario y la contraseña no son correctos, muestra un mensaje de error.
    $error_message = 'El nombre de usuario o la contraseña son incorrectos.';
  }
}
?>

<!-- login.html -->


<!doctype html>
<html lang="en">

<head>
  <title>
    
  </title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="login.css">
  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
  <header>

    <div class="row">
        <div class="col-4">

        </div>
        <div class="col-4 foto">

            <img src="logoLogin.png" style="width: 130px; margin-left: 40%; margin-top: 5%;">

        </div>
        <div class="col-4">

        </div>
    </div>

    <div class="login-box">
        <h2>LOGIN</h2>
        <form  action="login.php" method="post">
          <div class="user-box">
            <input type="text" name="username" required="" id="username">
            <label>NOMBRE</label>
          </div>
          <div class="user-box">
            <input type="password" name="password" required="" id="password">
            <label>CONTRASEÑA</label>
          </div>
          <button type="submit" style="background-color:transparent;border:0">
          <a >
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            
            ENTRAR
          </a>
        </form>
      </div>


  </header>
  







  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
</body>

</html>

<?php if (isset($error_message)) { ?>
  <p><?php echo $error_message; ?></p>
<?php } ?> 


