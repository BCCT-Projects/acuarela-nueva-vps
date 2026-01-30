<?php $classBody ="grupo"; include "includes/header.php"; 
$grupo_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
$grupo = ($grupo_id) ? $a->getGrupos($grupo_id) : null;
if (!$grupo) { die("Grupo no encontrado"); }
?>
<script>
    let groupData = <?= json_encode($grupo) ?>;
    groupData.children.forEach(child => {
        console.log("ID del niño:", child.id);
    });

    let kidData = [];
    const requests = groupData.children.map(child =>
    fetch("get/getChildren.php?id=" + child.id)
      .then(response => response.json())
      .then(data => data) // Retorna los datos
      .catch(error => console.error("Error obteniendo datos del niño:", error))
    );

    // Esperar a que todas las peticiones terminen antes de continuar
    Promise.all(requests).then(results => {
      kidData = results; // Guardamos los datos de todos los niños
      console.log("Datos de los niños cargados:", kidData);
      console.log("Cantidad de niños:", kidData.length);
    });
</script>

<main>
  <?php
    $mainHeaderTitle = "{$grupo->name}" ;
    $action = '<a href="/miembros/acuarela-app-web/editar-grupo/'.htmlspecialchars($grupo_id).'" class="btn btn-action-secondary enfasis btn-big">Editar grupo</a>';
    include "templates/sectionHeader.php";
