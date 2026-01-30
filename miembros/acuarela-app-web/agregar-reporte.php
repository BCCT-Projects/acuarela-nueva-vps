<?php $classBody ="agregarsalud"; include "includes/header.php"; 
$kid_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
$kid = ($kid_id) ? $a->getChildren($kid_id) : null;
if (!$kid) { die("Niño no encontrado o ID inválido."); }
?>
<script>
    let kidData = <?= json_encode($kid) ?>;
</script>
<main>
    <?php
    $mainHeaderTitle = "{$kid->name} {$kid->lastname}" ;
    // $action = '<a href="/miembros/acuarela-app-web/inspeccion" class="btn btn-action-primary enfasis btn-big"><i class="acuarela acuarela-Pago"></i>Generar informe</a>';
    include "templates/sectionHeader.php";    
    // Crea un objeto DateTime desde la cadena ISO 8601
    $birthdate = new DateTime($kid->birthdate);
    // Formatea la fecha al formato MM-DD-YYYY
    $birthdate_formateada = $birthdate->format('m-d-Y');
    // Crea un objeto DateTime desde la cadena ISO 8601
    $published_at = new DateTime($kid->published_at);
    // Formatea la fecha al formato MM-DD-YYYY
    $published_at_formateada = $published_at->format('m-d-Y');
