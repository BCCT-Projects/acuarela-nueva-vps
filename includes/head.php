<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="img/favicon.ico"/>
    <title>Acuarela | Home</title>
    <meta name="facebook-domain-verification" content="lth8med3qtj6lk9akuvgnovn4u6ysj" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css"
      media="print"
      onload="this.media='all'"
    />
    <noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" /></noscript>
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/fonts.css" />
    <link rel="stylesheet" href="fonts/acuarelaicon/style.css" />
    <link rel="stylesheet" href="css/styles.css?v=<?=time()?>" />
    <link rel="stylesheet" type="text/css" href="./css/glider.css">

<!-- Global site tag (gtag.js) - Google Analytics - Cargado de forma asíncrona -->
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-SD09S4QRP5');
  
  // Cargar el script de forma diferida
  setTimeout(function() {
    var script = document.createElement('script');
    script.async = true;
    script.src = 'https://www.googletagmanager.com/gtag/js?id=G-SD09S4QRP5';
    document.head.appendChild(script);
  }, 1000);
</script>

</head>

<body>
    <!--Facebook pixel code - Cargado de forma diferida -->
    <script>
      // Cargar Facebook Pixel después de que la página esté lista
      window.addEventListener('load', function() {
        setTimeout(function() {
          !function(f,b,e,v,n,t,s)
          {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
          n.callMethod.apply(n,arguments):n.queue.push(arguments)};
          if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
          n.queue=[];t=b.createElement(e);t.async=!0;
          t.src=v;s=b.getElementsByTagName(e)[0];
          s.parentNode.insertBefore(t,s)}(window, document,'script',
          'https://connect.facebook.net/en_US/fbevents.js');
          fbq('init', '924895545109881');
          fbq('track', 'PageView');
        }, 2000);
      });
    </script>
    <noscript>
      <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=924895545109881&ev=PageView&noscript=1"/>
    </noscript>
    <!-- End Facebook Pixel Code -->