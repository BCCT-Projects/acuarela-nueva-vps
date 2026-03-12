<?php $classBody = "grupos";
include "includes/header.php" ?>
<main>
  <?php
  // FETCH GRUPOS PARA SABER TOTAL
  $gruposArray = $a->getGrupos();
  $totalGrupos = 0;
  if(isset($gruposArray->response)) {
      $totalGrupos = count($gruposArray->response);
  } else if (is_array($gruposArray)) {
      $totalGrupos = count($gruposArray);
  }

  $limitReached = !$isProUser && $totalGrupos >= 3;

  $mainHeaderTitle = "Grupos";
  if ($limitReached) {
      $action = '<button class="btn btn-action-primary enfasis btn-big" disabled style="opacity:0.5; cursor:not-allowed;">Límite LITE alcanzado</button>';
  } else {
      $action = '<a href="/miembros/acuarela-app-web/grupos/nuevo-grupo" class="btn btn-action-primary enfasis btn-big">Crear grupo</a>';
  }
  
  $videoPath = 'videos/grupos.mp4';
  include "templates/sectionHeader.php";
  ?>
  <div class="content">
    <?php if (!$isProUser): ?>
    <div style="background: #E8F7F9; padding: 20px; border-radius: 12px; margin-bottom: 25px; border: 1px solid #0CB5C3;">
        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
            <span style="font-size: 1.25rem; font-weight: bold; color: #140A4C;">Capacidad de grupos (Plan LITE)</span>
            <span style="font-size: 1.25rem; font-weight: bold; color: <?= $limitReached ? '#FA6F5C' : '#0CB5C3' ?>;"><?= $totalGrupos ?> / 3 grupos</span>
        </div>
        <div style="background: #D1D5DB; height: 12px; border-radius: 6px; overflow: hidden; margin-bottom: 15px;">
            <div style="background: <?= $limitReached ? '#FA6F5C' : '#0CB5C3' ?>; height: 100%; width: <?= min(100, ($totalGrupos / 3) * 100) ?>%; transition: width 0.3s;"></div>
        </div>
        <?php if ($limitReached): ?>
            <p style="color: #FA6F5C; margin: 0 0 10px 0; font-weight: bold; font-size: 1.1rem;">Has alcanzado el límite de 3 grupos de tu plan actual.</p>
        <?php endif; ?>
        <p style="margin: 0; font-size: 1.1rem; color: #4A4A68;">
            Para crear grupos ilimitados, mejora tu cuenta. 
            <a href="javascript:;" onclick="document.getElementById('lightbox-finanzas').click();" style="color: #0CB5C3; font-weight: bold; text-decoration: underline;">Conoce el PLAN PRO</a>
        </p>
    </div>
    <?php endif; ?>

    <div class="alertMessage">
      <i class="acuarela acuarela-Informacion"></i>
      <p> Has llegado al número máximo de grupos. Si tu daycare requiere más grupos contáctanos</p>
    </div>
    <div class="emptyElement">
      <h2>Aún no tienes grupos creados</h2>
      <p>Actualmente, no has creado ningún grupo.Haz clic en <strong>Crear grupo</strong></p>
    </div>
    <ul class="list">

    </ul>
  </div>
 
</main>
<?php include "includes/footer.php" ?>