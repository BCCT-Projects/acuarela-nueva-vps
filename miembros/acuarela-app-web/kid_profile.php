<?php $classBody = "kid_profile";
include "includes/header.php";
$kid_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);

if (!$kid_id) {
    // Si no hay ID válido, redirigir o mostrar error
    header("Location: index.php");
    exit;
}

$kid = $a->getChildren($kid_id);

// Descifrar datos del niño (nombre, apellido, fecha de nacimiento)
$kid = $a->decryptChildData($kid);

// Descifrar datos de los padres (teléfonos)
if (isset($kid->acuarelausers) && is_array($kid->acuarelausers)) {
    foreach ($kid->acuarelausers as $key => $parent) {
        $kid->acuarelausers[$key] = $a->decryptParentData($parent);
    }
}

// Descifrar datos de salud (evita que el PHP falle al tratar strings cifrados como arrays)
if (isset($kid->healthinfo)) {
    $kid->healthinfo = $a->decryptHealthData($kid->healthinfo);
}

// Obtener estado COPPA
$coppaStatus = 'pending'; // Default
if (isset($kid->id)) {
    $consents = $a->queryStrapi("parental-consents?child_id={$kid->id}&_sort=createdAt:desc&_limit=1");
    if (is_array($consents) && count($consents) > 0) {
        $coppaStatus = $consents[0]->consent_status ?? 'pending';
    }
}

$coppaClass = 'warning';
$coppaLabel = 'Pendiente';
if ($coppaStatus === 'granted') {
    $coppaClass = 'success';
    $coppaLabel = 'Aprobado';
} elseif ($coppaStatus === 'revoked') {
    $coppaClass = 'danger';
    $coppaLabel = 'Revocado';
}

// Asegurar estructura de healthinfo para evitar errores
if (!isset($kid->healthinfo) || !is_object($kid->healthinfo)) {
    $kid->healthinfo = new stdClass();
}
$healthInfoDefaults = [
    'allergies' => [],
    'asthma' => 0,
    'medicines' => [],
    'vacination' => [],
    'accidents' => [],
    'physical_health' => '',
    'emotional_health' => '',
    'suspected_abuse' => '',
    'ointments' => [],
    'pediatrician' => '',
    'pediatrician_number' => '',
    'pediatrician_email' => '',
    'incidents' => [],
    'healthcheck' => []
];
foreach ($healthInfoDefaults as $key => $default) {
    if (!isset($kid->healthinfo->$key)) {
        $kid->healthinfo->$key = $default;
    }
}
?>
<script>
    let activities = <?= json_encode($kid->childrenactivities) ?>;
    let kidData = <?= json_encode($kid) ?>;
