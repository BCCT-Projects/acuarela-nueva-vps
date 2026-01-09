<?php $classBody = "asistentesList";
include "includes/header.php"; ?>
<main>
    <?php
    $mainHeaderTitle = "Asistentes";
    $action = '<a href="/miembros/acuarela-app-web/agregar-asistente" class="btn btn-action-primary enfasis btn-big">Agregar asistente</a>';
    $videoPath = 'videos/asistentes.mp4';
    include "templates/sectionHeader.php";
    ?>
    <div class="content">
        <div class="emptyElement">
            <h2>No hay Asistentes creados</h2>
            <p>Para agregar un Asistente, haz clic en el botón<strong>"Agregar Asistente"</strong></p>
        </div>
        <ul class="asistentes-list">

        </ul>
    </div>
   
</main>
<?php include "includes/footer.php" ?>