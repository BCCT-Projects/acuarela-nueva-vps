<?php include __DIR__ . "/head.php" ?>
<?php

// Obtener todas las suscripciones del usuario
$suscripciones = isset($a->daycareInfo) && isset($a->daycareInfo->suscriptions) ? $a->daycareInfo->suscriptions : [];
// Crear un array con los IDs de las suscripciones
$suscripcionIds = [];
if (is_array($suscripciones) || is_object($suscripciones)) {
    foreach ($suscripciones as $suscripcion) {
        if (isset($suscripcion->service->id)) {
            $suscripcionIds[] = $suscripcion->service->id;
        }
    }
}
// Pasar los IDs a JavaScript
echo '<script>';
echo 'var suscripcionIds = ' . json_encode($suscripcionIds) . ';';
echo '</script>';
?>
<header>
    <?php if (!isset($hideSidebar) || !$hideSidebar): ?>
        <button type="button" onclick="toggleMenu()">
            <i class="acuarela acuarela-Menu"></i>
            <i class="acuarela acuarela-Cancelar"></i>
        </button>
    <?php endif; ?>
    <img src="img/logos/logotipo_invertido.svg" alt="LOGO" />
    <?php if (!isset($hideSidebar) || !$hideSidebar): ?>
        <ul class="breadcrumb">
            <?php
            $section = isset($_GET['section']) ? $_GET['section'] : '';

            if ($section == 'muro-social') {
                echo '<li>Social</li>';
            } elseif ($section == 'inscripciones') {
                echo '<li>Inscripciones</li>';
            } elseif ($section == 'agregar-ninx') {
                echo '<li>Agregar Ninx</li>';
            } elseif ($section == 'asistencia') {
                echo '<li>Asistencia</li>';
            } elseif ($section == 'asistentes') {
                echo '<li>Asistentes</li>';
            } elseif ($section == 'grupos') {
                echo '<li>Grupos</li>';
            } elseif ($section == 'finanzas') {
                echo '<li>Finanzas</li>';
            } elseif ($section == 'inspeccion') {
                echo '<li>Inspección</li>';
            } elseif ($section == 'visitas') {
                echo '<li>Visitas</li>';
            }
            ?>
        </ul>
    <?php endif; ?>
    <div class="right">
        <ul>
            <?php if (!isset($hideSidebar) || !$hideSidebar): ?>
                <li>
                    <a href="/miembros/acuarela-app-web/cambiar-daycare">
                        <i class="acuarela acuarela-Gestion_daycares"></i>
                        <small>Cambiar de Daycare</small>
                    </a>
                </li>
            <?php endif; ?>
            <li><button type="button" onclick="showModalLang()"><svg width="513" height="343" viewBox="0 0 513 343"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_301_1272)">
                            <path d="M0 1H512V343H0V1Z" fill="white" />
                            <path d="M0 1H512V92.2H0V1ZM0 251.8H512V343H0V251.8Z" fill="#D03433" />
                            <path d="M0 92H512V252H0V92Z" fill="#FBCA46" />
                            <path d="M177.493 160.6H200.249V172H177.493V160.6Z" fill="white" />
                            <path
                                d="M163.84 194.8C163.84 201.64 170.667 206.2 177.493 206.2C184.32 206.2 191.147 201.64 191.147 194.8L193.422 160.6H161.564L163.84 194.8ZM150.187 160.6C150.187 153.76 154.738 149.2 159.289 149.2H193.422C200.249 149.2 204.8 153.76 204.8 158.32V160.6L202.524 194.8C200.249 208.48 191.147 217.6 177.493 217.6C163.84 217.6 154.738 208.48 152.462 194.8L150.187 160.6Z"
                                fill="#A41517" />
                            <path
                                d="M154.738 172H200.249V183.4H188.871L177.493 206.2L166.116 183.4H154.738V172ZM120.604 137.8H143.36V217.6H120.604V137.8ZM211.627 137.8H234.382V217.6H211.627V137.8ZM154.738 126.4C154.738 119.56 159.289 115 166.116 115H188.871C195.698 115 200.249 119.56 200.249 126.4V130.96C200.249 135.52 197.973 137.8 193.422 137.8H159.289C157.013 137.8 154.738 135.52 154.738 133.24V126.4Z"
                                fill="#A41517" />
                        </g>
                        <defs>
                            <clipPath id="clip0_301_1272">
                                <rect width="513" height="342" fill="white" transform="translate(0 0.759766)" />
                            </clipPath>
                        </defs>
                    </svg>Es</button></li>
            <li class="logout">
                <a href="/miembros/cerrar-sesion"><i class="acuarela acuarela-Cerrar_sesion"></i></a>
            </li>
        </ul>
    </div>
