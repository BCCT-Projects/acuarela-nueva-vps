<?php $classBody = "addWidgets";
include $_SERVER['DOCUMENT_ROOT'] . "/miembros/acuarela-app-web/includes/header.php"; ?>
<main>
    <?php
    $mainHeaderTitle = "Dashboard";
    $action = '
    <a href="/miembros/acuarela-app-web/inspeccion" class="btn btn-action-secondary enfasis btn-big">Cancelar</a>
    <a href="/miembros/acuarela-app-web/inspeccion" class="btn btn-action-primary enfasis btn-big">Agregar</a>
    ';
   include $_SERVER['DOCUMENT_ROOT'] . "/miembros/acuarela-app-web/templates/sectionHeader.php";
    ?>
    <?php 
$listWidgets = [
    [
        "name" => "Social",
        "desc" => "Mantente al tanto del impacto de tus publicaciones en la comunidad del daycare. Consulta las reacciones, comentarios y compartidos en un vistazo rápido.",
        "icon" => "Anadir_reaccion",
        "color" => "var(--cielo)"
    ],
    [
        "name" => "Niñxs inscritos",
        "desc" => "Mantén un control del total de niños inscritos en el daycare. Consulta la cantidad actual, nuevos ingresos y distribuciones por edad o grupo.",
        "icon" => "Formulario",
        "color" => "var(--pollito)"
    ],
    [
        "name" => "Asistencia niñxs",
        "desc" => "Consulta rápidamente la asistencia de los niños en el daycare. Visualiza cuántos han asistido, cuántos faltaron y las tendencias en asistencia durante el periodo seleccionado.",
        "icon" => "Asistencia",
        "color" => "var(--morita)"
    ],
    [
        "name" => "Asistentes inscritos",
        "desc" => "Visualiza el número total de asistentes en el daycare, su estado y funciones. Lleva un control de nuevos ingresos y cambios en el personal.",
        "icon" => "Asistente",
        "color" => "var(--sandia)"
    ],
    [
        "name" => "Asistencia Personal",
        "desc" => "Lleva un control detallado de la asistencia del personal del daycare. Consulta registros de entrada y salida, identifica retrasos y analiza la puntualidad de los asistentes.",
        "icon" => "Checklist",
        "color" => "var(--secundario1)"
    ]
];
?>

    <div class="content">
        <h3>¡Elige el widget que deseas agregar al dashboard!</h3>
        <ul class="listWidgets">
            <?php for ($i=0; $i < count($listWidgets ); $i++) { $widget = $listWidgets[$i]; ?>
            <li>
                <div class="card w_image lg">
                    <div class="card__img" style="background-color:<?=$widget['color']?>">
                        <i class="acuarela acuarela-<?=$widget['icon']?>"></i>
                    </div>
                    <div class="card_content">
                        <div class="card__header">
                            <div class="card__header-title">
                                <?=$widget['name']?>
                            </div>
                            <div class="card__header-actions">
                                <a href=""><i class="acuarela acuarela-Ver"></i> Vista previa</a>
                                <div class="cntr-check">
                                    <input checked="" type="checkbox" id="cbx-<?=strtolower($widget['name'])?>"
                                        class="hidden-xs-up">
                                    <label for="cbx-<?=strtolower($widget['name'])?>" class="cbx"></label>
                                </div>
                            </div>
                        </div>
                        <div class="card__body">
                            <p>
                                <?=$widget['desc']?>
                            </p>
                        </div>
                    </div>
                </div>
            </li>
            <?php } ?>
        </ul>
    </div>
    <div class="alertbx alertbx-rendimiento" style="display: none;">
        <div class="alertbx-content">
            <div class="alertbx-header">
                <h3>Ten en cuenta el rendimiento</h3>
                <button type="button">

                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="16" cy="16" r="15.5" stroke="#E1E4E9" />
                        <g clip-path="url(#clip0_250_6769)">
                            <path
                                d="M23.3795 20.3855L18.9946 16.0006L23.3795 11.6157C24.2064 10.7888 24.2064 9.44797 23.3795 8.62104C22.5526 7.79411 21.2118 7.79411 20.3848 8.62104L15.9996 13.0059L11.6147 8.62069C10.7875 7.79376 9.44665 7.79376 8.62007 8.62069C7.79315 9.44797 7.79315 10.7888 8.62007 11.6153L13.0053 16.0002L8.62007 20.3851C7.79315 21.2124 7.79315 22.5532 8.62007 23.3798C9.03407 23.7934 9.57547 23.9999 10.1176 23.9999C10.6593 23.9999 11.2014 23.7931 11.6151 23.3798L15.9996 18.9952L20.3848 23.3801C20.7988 23.7934 21.3402 24.0002 21.8823 24.0002C22.4245 24.0002 22.9662 23.7934 23.3799 23.3801C24.2064 22.5532 24.2064 21.2127 23.3795 20.3855Z"
                                fill="#98A2B7" />
                        </g>
                        <defs>
                            <clipPath id="clip0_250_6769">
                                <rect width="16" height="16" fill="white" transform="translate(8 8)" />
                            </clipPath>
                        </defs>
                    </svg>
                </button>

            </div>
            <p>
                Agregar demasiados widgets puede afectar la velocidad y el desempeño de tu dashboard. Para una mejor
                experiencia, te recomendamos optimizar tu selección y mantener solo los más relevantes.
            </p>
            <h4>¿Deseas continuar?</h4>
            <div class="actions">
                <button type="button" class="btn btn-action-secondary enfasis btn-big">Cancelar</button>
                <button type="button" class="btn btn-action-primary enfasis btn-big">Continuar</button>
            </div>
        </div>
    </div>
    <div class="alertbx alertbx-rendimiento" style="display: none;">
        <div class="alertbx-content">
            <div class="alertbx-header">
                <div class="txt">
                    <h3>¡Mira tu widget en acción!</h3>
                    <p>Así se verá cuando lo uses. ¿Listo para activarlo?</p>
                </div>
                <button type="button">

                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="16" cy="16" r="15.5" stroke="#E1E4E9" />
                        <g clip-path="url(#clip0_250_6769)">
                            <path
                                d="M23.3795 20.3855L18.9946 16.0006L23.3795 11.6157C24.2064 10.7888 24.2064 9.44797 23.3795 8.62104C22.5526 7.79411 21.2118 7.79411 20.3848 8.62104L15.9996 13.0059L11.6147 8.62069C10.7875 7.79376 9.44665 7.79376 8.62007 8.62069C7.79315 9.44797 7.79315 10.7888 8.62007 11.6153L13.0053 16.0002L8.62007 20.3851C7.79315 21.2124 7.79315 22.5532 8.62007 23.3798C9.03407 23.7934 9.57547 23.9999 10.1176 23.9999C10.6593 23.9999 11.2014 23.7931 11.6151 23.3798L15.9996 18.9952L20.3848 23.3801C20.7988 23.7934 21.3402 24.0002 21.8823 24.0002C22.4245 24.0002 22.9662 23.7934 23.3799 23.3801C24.2064 22.5532 24.2064 21.2127 23.3795 20.3855Z"
                                fill="#98A2B7" />
                        </g>
                        <defs>
                            <clipPath id="clip0_250_6769">
                                <rect width="16" height="16" fill="white" transform="translate(8 8)" />
                            </clipPath>
                        </defs>
                    </svg>
                </button>

            </div>
            <img src="/miembros/acuarela-app-web/dashboard/img/exampleCard.png" alt="Example card widget">
            <div class="actions">
                <button type="button" class="btn btn-action-secondary enfasis btn-big">Cancelar</button>
                <button type="button" class="btn btn-action-primary enfasis btn-big">Seleccionar</button>
            </div>
        </div>
    </div>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php" ?>