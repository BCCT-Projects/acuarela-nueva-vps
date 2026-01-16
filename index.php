<?php include 'includes/header.php'; ?>

<main class="containerheader">
  <!-- BANNER -->
  <section class="banner">
    <h1 class="banner__title">
      Administra <strong class="banner__title-strong">Tu Daycare Digitalmente</strong> Y Haz Crecer Tu Negocio.
    </h1>

    <div class="banner__content">
      <div class="banner__media">
        <div class="video-container">
          <button type="button" onclick="unMutedVideo()" id="unmutedBtn"><img src="img/volOff.svg" alt="unmuted"
              loading="lazy" /></button>
          <video id="video1" src="<?= $a->generalInfo->acf->video_home ?>" playsinline preload="metadata" autoplay muted
            loop>
            <source src="<?= $a->generalInfo->acf->video_home ?>" type="video/mp4">
          </video>
        </div>
        <div class="pink-square">
          <img class="video__logo" src="img/Logo_AC.png" alt="Acuarela" loading="lazy" />
        </div>
      </div>

      <div class="banner__content-info">
        <h2 class="banner__subtitle">
          Convierte el servicio de tu daycare en una experiencia 10/10 con la
          familia de herramientas digitales Acuarela.
        </h2>
        <div class="banner__buttons">
          <a class="btn btn--primarywhite" href="/planes-precios">
            Crea una cuenta gratis
          </a>
          <button class="btn btn--secondary openModalBtn">
            Obtener un DEMO
          </button>
          <div id="modalOverlay" class="modal-overlay hidden">
            <div class="modal-box">
              <img src="img/Cerrar.svg" alt="Cerrar" id="closeModalBtn" class="close-btn" loading="lazy" />
              <div class="modal-inner">
                <div class="modal-left">
                  <h3>¡Empieza ahora!</h3>
                  <form id="demoForm" class="modal-form">
                    <input type="text" id="nameInput" name="nombre" placeholder="Nombre" required />
                    <input type="text" id="lastnameInput" name="apellidos" placeholder="Apellidos" required />
                    <input type="email" id="emailInput" name="email" placeholder="Email" required />
                    <input type="text" id="daycareInput" name="daycare" placeholder="Daycare" required />
                    <input type="number" name="num_ninos" placeholder="Número de niños" required />
                    <!-- Aquí se inserta el reCAPTCHA de Google -->
                    <!-- <div class="recaptcha-container">
                      <span>
                        <div class="g-recaptcha" data-sitekey="6Lf2KDArAAAAAJ0pKA3IgyQatVKx07cOB-Jjt1DE"></div>
                      </span>
                    </div> -->
                    <button type="submit" id="submitBtn" class="submit-btn">
                      Recibir <span class="bold-text">DEMO</span>
                    </button>
                  </form>
                </div>
                <div class="modal-right">
                  <div>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                      the industry's standard dummy text ever since the 1500s.</p>
                    <img src="img/logo_w.svg" alt="Logo Acuarela" loading="lazy" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CLIENTES -->
  <!-- <section class="clientes__daycares">
    <p class="clientes-title">Con la confianza de</p>
    <img class="logos-daycares" src="img/daycares/GummyBear.png" alt="Acuarela" />
    <img class="logos-daycares" src="img/daycares/JyN.png" alt="Acuarela" />
    <img class="logos-daycares" src="img/daycares/LittleGenius.png" alt="Acuarela" />
    <img class="logos-daycares" src="img/daycares/ManitasFuturo.png" alt="Acuarela" />
    <img class="logos-daycares" src="img/daycares/Nuri.png" alt="Acuarela" />
    <img class="logos-daycares" src="img/daycares/RaisingStars.png" alt="Acuarela" />
  </section> -->

  <!-- FEATURES -->
  <section class="featurespr">
    <div class="features-boxpurple"></div>
    <div class="features-boxmenta"></div>
    <div class="features-boxpollito"></div>
    <div class="features-boxsandia"></div>
    <div class="features-inner">
      <div class="features-parttitle">
        <h2 class="features__title">Un Daycare 10/10 es capaz de:</h2>
        <button class="btn btn--secondary openModalBtn">
          Obtener un DEMO
        </button>
      </div>
      <div class="features-cont">
        <div class="features-cont__feature-feature subs1">
          <div class="feature__image img1">
            <img class="img-feature" src="img/feature-1white.svg"
              alt="Comunicarse fácilmente con personal y padres de familia" loading="lazy" />
          </div>
          <h3 class="feature-titleinfo">Comunicarse fácilmente con personal y padres de familia...</h3>
          <p class="feature-textinfo">
            Ahora la mensajería instantánea, las notificaciones masivas y el muro
            social son parte de un gran servicio. Acuarela te acerca a tus
            asistentes y clientes a un toque de tu tablet preferida.
          </p>
        </div>
        <div class="features-cont__feature-feature subs2">
          <div class="feature__image img2">
            <img class="img-feature" src="img/feature-2white.svg" alt="Conseguir nuevos clientes" loading="lazy" />
          </div>
          <h3 class="feature-titleinfo">Conseguir nuevos clientes</h3>
          <p class="feature-textinfo">
            La red de Daycares Acuarela pone tu negocio en el mapa, permitiendo
            que padres de familia en tu área conozcan tu daycare, instalaciones y
            mucho más.
          </p>
        </div>
        <div class="features-cont__feature-feature subs3">
          <div class="feature__image img3">
            <img class="img-feature" src="img/feature-3white.svg" alt="Usar nuevas formas de brindar seguridad"
              loading="lazy" />
          </div>
          <h3 class="feature-titleinfo">Usar nuevas formas de brindar seguridad</h3>
          <p class="feature-textinfo">
            A manera de red social, Acuarela te permite hacer publicaciones para
            los padres de familia de los niños que cuidas a diario, esto ayuda a
            fortalecer relaciones con ellos y brindar seguridad mientras están en
            sus labores cotidianas.
          </p>
        </div>
        <div class="features-cont__feature-feature subs4">
          <div class="feature__image img4">
            <img class="img-feature" src="img/feature-4white.svg" alt="Gestionar sus finanzas en tiempo récord"
              loading="lazy" />
          </div>
          <h3 class="feature-titleinfo">Gestionar sus finanzas en tiempo récord</h3>
          <p class="feature-textinfo">
            Obtén pagos automatizados vía PayPal, lleva control de Payrolls y
            obtén reportes del estado financiero de tu Daycare en pocos pasos, las
            24 horas del día, los 7 días de la semana.
          </p>
        </div>
      </div>
    </div>
  </section>


  <!-- ADD-ONS -->
  <section class="add__ons" id="nosotros">
    <div class="add__ons__content">
      <img class="adds-image" src="img/add-on1.png" alt="Cobros automáticos y Payrolls fáciles" loading="lazy" />

      <div class="adds-content">
        <div class="adds-content-page type1">
          <div class="page-title">
            <h4>Finanzas</h4>
          </div>
          <div class="page-line tipe1"></div>
          <div class="page-imagebox box1">
            <img src="img/feature-4white.svg" alt="Gestionar sus finanzas en tiempo récord" loading="lazy" />
          </div>
        </div>

        <div class="adds-content-info pri">
          <h3 class="adds-info-title">Cobros automáticos y Payrolls fáciles...</h3>
          <p class="adds-info-text">
            Nuestro sistema de pagos automáticos está listo para facilitar los cobros semanales de tu
            servicio a los padres de familia que son parte de tu Daycare, además, Acuarela te permite hacer
            gestión de tus gastos diarios y el pago periódico a los asistentes que te ayudan con el cuidado
            de niños en tu negocio.
          </p>
          <button class="btn btn--secondary" onclick="window.location.href='/planes-precios'">
            Ver planes y precios
          </button>
        </div>
      </div>
    </div>

    <div class="add__ons__content">
      <div class="adds-content">
        <div class="adds-content-page type2">
          <div class="page-imagebox box2">
            <img src="img/feature-2white.svg" alt="Conseguir nuevos clientes" loading="lazy" />
          </div>
          <div class="page-line tipe2"></div>
          <div class="page-title">
            <h4>Mensajería</h4>
          </div>
        </div>

        <div class="adds-content-info sec">
          <h3 class="adds-info-title">Llega a más clientes sin más esfuerzo...</h3>
          <p class="adds-info-text">
            Los daycares que usan Acuarela , son parte de nuestra red de Daycares, en la cual padres de
            familia de tu región pueden conocer tu servicio, instalaciones y atractivos. Esta red no tiene
            costo adicional y se convertirá en una importante fuente de clientes potenciales para que hagas
            crecer tu negocio desde el día uno.
          </p>
          <button class="btn btn--secondary" onclick="window.location.href='/planes-precios'">
            Ver planes y precios
          </button>
        </div>
      </div>

      <img class="adds-image" src="img/add-on2.png" alt="Llega a más clientes sin más esfuerzo" loading="lazy" />
    </div>

    <div class="add__ons__content">
      <img class="adds-image" src="img/add-on3.png"
        alt="Funciones que te permiten dedicar más tiempo a cuidar y menos a administrar…" loading="lazy" />

      <div class="adds-content">
        <div class="adds-content-page type1">
          <div class="page-title">
            <h4>Gestión</h4>
          </div>
          <div class="page-line tipe1"></div>
          <div class="page-imagebox box3">
            <img src="img/feature-5white.svg" alt="Gestión" />
          </div>
        </div>

        <div class="adds-content-info pri">
          <h3 class="adds-info-title">Funciones que te permiten dedicar más tiempo a cuidar y menos a administrar…...
          </h3>
          <p class="adds-info-text">
            El control de eventos, contratos, documentación, asistentes, fichas de salud, gestión de ingresos / gastos,
            entre otras 40 funciones de administración, te permitirán tener control de tu daycare fácilmente, y
            dedicarte la mayoría de tu tiempo al cuidado del futuro del mundo: los niños.
            Con una inversión mínima y pocos conocimientos de internet, tendrás al alcance de tu tablet un
            sinnúmero de herramientas que llevarán tu Daycare a otro nivel.
          </p>
          <button class="btn btn--secondary" onclick="window.location.href='/planes-precios'">
            Ver planes y precios
          </button>
        </div>
      </div>
    </div>
  </section>


  <!-- TESTIMONIOS -->
  <section class="testimonial__section">
    <div class="testimonial">
      <h2>Testimonios</h2>
      <div class="testimonial__content">
        <img src="img\Flecha_izquierda.png" alt="Desplazar testimonios a la izquierda" loading="lazy" />

        <div class="testimonial__content-view">
          <div class="testimonial__slider-track" id="testimonials-container">
            <!-- Los testimonios se cargarán de forma asíncrona -->
            <div class="loading-testimonials">Cargando testimonios...</div>
          </div>
        </div>

        <img src="img\Flecha_derecha.png" alt="Desplazar testimonios a la derecha" loading="lazy" />
      </div>
    </div>
  </section>


  <!-- PREGUNTAS FRECUENTES -->
  <?php include 'faq.php'; ?>


  <!-- 
  <?php
  $sections = $a->getHomeSections();
  for ($i = 0; $i < count($sections); $i++) {
    $section = $sections[$i];
    ?>
   <?php if ($i % 2 == 0) { ?>
    <section class="add-on add-on--left">
      <img class="add-on__img" src="<?= $section->acf->imagen ?>" />
      <div class="add-on__texts">
        <h2 class="add-on__title">
          <?= $section->title->rendered ?>
        </h2>
        <p class="add-on__description">
        <?= $section->content->rendered ?>
        </p>
        <button
          class="btn btn--primary"
          onclick="window.location.href='/planes-precios'"
        >
          <span class="btn__text"> <?= $section->acf->texto_boton ?> </span>
        </button>
      </div>
    </section>
   <?php } else { ?>
    <section class="add-on">
      <div class="add-on__texts">
        <h2 class="add-on__title">
          <?= $section->title->rendered ?>
        </h2>
        <p class="add-on__description">
        <?= $section->content->rendered ?>
        </p>
        <button
          class="btn btn--primary"
          onclick="window.location.href='/planes-precios'"
        >
          <span class="btn__text"> <?= $section->acf->texto_boton ?> </span>
        </button>
      </div>
      <img class="add-on__img" src="<?= $section->acf->imagen ?>" />
    </section>
   <?php } ?>
   <?php } ?> -->
  <!-- SECCIÓN PRIVACIDAD Y SEGURIDAD (COPPA) - PREMIUM REDESIGN V2 -->
  <section class="privacy-section" style="position: relative; overflow: visible; padding: 100px 20px 120px; background: linear-gradient(180deg, #FFFFFF 0%, #FAFCFF 100%);">
    
    <!-- Decoración de fondo sutil -->
    <div style="position: absolute; top: 15%; left: -120px; width: 400px; height: 400px; background: rgba(113, 85, 164, 0.04); border-radius: 50%; filter: blur(80px); pointer-events: none;"></div>
    <div style="position: absolute; bottom: 5%; right: -80px; width: 300px; height: 300px; background: rgba(12, 181, 195, 0.06); border-radius: 50%; filter: blur(60px); pointer-events: none;"></div>

    <div class="container" style="max-width: 1080px; margin: 0 auto; position: relative; z-index: 2;">
        <div class="privacy-card" style="display: flex; flex-direction: row; align-items: center; gap: 60px; background: white; border-radius: 32px; padding: 60px 70px; box-shadow: 0 25px 60px -15px rgba(20, 10, 76, 0.08); border: 1px solid rgba(255,255,255,0.8);">
            
            <!-- Icono Grande / Ilustración -->
            <div class="privacy-icon-wrapper" style="flex: 0 0 auto;">
                <div style="width: 110px; height: 110px; background: #FFF5F5; border-radius: 28px; display: flex; align-items: center; justify-content: center; transform: rotate(-5deg); box-shadow: 0 10px 30px rgba(250, 111, 92, 0.15);">
                    <!-- Icono Escudo Seguro SVG Inline -->
                    <svg width="58" height="58" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="transform: rotate(5deg);">
                        <path d="M12 22C12 22 20 18 20 12V5L12 2L4 5V12C4 18 12 22 12 22Z" fill="#FA6F5C" fill-opacity="0.1" stroke="#FA6F5C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9 12L11 14L15 10" stroke="#FA6F5C" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>

            <!-- Contenido Texto -->
            <div class="privacy-content" style="flex: 1; text-align: left;">
                <h2 style="color: #7155A4; font-size: 2.3rem; font-weight: 800; margin: 0 0 16px 0; font-family: 'Outfit', -apple-system, sans-serif; letter-spacing: -0.5px; line-height: 1.2;">
                    Control Parental y Privacidad
                </h2>
                <p style="color: #4A4A68; font-size: 1.25rem; line-height: 1.7; margin-bottom: 35px; font-family: 'Outfit', sans-serif; font-weight: 400;">
                    En Acuarela, la seguridad de los niños es innegociable. Cumplimos rigurosamente con la ley <strong>COPPA</strong> y te damos herramientas directas para gestionar o revocar el consentimiento de datos en cualquier momento.
                </p>
                
                <div class="privacy-actions" style="display: flex; flex-wrap: wrap; gap: 20px; align-items: center;">
                     <a href="/miembros/acuarela-app-web/privacy/coppa.php" class="btn-privacy-outline" style="background: transparent; border: 2px solid #0CB5C3; color: #0CB5C3; padding: 14px 32px; font-weight: 700; font-size: 1.1rem; border-radius: 50px; text-decoration: none; transition: all 0.2s;">
                        Ver Política COPPA
                    </a>
                    <a href="/miembros/acuarela-app-web/privacy/revocation_request.php" class="btn-privacy-action" style="background: #FA6F5C; border: 2px solid #FA6F5C; color: white; padding: 14px 32px; font-weight: 700; font-size: 1.1rem; border-radius: 50px; text-decoration: none; box-shadow: 0 8px 20px rgba(250, 111, 92, 0.3); transition: all 0.2s; display: inline-flex; align-items: center;">
                        <span>Solicitar Revocación</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="margin-left: 10px;"><path d="M5 12h14"></path><path d="M12 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>

        </div>
    </div>
    
    <style>
        /* Responsive Fixes */
        @media (max-width: 900px) {
            .privacy-card {
                flex-direction: column !important;
                text-align: center !important;
                padding: 50px 30px !important;
                gap: 40px !important;
            }
            .privacy-content {
                text-align: center !important;
            }
            .privacy-actions {
                justify-content: center;
                width: 100%;
                flex-direction: column;
            }
            .btn-privacy-outline, .btn-privacy-action {
                width: 100%;
                justify-content: center;
                max-width: 350px;
            }
        }
        .btn-privacy-outline:hover {
            border-color: #099ca8 !important;
            color: #099ca8 !important;
            background: #F0FEFF !important;
        }
        .btn-privacy-action:hover {
            background: #E03E52 !important;
            border-color: #E03E52 !important;
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(250, 111, 92, 0.4) !important;
        }
    </style>
  </section>

