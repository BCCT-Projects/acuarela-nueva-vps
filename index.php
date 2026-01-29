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
          Convierte el servicio de tu daycare en una experiencia 10/100 con la
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




  <!-- SECCIÓN DERECHOS DE PRIVACIDAD (DSAR) -->
  <section class="dsar-section" style="position: relative; overflow: visible; padding: 80px 20px; background: linear-gradient(135deg, #F0F9FF 0%, #FAFCFF 100%);">
    
    <div class="container" style="max-width: 1200px; margin: 0 auto; position: relative; z-index: 2;">
        
        <!-- Título -->
        <div style="text-align: center; margin-bottom: 50px;">
            <h2 style="color: #0CB5C3; font-size: 2.2rem; font-weight: 800; margin: 0 0 15px 0; font-family: 'Outfit', -apple-system, sans-serif;">
                Tus Datos, Tu Control
            </h2>
            <p style="color: #4A4A68; font-size: 1.15rem; line-height: 1.6; max-width: 700px; margin: 0 auto; font-family: 'Outfit', sans-serif;">
                Ejercer tus derechos de privacidad es simple y transparente.
            </p>
        </div>

        <!-- Grid Horizontal de 3 Columnas -->
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 25px; margin-bottom: 45px;">
            
            <!-- Card 1: Acceso -->
            <div class="dsar-card" style="background: white; border-radius: 20px; padding: 35px 25px; box-shadow: 0 8px 25px rgba(12, 181, 195, 0.1); border: 2px solid rgba(12, 181, 195, 0.15); transition: all 0.3s; text-align: center;">
                <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #0CB5C3 0%, #099ca8 100%); border-radius: 18px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; box-shadow: 0 8px 20px rgba(12, 181, 195, 0.25);">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                </div>
                <h3 style="color: #0CB5C3; font-size: 1.3rem; font-weight: 700; margin: 0 0 12px 0; font-family: 'Outfit', sans-serif;">
                    Acceder a tus Datos
                </h3>
                <p style="color: #6B7280; font-size: 1rem; line-height: 1.6; margin: 0; font-family: 'Outfit', sans-serif;">
                    Solicita una copia completa de la información personal que tenemos sobre ti.
                </p>
            </div>

            <!-- Card 2: Corrección -->
            <div class="dsar-card" style="background: white; border-radius: 20px; padding: 35px 25px; box-shadow: 0 8px 25px rgba(113, 85, 164, 0.1); border: 2px solid rgba(113, 85, 164, 0.15); transition: all 0.3s; text-align: center;">
                <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #7155A4 0%, #5a4483 100%); border-radius: 18px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; box-shadow: 0 8px 20px rgba(113, 85, 164, 0.25);">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                </div>
                <h3 style="color: #7155A4; font-size: 1.3rem; font-weight: 700; margin: 0 0 12px 0; font-family: 'Outfit', sans-serif;">
                    Corregir Información
                </h3>
                <p style="color: #6B7280; font-size: 1rem; line-height: 1.6; margin: 0; font-family: 'Outfit', sans-serif;">
                    Actualiza o corrige cualquier dato personal que esté incorrecto o desactualizado.
                </p>
            </div>

            <!-- Card 3: Eliminación -->
            <div class="dsar-card" style="background: white; border-radius: 20px; padding: 35px 25px; box-shadow: 0 8px 25px rgba(250, 111, 92, 0.1); border: 2px solid rgba(250, 111, 92, 0.15); transition: all 0.3s; text-align: center;">
                <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #FA6F5C 0%, #E03E52 100%); border-radius: 18px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; box-shadow: 0 8px 20px rgba(250, 111, 92, 0.25);">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        <line x1="10" y1="11" x2="10" y2="17"></line>
                        <line x1="14" y1="11" x2="14" y2="17"></line>
                    </svg>
                </div>
                <h3 style="color: #FA6F5C; font-size: 1.3rem; font-weight: 700; margin: 0 0 12px 0; font-family: 'Outfit', sans-serif;">
                    Eliminar tus Datos
                </h3>
                <p style="color: #6B7280; font-size: 1rem; line-height: 1.6; margin: 0; font-family: 'Outfit', sans-serif;">
                    Solicita la eliminación permanente de tu información personal de nuestros sistemas.
                </p>
            </div>

        </div>

        <!-- CTA -->
        <div style="text-align: center; background: white; border-radius: 24px; padding: 40px; box-shadow: 0 15px 40px rgba(12, 181, 195, 0.12); border: 2px solid rgba(12, 181, 195, 0.1);">
            <h3 style="color: #111827; font-size: 1.6rem; font-weight: 700; margin: 0 0 12px 0; font-family: 'Outfit', sans-serif;">
                ¿Listo para ejercer tus derechos?
            </h3>
            <p style="color: #6B7280; font-size: 1.1rem; line-height: 1.6; margin: 0 0 25px 0; font-family: 'Outfit', sans-serif;">
                Completa nuestro formulario seguro para procesar tu solicitud.
            </p>
            <a href="/miembros/acuarela-app-web/privacy/dsar.php" class="btn-dsar-main" style="display: inline-flex; align-items: center; gap: 12px; background: linear-gradient(135deg, #0CB5C3 0%, #099ca8 100%); color: white; padding: 16px 40px; font-weight: 700; font-size: 1.15rem; border-radius: 50px; text-decoration: none; box-shadow: 0 10px 25px rgba(12, 181, 195, 0.35); transition: all 0.3s;">
                <span>Iniciar Solicitud</span>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 12h14"></path>
                    <path d="M12 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

    </div>
    
    <style>
        .dsar-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15) !important;
        }
        .btn-dsar-main:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(12, 181, 195, 0.45) !important;
        }
        @media (max-width: 992px) {
            .dsar-section > .container > div:nth-child(2) {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
  </section>

  <!-- SECCIÓN CONTROL PARENTAL (COPPA) -->
  <section class="coppa-section" style="position: relative; overflow: visible; padding: 80px 20px; background: linear-gradient(135deg, #FFF5F5 0%, #FAFCFF 100%);">
    
    <div class="container" style="max-width: 1200px; margin: 0 auto; position: relative; z-index: 2;">
        
        <!-- Título -->
        <div style="text-align: center; margin-bottom: 50px;">
            <h2 style="color: #7155A4; font-size: 2.2rem; font-weight: 800; margin: 0 0 15px 0; font-family: 'Outfit', -apple-system, sans-serif;">
                Protección de Menores (COPPA)
            </h2>
            <p style="color: #4A4A68; font-size: 1.15rem; line-height: 1.6; max-width: 700px; margin: 0 auto; font-family: 'Outfit', sans-serif;">
                Control total sobre los datos de tus hijos según la ley COPPA.
            </p>
        </div>

        <!-- Grid Horizontal de 3 Columnas -->
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 25px; margin-bottom: 45px;">
            
            <!-- Card 1: Cumplimiento -->
            <div class="coppa-card" style="background: white; border-radius: 20px; padding: 35px 25px; box-shadow: 0 8px 25px rgba(113, 85, 164, 0.1); border: 2px solid rgba(113, 85, 164, 0.15); transition: all 0.3s; text-align: center;">
                <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #7155A4 0%, #5a4483 100%); border-radius: 18px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; box-shadow: 0 8px 20px rgba(113, 85, 164, 0.25);">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        <path d="M9 12l2 2 4-4"></path>
                    </svg>
                </div>
                <h3 style="color: #7155A4; font-size: 1.3rem; font-weight: 700; margin: 0 0 12px 0; font-family: 'Outfit', sans-serif;">
                    Cumplimiento COPPA
                </h3>
                <p style="color: #6B7280; font-size: 1rem; line-height: 1.6; margin: 0; font-family: 'Outfit', sans-serif;">
                    Protegemos la información de menores de 13 años según la ley federal.
                </p>
            </div>

            <!-- Card 2: Consentimiento -->
            <div class="coppa-card" style="background: white; border-radius: 20px; padding: 35px 25px; box-shadow: 0 8px 25px rgba(250, 111, 92, 0.1); border: 2px solid rgba(250, 111, 92, 0.15); transition: all 0.3s; text-align: center;">
                <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #FA6F5C 0%, #E03E52 100%); border-radius: 18px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; box-shadow: 0 8px 20px rgba(250, 111, 92, 0.25);">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
                <h3 style="color: #FA6F5C; font-size: 1.3rem; font-weight: 700; margin: 0 0 12px 0; font-family: 'Outfit', sans-serif;">
                    Consentimiento Parental
                </h3>
                <p style="color: #6B7280; font-size: 1rem; line-height: 1.6; margin: 0; font-family: 'Outfit', sans-serif;">
                    Los padres deben autorizar explícitamente la recopilación de información.
                </p>
            </div>

            <!-- Card 3: Revocación -->
            <div class="coppa-card" style="background: white; border-radius: 20px; padding: 35px 25px; box-shadow: 0 8px 25px rgba(12, 181, 195, 0.1); border: 2px solid rgba(12, 181, 195, 0.15); transition: all 0.3s; text-align: center;">
                <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #0CB5C3 0%, #099ca8 100%); border-radius: 18px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; box-shadow: 0 8px 20px rgba(12, 181, 195, 0.25);">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="15" y1="9" x2="9" y2="15"></line>
                        <line x1="9" y1="9" x2="15" y2="15"></line>
                    </svg>
                </div>
                <h3 style="color: #0CB5C3; font-size: 1.3rem; font-weight: 700; margin: 0 0 12px 0; font-family: 'Outfit', sans-serif;">
                    Revocación Inmediata
                </h3>
                <p style="color: #6B7280; font-size: 1rem; line-height: 1.6; margin: 0; font-family: 'Outfit', sans-serif;">
                    Puedes revocar el consentimiento y eliminar datos en cualquier momento.
                </p>
            </div>

        </div>

        <!-- CTA -->
        <div style="text-align: center; background: white; border-radius: 24px; padding: 40px; box-shadow: 0 15px 40px rgba(113, 85, 164, 0.12); border: 2px solid rgba(113, 85, 164, 0.1);">
            <h3 style="color: #111827; font-size: 1.6rem; font-weight: 700; margin: 0 0 12px 0; font-family: 'Outfit', sans-serif;">
                Gestiona el Consentimiento de tus Hijos
            </h3>
            <p style="color: #6B7280; font-size: 1.1rem; line-height: 1.6; margin: 0 0 25px 0; font-family: 'Outfit', sans-serif;">
                Revisa nuestra política COPPA o revoca el consentimiento.
            </p>
            <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center;">
                <a href="/miembros/acuarela-app-web/privacy/coppa.php" class="btn-coppa-outline" style="display: inline-flex; align-items: center; gap: 10px; background: transparent; border: 2px solid #7155A4; color: #7155A4; padding: 14px 32px; font-weight: 700; font-size: 1.1rem; border-radius: 50px; text-decoration: none; transition: all 0.3s;">
                    <span>Ver Política COPPA</span>
                </a>
                <a href="/miembros/acuarela-app-web/privacy/revocation_request.php" class="btn-coppa-main" style="display: inline-flex; align-items: center; gap: 10px; background: linear-gradient(135deg, #FA6F5C 0%, #E03E52 100%); color: white; padding: 14px 32px; font-weight: 700; font-size: 1.1rem; border-radius: 50px; text-decoration: none; box-shadow: 0 10px 25px rgba(250, 111, 92, 0.35); transition: all 0.3s;">
                    <span>Revocar Consentimiento</span>
                </a>
            </div>
        </div>

    </div>
    
    <style>
        .coppa-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15) !important;
        }
        .btn-coppa-outline:hover {
            background: #7155A4 !important;
            color: white !important;
            transform: translateY(-3px);
        }
        .btn-coppa-main:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(250, 111, 92, 0.45) !important;
        }
        @media (max-width: 992px) {
            .coppa-section > .container > div:nth-child(2) {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
  </section>

  <!-- SECCIÓN DERECHOS EDUCATIVOS (FERPA) -->
  <section class="ferpa-section" style="position: relative; overflow: visible; padding: 80px 20px; background: linear-gradient(135deg, #F5F3FF 0%, #FAFCFF 100%);">
    <div class="container" style="max-width: 1200px; margin: 0 auto; position: relative; z-index: 2;">
        <!-- Título -->
        <div style="text-align: center; margin-bottom: 50px;">
            <h2 style="color: #0CB5C3; font-size: 2.2rem; font-weight: 800; margin: 0 0 15px 0; font-family: 'Outfit', -apple-system, sans-serif;">
                Derechos Educativos (FERPA)
            </h2>
            <p style="color: #4A4A68; font-size: 1.15rem; line-height: 1.6; max-width: 760px; margin: 0 auto; font-family: 'Outfit', sans-serif;">
                Solicita acceso a registros educativos del menor o pide correcciones de información inexacta.
            </p>
        </div>

        <!-- Grid Horizontal de 3 Columnas -->
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 25px; margin-bottom: 45px;">

            <!-- Card 1: Acceso -->
            <div class="ferpa-card" style="background: white; border-radius: 20px; padding: 35px 25px; box-shadow: 0 8px 25px rgba(12, 181, 195, 0.1); border: 2px solid rgba(12, 181, 195, 0.15); transition: all 0.3s; text-align: center;">
                <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #0CB5C3 0%, #099ca8 100%); border-radius: 18px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; box-shadow: 0 8px 20px rgba(12, 181, 195, 0.25);">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                </div>
                <h3 style="color: #0CB5C3; font-size: 1.3rem; font-weight: 700; margin: 0 0 12px 0; font-family: 'Outfit', sans-serif;">
                    Acceso a Registros
                </h3>
                <p style="color: #6B7280; font-size: 1rem; line-height: 1.6; margin: 0; font-family: 'Outfit', sans-serif;">
                    Solicita ver o recibir copias de los registros educativos del menor.
                </p>
            </div>

            <!-- Card 2: Corrección -->
            <div class="ferpa-card" style="background: white; border-radius: 20px; padding: 35px 25px; box-shadow: 0 8px 25px rgba(113, 85, 164, 0.1); border: 2px solid rgba(113, 85, 164, 0.15); transition: all 0.3s; text-align: center;">
                <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #7155A4 0%, #5a4483 100%); border-radius: 18px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; box-shadow: 0 8px 20px rgba(113, 85, 164, 0.25);">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 20h9"></path>
                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"></path>
                    </svg>
                </div>
                <h3 style="color: #7155A4; font-size: 1.3rem; font-weight: 700; margin: 0 0 12px 0; font-family: 'Outfit', sans-serif;">
                    Solicitar Corrección
                </h3>
                <p style="color: #6B7280; font-size: 1rem; line-height: 1.6; margin: 0; font-family: 'Outfit', sans-serif;">
                    Pide la corrección/enmienda de registros inexactos o engañosos.
                </p>
            </div>

            <!-- Card 3: Política -->
            <div class="ferpa-card" style="background: white; border-radius: 20px; padding: 35px 25px; box-shadow: 0 8px 25px rgba(250, 111, 92, 0.1); border: 2px solid rgba(250, 111, 92, 0.15); transition: all 0.3s; text-align: center;">
                <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #FA6F5C 0%, #E03E52 100%); border-radius: 18px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; box-shadow: 0 8px 20px rgba(250, 111, 92, 0.25);">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <path d="M14 2v6h6"></path>
                        <path d="M16 13H8"></path>
                        <path d="M16 17H8"></path>
                        <path d="M10 9H8"></path>
                    </svg>
                </div>
                <h3 style="color: #FA6F5C; font-size: 1.3rem; font-weight: 700; margin: 0 0 12px 0; font-family: 'Outfit', sans-serif;">
                    Política FERPA
                </h3>
                <p style="color: #6B7280; font-size: 1rem; line-height: 1.6; margin: 0; font-family: 'Outfit', sans-serif;">
                    Lee qué registros aplican y cómo funciona el proceso FERPA en Acuarela.
                </p>
            </div>
        </div>

        <!-- CTA -->
        <div style="text-align: center; background: white; border-radius: 24px; padding: 40px; box-shadow: 0 15px 40px rgba(12, 181, 195, 0.12); border: 2px solid rgba(12, 181, 195, 0.1);">
            <h3 style="color: #111827; font-size: 1.6rem; font-weight: 700; margin: 0 0 12px 0; font-family: 'Outfit', sans-serif;">
                ¿Necesitas ejercer un derecho FERPA?
            </h3>
            <p style="color: #6B7280; font-size: 1.1rem; line-height: 1.6; margin: 0 0 25px 0; font-family: 'Outfit', sans-serif;">
                Accede a la política y envía tu solicitud desde el formulario oficial.
            </p>
            <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center;">
                <a href="/miembros/acuarela-app-web/privacy/coppa.php#ferpa" class="btn-ferpa-outline" style="display: inline-flex; align-items: center; gap: 10px; background: transparent; border: 2px solid #0CB5C3; color: #0CB5C3; padding: 14px 32px; font-weight: 700; font-size: 1.1rem; border-radius: 50px; text-decoration: none; transition: all 0.3s;">
                    <span>Ver info FERPA</span>
                </a>
                <a href="/miembros/acuarela-app-web/privacy/ferpa.php" class="btn-ferpa-main" style="display: inline-flex; align-items: center; gap: 10px; background: linear-gradient(135deg, #0CB5C3 0%, #099ca8 100%); color: white; padding: 14px 32px; font-weight: 700; font-size: 1.1rem; border-radius: 50px; text-decoration: none; box-shadow: 0 10px 25px rgba(12, 181, 195, 0.35); transition: all 0.3s;">
                    <span>Ir al Formulario FERPA</span>
                </a>
            </div>
        </div>
    </div>

    <style>
        .ferpa-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15) !important;
        }
        .btn-ferpa-outline:hover {
            background: #0CB5C3 !important;
            color: white !important;
            transform: translateY(-3px);
        }
        .btn-ferpa-main:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(12, 181, 195, 0.45) !important;
        }
        @media (max-width: 992px) {
            .ferpa-section > .container > div:nth-child(2) {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
  </section>

  <!-- PREGUNTAS FRECUENTES -->
  <?php include 'faq.php'; ?>

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