</header>
<?php if (!isset($hideSidebar) || !$hideSidebar): ?>
    <aside>
        <div class="profile">
            <div class="image">
                <?=
                    isset($_SESSION["userAll"]->photo) && isset($_SESSION["userAll"]->photo->url) ? '<img src="https://acuarelacore.com/api/' . $_SESSION["userAll"]->photo->url . '" alt="profilePhoto" />' : '<img src="img/placeholder.png" alt="profilePhoto" />' ?>
            </div>
            <div class="profile__txt">
                <h2><?= $_SESSION["userAll"]->name ?>     <?= $_SESSION["userAll"]->lastname ?></h2>
                <p><?= $_SESSION["userAll"]->acuarelauser->rols[0]->rol ?></p>
                <p>Daycare: <strong
                        id="daycareName"><?= isset($foundDaycare) && isset($foundDaycare->name) ? $foundDaycare->name : (isset($_SESSION["user"]->daycares[0]) && isset($_SESSION["user"]->daycares[0]->name) ? $_SESSION["user"]->daycares[0]->name : 'No disponible') ?></strong>
                </p>
            </div>
        </div>
        <nav>
            <a href="/miembros/acuarela-app-web/"
                class="<?= isset($_GET['activeTab']) && $_GET['activeTab'] == 0 ? 'active' : '' ?>"><i
                    class="acuarela acuarela-Anadir_reaccion"></i>Social</a>
            <a href="/miembros/acuarela-app-web/inscripciones"
                class="<?= isset($_GET['activeTab']) && $_GET['activeTab'] == 1 ? 'active' : '' ?>"><i
                    class="acuarela acuarela-Formulario"></i><span data-translate="7">Agregar niñxs</span></a>
            <a href="/miembros/acuarela-app-web/asistencia"
                class="<?= isset($_GET['activeTab']) && $_GET['activeTab'] == 2 ? 'active' : '' ?>"><i
                    class="acuarela acuarela-Asistencia"></i><span data-translate="8">Asistencia</span></a>
            <a href="/miembros/acuarela-app-web/asistentes"
                class="<?= isset($_GET['activeTab']) && $_GET['activeTab'] == 3 ? 'active' : '' ?>"><i
                    class="acuarela acuarela-Asistente"></i><span data-translate="9">Asistentes</span></a>
            <a href="/miembros/acuarela-app-web/grupos"
                class="<?= isset($_GET['activeTab']) && $_GET['activeTab'] == 4 ? 'active' : '' ?>"><i
                    class="acuarela acuarela-Grupo"></i><span data-translate="60">Grupos</span></a>
            <a href="/miembros/acuarela-app-web/administrador-tareas"
                class="<?= isset($_GET['activeTab']) && $_GET['activeTab'] == 9 ? 'active' : '' ?>"><i
                    class="acuarela acuarela-Checklist"></i><span data-translate="193">Administrador de tareas</span></a>
            <?php
            $validIds = ["66df29c33f91241d635ae818", "66dfcce23f91241d635ae934"];

            $result = [];
            if (is_array($suscripciones) || is_object($suscripciones)) {
                $result = array_filter($suscripciones, function ($suscripcion) use ($validIds) {
                    return isset($suscripcion->service->id) && in_array($suscripcion->service->id, $validIds);
                });
            }

            $foundSubscription = reset($result);
            if ($foundSubscription) { ?>
                <a href="/miembros/acuarela-app-web/finanzas"
                    class="<?= isset($_GET['activeTab']) && $_GET['activeTab'] == 5 ? 'active' : '' ?>"><i
                        class="acuarela acuarela-Finanzas"></i><span data-translate="53">Finanzas</span></a>
            <?php } else { ?>
                <a href="javascript:;" id="lightbox-finanzas" class="<?=isset($_GET['activeTab']) && $_GET['activeTab'] == 5 ? 'active':''?>"><i class="acuarela acuarela-Finanzas"></i><span data-translate="53">Finanzas</span> <div class="badge">PRO</div></a>
            <?php } ?>
            <a href="/miembros/acuarela-app-web/inspeccion" class="<?=isset($_GET['activeTab']) && $_GET['activeTab'] == 6 ? 'active':''?>"><i class="acuarela acuarela-Pago"></i><span data-translate="85">Inspección</span></a>
            <!-- <a href="/miembros/acuarela-app-web/visitas" class="<?=isset($_GET['activeTab']) && $_GET['activeTab'] == 7 ? 'active':''?>"><i class="acuarela acuarela-Familia"></i>Visitas</a> -->
            <a href="/miembros/acuarela-app-web/privacy_requests" class="<?=isset($_GET['activeTab']) && $_GET['activeTab'] == 10 ? 'active':''?>"><i class="acuarela acuarela-Candado"></i><span>Privacidad</span></a>
            <hr />
            <a href="/miembros/acuarela-app-web/configuracion" class="<?=isset($_GET['activeTab']) && $_GET['activeTab'] == 8 ? 'active':''?>"><span data-translate="26">Configuración</span></a>

    </nav>
