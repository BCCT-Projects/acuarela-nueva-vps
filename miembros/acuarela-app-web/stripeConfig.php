<?php $classBody = "stripeConfig";
include "includes/header.php";
$a->updateDaycareInfo(['idStripe'=>$_GET["stripeid"]]);
?>
<main>
  <div class="content">
    <img src="img/stripeFinishi.svg" alt="Ilustración de Stripe">
    <div class="text-content">
      <h2>¡Cuenta de Stripe vinculada con éxito!</h2>
      <h3>Tu cuenta de Stripe ya está activa y lista para recibir pagos electrónicos.</h3>
      <p>
        Ahora podrás cobrar directamente a los padres de familia a través de Acuarela.<br>
        <strong>Recuerda:</strong> cada transacción exitosa tiene un costo de <strong>USD 0.50</strong>.
      </p>
      <div class="actions">
        <a href="/miembros/acuarela-app-web/finanzas" class="btn btn-action-primary enfasis btn-big">Realizar prueba de cobro</a>
      </div>
    </div>
  </div>
</main>

<?php include "includes/footer.php" ?>