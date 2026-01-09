<?php
 session_start();
  include "includes/sdk.php";
  $a = new Acuarela();
  $a->updateDaycareInfo(['idStripe'=>$_GET["id"]]);
$test = isset($_GET['test']);
$url = $test
    ? 'exp://192.168.1.4:8081/--/configuration/pagosSuccess?status=success'
    : 'com.idt.bogota-app://configuration/pagosSuccess?status=success';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Redirigiendo a la app...</title>
  <meta http-equiv="refresh" content="2; url=<?= $url ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      background: #f0feff;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #333;
      margin: 0;
    }

    .container {
      background: #fff;
      padding: 2rem 3rem;
      border-radius: 1rem;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      text-align: center;
      max-width: 400px;
    }

    h1 {
      font-size: 1.5rem;
      margin-bottom: 1rem;
    }

    p {
      font-size: 1rem;
      margin-bottom: 1rem;
    }

    a {
      color: #0cb5c3;
      text-decoration: none;
      font-weight: bold;
    }

    a:hover {
      text-decoration: underline;
    }

    .status {
      font-size: 0.9rem;
      color: #888;
      margin-top: 1rem;
    }
  </style>
</head>
<body>
  <div class="container">
    <img src="https://bilingualchildcaretraining.com/design-system-acuarela/img/logos/logotipo_color.svg" alt="logo" width="180">
    <h1>Redirigiendo a la app...</h1>
    <p>Si no eres redirigido automáticamente,<br>
    <a href="<?= $url ?>">haz clic aquí</a>.</p>
    <div class="status">
      Entorno: <strong><?= $test ? 'Desarrollo' : 'Producción' ?></strong>
    </div>
  </div>
</body>
</html>
