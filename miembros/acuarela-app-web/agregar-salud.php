<?php $classBody = "agregarsalud";
include "includes/header.php";
$kid_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);

if (!$kid_id) { die("ID no válido"); }

$kid = $a->getChildren($kid_id);

// Descifrar datos de salud para edición
if (isset($kid->healthinfo)) {
    $kid->healthinfo = $a->decryptHealthData($kid->healthinfo);
}

// Verificar estado COPPA - Solo permitir si está aprobado
$coppaStatus = 'pending';
if (isset($kid->id)) {
    $consents = $a->queryStrapi("parental-consents?child_id={$kid->id}&_sort=createdAt:desc&_limit=1");
    if (is_array($consents) && count($consents) > 0) {
        $coppaStatus = $consents[0]->consent_status ?? 'pending';
    }
}

if ($coppaStatus !== 'granted') {
    header("Location: /miembros/acuarela-app-web/ninxs/{$kid_id}");
    echo "<script>alert('⚠️ No se puede modificar información de salud porque el consentimiento COPPA no está aprobado.');</script>";
    exit;
}
?>
<script>
    let kidData = <?= json_encode($kid) ?>;
</script>

<main>
    <?php
    $mainHeaderTitle = "{$kid->name} {$kid->lastname}";
    include "templates/sectionHeader.php";
    ?>
    <form id="healthInfoForm" method="POST">
        <div class="content">
            <div class="contentninx">
                <fieldset class="fieldsalud">
                    <h2>Información salud del niño </h2>
                    <div class="sectionsalud">
                        <h3 class="h3salud">Historial de salud: </h3>
                        <div class="decorative-line"></div>
                        <span class="input-group2">
                            <input type="hidden" name="asma" value="0">
                            <input type="checkbox" name="asma" id="asma" value="1" hidden>
                            <label for="asma" class="checkboxsalud">
                                <span class="fake-checkbox"></span> Asma
                            </label>
                            <span class="error-message"></span>
                        </span>
                        <span class="input-group">
                            <label for="alergias">Alergias</label>
                            <input type="text" placeholder="Agregar alergías" name="alergias" id="alergias"
                                value="<?= isset($kid->healthinfo->allergies) && is_array($kid->healthinfo->allergies) ? implode(', ', $kid->healthinfo->allergies) : $kid->healthinfo->allergies ?>"
                                required>
                            <i class="agregar-inputs acu acuarela acuarela-Agregar"></i>
                            <span class="error-message"></span>
                        </span>
                        <span class="input-group">
                            <label for="medicamentos">Medicamentos</label>
                            <input type="text" placeholder="Agregar medicamentos" name="medicamentos" id="medicamentos"
                                value="<?= isset($kid->healthinfo->medicines) && is_array($kid->healthinfo->medicines) ? implode(', ', $kid->healthinfo->medicines) : $kid->healthinfo->medicines ?>"
                                required>
                            <i class="agregar-inputs acu acuarela acuarela-Agregar"></i>
                            <span class="error-message"></span>
                        </span>
                        <span class="input-group">
                            <label for="vacunas">Vacunas</label>
                            <input type="text" placeholder="Agregar vacunas" name="vacunas" id="vacunas"
                                value="<?= isset($kid->healthinfo->vacination) && is_array($kid->healthinfo->vacination) ? implode(', ', $kid->healthinfo->vacination) : $kid->healthinfo->vacination ?>"
                                required>
                            <i class="agregar-inputs acu acuarela acuarela-Agregar"></i>
                            <span class="error-message"></span>
                        </span>
                        <span class="input-group">
                            <label for="accidentes">Accidentes</label>
                            <input type="text" placeholder="Agregar accidentes" name="accidentes" id="accidentes"
                                value="<?= isset($kid->healthinfo->accidents) && is_array($kid->healthinfo->accidents) ? implode(', ', $kid->healthinfo->accidents) : $kid->healthinfo->accidents ?>"
                                required>
                            <i class="agregar-inputs acu acuarela acuarela-Agregar"></i>
                            <span class="error-message"></span>
                        </span>
                        <span class="input-group">
                            <label for="salud_fisica">Salud fisica</label>
                            <input type="text" placeholder="Agregar el estado de salud física" name="salud_fisica"
                                id="salud_fisica"
                                value="<?= isset($kid->healthinfo->physical_health) ? $kid->healthinfo->physical_health : "" ?>">
                            <span class="error-message"></span>
                        </span>
                        <span class="input-group">
                            <label for="salud_emocional">Salud emocional</label>
                            <input type="text" placeholder="Agregar su salud mental" name="salud_emocional"
                                id="salud_emocional"
                                value="<?= isset($kid->healthinfo->emotional_health) ? $kid->healthinfo->emotional_health : "" ?>">
                            <span class="error-message"></span>
                        </span>
                        <span class="input-group">
                            <label for="sospecha_abuso">Sospecha de abuso</label>
                            <input type="text" placeholder="En caso de existir sospecha agregar detalles"
                                name="sospecha_abuso" id="sospecha_abuso"
                                value="<?= isset($kid->healthinfo->suspected_abuse) ? $kid->healthinfo->suspected_abuse : "" ?>"
                                required>
                            <span class="error-message"></span>
                        </span>
                    </div>
                    <div class="sectionsalud">
                        <h3 class="h3salud">Ungüentos autorizados: </h3>
                        <div class="decorative-line"></div>
                        <span class="input-group">
                            <label for="name">Ungüentos </label>
                            <input type="text" placeholder="Agregar marcar de cremas, bloqueadores solares, etc"
                                name="unguentos" id="unguentos"
                                value="<?= isset($kid->healthinfo->ointments) && is_array($kid->healthinfo->ointments) ? implode(', ', $kid->healthinfo->ointments) : $kid->healthinfo->ointments ?>">
                            <i class="agregar-inputs acu acuarela acuarela-Agregar"></i>
                            <span class="error-message"></span>
                        </span>
                    </div>
                    <div class="sectionsalud">
                        <h3 class="h3salud">Información de médico o pediatra: </h3>
                        <div class="decorative-line"></div>
                        <span class="input-group">
                            <i class="saludicon acuarela acuarela-Usuario"></i>
                            <label class="labelpediatra" for="name">Médico</label>
                            <input type="text" placeholder="Ingresar nombre del médico" name="pedriatra" id="pedriatra"
                                value="<?= isset($kid->healthinfo->pediatrician) ? $kid->healthinfo->pediatrician : "" ?>">
                            <span class="error-message"></span>
                        </span>
                        <span class="input-group">
                            <i class="saludicon acuarela acuarela-Telefono"></i>
                            <label class="labelpediatra" for="name">Teléfono</label>
                            <input type="text" placeholder="Agregar numero del médico" name="pedriatra_numero"
                                id="pedriatra_numero"
                                value="<?= isset($kid->healthinfo->pediatrician_number) ? $kid->healthinfo->pediatrician_number : "" ?>">
                            <span class="error-message"></span>
                        </span>
                        <span class="input-group">
                            <i class="saludicon acuarela acuarela-Mensajes"></i>
                            <label class="labelpediatra" for="name">Correo electrónico</label>
                            <input type="text"
                                placeholder="Agregar correo del medio (Recuerde agregar un correo valido con terminacion @example.com)"
                                name="pedriatra_email" id="pedriatra_email"
                                value="<?= isset($kid->healthinfo->pediatrician_email) ? $kid->healthinfo->pediatrician_email : "" ?>">
                            <span class="error-message"></span>
                        </span>
                    </div>
                    <div class="send-salud">
                        <?php
                        $buttonText = isset($kid->healthinfo) ? "Actualizar datos" : "Agregar datos"; // Verificar si existen datos de salud en el objeto $kid
                        ?>
                        <button id="saveButton" class="btn btn-action-primary enfasis btn-big btn-add" type="button"
                            onclick="handleHealthInfo()">
                            <?php echo $buttonText; ?>
                        </button>
                    </div>
                </fieldset>
            </div>
        </div>
    </form>
</main>
<?php include "includes/footer.php" ?>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        //Crear mas inputs 
        document.querySelectorAll(".agregar-inputs").forEach(addButton => {
            addButton.addEventListener("click", () => {
                const container = addButton.closest(".input-group");
                const originalInput = container.querySelector("input");
                const newInput = document.createElement("input");
                newInput.type = "text";
                newInput.name = originalInput.name;
                // newInput.placeholder = `Agregar otra ${originalInput.placeholder.toLowerCase()}`;
                newInput.placeholder = `Agregar nueva entrada`;
                newInput.classList.add("extra-input");
                container.insertBefore(newInput, addButton);  // Insertar el nuevo input antes del botón "agregar"
            });
        });
    });
</script>