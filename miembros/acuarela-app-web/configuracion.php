<?php $classBody ="configuracion"; include "includes/header.php"; ?>
<main>
  <?php
    include "templates/paypalAlert.php";
    $mainHeaderTitle = $_SESSION["userAll"]->name ." ".
  $_SESSION["userAll"]->lastname; $action = ''; $videoPath =
  'videos/editar_perfil.mp4'; include "templates/sectionHeader.php"; ?>
  <div class="navtabs">
    <div class="navtab active" data-target="cuenta">Cuenta</div>
    <div class="navtab" data-target="daycares">Mis Daycares</div>
    <?php if($foundSubscription){ ?>
    <div class="navtab" data-target="metodos">Métodos de pago</div>
    <?php } ?>
    <div class="underline"></div>
  </div>
  <div class="content">
    <div id="cuenta" class="tab-content active">
      <div class="basicinfo">
        <div class="photo">
          <?=isset($_SESSION["userAll"]->photo) && isset($_SESSION["userAll"]->photo->url) ? '<img loading="lazy" class="lazyload"
          src="img/placeholder.png"
          data-src="https://acuarelacore.com/api/'.$_SESSION["userAll"]->photo->url.'"
          alt="profilePhoto" />' : '<img
            loading="lazy"
            class="lazyload"
            src="img/placeholder.png"
            data-src="img/placeholder.png"
            alt="profilePhoto"
          />'?>
        </div>
        <div class="txt">
          <p>
            <i class="acuarela acuarela-Usuario"></i><span>Nombre</span><strong><?=$_SESSION["userAll"]->name ." ".
              $_SESSION["userAll"]->lastname?></strong>
          </p>
          <p>
            <i
              class="acuarela acuarela-Mensajes"></i><span>E-mail</span><strong><?=$_SESSION["userAll"]->email?></strong>
          </p>
          <p>
            <i
              class="acuarela acuarela-Telefono"></i><span>Teléfono</span><strong><?=$_SESSION["userAll"]->phone?></strong>
          </p>
        </div>
        <a href="/miembros/editar-perfil" target="_blank" class="btn btn-action-primary enfasis btn-big">Editar
          perfil</a>
      </div>
    </div>
    <div id="daycares" class="tab-content">
      <div class="emptyElement" style="display: flex">
        <h2>Información de mis daycares</h2>
        <p>Para ver y editar la información de tus daycares ingresa aquí</p>
        <a href="/miembros/acuarela-app-web/" class="btn btn-action-primary enfasis btn-big">Volver a la aplicación</a>
      </div>
    </div>
    <div id="metodos" class="tab-content">
      <?php  if(!isset($a->daycareInfo) || !isset($a->daycareInfo->idStripe) || $a->daycareInfo->idStripe == ""){ ?>
      <div class="container">
        <div id="paypal-message" style="display:none;">
          <p
            style="font-size: 21px;line-height: 27px;align-items: center;color: #140A4C;margin-bottom: 15px;text-align: center;font-weight:bold">
            Tu vinculación a los pagos electrónicos de Stripe está lista
          </p>
          <p
            style="font-size: 14px;line-height: 22px;align-items: center;color: #140A4C;margin-bottom: 15px;text-align: center;">
            ¡Ya puedes recibir pagos de los padres de familia que usen
            Acuarela for Families!
          </p>
        </div>
        <a class="button" href="marketplace">
          <img src="img/stripeLogo.png?v=1" alt="paypal" width="70" />
        </a>
        <div class="icon-container">
          <svg width="21" height="24" viewBox="0 0 21 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_359_24528)">
              <path
                d="M0.144958 7.35383C0.144958 6.22064 0.15 5.08744 0.142437 3.95425C0.138655 3.4359 0.370588 3.24043 0.910084 3.23177C4.2958 3.18105 7.41429 2.32868 10.084 0.190948C10.4218 -0.0799795 10.7055 -0.0515258 11.0345 0.210742C13.6714 2.31383 16.7483 3.16126 20.0887 3.23301C20.5525 3.24291 20.9256 3.27507 20.9433 3.8627C21.0567 7.45033 21.0706 11.0281 20.2676 14.5625C19.7937 16.647 18.7412 18.3691 17.1353 19.7942C15.3189 21.4062 13.3311 22.7732 11.1391 23.8433C10.8718 23.9745 10.4508 24.0623 10.2113 23.9485C7.29832 22.5555 4.65756 20.7852 2.56891 18.3184C1.21513 16.7188 0.748739 14.7629 0.485294 12.7736C0.247059 10.9786 0.156303 9.16621 0 7.36126C0.0478992 7.35878 0.0970588 7.35631 0.144958 7.35383ZM9.33025 13.4417C8.63949 12.7885 7.98529 12.1848 7.35 11.5625C6.97689 11.1975 6.59244 11.0231 6.14244 11.4041C5.75798 11.7295 5.81218 12.1575 6.27983 12.6301C7.03992 13.3984 7.80378 14.1641 8.57143 14.9262C9.14496 15.4953 9.50294 15.4953 10.0424 14.9163C11.642 13.1967 13.2378 11.4747 14.8311 9.75136C15.2798 9.26517 15.3202 8.82476 14.9244 8.51796C14.463 8.16043 14.0773 8.3361 13.7231 8.72332C12.8811 9.64249 12.029 10.553 11.1794 11.466C10.5592 12.1291 9.93781 12.7909 9.33025 13.4417Z"
                fill="#140A4C" />
            </g>
            <defs>
              <clipPath id="clip0_359_24528">
                <rect width="21" height="24" fill="white" />
              </clipPath>
            </defs>
          </svg>
          <div>
            <strong class="text" id="word-113">Pago 100% seguro</strong>
            <p class="text" id="word-153">Tu pago es seguro aquí</p>
          </div>
        </div>
      </div>
      <?php }else{ ?>
      <div class="payment-method stripe-ready">
        <div class="stripe-logo">
          <span class="logo"><img src="img/stripeLogo.png?v=1" alt="paypal" width="70" /></span>
        </div>
        <div class="stripe-text">
          <p class="status"><strong>¡Todo listo!</strong> Ya puedes comenzar a recibir pagos.</p>
          <p class="description">Gestiona tus ingresos desde el panel de finanzas.</p>
          <a href="/miembros/acuarela-app-web/finanzas" class="go-to-finances btn btn-action-primary enfasis btn-big">Ir
            a Finanzas</a>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
</main>
<?php include "includes/footer.php" ?>