</aside>
<?php endif; ?>

<div id="translate-content" style="display:none;max-width:500px;">
    <div class="selector-container">
        <div class="selector" id="es" onclick="changeLang('es')"><svg width="513" height="343" viewBox="0 0 513 343"
                fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_301_1272)">
                    <path d="M0 1H512V343H0V1Z" fill="white" />
                    <path d="M0 1H512V92.2H0V1ZM0 251.8H512V343H0V251.8Z" fill="#D03433" />
                    <path d="M0 92H512V252H0V92Z" fill="#FBCA46" />
                    <path d="M177.493 160.6H200.249V172H177.493V160.6Z" fill="white" />
                    <path
                        d="M163.84 194.8C163.84 201.64 170.667 206.2 177.493 206.2C184.32 206.2 191.147 201.64 191.147 194.8L193.422 160.6H161.564L163.84 194.8ZM150.187 160.6C150.187 153.76 154.738 149.2 159.289 149.2H193.422C200.249 149.2 204.8 153.76 204.8 158.32V160.6L202.524 194.8C200.249 208.48 191.147 217.6 177.493 217.6C163.84 217.6 154.738 208.48 152.462 194.8L150.187 160.6Z"
                        fill="#A41517" />
                    <path
                        d="M154.738 172H200.249V183.4H188.871L177.493 206.2L166.116 183.4H154.738V172ZM120.604 137.8H143.36V217.6H120.604V137.8ZM211.627 137.8H234.382V217.6H211.627V137.8ZM154.738 126.4C154.738 119.56 159.289 115 166.116 115H188.871C195.698 115 200.249 119.56 200.249 126.4V130.96C200.249 135.52 197.973 137.8 193.422 137.8H159.289C157.013 137.8 154.738 135.52 154.738 133.24V126.4Z"
                        fill="#A41517" />
                </g>
                <defs>
                    <clipPath id="clip0_301_1272">
                        <rect width="513" height="342" fill="white" transform="translate(0 0.759766)" />
                    </clipPath>
                </defs>
            </svg>Español</div>
        <hr />
        <div class="selector" id="en" onclick="changeLang('en')"><svg width="513" height="343" viewBox="0 0 513 343"
                fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_301_131)">
                    <path d="M0 0.957031H513V342.957H0V0.957031Z" fill="white" />
                    <path
                        d="M0 0.957031H513V27.257H0V0.957031ZM0 53.557H513V79.857H0V53.557ZM0 106.157H513V132.457H0V106.157ZM0 158.757H513V185.057H0V158.757ZM0 211.457H513V237.757H0V211.457ZM0 264.057H513V290.357H0V264.057ZM0 316.657H513V342.957H0V316.657Z"
                        fill="#D80027" />
                    <path d="M0 0.957031H256.5V185.057H0V0.957031Z" fill="#2E52B2" />
                    <path
                        d="M47.8002 139.857L43.8002 127.057L39.4002 139.857H26.2002L36.9002 147.557L32.9002 160.357L43.8002 152.457L54.4002 160.357L50.3002 147.557L61.2002 139.857H47.8002ZM104.1 139.857L100 127.057L95.8002 139.857H82.6002L93.3002 147.557L89.3002 160.357L100 152.457L110.8 160.357L106.8 147.557L117.5 139.857H104.1ZM160.6 139.857L156.3 127.057L152.3 139.857H138.8L149.8 147.557L145.6 160.357L156.3 152.457L167.3 160.357L163.1 147.557L173.8 139.857H160.6ZM216.8 139.857L212.8 127.057L208.6 139.857H195.3L206.1 147.557L202.1 160.357L212.8 152.457L223.6 160.357L219.3 147.557L230.3 139.857H216.8ZM100 76.2572L95.8002 89.0572H82.6002L93.3002 96.9572L89.3002 109.557L100 101.757L110.8 109.557L106.8 96.9572L117.5 89.0572H104.1L100 76.2572ZM43.8002 76.2572L39.4002 89.0572H26.2002L36.9002 96.9572L32.9002 109.557L43.8002 101.757L54.4002 109.557L50.3002 96.9572L61.2002 89.0572H47.8002L43.8002 76.2572ZM156.3 76.2572L152.3 89.0572H138.8L149.8 96.9572L145.6 109.557L156.3 101.757L167.3 109.557L163.1 96.9572L173.8 89.0572H160.6L156.3 76.2572ZM212.8 76.2572L208.6 89.0572H195.3L206.1 96.9572L202.1 109.557L212.8 101.757L223.6 109.557L219.3 96.9572L230.3 89.0572H216.8L212.8 76.2572ZM43.8002 25.6572L39.4002 38.2572H26.2002L36.9002 46.1572L32.9002 58.8572L43.8002 50.9572L54.4002 58.8572L50.3002 46.1572L61.2002 38.2572H47.8002L43.8002 25.6572ZM100 25.6572L95.8002 38.2572H82.6002L93.3002 46.1572L89.3002 58.8572L100 50.9572L110.8 58.8572L106.8 46.1572L117.5 38.2572H104.1L100 25.6572ZM156.3 25.6572L152.3 38.2572H138.8L149.8 46.1572L145.6 58.8572L156.3 50.9572L167.3 58.8572L163.1 46.1572L173.8 38.2572H160.6L156.3 25.6572ZM212.8 25.6572L208.6 38.2572H195.3L206.1 46.1572L202.1 58.8572L212.8 50.9572L223.6 58.8572L219.3 46.1572L230.3 38.2572H216.8L212.8 25.6572Z"
                        fill="white" />
                </g>
                <defs>
                    <clipPath id="clip0_301_131">
                        <rect width="513" height="342" fill="white" transform="translate(0 0.957031)" />
                    </clipPath>
                </defs>
            </svg>Inglés</div>
    </div>
</div>