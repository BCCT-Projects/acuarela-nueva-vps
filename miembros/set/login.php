<?php
  include '../includes/config.php';

  // Normaliza los datos
  $email = strtolower(trim($_POST['email']));
  $password = $_POST['password'];

  $_SESSION["estanoesunacontrasena"] = $password;
  $userLogin = $a->loginBilingualUser($email, $password);

  // Asegurar que los daycares estén disponibles en la respuesta
  // Si $userLogin tiene estructura response[0], extraer el objeto
  if (isset($userLogin->response) && is_array($userLogin->response) && !empty($userLogin->response)) {
      $userLogin = $userLogin->response[0];
  }
  
  // Los daycares deberían estar en $_SESSION["user"] después del login
  // Verificar diferentes estructuras posibles
  if (!isset($userLogin->daycares) || empty($userLogin->daycares)) {
      // Intentar obtener de la sesión directamente
      if (isset($_SESSION["user"]->daycares) && !empty($_SESSION["user"]->daycares)) {
          $userLogin->daycares = $_SESSION["user"]->daycares;
      } 
      // Si la sesión tiene estructura response
      elseif (isset($_SESSION["user"]->response) && is_array($_SESSION["user"]->response) && !empty($_SESSION["user"]->response)) {
          $sessionUser = $_SESSION["user"]->response[0];
          if (isset($sessionUser->daycares) && !empty($sessionUser->daycares)) {
              $userLogin->daycares = $sessionUser->daycares;
          }
      }
      // Si aún no tiene, intentar desde userInfoAll
      elseif (isset($_SESSION["userAll"]->daycares) && !empty($_SESSION["userAll"]->daycares)) {
          $userLogin->daycares = $_SESSION["userAll"]->daycares;
      }
  }

  echo json_encode($userLogin);