?>
    <form id="healthInfoForm" method="POST">
        <div class="content">
            <div class="contentninx">
                <fieldset class="fieldsalud">
                    <h2>Reporte de incidentes</h2>
                    <div class="sectionsalud">
                        <h3 class="h3salud">Reportado por: </h3>
                        <div class="decorative-line"></div>

                        <span class="input-group">
                            <i class="saludicon acuarela acuarela-Usuario"></i>
                            <label class="labelpediatra" for="reportado_por">Reportado por: </label>
                            <input type="text" placeholder="Digitar nombre de quien reporta" name="reportado_por" id="reportado_por" 
                                   value="<?= isset($kid->healthinfo->incidents->reported_for) ? $kid->healthinfo->incidents->reported_for : "" ?>" required>
                            <span class="error-message"></span>
                        </span>

                        <span class="input-group">
                            <i class="saludicon acuarela acuarela-Ayuda"></i>
                            <label class="labelpediatra" for="tipo-incidente">Tipo de incidente</label>
                            <select name="tipo-incidente" id="tipo-incidente" required>
                                <option value="" disabled <?= empty($kid->healthinfo->incidents->incident_type) ? 'selected' : '' ?>>Síntomas de enfermedad</option>
                                <option value="Fiebre" <?= isset($kid->healthinfo->incidents->incident_type) && $kid->healthinfo->incidents->incident_type == "Fiebre" ? 'selected' : '' ?>>Fiebre</option>
                                <option value="Tos persistente" <?= isset($kid->healthinfo->incidents->incident_type) && $kid->healthinfo->incidents->incident_type == "Tos persistente" ? 'selected' : '' ?>>Tos persistente</option>
                                <option value="Congestión nasal" <?= isset($kid->healthinfo->incidents->incident_type) && $kid->healthinfo->incidents->incident_type == "Congestión nasal" ? 'selected' : '' ?>>Congestión nasal</option>
                                <option value="Dolor de garganta" <?= isset($kid->healthinfo->incidents->incident_type) && $kid->healthinfo->incidents->incident_type == "Dolor de garganta" ? 'selected' : '' ?>>Dolor de garganta</option>
                                <option value="Dificultad para respirar" <?= isset($kid->healthinfo->incidents->incident_type) && $kid->healthinfo->incidents->incident_type == "Dificultad para respirar" ? 'selected' : '' ?>>Dificultad para respirar</option>
                                <option value="Vómitos" <?= isset($kid->healthinfo->incidents->incident_type) && $kid->healthinfo->incidents->incident_type == "Vómitos" ? 'selected' : '' ?>>Vómitos</option>
                                <option value="Diarrea" <?= isset($kid->healthinfo->incidents->incident_type) && $kid->healthinfo->incidents->incident_type == "Diarrea" ? 'selected' : '' ?>>Diarrea</option>
                                <option value="Erupción cutánea" <?= isset($kid->healthinfo->incidents->incident_type) && $kid->healthinfo->incidents->incident_type == "Erupción cutánea" ? 'selected' : '' ?>>Erupción cutánea</option>
                                <option value="Caída o golpe" <?= isset($kid->healthinfo->incidents->incident_type) && $kid->healthinfo->incidents->incident_type == "Caída o golpe" ? 'selected' : '' ?>>Caída o golpe</option>
                                <option value="Sangrado (herida leve)" <?= isset($kid->healthinfo->incidents->incident_type) && $kid->healthinfo->incidents->incident_type == "Sangrado (herida leve)" ? 'selected' : '' ?>>Sangrado (herida leve)</option>
                                <option value="Reacción alérgica" <?= isset($kid->healthinfo->incidents->incident_type) && $kid->healthinfo->incidents->incident_type == "Reacción alérgica" ? 'selected' : '' ?>>Reacción alérgica</option>
                                <option value="Picadura de insecto" <?= isset($kid->healthinfo->incidents->incident_type) && $kid->healthinfo->incidents->incident_type == "Picadura de insecto" ? 'selected' : '' ?>>Picadura de insecto</option>
                                <option value="Fractura o esguince" <?= isset($kid->healthinfo->incidents->incident_type) && $kid->healthinfo->incidents->incident_type == "Fractura o esguince" ? 'selected' : '' ?>>Fractura o esguince</option>
                                <option value="Quemadura leve" <?= isset($kid->healthinfo->incidents->incident_type) && $kid->healthinfo->incidents->incident_type == "Quemadura leve" ? 'selected' : '' ?>>Quemadura leve</option>
                                <option value="Ingestión de objeto extraño" <?= isset($kid->healthinfo->incidents->incident_type) && $kid->healthinfo->incidents->incident_type == "Ingestión de objeto extraño" ? 'selected' : '' ?>>Ingestión de objeto extraño</option>
                                <option value="Asfixia (obstrucción leve)" <?= isset($kid->healthinfo->incidents->incident_type) && $kid->healthinfo->incidents->incident_type == "Asfixia (obstrucción leve)" ? 'selected' : '' ?>>Asfixia (obstrucción leve)</option>
                                <option value="Mareos o desmayo" <?= isset($kid->healthinfo->incidents->incident_type) && $kid->healthinfo->incidents->incident_type == "Mareos o desmayo" ? 'selected' : '' ?>>Mareos o desmayo</option>
                                <option value="Convulsiones" <?= isset($kid->healthinfo->incidents->incident_type) && $kid->healthinfo->incidents->incident_type == "Convulsiones" ? 'selected' : '' ?>>Convulsiones</option>
                                <option value="Síntomas de deshidratación" <?= isset($kid->healthinfo->incidents->incident_type) && $kid->healthinfo->incidents->incident_type == "Síntomas de deshidratación" ? 'selected' : '' ?>>Síntomas de deshidratación</option>
                                <option value="Other" <?= isset($kid->healthinfo->incidents->incident_type) && $kid->healthinfo->incidents->incident_type == "Other" ? 'selected' : '' ?>>Other</option>
                            </select>
                            <span class="error-message"></span>
                        </span>


                        <span class="input-group">
                            <i class="saludicon acuarela acuarela-Informacion"></i>
                            <label class="labelpediatra" for="descripcion">Descripción</label>
                            <input type="text" placeholder="Describe lo sucedido" name="descripcion" id="descripcion" 
                                   value="<?= isset($kid->healthinfo->incidents->description) ? $kid->healthinfo->incidents->description : "" ?>" required>
                            <span class="error-message"></span>
                        </span>

                        <span class="input-group">
                            <i class="saludicon acuarela acuarela-Advertencia"></i>
                            <label class="labelpediatra" for="temperatura">Temperatura</label>
                            <input type="text" placeholder="Digita la temperatura del niño" name="temperatura" id="temperatura" 
                                   value="<?= isset($kid->healthinfo->incidents->temperature) ? $kid->healthinfo->incidents->temperature : "" ?>" required>
                            <span class="tempspan">°F</span>
                            <span class="error-message"></span>
                        </span>

                        <span class="input-group">
                            <i class="saludicon acuarela acuarela-Prioridad"></i>
                            <label class="labelpediatra" for="levelgrave">Nivel de gravedad</label>
                            <select name="levelgrave" id="levelgrave" required>
                                <option value="" disabled <?= empty($kid->healthinfo->incidents->gravedad) ? 'selected' : '' ?>> Agregar el nivel de gravedad del ninxs </option>
                                <option value="Leve" <?= isset($kid->healthinfo->incidents->gravedad) && $kid->healthinfo->incidents->gravedad == "Leve" ? 'selected' : '' ?>> Leve </option>
                                <option value="Moderado" <?= isset($kid->healthinfo->incidents->gravedad) && $kid->healthinfo->incidents->gravedad == "Moderado" ? 'selected' : '' ?>> Moderado </option>
                                <option value="Grave" <?= isset($kid->healthinfo->incidents->gravedad) && $kid->healthinfo->incidents->gravedad == "Grave" ? 'selected' : '' ?>> Grave </option>
                            </select>
                            <span class="error-message"></span>
                        </span>

                        <?php
                            $reportTranslations = [
                                "A-Absent" => "Ausente",
                                "B-Bruise" => "Moretón",
                                "C-Crusty Eyes" => "Ojos con Costra",
                                "CS-Cuts/Scrapes" => "Cortes/raspaduras",
                                "D-Diarrhea" => "Diarrea",
                                "E-Earache" => "Dolor de oídos",
                                "F-Feverish" => "Febril",
                                "FC-Flushed Complexion" => "Tez enrojecida",
                                "G-Glazed eyes" => "Ojos vidriosos",
                                "H-Headache" => "Dolor de cabeza",
                                "HA-Hyperactive" => "Hiperactiva",
                                "HL-Head Lice" => "Piojos",
                                "I-Irritable" => "Irritable",
                                "L-Listless" => "Apático",
                                "M-Mild Cough" => "Tos leve",
                                "N-Nasal Discharge" => "Secreción nasal",
                                "OK-Okay" => "Okay",
                                "OS-Open Sores" => "Llagas abiertas",
                                "P-Pale" => "Pálida",
                                "R-Rash" => "Erupción",
                                "S-Sleepy" => "Somnolienta",
                                "SC-Severe Cough" => "Tos severa",
                                "ST-Sore Throat" => "Dolor de garganta",
                                "V-Vomiting" => "Vómitos",
                                "W-Wheezing" => "Sibilancia"
                            ];
                                $selectedStateHealth = isset($kid->healthinfo->incidents->statehealth) ? $kid->healthinfo->incidents->statehealth : "";
                            ?>
                        <span class="input-group">
                            <i class="saludicon acuarela acuarela-Salud"></i>
                            <label class="labelpediatra" for="report">Estado de salud </label> 
                            <select class="selectreport" name="statehealth" id="report2">
                                <option value="" disabled <?= empty($selectedStateHealth) ? 'selected' : '' ?>>Seleccione</option>
                                <?php foreach ($reportTranslations as $key => $value): ?>
                                    <option value="<?= $key ?>" <?= ($selectedStateHealth == $key) ? 'selected' : '' ?>>
                                        <?= $key ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <span class="info-select"> 
                                <span class="selected-report-container">
                                    <span class="text-real">
                                        <span class="circle-indicator"></span>
                                        <span id="selected-report2">Sin seleccionar</span>
                                    </span>
                                    <span id="translated-report2"></span> <!-- Aquí se mostrará la traducción -->
                                </span>
                            </span>
                            <span class="error-message"></span>
                        </span>

                        <span class="input-group">
                            <i class="saludicon acuarela acuarela-Informacion"></i>
                            <label class="labelpediatra" for="acciones_tomadas">Acciones tomadas</label>
                            <input type="text" placeholder="Describe las acciones realizadas" name="acciones_tomadas" id="acciones_tomadas" 
                                   value="<?= isset($kid->healthinfo->incidents->actions_taken) ? $kid->healthinfo->incidents->actions_taken : "" ?>" required>
                            <span class="error-message"></span>
                        </span>

                        <span class="input-group">
                            <i class="saludicon acuarela acuarela-Informacion"></i>
                            <label class="labelpediatra" for="acciones_esperadas">Acciones esperadas</label>
                            <input type="text" placeholder="Describe las acciones que deberia realizar el acudiente" name="acciones_esperadas" id="acciones_esperadas" 
                                   value="<?= isset($kid->healthinfo->incidents->actions_expected) ? $kid->healthinfo->incidents->actions_expected : "" ?>" required>
                            <span class="error-message"></span>
                        </span>
                        
                    </div>
                    <div class="send-salud">
                        <button class="btn btn-action-primary enfasis btn-big btn-add" type="button" onclick="handleReportInfo()"> Guardar </button>
                    </div>
                </fieldset>
            </div>
        </div>
    </form>
