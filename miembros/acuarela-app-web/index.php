<?php $classBody = "social";
include "includes/header.php" ?>
<main>
  <?php
      $mainHeaderTitle = '<span data-translate="144"></span>';
      $action = '<button class="btn btn-action-primary enfasis btn-big" id="openModalButton"><span data-translate="124">
</span></button>';
      $videoPath = 'videos/muro_social.mp4';
      include "templates/sectionHeader.php";
  ?>
  <div class="content">
    <div class="emptyElement">
      <h2 data-translate="99">No hay post disponibles</h2>
      <p data-translate="100">Para compartir fotos con padres y asistentes, haz clic en el botón <strong>PUBLICAR</strong> </p>
    </div>
    <section class="post-list"></section>
  </div>
  <!-- Modal para crear publicación Prueba-->
  <div id="postModal" class="modal">
    <div class="modal-content">
      <span class="close-button" id="closeModal">&times;</span>
      <h2 data-translate="194">Crear publicación</h2>
      <textarea id="postContent" placeholder="Escribe algo..."></textarea>
      <div class="image-preview" id="imagePreview"></div>
      <button class="btn btn-secondary" id="uploadImageButton">
        <i class="acuarela acuarela-Importar acuarela-24 "></i>
      </button>
      <input type="file" id="imageInput" style="display: none;" accept="image/*" multiple />

      <div id="activitiesContainer">
        <h3 data-translate="195">Vincular publicación a:</h3>
        <div class="activities-list" id="activitiesListContainer"></div>
      </div>

      <button class="btn btn-primary" id="publishButton" data-translate="124">Publicar</button>
    </div>
  </div>
</main>

<?php include "boxes/tour.php" ?>
<?php include "includes/footer.php" ?>