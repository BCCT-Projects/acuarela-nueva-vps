<?php
if (!isset($show_preloader)) {
    $show_preloader = true; // Valor por defecto
}
include 'soporte.php';
?>

<?php if ($show_preloader): ?>
<div class="preloader">
  <img src="/miembros/img/finalpreloader.gif" alt="Logo">
  <h2></h2>
</div>
<?php endif; ?>

<footer>
  <img src="/miembros/img/logos/logo_oscuro.svg" alt="logo" class="logo">
  <div class="menu">
    <small>Bilingual Childcare Training Ⓒ <?php echo date("Y"); ?></small>
    <nav>
      <a href="/privacidad-terminos-condiciones" target="_blank">PRIVACIDAD ,TÉRMINOS Y CONDICIONES</a>
    </nav>
  </div>
</footer>
</body>
<script src="/miembros/js/jquery.js"></script>
<script src="/miembros/js/jquery.validate.min.js"></script>
<script src="/miembros/js/additional-methods.min.js"></script>
<script src="/miembros/js/jquery.form.js"></script>
<script src="/miembros/js/foodai.js?v=<?= time() ?>"></script>
<script src="//cdn.jsdelivr.net/npm/desvg@1.0.2/desvg.min.js"></script>
<script src="/miembros/js/main.js?v=<?= time() ?>"></script>
<script src="/miembros/js/googleAnalytics.js?v=<?= time(); ?>"></script>
<!--<script src="js/googleMaps.js?v="></script>
<script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAw2qBynYleldgejZ6JGPjXpkoDMhabqis&libraries=places&callback=initAutocomplete"></script>-->
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>


<script>
  if (document.querySelector("#phone")) {
    const input = document.querySelector("#phone");
    const input2 = document.querySelector("#phonedaycare");
    window.intlTelInput(input, {
      utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js",
    });
    window.intlTelInput(input2, {
      utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js",
    });
  }
</script>

<script>
 const paramKeys = ["service", "redirect_url"];
    const url = new URL(window.location);

    // Guardar los parámetros si están en la URL o recuperarlos del sessionStorage
    const queryParams = {};
    paramKeys.forEach(key => {
        let value = url.searchParams.get(key);
        if (value) {
            sessionStorage.setItem(key, value);
        } else {
            value = sessionStorage.getItem(key);
        }
        if (value) {
            queryParams[key] = value;
        }
    });

    // Agregar o actualizar parámetros en la URL sin recargar
    function addOrUpdateQueryParam(key, value) {
        url.searchParams.set(key, value);
        window.history.pushState({}, '', url);
    }

    // Asegurar que los parámetros estén presentes en la URL
    Object.entries(queryParams).forEach(([key, value]) => {
        addOrUpdateQueryParam(key, value);
    });

    // Cambiar el logo si existe el parámetro `service` (opcional, según tu lógica original)
    if (queryParams["service"]) {
      
        document.querySelector("header").style.backgroundColor = `#0cb5c3`;
        document.querySelector("header h1 a img").src = `/miembros/img/logotipo_invertido.svg`;
        document.querySelector("footer .logo").src = `/miembros/img/logotipo_color.svg`;
        document.querySelector(".login main form a.link.register").href = `https://acuarela.app/planes-precios`;
    }

</script>

</html>