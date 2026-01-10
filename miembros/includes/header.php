<?php

if (isset($external)) {
    include '../includes/config.php';
} else {
    include 'includes/config.php';
}

$states = array(
    "Alabama",
    "Alaska",
    "Arizona",
    "Arkansas",
    "California",
    "Colorado",
    "Connecticut",
    "Delaware",
    "Florida",
    "Georgia",
    "Hawaii",
    "Idaho",
    "Illinois",
    "Indiana",
    "Iowa",
    "Kansas",
    "Kentucky",
    "Louisiana",
    "Maine",
    "Maryland",
    "Massachusetts",
    "Michigan",
    "Minnesota",
    "Mississippi",
    "Missouri",
    "Montana",
    "Nebraska",
    "Nevada",
    "New Hampshire",
    "New Jersey",
    "New Mexico",
    "New York",
    "North Carolina",
    "North Dakota",
    "Ohio",
    "Oklahoma",
    "Oregon",
    "Pennsylvania",
    "Rhode Island",
    "South Carolina",
    "South Dakota",
    "Tennessee",
    "Texas",
    "Utah",
    "Vermont",
    "Virginia",
    "Washington",
    "West Virginia",
    "Wisconsin",
    "Wyoming"
);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <?php if (isset($external)) { ?>
        <base href="/miembros<?= $base ?>" />
    <?php } else { ?>
        <base href="/miembros/" />
    <?php } ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Portal de usuarios - Bilingual Childcare Taining</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">
    <link rel="stylesheet" href="/miembros/css/styles.css?v=<?= time() ?>" />
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-QHGJX12D97"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-QHGJX12D97', {
            'debug_mode': true
        });
    </script>
    <!-- Google Tag Manager 
      <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':  
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-WDN6LBJ');</script>
     End Google Tag Manager -->
</head>

<body class="priv-zone profile <?= $classBody ?>">
    <!-- Google Tag Manager (noscript) 
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WDN6LBJ"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
 End Google Tag Manager (noscript) -->
    <script>
        let idioma = "";
        let curriculumID = <?= isset($_GET["idcurriculum"]) && !empty($_GET["idcurriculum"]) ? "'" . addslashes($_GET["idcurriculum"]) . "'" : "''" ?>;
        /*if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/service-worker.js')
                    .then((registration) => {
                        console.log('Service Worker registrado con éxito:', registration);
                    })
                    .catch((error) => {
                        console.log('Error al registrar el Service Worker:', error);
                    });
            });
        }*/
    </script>
    <?php if (isset($_SESSION["user"])): ?>
        <script>
            // TEMPORALMENTE DESACTIVADO - Service Worker causaba problemas con CSP
            /*
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('./service-worker.js')
                    .then(() => console.log('Service Worker registrado'))
                    .catch(err => console.error('Error SW:', err));
            }
            */
            // Desregistrar cualquier SW existente
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.getRegistrations().then(function(registrations) {
                    for(let registration of registrations) {
                        registration.unregister();
                    }
                });
            }
        </script>
    <?php endif; ?>
    <div class="bg">
        <img src="/miembros/img/1.png" alt="img1.png" class="img-1">
        <img src="/miembros/img/2.png" alt="img2.png" class="img-2">
        <img src="/miembros/img/3.png" alt="img2.png" class="img-3">
        <img src="/miembros/img/4.png" alt="img2.png" class="img-4">
        <img src="/miembros/img/5.png" alt="img2.png" class="img-5">
    </div>
    <header class="outter">
        <div class="container flex">
            <?php if(isset($_GET['service'])){ ?>
            <?php switch ($_GET['service']) {
                case 'acuarela':
                    echo '<h1><a href="/miembros/acuarela-app-web/"><img src="/miembros/img/logotipo_invertido.svg?v=1" /></a></h1>';
                    break;
                
                default:
                    echo '<h1><a href="/miembros/acuarela-app-web/"><img src="/miembros/img/logomiembros_w.svg" /></a></h1>';
                    break;
                } ?>

            <?php } else{?>
            <h1><a href="/miembros/acuarela-app-web/"><img src="/miembros/img/logomiembros_w.svg" /></a></h1>
            <?php } ?>
            
            <!--<nav>
            <ul><li><a class="uppercase" href=""></a></li></ul>
        </nav>-->
            <div class="useroptions">
                <?php if (isset($_SESSION["user"])) { ?>
                    <div class="row">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21Z"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M12 15C14.0711 15 15.75 13.3211 15.75 11.25C15.75 9.17893 14.0711 7.5 12 7.5C9.92893 7.5 8.25 9.17893 8.25 11.25C8.25 13.3211 9.92893 15 12 15Z"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M5.9812 18.6937C6.54549 17.5822 7.40654 16.6487 8.4689 15.9966C9.53126 15.3446 10.7534 14.9994 12 14.9994C13.2465 14.9994 14.4686 15.3446 15.531 15.9966C16.5934 16.6487 17.4544 17.5822 18.0187 18.6937"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <small><?= $_SESSION["user"]->name ?></small>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19.5 9L12 16.5L4.5 9" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>

                    </div>
                    <ul class="outter">
                        <li><a href="/miembros/acuarela-app-web/">Aplicación</a></li>
                        <li><a href="/miembros/acuarela-app-web/configuracion">Configuración</a></li>
                        <!-- <li><a id="link-open-modal-3">Invitar Usuario</a></li> -->
                        <li><a href="/miembros/cerrar-sesion">Cerrar sesión<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16.3125 8.0625L20.25 12L16.3125 15.9375" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M9.75 12H20.25" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M9.75 20.25H4.5C4.30109 20.25 4.11032 20.171 3.96967 20.0303C3.82902 19.8897 3.75 19.6989 3.75 19.5V4.5C3.75 4.30109 3.82902 4.11032 3.96967 3.96967C4.11032 3.82902 4.30109 3.75 4.5 3.75H9.75"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg></a></li>
                    </ul>
                <?php } ?>
            </div>
        </div>
    </header>
