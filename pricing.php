<?php include 'includes/header.php';
$prices = $a->getPrices();
?>


<main class="containerheader">
  <!-- BANNER -->
  <section class="banner banner--center banner--short">
    <div class="banner__texts">
      <h1 class="banner__titlev2">
        ¡Únete a la nueva era del cuidado infantil y transforma tu daycare!
      </h1>
      <h2 class="banner__subtitle v2">
        Conoce cada uno de nuestros planes diseñado para modernizar y optimizar la gestión de tu centro, 
        brindándote herramientas para mejorar la experiencia de los niños, el bienestar del personal y la confianza 
        de los padres.
      </h2>
    </div>
  </section>

  <!-- PRICING -->
  <!-- <section class="pricing" id="acuarela-services"> -->
  <div class="preloader">
    <div class="loading">
      <img src="img/preloader.gif" alt="Cargando...">
    </div>
  </div>
  <section class="acuarela-services" id="acuarela-services">
    <div id="curriculums-slide-planes-acuarela">
      <div class="desc">
        <!-- <?= $service->acf->{$template}->desc_plan ?> -->
      </div>
      <!-- <div class="switch-container">
        <label class="switch">
          <input type="checkbox" id="frequencySwitch" onchange="toggleFrequencyAcuarela()">
          <span class="slider round"></span>
        </label>
        <span id="frequencyLabelAcuarela">Anual</span>
      </div> -->
      <section class="acuarela-slide">
        <!-- <ul class="bussines-slide" id="prices"> </ul> -->
        <table class="acuarela-bussines-slide" id="services"></table>
      </section>
    </div>

    <!-- <?php for ($i = 0; $i < count($prices); $i++) {
            $price = $prices[$i]; ?>
      <div class="pricing-plan">
        <b class="pricing-plan__name"><?= $price->title->rendered ?></b>
        <h1 class="launch__price"><?= $price->acf->precio ?></h1>
        <h1 class="pricing-plan__price"></h1>
        <hr />
        <?= $price->content->rendered ?>
        <a href="<?= $price->acf->link_de_pago ?>" class="btn btn--primary btn--small">
          <span class="btn__text"><?= $price->acf->texto_boton ?></span>
        </a>
      </div>
    <?php } ?> -->
    <!-- <?php if (!isset($_GET["free"])) { ?>
      <div class="pricing-plan">
        <b class="pricing-plan__name">Suscripción Gratuita</b>
        <h1 class="launch__price">FREE TRIAL</h1>
        <h1 class="pricing-plan__price"></h1>
        <hr />
        <ul class="pricing-plan__features">
          <li>Disfruta del servicio completo por 14 días, luego podrás elegir entre una suscripción mensual o anual.</li>
          <li>
            Gestiona las inscripciones de hasta 16 niños, con sus respectivos
            padres y acudientes
          </li>
          <li>Registra ingreso y salida de niños por medio de QR CODE.</li>
          <li>Administra las finanzas de tu daycare desde tu iPad o tablet</li>
          <li>Administra grupos y sus actividades.</li>
          <li>Gestiona tus precios, horarios y asistentes.</li>
          <li>
            Ofrece a los padres la app móvil de tu guardería para estar en
            constante comunicación.
          </li>
          <li>
            Haz publicaciones del progreso de tus niños a sus padres y familiares.
          </li>
        </ul>
        <a href="/invitaciones" class="btn btn--primary btn--small">
          <span class="btn__text">Obtén tu invitación</span>
        </a>
      </div>
    <?php } ?>
    <div class="pricing-plan">
      <b class="pricing-plan__name">Suscripción mensual</b>
      <h1 class="launch__price">$24.00/mes</h1>
      <h1 class="pricing-plan__price"><s>$29.00/mes</s></h1>
      <hr />
      <ul class="pricing-plan__features">
        <li>
          Gestiona las inscripciones de hasta 16 niños, con sus respectivos
          padres y acudientes
        </li>
        <li>Registra ingreso y salida de niños por medio de QR CODE.</li>
        <li>Administra las finanzas de tu daycare desde tu iPad o tablet</li>
        <li>Administra grupos y sus actividades.</li>
        <li>Gestiona tus precios, horarios y asistentes.</li>
        <li>
          Ofrece a los padres la app móvil de tu guardería para estar en
          constante comunicación.
        </li>
        <li>
          Haz publicaciones del progreso de tus niños a sus padres y familiares.
        </li>
      </ul>
      <button
        class="btn btn--primary btn--small"
        onclick="InitiateCheckout('monthly',21)"
      >
        <a
          href="https://bilingualchildcaretraining.com/checkout/?service=6352aad797a7c9104df3f2fd"
          target="_blank"
        >
          <span class="btn__text">Seleccionar</span>
        </a>
      </button>
    </div>
    <div class="pricing-plan">
      <b class="pricing-plan__name">Ahorra el 10% con una suscripción anual</b>
      <h1 class="launch__price">$259.00/año</h1>
      <h1 class="pricing-plan__price"><s>$315.00/año</s></h1>
      <hr />
      <ul class="pricing-plan__features">
        <li>
          Gestiona las inscripciones de hasta 16 niños, con sus respectivos
          padres y acudientes
        </li>
        <li>Registra ingreso y salida de niños por medio de QR CODE.</li>
        <li>Administra las finanzas de tu daycare desde tu iPad o tablet</li>
        <li>Administra grupos y sus actividades.</li>
        <li>Gestiona tus precios, horarios y asistentes.</li>
        <li>
          Ofrece a los padres la app móvil de tu guardería para estar en
          constante comunicación.
        </li>
        <li>
          Haz publicaciones del progreso de tus niños a sus padres y familiares.
        </li>
      </ul>
      <button
        class="btn btn--primary btn--small"
        onclick="InitiateCheckout('yearly',227)"
      >
        <a
          href="https://bilingualchildcaretraining.com/checkout/?service=6352ab1a97a7c9104df3f300"
          target="_blank"
        >
          <span class="btn__text">Seleccionar</span>
        </a>
      </button>
    </div> -->
  </section>
  <section class="acuarela-services2" id="acuarela-services">
    <div id="curriculums-slide-planes-acuarela">
      <div class="desc">
        <!-- <?= $service->acf->{$template}->desc_plan ?> -->
      </div>
      <!-- <div class="switch-container">
        <label class="switch">
          <input type="checkbox" id="frequencySwitch" onchange="toggleFrequencyAcuarela()">
          <span class="slider round"></span>
        </label>
        <span id="frequencyLabelAcuarela">Anual</span>
      </div> -->
      <section class="acuarela-slide2">
        <!-- <ul class="bussines-slide" id="prices"> </ul> -->
        <div class="acuarela-bussines-slide2" id="services2"></div>
        <div class="acuarela-bussines-slide2" id="servicesPro"></div>
      </section>
    </div>
  </section>


  <!-- Tabla detallando los servicios -->
  <section class="service__table">
    <div class="service__table-header">
      <div></div>
      <div> <h2>Acuarela Lite</h2> </div>
      <div class="pro">
        <h2>Acuarela Pro</h2>
        <img src="img/crown_simple.svg" alt="Pro" />
      </div>
    </div>

    <div class="service__table-list">
      <div class="title-list">
        <h3>Servicio Principal...</h3>
      </div>
      <div class="list-specs">
        <h3>Servicio Especifico...</h3>
        <img class="toggle-btn" src="img/Flecha_izquierdawhite.svg" alt="Pro" />
      </div>
      <ul class="list-deployment">
        <li>
          <p>Info detalada</p>
          <p>Detalles</p>
          <p>Detalles</p>
        </li>
        <li>
          <p>Info detalada</p>
          <p>Detalles</p>
          <p>Detalles</p>
        </li>
      </ul>
    </div>
  </section>


  <section class="service__somos">
    <div class="content-somos">
      <h2>Somos una herramienta potente en el cuidado y administración de tu Daycare</h2>

      <div class="box">
        <div class="feature">
          <div class="feature__imagev2 img3">
            <img class="img-feature" src="img/false.svg" alt="Comunicarse fácilmente con personal y padres de familia" />
          </div>
          <p>Más capacidad, más crecimiento, gestiona inscripciones de hasta 16 niños sin complicaciones.</p>
          <!-- <button
              class="btn btn--secondary"
              onclick="window.location.href='https://bilingualchildcaretraining.com/miembros/crear-cuenta'"
            >
            ¡Conoce más!
          </button> -->
        </div>

        <div class="feature">
          <div class="feature__imagev2 img1">
            <img class="img-feature" src="img/false.svg" alt="Comunicarse fácilmente con personal y padres de familia" />
          </div>
          <p>Más capacidad, más crecimiento, gestiona inscripciones de hasta 16 niños sin complicaciones.</p>
          <!-- <button
              class="btn btn--secondary"
              onclick="window.location.href='https://bilingualchildcaretraining.com/miembros/crear-cuenta'"
            >
            ¡Conoce más!
          </button> -->
        </div>

        <div class="feature">
          <div class="feature__imagev2 img2">
            <img class="img-feature" src="img/false.svg" alt="Comunicarse fácilmente con personal y padres de familia" />
          </div>
          <p>Más capacidad, más crecimiento, gestiona inscripciones de hasta 16 niños sin complicaciones.</p>
          <!-- <button
              class="btn btn--secondary"
              onclick="window.location.href='https://bilingualchildcaretraining.com/miembros/crear-cuenta'"
            >
            ¡Conoce más!
          </button> -->
        </div>
      </div>
    </div>
  </section>


  <!-- PREGUNTAS FRECUENTES -->
  <?php include 'faq.php'; ?>

</main>
<?php include 'includes/footer.php' ?>