</main>
<?php include "includes/footer.php" ?>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        // ===> Modificar el select y los contenidos mostrados segun su seleccion
        const selectElement = document.getElementById("report2");
        const selectedReportSpan = document.getElementById("selected-report2");
        const translatedReportSpan = document.getElementById("translated-report2");

        // Mapa de traducción de PHP convertido a JavaScript
        const reportTranslations = <?php echo json_encode($reportTranslations); ?>;

        selectElement.addEventListener("change", function() {
            const selectedValue = this.value;
            if (selectedValue) {
                selectedReportSpan.textContent = selectedValue; // Muestra la opción en inglés
                translatedReportSpan.textContent = reportTranslations[selectedValue]; // Traducción en español
            } else {
                selectedReportSpan.textContent = "Sin seleccionar";
                translatedReportSpan.textContent = "";
            }
        });


        // ===> Verificar si se debe mostrar el botón
        if (localStorage.getItem("showEmergencyButton") === "true") {
            const sendSaludDiv = document.querySelector(".send-salud");
            const guardarBtn = document.querySelector(".btn-add");

            if (sendSaludDiv && guardarBtn) {
                guardarBtn.style.display = "none";

                // Crear el contenedor principal
                const questionDiv = document.createElement("div");
                questionDiv.className = "emergency-question";
                questionDiv.innerHTML = `
                    <i class="acuarela acuarela-Informacion"></i>
                    <p>¿Quieres enviar un reporte detallado al padre de familia?</p>
                    <div class="interaction-container">
                        <input type="radio" name="reportOption" value="yes" id="reportYes">
                        <label for="reportYes">Sí</label>
                        <input type="radio" name="reportOption" value="no" id="reportNo">
                        <label for="reportNo">No</label>
                        <button class="btn btn-action-primary enfasis btn-big btn-add confirm-button" type="button">Confirmar</button>
                    </div>
                `;

                // Agregar la pregunta al DOM
                sendSaludDiv.appendChild(questionDiv);

                // Evento para manejar la selección
                document.querySelector(".confirm-button").addEventListener("click", () => {
                    const selectedOption = document.querySelector('input[name="reportOption"]:checked');

                    if (selectedOption) {
                        if (selectedOption.value === "yes") {
                            if (window.innerWidth > 425) {
                                showLightboxParient();
                            } else {
                                showLightboxEmergency();
                            }
                        } else {
                            window.location.href = `/miembros/acuarela-app-web/ninxs/${kidData._id}`;
                        }
                        questionDiv.remove();
                        localStorage.removeItem("showEmergencyButton");
                    } else {
                        alert("Por favor selecciona una opción.");
                    }
                });
            }
        }
    });

</script>
