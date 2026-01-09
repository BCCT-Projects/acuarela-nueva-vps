<?php 
$classBody = "changedaycare";

// Detectar si viene del login
$fromLogin = isset($_GET['fromLogin']);

// Establecer bandera antes de incluir config para evitar auto-selección en SDK
if ($fromLogin) {
    $_SESSION['selecting_daycare'] = true;
    // Agregar clase al body para ajustar el layout cuando no hay sidebar
    $classBody .= " no-sidebar";
}

// Obtener daycares
$daycares = isset($_SESSION["user"]->daycares) ? $_SESSION["user"]->daycares : [];

// Pasar variable a header para ocultar sidebar si viene del login
$hideSidebar = $fromLogin;

include "includes/header.php" ?>
<main>
  <?php
      // Cambiar título si viene del login
      if ($fromLogin) {
          $mainHeaderTitle = 'Selecciona el Daycare';
      } else {
          $mainHeaderTitle = '<span data-translate="196"></span>';
      }
      $action = '';
      include "templates/sectionHeader.php";
  ?>
  <div class="content">
    <?php if (empty($daycares)): ?>
      <div class="no-daycares">
        <p>No tienes daycares asignados. Por favor, contacta al administrador.</p>
      </div>
    <?php else: ?>
      <ul class="listDaycare">
        <?php for ($i=0; $i < count($daycares); $i++) { 
          $daycare = $daycares[$i];
          // Obtener imagen del daycare si existe
          $daycareImage = "img/placeholder.png";
          if (isset($daycare->photo) && !empty($daycare->photo)) {
            $daycareImage = $a->getSmallestImageUrl($daycare->photo);
          } elseif (isset($daycare->image) && !empty($daycare->image)) {
            $daycareImage = $a->getSmallestImageUrl($daycare->image);
          }
        ?>
        <li>
          <a href="s/daycareActive/?daycare=<?=$daycare->id?><?=$fromLogin ? '&fromLogin=1' : ''?>">
            <div class="card w_image lg">
              <div class="card__img">
                <img
                  src="<?=$daycareImage?>"
                  alt="<?=htmlspecialchars($daycare->name)?>"
                  onerror="this.src='img/placeholder.png'">
              </div>
              <div class="card_content">
                <div class="card__header">
                  <div class="card__header-title"><?=htmlspecialchars($daycare->name)?></div>
                </div>
                <div class="card__body">
  
                </div>
              </div>
            </div>
          </a>
        </li>
        <?php } ?>
      </ul>
    <?php endif; ?>
  </div>
</main>

<?php if (!isset($fromLogin) || !$fromLogin): ?>
<?php include "boxes/tour.php" ?>
<?php endif; ?>
<?php 
// Limpiar la bandera después de cargar la página
if (isset($_SESSION['selecting_daycare'])) {
    unset($_SESSION['selecting_daycare']);
}
?>
<?php include "includes/footer.php" ?>