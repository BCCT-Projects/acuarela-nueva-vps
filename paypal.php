<?php 
include 'includes/config.php';
// Validate and Sanitize Inputs
$idParent = filter_input(INPUT_GET, 'idParent', FILTER_SANITIZE_STRING);
$movementId = filter_input(INPUT_GET, 'movement', FILTER_SANITIZE_STRING);
$merchantId = filter_input(INPUT_GET, 'merchantID', FILTER_SANITIZE_STRING);

if (!$idParent || !$movementId || !$merchantId) {
    die("Invalid request parameters.");
}

$getParent = $a->getParent($idParent);
$getMovement = $a->getMovement($movementId);
?>
<!DOCTYPE html>
<html>
  <head>
  <title>Acuarela | Paypal</title>
  <base href="/">
  <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css"
    />
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/fonts.css" />
    <link rel="stylesheet" href="fonts/acuarelaicon/style.css" />
    <link rel="stylesheet" href="css/styles.css" />
    <link rel="stylesheet" type="text/css" href="./css/glider.css">
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Ensures optimal rendering on mobile devices -->
    <link rel="stylesheet" href="css/styles.css">
    <style>
      main{
        min-height: 100vh;
        display: flex;
        align-items: center;justify-content: center;
        flex-direction: column;
        background: none;
      }
      .data{
        display: flex;
        align-items: center;justify-content: center;
        flex-wrap: wrap;
      }
      .data section {
        flex: 1;
        display: flex;
        align-items: center;justify-content: center;
        flex-direction: column;
      }
      .data section h1{
        margin-bottom: 30px;
      }
      #paypal-button-container{
        width: 100%;
    text-align: center;
      }
      .logo{
        width: 200px;
        margin: 0 auto 50px;
      }
      @media screen and (max-width: 768px) {
        .data{
          flex-direction: column;
        }
      }

    </style>
  </head>

  <body>
    <!-- Include the PayPal JavaScript SDK; replace "test" with your own sandbox Business account app client ID -->
    <script src="https://www.paypal.com/sdk/js?&client-id=AX68Wit8QMjbeWEL1p0HXMEJNaD2zBNahV_km33_CMS-0tfD6RlZneLwbav6qJmw9Yoyv6cs_NdZmby6&merchant-id=<?= htmlspecialchars($merchantId, ENT_QUOTES, 'UTF-8') ?>&currency=USD"></script>
    <main>
  <img src="img/logo.svg" alt="logo" class="logo">
  <div class="data">
  <?php if($getMovement->type == "2"){ ?>
    <section>
      <h1>Tus datos</h1>
      <p><b>Nombre: </b><?=$getParent->name?></p>
      <p><b>Apellido: </b><?=$getParent->lastname?></p>
      <p><b>Daycare: </b><?=$getParent->daycare->name?></p>

    </section>
    <section>
      <h1>Datos de pago</h1>
      <p><b>ID seguimiento del pago: </b><?=$getMovement->id?></p>
      <p><b>Concepto de pago: </b><?=$getMovement->name?></p>
      <p><b>Monto: </b>$<?=number_format($getMovement->amount, 2)?></p>
    </section>
    <div id="paypal-button-container"></div>
    <?php }else{ ?>
      <section>
        <h1>El pago de esta factura  ya fue realizado</h1>
        <p style="text-align:center">Ya puedes cerrar esta ventana y seguir más cerca de tus hijos en Acuarela for Families</p>
      </section>
        <?php } ?>
  

  </div>

</main>

    <!-- Set up a container element for the button -->
    <script>
      paypal.Buttons({

        // Sets up the transaction when a payment button is clicked
        createOrder: function(data, actions) {
          return actions.order.create({
            purchase_units: [{
              amount: {
                value: '1' // Can reference variables or functions. Example: `value: document.getElementById('...').value`
              }
            }]
          });
        },

        // Finalize the transaction after payer approval
        onApprove: function(data, actions) {
          return actions.order.capture().then(function(orderData) {
            console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
            var transaction = orderData.purchase_units[0].payments.captures[0];
            var element = document.getElementById('paypal-button-container');
            element.innerHTML = '';
            element.innerHTML = '<h3>Thank you for your payment!</h3>';

            fetch(`/s/update/?idMovement=<?=$getMovement->id?>`)
            .then(response => response.json())
            .then(result => console.log(result))
            .catch(error => console.log('error', error));
          });
        }
      }).render('#paypal-button-container');

    </script>
  </body>
</html>