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
    <div class="navtab" data-target="metodos">Métodos de pago</div>
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
      <?php if(!isset($a->daycareInfo) || !isset($a->daycareInfo->paypal->client_id) || empty($a->daycareInfo->paypal->client_id)){ ?>
      <!-- Sin cuenta Stripe vinculada - Diseño mejorado -->
      <div style="max-width: 550px; margin: 0 auto; padding: 10px;">
        <!-- Card principal con gradiente -->
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 16px; overflow: hidden; margin-bottom: 20px;">
          <div style="padding: 25px; text-align: center;">
            <img src="img/stripeLogo.png?v=1" alt="Stripe" style="height: 35px; filter: brightness(0) invert(1); margin-bottom: 12px;" />
            <h3 style="color: white; margin: 0 0 8px 0; font-size: 1.3rem;">Vincula tu cuenta de Stripe</h3>
            <p style="color: rgba(255,255,255,0.9); margin: 0; font-size: 1rem;">Recibe pagos de los padres directamente en tu cuenta</p>
          </div>
        </div>

        <!-- Mensaje de éxito oculto -->
        <div id="paypal-message" style="display:none; background: #f0fdfa; border: 1px solid #00A099; border-radius: 12px; padding: 20px; text-align: center; margin-bottom: 20px;">
          <p style="font-size: 1.1rem; color: #115e59; margin-bottom: 8px; font-weight: 600;">✓ ¡Vinculación completada!</p>
          <p style="font-size: 1rem; color: #0d9488; margin: 0;">Ya puedes recibir pagos de los padres en Acuarela</p>
        </div>

        <!-- Pasos a seguir -->
        <div style="background: #f8fafc; border-radius: 12px; padding: 20px; margin-bottom: 20px;">
          <h4 style="margin: 0 0 15px 0; color: #1e293b; font-size: 1.1rem; text-align: center;">Pasos para activar pagos:</h4>
          <div style="display: flex; gap: 12px;">
            <div style="flex: 1; text-align: center; padding: 12px 8px; background: white; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
              <div style="background: #667eea; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px auto; font-weight: bold; font-size: 1rem;">1</div>
              <p style="margin: 0; color: #475569; font-size: 0.95rem;">Conecta con Stripe</p>
            </div>
            <div style="flex: 1; text-align: center; padding: 12px 8px; background: white; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
              <div style="background: #667eea; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px auto; font-weight: bold; font-size: 1rem;">2</div>
              <p style="margin: 0; color: #475569; font-size: 0.95rem;">Completa tus datos</p>
            </div>
            <div style="flex: 1; text-align: center; padding: 12px 8px; background: white; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
              <div style="background: #00A099; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px auto; font-size: 1rem;">✓</div>
              <p style="margin: 0; color: #475569; font-size: 0.95rem;">¡Listo!</p>
            </div>
          </div>
        </div>

        <!-- Requisitos -->
        <div style="background: white; border-radius: 10px; padding: 18px; border: 1px solid #e2e8f0; margin-bottom: 20px;">
          <p style="margin: 0 0 12px 0; color: #64748b; font-size: 1rem; font-weight: 600;">📋 Necesitarás:</p>
          <ul style="margin: 0; padding: 0 0 0 20px; color: #64748b; font-size: 1rem; line-height: 1.6;">
            <li style="margin-bottom: 6px;">Cuenta bancaria del daycare</li>
            <li style="margin-bottom: 6px;">Información fiscal (EIN/TIN)</li>
            <li>Dirección comercial</li>
          </ul>
        </div>

        <!-- Botón de conexión -->
        <a class="btn btn-action-primary enfasis btn-big" href="marketplace" style="display: flex; align-items: center; justify-content: center; gap: 10px; width: 100%; padding: 16px; font-size: 1.05rem;">
          <img src="img/stripeLogo.png?v=1" alt="Stripe" style="height: 22px; filter: brightness(0) invert(1);" />
          Conectar con Stripe
        </a>

        <!-- Seguridad -->
        <div style="display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 15px; color: #64748b; font-size: 0.9rem;">
          <svg width="16" height="18" viewBox="0 0 21 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0.144958 7.35383C0.144958 6.22064 0.15 5.08744 0.142437 3.95425C0.138655 3.4359 0.370588 3.24043 0.910084 3.23177C4.2958 3.18105 7.41429 2.32868 10.084 0.190948C10.4218 -0.0799795 10.7055 -0.0515258 11.0345 0.210742C13.6714 2.31383 16.7483 3.16126 20.0887 3.23301C20.5525 3.24291 20.9256 3.27507 20.9433 3.8627C21.0567 7.45033 21.0706 11.0281 20.2676 14.5625C19.7937 16.647 18.7412 18.3691 17.1353 19.7942C15.3189 21.4062 13.3311 22.7732 11.1391 23.8433C10.8718 23.9745 10.4508 24.0623 10.2113 23.9485C7.29832 22.5555 4.65756 20.7852 2.56891 18.3184C1.21513 16.7188 0.748739 14.7629 0.485294 12.7736C0.247059 10.9786 0.156303 9.16621 0 7.36126ZM9.33025 13.4417C8.63949 12.7885 7.98529 12.1848 7.35 11.5625C6.97689 11.1975 6.59244 11.0231 6.14244 11.4041C5.75798 11.7295 5.81218 12.1575 6.27983 12.6301C7.03992 13.3984 7.80378 14.1641 8.57143 14.9262C9.14496 15.4953 9.50294 15.4953 10.0424 14.9163C11.642 13.1967 13.2378 11.4747 14.8311 9.75136C15.2798 9.26517 15.3202 8.82476 14.9244 8.51796C14.463 8.16043 14.0773 8.3361 13.7231 8.72332C12.8811 9.64249 12.029 10.553 11.1794 11.466C10.5592 12.1291 9.93781 12.7909 9.33025 13.4417Z" fill="#64748b"/>
          </svg>
          <span>Pago 100% seguro con SSL</span>
        </div>
      </div>
      <?php }else{ ?>
      <!-- Cuenta Stripe ya vinculada -->
      <div style="max-width: 550px; margin: 0 auto; padding: 10px;">
        <div style="background: linear-gradient(135deg, #00A099 0%, #007a75 100%); border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px rgba(0, 160, 153, 0.4);">
          <div style="padding: 40px; text-align: center;">
            <div style="background: rgba(255,255,255,0.25); border-radius: 50%; width: 70px; height: 70px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px auto; box-shadow: inset 0 2px 4px rgba(255,255,255,0.3);">
              <i class="acuarela acuarela-Verificado" style="font-size: 34px; color: white;"></i>
            </div>
            <img src="img/stripeLogo.png?v=1" alt="Stripe" style="height: 38px; filter: brightness(0) invert(1); margin-bottom: 25px;" />
            <h3 style="color: white; margin: 0 0 12px 0; font-size: 1.6rem; font-weight: bold;">¡Todo listo!</h3>
            <p style="color: rgba(255,255,255,0.95); margin: 0 0 30px 0; font-size: 1.1rem; line-height: 1.5;">Tu cuenta de Stripe está vinculada correctamente y lista para operar.</p>
            <a href="/miembros/acuarela-app-web/finanzas" class="btn btn-action-primary enfasis btn-big" style="background: white; color: #00A099; padding: 16px 30px; font-size: 1.1rem; font-weight: bold; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; gap: 10px; width: 100%; max-width: 300px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); border: none; text-decoration: none;">
              <i class="acuarela acuarela-Finanzas" style="font-size: 22px;"></i> Ir a Finanzas
            </a>
          </div>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
  <div class="legal-links" style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid #e9ecef; text-align: center;">
    <p style="color: #6c757d; font-size: 0.9rem;">
      <a href="/miembros/acuarela-app-web/privacy/coppa" target="_blank" style="color: #667eea; text-decoration: none; margin: 0 1rem;">
        Aviso de Privacidad COPPA
      </a>
      <a href="/miembros/acuarela-app-web/privacy/ferpa.php" target="_blank" style="color: #667eea; text-decoration: none; margin: 0 1rem;">
        Formulario FERPA
      </a>
      <a href="/miembros/acuarela-app-web/privacy/coppa.php#ferpa" target="_blank" style="color: #667eea; text-decoration: none; margin: 0 1rem;">
        Info FERPA
      </a>
    </p>
  </div>
</main>
<?php include "includes/footer.php" ?>
