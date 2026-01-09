<? if (!isset($noFooter)) { ?>
  <footer class="footer">
    <div class="footer__over over">
      <div class="over__texts">
        <h1>¿Ya eres parte de Acuarela?</h1>
      </div>
      <div class="over__buttons">
        <div>
          <h4>Descarga la app para Daycares</h4>
          <button class="btn btn--white btn--big" onclick="trackDownload('appStore')">
            <a href="<?= $a->generalInfo->acf->apps->app_store ?>" target="_blank">
              <img src="img/appStore_available.svg" />
            </a>
          </button>
          <button class="btn btn--white btn--big" onclick="trackDownload('playstore')" target="_blank">
            <a href="<?= $a->generalInfo->acf->apps->play_store ?>">
              <img src="img/playStore_available.svg" />
            </a>

          </button>
        </div>
        <!--<div>
              <h4>Descarga la app para padres</h4>
              <button class="btn btn--white btn--big">
                <img src="img/appStore_available.svg" />
              </button>
              <button class="btn btn--white btn--big">
                <img src="img/playStore_available.svg" />
              </button>
            </div>!-->
      </div>
    </div>
    <div class="footer__body">
      <div>
        <img class="footer__logo" src="img/logo_w.svg" alt="Acuarela" />
        <div class="footer__info">
          <h4>Acuarela</h4>
          <ul class="footer__address">
            <li><?= $a->generalInfo->acf->email ?></li>
            <li><?= $a->generalInfo->acf->phone ?></li>
          </ul>
        </div>
      </div>
      <div>
        <nav class="footer__nav">
          <a href="/">Acuarela</a>
          <a href="sobre-nosotros">Nosotros</a>
          <a href="planes-precios">Planes y Precios</a>
          <a href="preguntas-frecuentes">Preguntas Frecuentes</a>
        </nav>
        <div class="footer__social social">
          <h4>Síguenos en redes sociales</h4>
          <div class="social__logos">
            <a href="<?= $a->generalInfo->acf->social->facebook ?>" target="_blank">
              <img src="img/facebook-icon.png" class="active"></img>
              <img src="img/hover-facebook.png" class="hover"></img>
            </a>
            <a href="<?= $a->generalInfo->acf->social->instagram ?>" target="_blank">
              <img src="img/instagram.svg" class="active"></img>
              <img src="img/instagramy.svg" class="hover"></img>
            </a>

          </div>
        </div>
      </div>
    </div>

    <div class="footer__bottom">
      <span><?= $a->generalInfo->acf->copy_footer ?></span>
      <a href="/politicas">Privacidad, términos y condiciones</a>
    </div>
  </footer>
<? } ?>

<script src="js/jquery.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script src="js/jquery.form.js"></script>
<script src="js/additional-methods.min.js"></script>

<script src="js/jquery.fancybox.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/glider-js@1.7.3/glider.min.js"></script>
<!-- <script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script> -->
<script src="js/jquery.mCustomScrollbar.js"></script>
<!-- <script src="js/main.js"></script> -->
<script src="js/main.js?v=<?= time(); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script><!--Librería para personalizar alertas -->

<!--Javascript file for carousel and burger menu settings-->
<script src="js/app.js"></script>
</body>


</html>