?>
  <div class="content">
    <div class="contentHeader">
      <?php
          // echo 'ID recibido: ' . htmlspecialchars($_GET['id']);
          // echo '<pre>';
          //     var_dump($grupo);
          // echo '</pre>';
      ?>
      <h2>Reporte</h2>
      <button type="button" onclick="showActivityLightbox(false)" class="btn btn-action-primary enfasis btn-big">Agregar actividad</button>
    </div>
    <p>Encontrarás el estado general de las actividades de tu grupo.</p>
    <?php 
      // Mapa de iconos
      $iconMap = array(
        "6088935af169a43504538925" => "acuarela-Alimentacion",
        "60889371f169a43504538926" => "acuarela-Siesta",
        "6088937ff169a43504538927" => "acuarela-Bano",
        "6088939df169a43504538929" => "acuarela-Salud",
        "608893aef169a4350453892a" => "acuarela-Actividades"
      );
      // Mapa de rates
      $ratesMap = array(
        "0" => "#0cb5c3",
        "1" => "#f5aa16",
        "2" => "#eb5d5e"
      );
      // Mapa de rates texts
      $ratesTextMap = array(
        "0" => "¡Excelente! buen trabajo",
        "1" => "El grupo va mejorando",
        "2" => "Hay que trabajar en ello"
      );
      // Asignar iconos
      foreach ($grupo->rates as $activity) {
        $activity->icon = $iconMap[$activity->type];
        $activity->rateColor = $ratesMap[$activity->rate];
        $activity->rateText = $ratesTextMap[$activity->rate];
      }
      // Mostrar la lista de actividades con iconos
      echo '<ul class="activities">';
      foreach ($grupo->rates as $activity) {
          $onclickFunction = ($activity->name === 'Health Check') ? 'showLightboxNinoHealthCkeck()' : 'showActivityLightbox(true)';
        
          echo '<li onclick="' . $onclickFunction . '"><label for="'.$activity->type.'">';
          echo '<button type="button"  class="addActivity"><i class="acuarela acuarela-Agregar"></i></button>';
          echo '<h3>' . $activity->name . '</h3>';
          echo '<i class="acuarela ' . $activity->icon . '"></i>';
          echo '<div class="rate"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="12" fill="'.$activity->rateColor.'" /><path d="M19.5039 7.80688L19.4954 7.80947C19.1862 7.89338 19.0031 8.21602 19.0857 8.53002L19.1479 8.73503C19.1624 8.7826 19.107 8.8198 19.0695 8.78866L18.9239 8.66669C18.8932 8.64074 18.8634 8.61306 18.8327 8.58625C18.636 8.41152 18.3822 8.29388 18.1565 8.23419L18.1531 8.23333C17.9112 8.16326 17.6395 8.16758 17.3456 8.24803C17.183 8.29215 17.0314 8.35183 16.8942 8.42449L16.7435 8.50494L15.9641 5.55094C15.8671 5.18158 15.4931 4.96273 15.1303 5.06221L11.2848 6.10887L11.318 5.9523C11.3334 5.87791 11.341 5.80006 11.3402 5.72221C11.3376 5.61841 11.3214 5.51028 11.2933 5.40129C11.2013 5.05183 11.0225 4.80444 10.7465 4.647C10.4697 4.48871 10.1631 4.45843 9.80793 4.55531C9.68443 4.58905 9.572 4.63316 9.47576 4.68593C9.38036 4.73783 9.29349 4.80011 9.21854 4.87018C9.14529 4.93938 9.08141 5.01982 9.0286 5.11065C8.86507 5.38312 8.83101 5.68501 8.92384 6.03534C8.94769 6.1253 8.98517 6.21959 9.03457 6.31474C9.07971 6.3874 9.13422 6.46006 9.19554 6.53099L9.29775 6.6495L5.4352 7.69962C5.07237 7.79823 4.85604 8.17796 4.95398 8.54646L6.43342 14.1552C6.41383 14.1984 6.39254 14.2417 6.36869 14.2832C6.29459 14.4129 6.2009 14.5306 6.08932 14.6283C5.97519 14.7226 5.84829 14.7892 5.70775 14.8273C5.41136 14.9077 5.15499 14.8766 4.93865 14.7339C4.71806 14.5981 4.5673 14.374 4.48469 14.0626C4.39866 13.7374 4.391 13.4692 4.48043 13.2261C4.53238 13.0852 4.63118 12.9078 4.75298 12.8663C4.84156 12.836 4.94206 12.8222 5.03575 12.8274C5.38836 12.8481 5.32789 12.4096 5.23675 12.189C5.18395 12.0618 5.02638 11.8447 4.85859 11.7721C4.77257 11.7349 4.51194 11.6908 4.24195 11.8136C3.69174 12.0627 3.47114 12.3767 3.26673 12.7244C2.97289 13.2244 2.92945 13.8066 3.09894 14.4484C3.15771 14.6716 3.23351 14.8714 3.3272 15.047C3.42089 15.2235 3.52991 15.3809 3.65596 15.5193C3.78202 15.6577 3.92766 15.7762 4.09204 15.8757C4.57667 16.1758 5.12859 16.2416 5.74778 16.0729C5.91217 16.0279 6.0791 15.9596 6.2503 15.867C6.36698 15.7926 6.48026 15.7079 6.59013 15.6136C6.66423 15.5496 6.71449 15.4734 6.75963 15.3913L7.55172 18.3928C7.64882 18.7622 8.02273 18.981 8.38556 18.8816L12.2592 17.8271L12.2123 18.0477C12.197 18.1221 12.1893 18.1999 12.1902 18.2778C12.1927 18.3816 12.2089 18.4897 12.237 18.5987C12.329 18.9482 12.5079 19.1956 12.7838 19.353C13.0606 19.5113 13.3673 19.5416 13.7224 19.4447C13.8459 19.411 13.9584 19.3668 14.0546 19.3141C14.15 19.2622 14.2369 19.1999 14.3118 19.1298C14.3851 19.0606 14.4489 18.9802 14.5017 18.8894C14.6653 18.6169 14.6993 18.315 14.6065 17.9647C14.5827 17.8747 14.5452 17.7804 14.4958 17.6853C14.4506 17.6126 14.3961 17.5399 14.3348 17.469L14.19 17.3021L18.079 16.2442C18.4426 16.1455 18.6581 15.7658 18.5602 15.3973L17.8507 12.7097L18.0159 12.6985C18.1394 12.6898 18.2672 12.6682 18.3967 12.6328C18.7007 12.5497 18.9511 12.4122 19.1419 12.2236C19.3344 12.0333 19.463 11.8023 19.6334 11.5031L19.7415 11.3084C19.7628 11.2704 19.8173 11.2782 19.8284 11.3197L19.8565 11.4269C19.9391 11.7401 20.2508 11.9425 20.56 11.8646C20.8752 11.785 21.0642 11.4589 20.9799 11.1415L20.21 8.22294C20.1299 7.90895 19.8122 7.72211 19.5039 7.80688ZM9.06353 9.75141C9.16829 9.50748 9.3727 9.32842 9.62481 9.25922C9.87777 9.19089 10.1503 9.23241 10.353 9.40022C10.4578 9.48672 10.4757 9.70211 10.4254 9.77131C10.4041 9.80072 10.3743 9.82061 10.3411 9.82926C10.2977 9.84137 10.2483 9.83359 10.2091 9.80418C10.0745 9.70297 9.90502 9.6701 9.74405 9.71422C9.58307 9.75833 9.45191 9.87251 9.38547 10.0282C9.35141 10.1078 9.26027 10.1441 9.18277 10.1095C9.10526 10.0749 9.00305 9.89241 9.06353 9.75141ZM13.9396 11.5229C14.0623 11.9875 14.1168 12.3361 14.104 12.567C14.0878 12.8075 14.0163 13.0402 13.8885 13.2651C13.7684 13.4874 13.5844 13.682 13.3357 13.8472C13.0998 14.0064 12.7992 14.1361 12.4346 14.2347C12.0718 14.3334 11.7524 14.3731 11.4747 14.3533C11.1903 14.3385 10.9296 14.265 10.6937 14.1335C10.4774 14.0142 10.3045 13.8507 10.1733 13.6448C10.0464 13.4545 9.92121 13.1232 9.796 12.6501L9.42891 11.2565C9.32926 10.8785 9.54986 10.4893 9.92291 10.3881C10.2951 10.2869 10.6784 10.5109 10.778 10.8898L11.1707 12.3767C11.261 12.7175 11.3819 12.9468 11.5352 13.0635C11.6792 13.1915 11.8785 13.221 12.1323 13.1518C12.3835 13.0834 12.5445 12.9589 12.6143 12.7789C12.6842 12.599 12.674 12.3369 12.5837 11.9926L12.191 10.5057C12.0914 10.1277 12.312 9.73844 12.685 9.63723L12.7165 9.62858C13.0887 9.52738 13.472 9.75141 13.5717 10.1303L13.9396 11.5229ZM13.2191 9.01183C13.1978 9.04124 13.168 9.06114 13.1356 9.06979C13.0922 9.0819 13.0428 9.07411 13.0036 9.0447C12.869 8.9435 12.6995 8.91063 12.5385 8.95474L12.507 8.96339C12.346 9.00751 12.2149 9.12169 12.1484 9.27739C12.1144 9.35697 12.0232 9.3933 11.9457 9.3587C11.8674 9.3241 11.7788 9.14677 11.8256 9.00059C11.9057 8.748 12.1348 8.5776 12.3869 8.5084L12.4184 8.49975C12.6714 8.43141 12.9303 8.4911 13.1467 8.64074C13.2761 8.72897 13.2702 8.94177 13.2191 9.01183ZM19.0993 10.8837C18.9801 11.106 18.7799 11.2557 18.4989 11.3326C18.2144 11.4096 17.9691 11.382 17.763 11.247C17.5483 11.1121 17.3993 10.8872 17.3167 10.5723C17.2341 10.26 17.2519 9.98756 17.3703 9.7566C17.4845 9.53257 17.6829 9.38206 17.9648 9.30507C18.2468 9.22808 18.4955 9.26009 18.7109 9.40022C18.9213 9.53084 19.0687 9.75487 19.153 10.0723C19.2356 10.3907 19.2186 10.6614 19.0993 10.8837Z" fill="#FFF" /></svg><span>'.$activity->rateText.'</span></div>';
          echo '</label></li>';
      }
      echo '</ul>';
    ?>
    <h2>Integrantes</h2>
    <?php $children = $grupo->children; ?>
    <section
          class="splide"
          id="integrantes"
          aria-label="Splide Basic HTML Example"
        >
          <div class="splide__track">
            <ul class="splide__list">
            <?php 
              for ($i=0; $i < count($children); $i++) { 
              $kid = $children[$i];
            ?>
              <li class="splide__slide">
              <?php
                $photoUrl = isset($kid->photo) ? 'https://acuarelacore.com/api/' . $kid->photo->formats->small->url : null;
                $gender = $kid->gender;

                if ($photoUrl) {
                    echo "<img src='$photoUrl' alt='{}'>";
                } else {
                    if ($gender === "Masculino") {
                        echo '<img src="img/mal.png" alt="">';
                    } elseif ($gender === "Femenino") {
                        echo '<img src="img/fem.png" alt="">';
                    } elseif ($gender === "X") {
                        echo '<img src="img/Nonbinary.png" alt="">';
                    }
                }
              ?>
                <span><?=$kid->name?></span>
                <a href="/miembros/acuarela-app-web/ninxs/<?=$kid->id?>" class="btn btn-action-primary enfasis btn-small">Ver perfil</a>
              </li>
            <?php } ?>
            </ul>
          </div>
        </section>
   

  </div>
  <?php include "boxes/addActivity.php" ?>
</main>
<?php include "includes/footer.php" ?>