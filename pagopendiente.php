<?php

$curl = curl_init();

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
if (!$id) { die("ID required"); }

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://acuarelacore.com/api/movements/'. $id,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'token: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJtYWlsIjoiZGFuaXpxdWkyM0BnbWFpbC5jb20iLCJpZCI6IjYyNWY0MDMxNzE2MzE2ZDgxZGI4ZDkyMCIsIm5hbWUiOiJEYW5pZWxhIiwicGhvbmUiOiIzMTI0NTcyNzc3IiwiaWF0IjoxNjUxMDI2OTI3LCJleHAiOjE2NTEyODYxMjd9.hXH9Hx4ctmY4RfRqNn8zAbUIaSl2mIrqbSjV_lRpWLo'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
$response = json_decode($response);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="img/favicon.ico" />
    <title>Acuarela | Home</title>
    <base href="/" />
    <meta
      name="facebook-domain-verification"
      content="lth8med3qtj6lk9akuvgnovn4u6ysj"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css"
    />
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/fonts.css" />
    <link rel="stylesheet" href="css/styles.css" />
  </head>
  <body class="autoPays">
    <div
      class="left"
      style="
        background-image: url(https://images.pexels.com/photos/4482900/pexels-photo-4482900.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940);
      "
    ></div>
    <div class="right">
      <div class="content">
        <?php if($response->estado === "0"){ ?>
          <h2>Pagos Pendiente</h2>
          <p>
          <b>Estado:</b><?= $response->estado === '0' ? 'Pendiente' : ''?>
          </p>
          <p><b>Total a pagar:</b> $<?= $response->amount ?></p>
          <p><b>Nombre del niño:</b> <?= $response->child->name ?> <?= $response->child->lastname ?></p>
          <p><b>Daycare:</b> <?= $response->daycare->name ?></p>
          <p><b>Nombre de quien paga:</b> <?= $response->payer->name ?> <?= $response->payer->lastname ?></p>        
          <div id="paypal-button-container"></div>
        <?php }else{ ?>
          <h2>El pago de esta factura  ya fue realizado</h2>
          <p style="text-align:center">Ya puedes cerrar esta ventana y seguir más cerca de tus hijos en Acuarela for Families</p>
        <?php } ?>
      </div>
    </div>
        <!-- Sample PayPal credentials (client-id) are included -->
        <script src="https://www.paypal.com/sdk/js?client-id=AX68Wit8QMjbeWEL1p0HXMEJNaD2zBNahV_km33_CMS-0tfD6RlZneLwbav6qJmw9Yoyv6cs_NdZmby6&currency=USD&intent=capture"></script>
        <script>
          const paypalButtonsComponent = paypal.Buttons({
              // optional styling for buttons
              // https://developer.paypal.com/docs/checkout/standard/customize/buttons-style-guide/
              style: {
                color: "gold",
                shape: "rect",
                layout: "vertical"
              },

              // set up the transaction
              createOrder: (data, actions) => {
                  // pass in any options from the v2 orders create call:
                  // https://developer.paypal.com/api/orders/v2/#orders-create-request-body
                  const createOrderPayload = {
                      purchase_units: [
                          {
                            "reference_id": "REFID-<?=$response->payer->id?>",
                              amount: {
                                  value: <?= $response->amount ?>
                              }
                          }
                      ]
                  };

                  return actions.order.create(createOrderPayload);
              },

              // finalize the transaction
              onApprove: (data, actions) => {
                  const captureOrderHandler = (details) => {
                      const payerName = details.payer.name.given_name;
                      console.log('Transaction completed');
                      console.log(details);
                  };

                  return actions.order.capture().then(captureOrderHandler);
              },

              // handle unrecoverable errors
              onError: (err) => {
                  console.error('An error prevented the buyer from checking out with PayPal');
              }
          });

          paypalButtonsComponent
              .render("#paypal-button-container")
              .catch((err) => {
                  console.error('PayPal Buttons failed to render');
              });
        </script>
  </body>
</html>