</main>
<?php include 'includes/footer.php'; ?>

<!-- Scripts movidos al final para no bloquear el renderizado -->
<script>
  // Cargar video de forma lazy
  document.addEventListener('DOMContentLoaded', function () {
    const video = document.getElementById('video1');
    if (video) {
      video.preload = 'auto';
      video.load();
    }

    // Cargar testimonios de forma asíncrona (solo cuando el usuario hace scroll cerca de la sección)
    const testimonialsSection = document.querySelector('.testimonial__section');
    if (testimonialsSection) {
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const container = document.getElementById('testimonials-container');
            if (container && !container.dataset.loaded) {
              container.dataset.loaded = 'true';
              fetch('/g/getTestimonios/')
                .then(response => response.json())
                .then(testimonios => {
                  if (Array.isArray(testimonios) && testimonios.length > 0) {
                    container.innerHTML = testimonios.map((testimonio, i) => `
                      <div class="testimonial__slide">
                        <div class="testimonial__content-video">
                          <img class="testimonials-cont__avatar" src="${testimonio.acf?.imagen || ''}" loading="lazy" alt="${testimonio.title?.rendered || ''}"/>
                        </div>
                        <div class="testimonial__content-info">
                          <div class="imgbox">
                            <img src="img/Heart.svg" alt="Like" />
                          </div>
                          <h3>${testimonio.title?.rendered || ''}</h3>
                          <h4>${testimonio.acf?.cargo || ''}</h4>
                          <p>${testimonio.content?.rendered || ''}</p>
                        </div>
                      </div>
                    `).join('');
                  } else {
                    container.innerHTML = '<p>No hay testimonios disponibles.</p>';
                  }
                })
                .catch(error => {
                  console.error('Error cargando testimonios:', error);
                  container.innerHTML = '<p>No se pudieron cargar los testimonios.</p>';
                });
            }
            observer.unobserve(entry.target);
          }
        });
      }, { rootMargin: '100px' });

      observer.observe(testimonialsSection);
    }
  });
</script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>