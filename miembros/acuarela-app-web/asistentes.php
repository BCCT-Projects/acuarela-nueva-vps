<?php $classBody = "asistentesList";
include "includes/header.php"; ?>
<main>
    <?php
    // FETCH ASISTENTES PARA SABER TOTAL
    $asistentesArray = $a->getAsistentes();
    $totalAsistentes = 0;
    if(isset($asistentesArray->response)) {
        $totalAsistentes = count($asistentesArray->response);
    } else if (is_array($asistentesArray)) {
        $totalAsistentes = count($asistentesArray);
    }

    $limitReached = !$isProUser && $totalAsistentes >= 2;

    $mainHeaderTitle = "Asistentes";
    if ($limitReached) {
        $action = '<button class="btn btn-action-primary enfasis btn-big" disabled style="opacity:0.5; cursor:not-allowed;">Límite LITE alcanzado</button>';
    } else {
        $action = '<a href="/miembros/acuarela-app-web/agregar-asistente" class="btn btn-action-primary enfasis btn-big">Agregar asistente</a>';
    }
    
    $videoPath = 'videos/asistentes.mp4';
    include "templates/sectionHeader.php";
    ?>
    <div class="content">
        <?php if (!$isProUser): ?>
        <div style="background: #E8F7F9; padding: 20px; border-radius: 12px; margin-bottom: 25px; border: 1px solid #0CB5C3;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                <span style="font-size: 1.25rem; font-weight: bold; color: #140A4C;">Capacidad de asistentes (Plan LITE)</span>
                <span style="font-size: 1.25rem; font-weight: bold; color: <?= $limitReached ? '#FA6F5C' : '#0CB5C3' ?>;"><?= $totalAsistentes ?> / 2 asistentes</span>
            </div>
            <div style="background: #D1D5DB; height: 12px; border-radius: 6px; overflow: hidden; margin-bottom: 15px;">
                <div style="background: <?= $limitReached ? '#FA6F5C' : '#0CB5C3' ?>; height: 100%; width: <?= min(100, ($totalAsistentes / 2) * 100) ?>%; transition: width 0.3s;"></div>
            </div>
            <?php if ($limitReached): ?>
                <p style="color: #FA6F5C; margin: 0 0 10px 0; font-weight: bold; font-size: 1.1rem;">Has alcanzado el límite de 2 asistentes de tu plan actual.</p>
            <?php endif; ?>
            <p style="margin: 0; font-size: 1.1rem; color: #4A4A68;">
                Para agregar asistentes ilimitados, mejora tu cuenta. 
                <a href="javascript:;" onclick="document.getElementById('lightbox-finanzas').click();" style="color: #0CB5C3; font-weight: bold; text-decoration: underline;">Conoce el PLAN PRO</a>
            </p>
        </div>
        <?php endif; ?>

        <div class="emptyElement">
            <h2>No hay Asistentes creados</h2>
            <p>Para agregar un Asistente, haz clic en el botón<strong>"Agregar Asistente"</strong></p>
        </div>
        <ul class="asistentes-list">

        </ul>
    </div>
   
</main>
<?php include "includes/footer.php" ?>