<?php $classBody = "inscripcionesList";
include "includes/header.php" ?>
<main>
  <?php
  // FETCH INSCRIPCIONES PARA SABER TOTAL
  $inscripcionesInfo = $a->getInscripciones();
  $totalInscripciones = 0;
  if(isset($inscripcionesInfo->response)) {
      $totalInscripciones = count($inscripcionesInfo->response);
  } else if (is_array($inscripcionesInfo)) {
      $totalInscripciones = count($inscripcionesInfo);
  }

  $limitReached = !$isProUser && $totalInscripciones >= 16;

  $mainHeaderTitle = "Niñxs agregados";
  if ($limitReached) {
      $action = '<button class="btn btn-action-primary enfasis btn-big" disabled style="opacity:0.5; cursor:not-allowed;">Límite LITE alcanzado</button>';
  } else {
      $action = '<a href="/miembros/acuarela-app-web/agregar-ninx" class="btn btn-action-primary enfasis btn-big">Agregar niñxs</a>';
  }
  
  $videoPath = 'videos/agregar_ninxs.mp4';
  include "templates/sectionHeader.php";
  ?>
  <div class="content">
    <?php if (!$isProUser): ?>
    <div style="background: #E8F7F9; padding: 20px; border-radius: 12px; margin-bottom: 25px; border: 1px solid #0CB5C3;">
        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
            <span style="font-size: 1.25rem; font-weight: bold; color: #140A4C;">Capacidad de niñxs (Plan LITE)</span>
            <span style="font-size: 1.25rem; font-weight: bold; color: <?= $limitReached ? '#FA6F5C' : '#0CB5C3' ?>;"><?= $totalInscripciones ?> / 16 niñxs</span>
        </div>
        <div style="background: #D1D5DB; height: 12px; border-radius: 6px; overflow: hidden; margin-bottom: 15px;">
            <div style="background: <?= $limitReached ? '#FA6F5C' : '#0CB5C3' ?>; height: 100%; width: <?= min(100, ($totalInscripciones / 16) * 100) ?>%; transition: width 0.3s;"></div>
        </div>
        <?php if ($limitReached): ?>
            <p style="color: #FA6F5C; margin: 0 0 10px 0; font-weight: bold; font-size: 1.1rem;">Has alcanzado el límite de 16 niñxs de tu plan actual.</p>
        <?php endif; ?>
        <p style="margin: 0; font-size: 1.1rem; color: #4A4A68;">
            Para agregar niñxs ilimitados, mejora tu cuenta. 
            <a href="javascript:;" onclick="document.getElementById('lightbox-finanzas').click();" style="color: #0CB5C3; font-weight: bold; text-decoration: underline;">Conoce el PLAN PRO</a>
        </p>
    </div>
    <?php endif; ?>

    <div class="emptyElement">
      <h2>No hay Inscripciones creadas</h2>
      <p>Para agregar una inscripción, haz clic en el botón <strong>'Agregar niñxs'</strong></p>
    </div>

    <ul>
    </ul>
  </div>
  
</main>
<?php include "includes/footer.php" ?>