</script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<main>
    <?php
    $mainHeaderTitle = "{$kid->name} {$kid->lastname}";
    $action = '<a href="/miembros/acuarela-app-web/inspeccion" class="btn btn-action-primary enfasis btn-big"><i class="acuarela acuarela-Pago"></i>Generar informe</a>';
    include "templates/sectionHeader.php";
    // Crea un objeto DateTime desde la cadena ISO 8601
    $birthdate = new DateTime($kid->birthday);
    // Formatea la fecha al formato MM-DD-YYYY
    $birthdate_formateada = $birthdate->format('m-d-Y');
    // Crea un objeto DateTime desde la cadena ISO 8601
    $published_at = new DateTime($kid->published_at);
    // Formatea la fecha al formato MM-DD-YYYY
    $published_at_formateada = $published_at->format('m-d-Y');
    ?>
    <div class="content">
        <div class="contentninx">
            <div class="contentcent">

                <!-- DATA CLASSIFICATION BANNER (ISO 27001 / COPPA) -->
                <div
                    style="background-color: #fff3cd; border: 1px solid #ffeeba; color: #856404; padding: 12px 20px; margin-bottom: 20px; border-radius: 8px; display: flex; align-items: center; gap: 10px; font-size: 0.9rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                    <div>
                        <strong>DATOS SENSIBLES / SENSITIVE DATA:</strong>
                        Acceso monitoreado. Protegido por COPPA.
                        <span class="badge badge-<?= $coppaClass ?>"
                            style="margin-left: 10px; padding: 2px 8px; border-radius: 4px; font-size: 0.8em; text-transform: uppercase; background: #fff; border: 1px solid currentColor;">COPPA:
                            <?= $coppaLabel ?></span>
                    </div>
                </div>

                <div class="basicinfo">
                    <div class="txt">
                        <div class="txt_data">
                            <p><i class="acuarela acuarela-Evento"></i>
                                <span class="txt_infodata">
                                    <span>Fecha de nacimiento</span>
                                    <strong><?= $birthdate_formateada ?: 'No disponible' ?></strong>
                                </span>
                            </p>
                            <p><i class="acuarela acuarela-Calendario"></i>
                                <span class="txt_infodata">
                                    <span>Inscrito desde</span>
                                    <strong><?= $published_at_formateada ?: 'No disponible' ?></strong>
                                </span>
                            </p>
                            <?php
                            $colorStyle = 'color: #f5aa16;'; // Warning default
                            if ($coppaStatus === 'granted') {
                                $colorStyle = 'color: #3fb072;'; // Green
                            } elseif ($coppaStatus === 'revoked') {
                                $colorStyle = 'color: #e65252;'; // Red
                            }
                            ?>
                            <p><i class="acuarela acuarela-Informacion"></i>
                                <span class="txt_infodata">
                                    <span>Estado COPPA</span>
                                    <strong style="<?= $colorStyle ?>"><?= $coppaLabel ?></strong>

                                    <?php if ($coppaStatus !== 'granted'): ?>
                                        <button id="btnResendConsent" type="button" data-child-id="<?= $kid->id ?>"
                                            style="margin-left: 10px; cursor: pointer; border: none; background: #6c757d; color: white; padding: 4px 10px; border-radius: 4px; font-size: 12px; transition: background 0.3s;"
                                            onmouseover="this.style.background='#5a6268'"
                                            onmouseout="this.style.background='#6c757d'">
                                            Reenviar Solicitud
                                        </button>
                                    <?php endif; ?>
                                </span>
                            </p>
                            <p><i class="acuarela acuarela-Localizacion"></i>
                                <span class="txt_infodata">
                                    <span>Ciudad</span>
                                    <strong><?= $kid->city ?? 'No disponible' ?></strong>
                                </span>
                            </p>
                            <p><i class="acuarela acuarela-Telefono"></i>
                                <span class="txt_infodata">
                                    <span>Número Mamá</span>
                                    <strong><?= $kid->acuarelausers[0]->phone ?? 'No disponible' ?></strong>
                                </span>
                            </p>

                            <p><i class="acuarela acuarela-Mensajes"></i>
                                <span class="txt_infodata">
                                    <span>Correo Mamá</span>
                                    <strong><?= $kid->acuarelausers[0]->mail ?? 'No disponible' ?></strong>
                                </span>
                            </p>

                            <p><i class="acuarela acuarela-Telefono"></i>
                                <span class="txt_infodata">
                                    <span>Número Papá</span>
                                    <strong><?= $kid->acuarelausers[1]->phone ?? 'No disponible' ?></strong>
                                </span>
                            </p>

                            <p><i class="acuarela acuarela-Mensajes"></i>
                                <span class="txt_infodata">
                                    <span>Correo Papá</span>
                                    <strong><?= $kid->acuarelausers[1]->mail ?? 'No disponible' ?></strong>
                                </span>
                            </p>
                            <?php
                            // echo 'ID recibido: ' . htmlspecialchars($_GET['id']);
                            // echo '<pre>';
                            //     var_dump($kid);
                            // echo '</pre>';
                            ?>
                        </div>
                        <button class="emergency_contact" href="javascript:;" id="lightbox-emergencycontact">Contacto de
                            Emergencia</button>
                    </div>
                    <div class="photo">
                        <?php
                        $photoUrl = isset($kid->photo) ? 'https://acuarelacore.com/api/' . $kid->photo->formats->small->url : null;
                        $gender = $kid->gender;

                        if ($photoUrl) {
                            echo "<img loading='lazy' class='lazyload' src='img/placeholder.png' data-src='$photoUrl' alt='{$kid->name}'>";
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
                    </div>
                </div>
                <div class="navtabs">
                    <div class="navtab active" data-target="familia">Familia</div>
                    <div class="navtab" data-target="salud">Salud</div>
                    <div class="navtab" data-target="health_check">Health Check</div>
                    <div class="navtab" data-target="actividades">Actividades</div>
                    <div class="navtab" data-target="pagos">Pagos</div>
                    <!-- <div class="navtab" data-target="registro">Registro</div> -->
                    <div class="navtab " data-target="Adjuntos">Adjuntos</div>
                    <div class="underline"></div>
                </div>

                <div id="familia" class="tab-content active">
                    <h3>Padres</h3>
                    <ul>
                        <?php
                        for ($i = 0; $i < count($kid->acuarelausers); $i++) {
                            $parent = $kid->acuarelausers[$i];
                            ?>
                            <li>
                                <div class="image">
                                    <?= !empty($parent->photo)
                                        ? "<img src='https://acuarelacore.com/api/{$parent->photo->formats->small->url}' alt='{$parent->name}'>"
                                        : "<i class='acuarela acuarela-Camara'></i>" ?>


                                </div>
                                <?php if ($parent->is_principal) { ?>
                                    <i class="acuarela acuarela-Estrella"></i>
                                <?php } ?>
                                <span class="name"><?= $parent->name ?>     <?= $parent->lastname ?></span>
                            </li>
                        <?php } ?>
                    </ul>
                    <h3>Responsables</h3>
                    <ul>
                        <?php
                        for ($i = 0; $i < count($kid->guardians); $i++) {
                            $guardian = $kid->guardians[$i];
                            ?>
                            <li>
                                <div class="image">
                                    <?= isset($guardian->photo) && isset($guardian->photo->formats->small->url)
                                        ? "<img src='https://acuarelacore.com/api/{$guardian->photo->formats->small->url}' alt='{$guardian->guardian_name}'>"
                                        : "<i class='acuarela acuarela-Camara'></i>" ?>
                                </div>
                                <?php if (isset($guardian->guardian_emergency) && $guardian->guardian_emergency) { ?>
                                    <i class="acuarela acuarela-Estrella"></i>
                                <?php } ?>
                                <span class="name"><?= $guardian->guardian_name ?>
                                    <?= $guardian->guardian_lastname ?></span>
                            </li>
                        <?php } ?>
                    </ul>
                </div>

                <div id="salud" class="tab-content">
                    <div class="saludcontainer">
                        <div class="saludinfo">
                            <div class="saludhistorial">
                                <h3>Historial de salud</h3>
                                <!-- <p><span class="hs-sep"><i class="acuarela acuarela-Checklist"></i> <span>Alergias: </span> </span>  <?= $kid->healthinfo->allergies ?> </p> -->
                                <div class="saludcampos">
                                    <p class="hs-sep"><i class="acuarela acuarela-Checklist"></i> <span>Alergias:</span>
                                    </p>
                                    <div class="saludcampos-JSON">
                                        <?php
                                        $alergias = $kid->healthinfo->allergies ?? [];
                                        $alergiasFiltradas = array_filter($alergias, fn($a) => trim($a) !== '');
                                        if (empty($alergiasFiltradas)): ?>
                                            <p>Ninguna</p>
                                        <?php else: ?>
                                            <?php foreach ($alergiasFiltradas as $alergia): ?>
                                                <p><?= htmlspecialchars($alergia) ?></p>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="saludcampos">
                                    <p class="hs-sep"><i class="acuarela acuarela-Checklist"></i> <span>Asma: </span>
                                    </p>
                                    <div class="saludcampos-JSON">
                                        <p><?= $kid->healthinfo->asthma == 1 ? 'Sí' : 'No' ?></p>
                                    </div>
                                </div>
                                <div class="saludcampos">
                                    <p class="hs-sep"><i class="acuarela acuarela-Checklist"></i>
                                        <span>Medicamentos:</span>
                                    </p>
                                    <div class="saludcampos-JSON">
                                        <?php
                                        $medicamentos = $kid->healthinfo->medicines ?? [];
                                        $medicamentosFiltrados = array_filter($medicamentos, fn($m) => trim($m) !== '');
                                        if (empty($medicamentosFiltrados)): ?>
                                            <p>Ninguno</p>
                                        <?php else: ?>
                                            <?php foreach ($medicamentosFiltrados as $med): ?>
                                                <p><?= htmlspecialchars($med) ?></p>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="saludcampos">
                                    <p class="hs-sep"><i class="acuarela acuarela-Checklist"></i> <span>Vacunas:</span>
                                    </p>
                                    <div class="saludcampos-JSON">
                                        <?php
                                        $vacunas = $kid->healthinfo->vacination ?? [];
                                        $vacunasFiltradas = array_filter($vacunas, fn($v) => trim($v) !== '');
                                        if (empty($vacunasFiltradas)): ?>
                                            <p>Ninguna</p>
                                        <?php else: ?>
                                            <?php foreach ($vacunasFiltradas as $vac): ?>
                                                <p><?= htmlspecialchars($vac) ?></p>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="saludcampos">
                                    <p class="hs-sep"><i class="acuarela acuarela-Checklist"></i>
                                        <span>Accidentes:</span>
                                    </p>
                                    <div class="saludcampos-JSON">
                                        <?php
                                        $accidentes = $kid->healthinfo->accidents ?? [];
                                        // Filtramos el array para eliminar valores vacíos ("" o null)
                                        $accidentesFiltrados = array_filter($accidentes, fn($a) => trim($a) !== '');
                                        if (empty($accidentesFiltrados)): ?>
                                            <p>Ninguno</p>
                                        <?php else: ?>
                                            <?php foreach ($accidentesFiltrados as $accidente): ?>
                                                <p><?= htmlspecialchars($accidente) ?></p>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="saludcampos">
                                    <p class="hs-sep"><i class="acuarela acuarela-Checklist"></i> <span>Salud
                                            física:</span></p>
                                    <div class="saludcampos-JSON">
                                        <p><?= !empty($kid->healthinfo->physical_health) ? $kid->healthinfo->physical_health : 'Ninguna' ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="saludcampos">
                                    <p class="hs-sep"><i class="acuarela acuarela-Checklist"></i> <span>Salud
                                            emocional:</span></p>
                                    <div class="saludcampos-JSON">
                                        <p><?= !empty($kid->healthinfo->emotional_health) ? $kid->healthinfo->emotional_health : 'Ninguna' ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="saludcampos">
                                    <p class="hs-sep"><i class="acuarela acuarela-Checklist"></i> <span>Sospecha de
                                            abuso: </span></p>
                                    <div class="saludcampos-JSON">
                                        <p><?= !empty($kid->healthinfo->suspected_abuse) ? $kid->healthinfo->suspected_abuse : 'Ninguna' ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="saludinfo-add">
                                <div class="saludunguentos">
                                    <div class="unguentosdesp">
                                        <h3 class="unguentostitle">Ungüentos autorizados</h3>
                                        <p class="ung-btn"><i class="iconung acuarela acuarela-Flecha_arriba"></i></p>
                                    </div>
                                    <div class="unguentoscontent show">
                                        <?php
                                        $unguentos = $kid->healthinfo->ointments ?? [];
                                        $unguentosFiltrados = array_filter($unguentos, fn($u) => trim($u) !== '');
                                        if (empty($unguentosFiltrados)): ?>
                                            <p>Ninguno</p>
                                        <?php else: ?>
                                            <?php foreach ($unguentosFiltrados as $ung): ?>
                                                <p><?= htmlspecialchars($ung) ?></p>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="saludunguentos">
                                    <div class="unguentosdesp">
                                        <h3 class="unguentostitle">Datos del pediatra</h3>
                                        <p class="ung-btn"><i class="iconung acuarela acuarela-Flecha_arriba"></i></p>
                                    </div>
                                    <div class="unguentoscontent show">
                                        <p class="hs-sep3"><strong>Doctor: </strong>
                                            <?= !empty($kid->healthinfo->pediatrician) ? $kid->healthinfo->pediatrician : 'No agregados' ?>
                                        </p>
                                        <p class="hs-sep3"><strong>Teléfono: </strong>
                                            <?= !empty($kid->healthinfo->pediatrician_number) ? $kid->healthinfo->pediatrician_number : 'No agregados' ?>
                                        </p>
                                        <p class="hs-sep3"><strong>Correo: </strong>
                                            <?= !empty($kid->healthinfo->pediatrician_email) ? $kid->healthinfo->pediatrician_email : 'No agregados' ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if ($coppaStatus === 'granted'): ?>
                            <a class="saludinfoadd saludinfoadd-shadow"
                                href="/miembros/acuarela-app-web/agregar-salud/<?= $kid->_id ?>"><i
                                    class="acuarela acuarela-Agregar"></i> Agregar datos de salud </a>
                        <?php else: ?>
                            <p
                                style="text-align: center; color: #e65252; padding: 15px; background: #ffe5e5; border-radius: 8px; margin: 15px 0;">
                                <i class="acuarela acuarela-Advertencia"></i> No se puede modificar información de salud
                                porque el consentimiento COPPA está <strong><?= $coppaLabel ?></strong>.
                            </p>
                        <?php endif; ?>

                        <div class="saludincidentes">
                            <h3 class="saludincidentes-title">Incidentes</h3>
                            <?php if (!empty($kid->healthinfo->incidents)): ?>
                                <?php foreach ($kid->healthinfo->incidents as $index => $incident): ?>
                                    <div class="incidentnino" id="incidentes">
                                        <div class="incidentnino-desp">
                                            <h4 class="h4">Incidente <?= $index + 1 ?></h4>
                                            <!-- Mostrará Incidente 1, Incidente 2, etc. -->
                                            <p class="iconincid"><i class="acuarela acuarela-Flecha_arriba"></i></p>
                                        </div>
                                        <div class="incidentinfo">
                                            <div class="incidentreport">
                                                <p> Reportado por <?= $incident->reported_for ?> </p>
                                                <!-- <p><i class="acuarela acuarela-Horario"></i> <?= date('H:i', strtotime($incident->reported_enh)) ?> </p> -->
                                                <p><i class="acuarela acuarela-Calendario"></i>
                                                    <?= date('m-d-Y', strtotime($incident->reported_enf)) ?> </p>
                                            </div>
                                            <div class="incidentdetails">
                                                <p class="incdet-p">
                                                    <span class="hs-sep2"><i class="acuarela acuarela-Ayuda"></i> <span>Tipo de
                                                            incidente </span></span>
                                                    <span
                                                        class="inc-text"><?= !empty($incident->incident_type) ? htmlspecialchars($incident->incident_type) : 'No registrado' ?></span>
                                                </p>
                                                <p class="incdet-p">
                                                    <span class="hs-sep2"><i class="acuarela acuarela-Informacion"></i>
                                                        <span>Descripción </span></span>
                                                    <span
                                                        class="inc-text"><?= !empty($incident->description) ? htmlspecialchars($incident->description) : 'No registrado' ?></span>
                                                </p>
                                                <p class="incdet-p">
                                                    <span class="hs-sep2"><i class="acuarela acuarela-Prioridad"></i>
                                                        <span>Nivel de gravedad </span></span>
                                                    <span
                                                        class="inc-text"><?= !empty($incident->gravedad) ? htmlspecialchars($incident->gravedad) : 'No registrado' ?></span>
                                                </p>
                                                <p class="incdet-p">
                                                    <span class="hs-sep2"><i class="acuarela acuarela-Advertencia"></i>
                                                        <span>Temperatura </span></span>
                                                    <span
                                                        class="inc-text"><?= isset($incident->temperature) && trim($incident->temperature) !== '' ? htmlspecialchars($incident->temperature) . ' °F' : 'No registrado' ?></span>
                                                </p>
                                                <p class="incdet-p">
                                                    <span class="hs-sep2"><i class="acuarela acuarela-Salud"></i> <span>Estado
                                                            de salud </span></span>
                                                    <span
                                                        class="inc-text"><?= !empty($incident->statehealth) ? htmlspecialchars($incident->statehealth) : 'No registrado' ?></span>
                                                </p>
                                                <p class="incdet-p">
                                                    <span class="hs-sep2"><i class="acuarela acuarela-Informacion"></i>
                                                        <span>Acciones tomadas </span></span>
                                                    <span
                                                        class="inc-text"><?= !empty($incident->actions_taken) ? htmlspecialchars($incident->actions_taken) : 'No registrado' ?></span>
                                                </p>
                                                <p class="incdet-p">
                                                    <span class="hs-sep2"><i class="acuarela acuarela-Informacion"></i>
                                                        <span>Acciones esperadas </span></span>
                                                    <span
                                                        class="inc-text"><?= !empty($incident->actions_expected) ? htmlspecialchars($incident->actions_expected) : 'No registrado' ?></span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No hay incidentes registrados.</p>
                            <?php endif; ?>
                            <?php if ($coppaStatus === 'granted'): ?>
                                <a class="saludinfoadd"
                                    href="/miembros/acuarela-app-web/agregar-reporte/<?= $kid->_id ?>"><i
                                        class="acuarela acuarela-Agregar"></i> Agregar nuevo reporte </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div id="health_check" class="tab-content">
                    <div class="health-calendar">
                        <div class="header">
                            <select id="year-select"></select>
                            <select id="month-select"></select>
                        </div>
                        <!-- Contenedor del calendario -->
                        <div id="calendar-container">
                            <table id="calendar">
                                <thead>
                                    <tr>
                                        <th>D</th>
                                        <th>L</th>
                                        <th>M</th>
                                        <th>M</th>
                                        <th>J</th>
                                        <th>V</th>
                                        <th>S</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Las fechas se generarán dinámicamente -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php if ($coppaStatus === 'granted'): ?>
                        <div class="health-buttoms">
                            <button id="btnView-reporte" class="btn btn-action-secondary enfasis btn-big btn-disable"> Ver
                                reporte </button>
                            <button id="btnAgregar-reporte" class="btn btn-action-secondary enfasis btn-big btn-disable">
                                Agregar reporte </button>
                        </div>
                        <p id="calendar-help-text"
                            style="text-align: center; color: #6c757d; font-size: 14px; margin-top: 10px; transition: opacity 0.3s;">
                            <i class="acuarela acuarela-Informacion"></i> Selecciona un día en el calendario para continuar
                        </p>
                    <?php else: ?>
                        <p
                            style="text-align: center; color: #e65252; padding: 15px; background: #ffe5e5; border-radius: 8px; margin: 15px;">
                            <i class="acuarela acuarela-Advertencia"></i> No se puede registrar información de Health Check
                            porque el consentimiento COPPA está <strong><?= $coppaLabel ?></strong>.
                        </p>
                    <?php endif; ?>
                </div>

                <div id="actividades" class="tab-content">
                    <div class="actividadescontainer">
                        <div class="header">
                            <button id="prev-month" class="nav-button">«</button>
                            <button id="prev-day" class="nav-button">‹</button>
                            <h2 id="date-display">Enero 22</h2>
                            <button id="next-day" class="nav-button">›</button>
                            <button id="next-month" class="nav-button">»</button>
                        </div>
                        <div id="activities-list" class="activities-list">
                            <!-- Activities will be injected here -->
                        </div>
                        <div id="no-activities" class="no-activities">No hay actividades registradas</div>
                    </div>
                </div>

                <div id="pagos" class="tab-content">
                    <?php if (!empty($kid->movements) && count($kid->movements) > 0): ?>
                        <ul>
                            <?php
                            for ($i = 0; $i < count($kid->movements); $i++) {
                                $pay = $kid->movements[$i];
                                ?>
                                <li>
                                    <h4><?= $pay->name ?></h4>
                                    <span class="status" style="color:<?= $pay->status ? "#3fb072"
                                        : "#f5aa16" ?>;">
                                        <?= $pay->status ? "PAGO APROBADO" : "PAGO PENDIENTE" ?>
                                    </span>
                                    <span class="date">
                                        <?php
                                        // Crea un objeto DateTime desde la cadena ISO 8601
                                        $payDate = new DateTime($pay->date);
                                        // Formatea la fecha al formato MM-DD-YYYY
                                        $payDate_formateada = $payDate->format('m-d-Y');
                                        echo $payDate_formateada;
                                        ?>
                                    </span>
                                    <span class="amount">
                                        $<?= $pay->amount ?>
                                    </span>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    <?php else: ?>
                        <div style="text-align: center; padding: 60px 20px;">
                            <i class="acuarela acuarela-Pago" style="font-size: 64px; color: #d0d0d0;"></i>
                            <p style="color: #6c757d; font-size: 18px; margin-top: 20px; font-weight: 500;">
                                No hay pagos registrados
                            </p>
                            <p style="color: #999; font-size: 14px; margin-top: 8px;">
                                Los movimientos financieros aparecerán aquí
                            </p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- <div id="registro" class="tab-content"></div> -->
                <div id="Adjuntos" class="tab-content ">
                    <?php if (!empty($kid->files) && count($kid->files) > 0): ?>
                        <ul>
                            <?php
                            for ($i = 0; $i < count($kid->files); $i++) {
                                $file = $kid->files[$i];
                                ?>
                                <li>
                                    <a href="https://acuarelacore.com/api<?= $file->file->url ?>">
                                        <i class="acuarela acuarela-Nota"></i>
                                        <h4><?= $file->name ?></h4>
                                    </a>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    <?php else: ?>
                        <div style="text-align: center; padding: 60px 20px;">
                            <i class="acuarela acuarela-Nota" style="font-size: 64px; color: #d0d0d0;"></i>
                            <p style="color: #6c757d; font-size: 18px; margin-top: 20px; font-weight: 500;">
                                No hay documentos adjuntos
                            </p>
                            <p style="color: #999; font-size: 14px; margin-top: 8px;">
                                Los archivos subidos aparecerán aquí
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include "includes/footer.php" ?>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        //==> Calendario del HEALTH CHECK
        const calendar = document.querySelector('#calendar tbody');

        // Safe access to healthcheck data
        const safeHealthCheck = (kidData && kidData.healthinfo && kidData.healthinfo.healthcheck) ? kidData.healthinfo.healthcheck : [];
        kidData.healthinfo = kidData.healthinfo || {}; // Ensure healthinfo exists
        kidData.healthinfo.healthcheck = safeHealthCheck; // Assign safe array back to object structure to avoid rewriting all logic

        const monthSelect = document.querySelector('#month-select');
        const yearSelect = document.querySelector('#year-select');

        const tds = document.querySelectorAll("#calendar td");
        const btnAddreport = document.getElementById("btnAgregar-reporte");
        const btnViewreport = document.getElementById("btnView-reporte");

        // Deshabilitar los botones al inicio
        if (btnAddreport) {
            btnAddreport.disabled = false;
            btnAddreport.classList.add("active");
        }
        if (btnViewreport) {
            btnViewreport.disabled = true;
        }

        const today = new Date();
        let currentYear = today.getFullYear();
        let currentMonth = today.getMonth();

        // Nombres de los meses
        const months = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];

        // Generar las opciones del selector de mes
        months.forEach((month, index) => {
            const option = document.createElement('option');
            option.value = index;
            option.textContent = month;
            if (index === currentMonth) option.selected = true;
            monthSelect.appendChild(option);
        });

        // Generar las opciones del selector de año (10 años hacia atrás y adelante)
        for (let i = currentYear - 10; i <= currentYear + 10; i++) {
            const option = document.createElement('option');
            option.value = i;
            option.textContent = i;
            if (i === currentYear) option.selected = true;
            yearSelect.appendChild(option);
        }

        function generateCalendar(year, month) {
            calendar.innerHTML = ''; // Limpia el calendario

            const firstDay = new Date(year, month, 1).getDay(); // Día de la semana del primer día del mes
            const daysInMonth = new Date(year, month + 1, 0).getDate(); // Cantidad de días en el mes
            const daysInPrevMonth = new Date(year, month, 0).getDate(); // Días en el mes anterior

            let date = 1;
            let nextMonthDate = 1;

            for (let i = 0; i < 6; i++) {
                const row = document.createElement('tr');
                let hasDays = false; // Para evitar agregar filas innecesarias

                for (let j = 0; j < 7; j++) {
                    const cell = document.createElement('td');

                    if (i === 0 && j < firstDay) {
                        // Días del mes anterior (en gris)
                        const dayNumber = daysInPrevMonth - (firstDay - j - 1);
                        cell.appendChild(createDayCell(dayNumber, year, month, 'prev-month-cell', true));
                    } else if (date > daysInMonth) {
                        // Días del siguiente mes (en gris, pero solo hasta completar la semana)
                        cell.appendChild(createDayCell(nextMonthDate, year, month, 'next-month-cell', true));
                        nextMonthDate++;
                    } else {
                        // Días del mes actual
                        const dayCell = createDayCell(date, year, month);
                        if (date === today.getDate() && year === today.getFullYear() && month === today.getMonth()) {
                            dayCell.style.backgroundColor = '#0cb5c3'; // Resalta el día actual
                            dayCell.style.color = 'white';
                            const dayTextParagraphs = dayCell.querySelectorAll('.day-text p');
                            dayTextParagraphs.forEach(p => {
                                p.style.color = 'white';
                            });
                        }
                        cell.appendChild(dayCell);
                        date++;
                        hasDays = true;
                    }
                    row.appendChild(cell);
                }
                // Solo agrega la fila si tiene días útiles
                if (hasDays || i === 0) {
                    calendar.appendChild(row);
                } else {
                    break;
                }
            }
        }

        let fechaSeleccionada = null;

        // Cuando cambias de mes con los <select>, el evento change genera el calendario, pero los <td> nuevos no tienen eventos asignados,
        function asignarEventosCalendario() {
            const tds = document.querySelectorAll("#calendar td");
            tds.forEach(td => {
                const dayWrapper = td.querySelector(".day-wrapper");
                if (!dayWrapper) return;
                const fechaTd = dayWrapper.getAttribute("data-fecha");
                if (!fechaTd) return;

                const existeFecha = kidData.healthinfo.healthcheck.some(entry => entry.daily_fecha === fechaTd);
                if (existeFecha) {
                    td.classList.add("has-data");
                    td.style.backgroundColor = "var(--fondo2)";
                }

                td.addEventListener("mouseenter", function () {
                    if (!this.classList.contains("active")) {
                        this.style.backgroundColor = "var(--cielo_tenue)";
                    }
                });

                td.addEventListener("mouseleave", function () {
                    if (!this.classList.contains("active")) {
                        this.style.backgroundColor = this.classList.contains("has-data") ? "#d7f6f9" : "";
                    }
                });

                td.addEventListener("click", function () {
                    tds.forEach(cell => {
                        cell.classList.remove("active");
                        if (cell.classList.contains("has-data")) {
                            cell.style.backgroundColor = "var(--fondo2)";
                        } else {
                            cell.style.backgroundColor = "";
                        }
                    });

                    this.classList.add("active");

                    if (this.classList.contains("has-data")) {
                        this.style.backgroundColor = "var(--cielo_tenue)";
                    } else {
                        this.style.backgroundColor = "var(--cielo_tenue)";
                    }

                    const dayWrapper = this.querySelector(".day-wrapper");
                    if (dayWrapper) {
                        fechaSeleccionada = dayWrapper.getAttribute("data-fecha");
                        btnAddreport.setAttribute("data-fecha", fechaSeleccionada);
                    }


                    const existeFecha = kidData.healthinfo.healthcheck.some(entry => entry.daily_fecha === fechaSeleccionada);

                    if (btnAddreport) {
                        btnAddreport.disabled = !existeFecha ? false : true;
                        btnAddreport.classList.toggle("active", !existeFecha);
                    }

                    if (existeFecha) {
                        if (btnViewreport) {
                            btnViewreport.disabled = false;
                            btnViewreport.classList.add("active");
                            btnViewreport.setAttribute("data-fecha", fechaSeleccionada);
                        }
                    } else {
                        if (btnViewreport) {
                            btnViewreport.disabled = true;
                            btnViewreport.classList.remove("active");
                            btnViewreport.removeAttribute("data-fecha");
                        }
                    }

                    // Ocultar mensaje de ayuda cuando se selecciona un día válido
                    const helpText = document.getElementById("calendar-help-text");
                    if (helpText && ((btnAddreport && !btnAddreport.disabled) || (btnViewreport && !btnViewreport.disabled))) {
                        helpText.style.opacity = "0";
                        setTimeout(() => helpText.style.display = "none", 300);
                    }
                });
            });
        }


        // Función para crear un div con el número del día y los textos "Hola" y "Vamos"
        function createDayCell(dayNumber, year, month, extraClass = '', isGrayed = false) {
            const wrapper = document.createElement('div');
            wrapper.classList.add('day-wrapper');
            if (extraClass) {
                wrapper.classList.add(extraClass);
            }
            // Formatear la fecha correctamente (YYYY-MM-DD)
            const formattedDate = `${year}-${(month + 1).toString().padStart(2, '0')}-${dayNumber.toString().padStart(2, '0')}`;
            wrapper.setAttribute('data-fecha', formattedDate);

            const dayDiv = document.createElement('div');
            dayDiv.textContent = dayNumber.toString().padStart(2, '0'); // Formato con 2 dígitos
            dayDiv.classList.add('day-number');
            wrapper.appendChild(dayDiv);

            // Si el día está gris (fuera de los días actuales del mes)
            if (!isGrayed) {
                const textDiv = document.createElement('div');
                textDiv.classList.add('day-text');

                const healthTempt = kidData.healthinfo.healthcheck.find(entry => entry.daily_fecha === formattedDate);
                const pTemp = document.createElement('p');
                pTemp.textContent = healthTempt ? `${healthTempt.temperature}°F` : '--';

                const pGuion = document.createElement('p');
                pGuion.textContent = '-';

                const healthReport = kidData.healthinfo.healthcheck.find(entry => entry.daily_fecha === formattedDate);
                const pReport = document.createElement('p');
                if (healthReport) {
                    if (healthReport.report === "Ninguno") {
                        pReport.textContent = "OK";
                    } else if (typeof healthReport.report === 'string') {
                        const reportCode = healthReport.report.split('-')[0];
                        pReport.textContent = reportCode;
                    } else {
                        pReport.textContent = "--";
                    }
                } else {
                    pReport.textContent = "--"; // Si no hay datos, mostrar "--"
                }

                textDiv.appendChild(pTemp);
                // textDiv.appendChild(pGuion);
                textDiv.appendChild(pReport);
                wrapper.appendChild(textDiv);
            } else {
                // Si el día es gris, solo agregamos el contenedor vacío
                const textDiv = document.createElement('div');
                textDiv.classList.add('day-text');
                wrapper.appendChild(textDiv);
            }

            return wrapper;
        }


        // Evento para actualizar el calendario al cambiar mes o año
        monthSelect.addEventListener('change', function () {
            currentMonth = parseInt(this.value, 10);
            generateCalendar(currentYear, currentMonth);
            asignarEventosCalendario();
        });

        yearSelect.addEventListener('change', function () {
            currentYear = parseInt(this.value, 10);
            generateCalendar(currentYear, currentMonth);
            asignarEventosCalendario();
        });

        // Generar el calendario inicial
        generateCalendar(currentYear, currentMonth);
        asignarEventosCalendario();


        // Evento para mostrar el Lightbox de agregar reporte
        // Evento para mostrar el Lightbox de agregar reporte
        if (btnAddreport) {
            btnAddreport.addEventListener("click", function () {
                if (!btnAddreport.disabled) {
                    const fechaSeleccionada = btnAddreport.getAttribute("data-fecha");
                    if (fechaSeleccionada) {
                        showLightboxAddHealthCkeck(fechaSeleccionada);
                    }
                }
            });
        }

        // Evento para mostrar el Lightbox de ver reporte
        if (btnViewreport) {
            btnViewreport.addEventListener("click", function () {
                if (!btnViewreport.disabled) {
                    const fechaSeleccionada = btnViewreport.getAttribute("data-fecha");
                    if (fechaSeleccionada) {
                        showLightboxViewHealthCkeck(fechaSeleccionada);
                    }
                }
            });
        }


        // Lógica para Reenviar Consentimiento COPPA
        const btnResend = document.getElementById('btnResendConsent');
        if (btnResend) {
            btnResend.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¿Enviar un nuevo correo de solicitud de consentimiento? Esto generará un nuevo token e invalidará enlaces anteriores.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#0cb5c3',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, enviar',
                    cancelButtonText: 'Cancelar',
                    background: "#f0feff",
                    color: "#333"
                }).then((result) => {
                    if (result.isConfirmed) {
                        const originalText = btnResend.innerHTML;
                        btnResend.disabled = true;
                        btnResend.innerHTML = 'Enviando...';

                        const childId = btnResend.getAttribute('data-child-id');

                        fetch('set/consent/resend_request.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ child_id: childId })
                        })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        title: 'Éxito',
                                        text: '✅ Correo enviado exitosamente.',
                                        icon: 'success',
                                        confirmButtonText: 'Entendido',
                                        confirmButtonColor: '#0cb5c3',
                                        background: "#f0feff",
                                        color: "#333"
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error',
                                        text: '❌ Error: ' + (data.message || 'Desconocido'),
                                        icon: 'error',
                                        confirmButtonText: 'Entendido',
                                        confirmButtonColor: '#0cb5c3',
                                        background: "#f0feff",
                                        color: "#333"
                                    });
                                }
                            })
                            .catch(err => {
                                console.error(err);
                                Swal.fire({
                                    title: 'Error',
                                    text: '❌ Error de conexión.',
                                    icon: 'error',
                                    confirmButtonText: 'Entendido',
                                    confirmButtonColor: '#0cb5c3',
                                    background: "#f0feff",
                                    color: "#333"
                                });
                            })
                            .finally(() => {
                                btnResend.disabled = false;
                                btnResend.innerHTML = originalText;
                            });
                    }
                });
            });
        }
    });
</script>