<?php
// privacy/ferpa.php - Formulario público FERPA (independiente de sesión)
// Evitar que el navegador cachee versiones viejas del formulario/JS (esto causaba “en incógnito sí, normal no”).
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

require_once __DIR__ . '/../includes/env.php';
$siteKey = Env::get('RECAPTCHA_SITE_KEY', '');

// Detectar idioma (default: es)
$lang = isset($_GET['lang']) && in_array($_GET['lang'], ['es', 'en']) ? $_GET['lang'] : 'es';

$t = [
    'es' => [
        'title' => 'Centro de Privacidad',
        'subtitle' => 'Derechos Educativos (FERPA)',
        'desc' => 'La Ley de Derechos Educativos y Privacidad Familiar (FERPA) le otorga como padre o tutor ciertos derechos sobre los registros educativos de sus hijos. Utilice este formulario para ejercer estos derechos de manera formal.',
        'what_is_ferpa' => '¿Qué es FERPA?',
        'ferpa_info' => 'FERPA es una ley federal que protege la privacidad de los registros educativos de los estudiantes.',
        'right_access' => 'Acceso',
        'right_access_desc' => 'Solicitar ver copias de los registros educativos.',
        'right_correction' => 'Corrección',
        'right_correction_desc' => 'Solicitar la enmienda de registros que considere inexactos.',
        'label_type' => 'Tipo de Solicitud',
        'opt_access' => 'Acceso a Registros Educativos',
        'opt_correction' => 'Solicitud de Corrección/Enmienda',
        'label_email' => 'Correo Electrónico Registrado (Padre/Tutor)',
        'placeholder_email' => 'ejemplo@correo.com',
        'label_phone' => 'Número de Teléfono Registrado',
        'placeholder_phone' => 'Ej: 555-123-4567',
        'phone_help' => 'Utilizaremos estos datos para validar su identidad.',
        'label_child_name' => 'Nombre del Estudiante',
        'placeholder_child_name' => 'Nombre completo del niño/a',
        'label_details' => 'Detalles de la Solicitud',
        'placeholder_access' => 'Describa qué registros desea revisar (ej. Reportes de Progreso 2025, Asistencia del último mes)...',
        'placeholder_correction' => "Indique claramente:\n1. El registro que es incorrecto.\n2. Por qué es incorrecto.\n3. Cómo debería corregirse.",
        'details_help_access' => 'Sea específico para agilizar la búsqueda.',
        'details_help_correction' => 'Debe aportar evidencia o razón justificada para la enmienda.',
        'btn_submit' => 'Enviar Solicitud Oficial',
        'btn_processing' => 'Procesando...',
        'back_home' => 'Volver al inicio',
        'footer_rights' => 'Bilingual Child Care Training (BCCT). Todos los derechos reservados.',
        'error_connection' => 'Error de conexión. Intente nuevamente.',
        'bot_detected' => 'Error de validación de seguridad. Por favor intente nuevamente.'
    ],
    'en' => [
        'title' => 'Privacy Center',
        'subtitle' => 'Educational Rights (FERPA)',
        'desc' => 'The Family Educational Rights and Privacy Act (FERPA) grants you as a parent or guardian certain rights over your children\'s educational records. Use this form to formally exercise these rights.',
        'what_is_ferpa' => 'What is FERPA?',
        'ferpa_info' => 'FERPA is a federal law that protects the privacy of student education records.',
        'right_access' => 'Access',
        'right_access_desc' => 'Request to view copies of educational records.',
        'right_correction' => 'Correction',
        'right_correction_desc' => 'Request amendment of records you believe are inaccurate.',
        'label_type' => 'Request Type',
        'opt_access' => 'Access to Educational Records',
        'opt_correction' => 'Correction/Amendment Request',
        'label_email' => 'Registered Email (Parent/Guardian)',
        'placeholder_email' => 'example@email.com',
        'label_phone' => 'Registered Phone Number',
        'placeholder_phone' => 'Ex: 555-123-4567',
        'phone_help' => 'We will use this information to verify your identity.',
        'label_child_name' => 'Student Name',
        'placeholder_child_name' => 'Child\'s full name',
        'label_details' => 'Request Details',
        'placeholder_access' => 'Describe which records you wish to review (e.g., Progress Reports 2025, Last month\'s attendance)...',
        'placeholder_correction' => "Clearly indicate:\n1. The record that is incorrect.\n2. Why it is incorrect.\n3. How it should be corrected.",
        'details_help_access' => 'Be specific to expedite the search.',
        'details_help_correction' => 'You must provide evidence or justified reason for the amendment.',
        'btn_submit' => 'Submit Official Request',
        'btn_processing' => 'Processing...',
        'back_home' => 'Back to Home',
        'footer_rights' => 'Bilingual Child Care Training (BCCT). All rights reserved.',
        'error_connection' => 'Connection error. Please try again.',
        'bot_detected' => 'Security validation error. Please try again.'
    ]
][$lang];
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $t['title'] ?> - Acuarela</title>
    <link rel="shortcut icon" href="../img/favicon.png">

    <!-- Google reCAPTCHA v2 -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --cielo: #0CB5C3;
            --sandia: #FA6F5C;
            --sandia-dark: #E65252;
            --blanco: #FFFFFF;
            --gris-bg: #F9FAFB;
            --gris-text-dark: #111827;
            --gris-text-light: #6B7280;
            --border-input: #D1D5DB;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            font-family: 'Outfit', sans-serif;
            background-color: var(--gris-bg);
            color: var(--gris-text-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1.5;
        }

        .main-wrapper {
            width: 100%;
            max-width: 650px;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Language Switcher */
        .lang-selector {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 8px;
            z-index: 100;
        }

        .lang-btn {
            background: white;
            color: var(--gris-text-light);
            padding: 6px 14px;
            border-radius: 20px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.2s;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-input);
        }

        .lang-btn:hover,
        .lang-btn.active {
            background: var(--cielo);
            color: white;
            border-color: var(--cielo);
        }

        /* Header */
        .header-section {
            text-align: center;
            margin-bottom: 2rem;
            width: 100%;
        }

        .logo {
            height: 48px;
            margin-bottom: 1.5rem;
        }

        h1 {
            font-size: 1.875rem;
            font-weight: 700;
            margin: 0 0 0.5rem 0;
            color: var(--gris-text-dark);
            letter-spacing: -0.025em;
        }

        .subtitle {
            font-size: 1.1rem;
            color: var(--gris-text-light);
            margin: 0;
        }

        /* Card */
        .card {
            background: white;
            padding: 2.5rem;
            border-radius: 24px;
            box-shadow: var(--shadow-lg);
            width: 100%;
            border: 1px solid rgba(0, 0, 0, 0.02);
        }

        /* Info Box */
        .info-box {
            background: linear-gradient(135deg, #E0F7FA 0%, #F3F4F6 100%);
            padding: 1.25rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            border-left: 4px solid var(--cielo);
        }

        .info-box h3 {
            font-size: 1rem;
            font-weight: 600;
            margin: 0 0 0.75rem 0;
            color: var(--cielo);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-box p {
            font-size: 0.9rem;
            color: var(--gris-text-light);
            margin: 0 0 1rem 0;
        }

        .rights-list {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .right-item {
            flex: 1;
            min-width: 200px;
            background: white;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            box-shadow: var(--shadow-sm);
        }

        .right-item strong {
            color: var(--cielo);
            font-size: 0.9rem;
        }

        .right-item span {
            display: block;
            font-size: 0.8rem;
            color: var(--gris-text-light);
            margin-top: 4px;
        }

        .description {
            font-size: 0.95rem;
            color: var(--gris-text-light);
            margin-bottom: 2rem;
            text-align: center;
            background: #F3F4F6;
            padding: 1rem;
            border-radius: 12px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--gris-text-dark);
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        select,
        textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-input);
            border-radius: 12px;
            font-size: 1rem;
            font-family: inherit;
            background: #fff;
            transition: all 0.2s;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: var(--cielo);
            outline: none;
            box-shadow: 0 0 0 4px rgba(12, 181, 195, 0.1);
        }

        textarea {
            resize: vertical;
            min-height: 120px;
        }

        .form-help {
            font-size: 0.8rem;
            color: var(--gris-text-light);
            margin-top: 0.5rem;
        }

        .btn-submit {
            width: 100%;
            padding: 1rem;
            background-color: var(--cielo);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
            margin-top: 1rem;
            box-shadow: 0 4px 6px rgba(12, 181, 195, 0.2);
        }

        .btn-submit:hover {
            background-color: #0aa3b0;
            transform: translateY(-1px);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit:disabled {
            opacity: 0.7;
            cursor: wait;
        }

        /* Messages */
        .message {
            margin-top: 1.5rem;
            padding: 1rem;
            border-radius: 12px;
            font-size: 0.95rem;
            text-align: center;
            display: none;
            line-height: 1.4;
        }

        .message.success {
            background-color: #ECFDF5;
            color: #065F46;
            border: 1px solid #A7F3D0;
        }

        .message.error {
            background-color: #FEF2F2;
            color: #991B1B;
            border: 1px solid #FECACA;
        }

        /* Footer */
        .footer {
            margin-top: 2rem;
            text-align: center;
            font-size: 0.85rem;
            color: var(--gris-text-light);
        }

        .back-link {
            color: var(--cielo);
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: background 0.2s;
        }

        .back-link:hover {
            background: rgba(12, 181, 195, 0.1);
        }

        /* Honeypot */
        .website-bot {
            display: none !important;
        }

        /* reCAPTCHA centering */
        .recaptcha-wrapper {
            display: flex;
            justify-content: center;
            margin: 1.5rem 0;
        }

        @media (max-width: 640px) {
            .card {
                padding: 1.5rem;
            }

            .main-wrapper {
                padding: 1rem;
            }

            .rights-list {
                flex-direction: column;
            }

            .right-item {
                min-width: auto;
            }
        }
    </style>
</head>

<body>
    <!-- Lang Switcher -->
    <div class="lang-selector">
        <a href="?lang=es" class="lang-btn <?= $lang == 'es' ? 'active' : '' ?>">ES</a>
        <a href="?lang=en" class="lang-btn <?= $lang == 'en' ? 'active' : '' ?>">EN</a>
    </div>

    <div class="main-wrapper">
        <header class="header-section">
            <img src="../img/logos/logotipo_color.svg" alt="Acuarela" class="logo">
            <h1><?= $t['title'] ?></h1>
            <p class="subtitle"><?= $t['subtitle'] ?></p>
        </header>

        <div class="card">
            <!-- FERPA Info Box -->
            <div class="info-box">
                <h3>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                    <?= $t['what_is_ferpa'] ?>
                </h3>
                <p><?= $t['ferpa_info'] ?></p>
                <div class="rights-list">
                    <div class="right-item">
                        <strong><?= $t['right_access'] ?></strong>
                        <span><?= $t['right_access_desc'] ?></span>
                    </div>
                    <div class="right-item">
                        <strong><?= $t['right_correction'] ?></strong>
                        <span><?= $t['right_correction_desc'] ?></span>
                    </div>
                </div>
            </div>

            <p class="description"><?= $t['desc'] ?></p>

            <form id="ferpaForm">
                <!-- Honeypot -->
                <input type="text" name="website_check" class="website-bot" tabindex="-1" autocomplete="off">

                <!-- Paso 1: Identidad -->
                <div id="identitySection">
                    <div class="form-group">
                        <label for="requester_email"><?= $t['label_email'] ?></label>
                        <input type="email" id="requester_email" name="requester_email"
                            placeholder="<?= $t['placeholder_email'] ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="requester_phone"><?= $t['label_phone'] ?></label>
                        <input type="tel" id="requester_phone" name="requester_phone"
                            placeholder="<?= $t['placeholder_phone'] ?>" required>
                        <p class="form-help"><?= $t['phone_help'] ?></p>
                    </div>

                    <button type="button" id="validateIdentityBtn" class="btn-submit">
                        <?= $lang === 'es' ? 'Validar datos' : 'Validate data' ?>
                    </button>
                </div>

                <!-- Paso 2: Selección de hijo y detalles (oculto hasta validar) -->
                <div id="requestSection" style="display:none; margin-top:1.5rem;">
                    <!-- Selector de estudiante (solo cuando haya hijos asociados) -->
                    <div class="form-group" id="childSelectGroup" style="display:none;">
                        <label for="child_id"><?= $t['label_child_name'] ?></label>
                        <select id="child_id" name="child_id">
                            <!-- Opciones llenadas vía JS -->
                        </select>
                        <p class="form-help" id="childSelectHelp">
                            <?= $lang === 'es'
                                ? 'Seleccione el estudiante para el que desea ejercer los derechos FERPA.'
                                : 'Select the student for whom you wish to exercise FERPA rights.' ?>
                        </p>
                    </div>

                    <!-- Nombre manual del estudiante (solo cuando no haya hijos asociados) -->
                    <div class="form-group" id="childNameGroup" style="display:none;">
                        <label for="child_name"><?= $t['label_child_name'] ?></label>
                        <input type="text" id="child_name" name="child_name"
                            placeholder="<?= $t['placeholder_child_name'] ?>">
                        <p class="form-help" id="childNameHelp">
                            <?= $lang === 'es'
                                ? 'Si no aparece en la lista, escriba el nombre completo del estudiante.'
                                : 'If not listed, type the student’s full name.' ?>
                        </p>
                    </div>

                    <div class="form-group">
                        <label for="request_type"><?= $t['label_type'] ?></label>
                        <select name="request_type" id="request_type" required>
                            <option value="access"><?= $t['opt_access'] ?></option>
                            <option value="correction"><?= $t['opt_correction'] ?></option>
                        </select>
                    </div>

                    <!-- Campos adicionales para solicitudes de CORRECCIÓN (registro específico) -->
                    <div id="correctionRecordBlock" style="display:none;">
                        <div class="form-group">
                            <label for="record_type"><?= $lang === 'es' ? 'Tipo de Registro a Corregir' : 'Record Type to Correct' ?></label>
                            <select id="record_type" name="record_type">
                                <option value=""><?= $lang === 'es' ? 'Seleccione una opción' : 'Select an option' ?></option>
                                <option value="attendance"><?= $lang === 'es' ? 'Asistencia' : 'Attendance' ?></option>
                                <option value="activities"><?= $lang === 'es' ? 'Evaluaciones / Actividades' : 'Activities' ?></option>
                                <option value="development_report"><?= $lang === 'es' ? 'Reporte de desarrollo' : 'Development report' ?></option>
                                <option value="inscription"><?= $lang === 'es' ? 'Inscripción' : 'Enrollment' ?></option>
                                <option value="communication"><?= $lang === 'es' ? 'Comunicación institucional' : 'Institutional communication' ?></option>
                                <option value="other"><?= $lang === 'es' ? 'Otro' : 'Other' ?></option>
                            </select>
                            <p class="form-help">
                                <?= $lang === 'es'
                                    ? 'Indique a qué tipo de registro educativo se refiere su corrección.'
                                    : 'Indicate which educational record type your correction refers to.' ?>
                            </p>
                        </div>

                        <div class="form-group">
                            <label for="record_ref"><?= $lang === 'es' ? 'Referencia del Registro (ID o detalle)' : 'Record Reference (ID or details)' ?></label>
                            <input type="text" id="record_ref" name="record_ref"
                                placeholder="<?= $lang === 'es' ? 'Ej: ID del registro, fecha, o referencia' : 'Ex: record ID, date, or reference' ?>">
                            <p class="form-help">
                                <?= $lang === 'es'
                                    ? 'Si no conoce el ID exacto, describa la referencia (fecha, sección, etc.).'
                                    : 'If you don’t know the exact ID, describe a reference (date, section, etc.).' ?>
                            </p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="details"><?= $t['label_details'] ?></label>
                        <textarea id="details" name="details" placeholder="<?= $t['placeholder_access'] ?>" required></textarea>
                        <p class="form-help" id="detailsHelp"><?= $t['details_help_access'] ?></p>
                    </div>

                    <?php if (!empty($siteKey)): ?>
                        <div class="recaptcha-wrapper">
                            <div class="g-recaptcha" data-sitekey="<?= htmlspecialchars($siteKey) ?>"></div>
                        </div>
                    <?php endif; ?>

                    <button type="submit" class="btn-submit"><?= $t['btn_submit'] ?></button>
                </div>
            </form>

            <div id="responseMessage" class="message"></div>
        </div>

        <footer class="footer">
            <a href="../" class="back-link">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                <?= $t['back_home'] ?>
            </a>
            <p>&copy; <?= date('Y') ?> <?= $t['footer_rights'] ?></p>
        </footer>
    </div>

    <script>
        const loadTime = Date.now();
        const translations = {
            placeholder_access: <?= json_encode($t['placeholder_access']) ?>,
            placeholder_correction: <?= json_encode($t['placeholder_correction']) ?>,
            details_help_access: <?= json_encode($t['details_help_access']) ?>,
            details_help_correction: <?= json_encode($t['details_help_correction']) ?>,
            btn_submit: <?= json_encode($t['btn_submit']) ?>,
            btn_processing: <?= json_encode($t['btn_processing']) ?>,
            error_connection: <?= json_encode($t['error_connection']) ?>,
            bot_detected: <?= json_encode($t['bot_detected']) ?>,
            validate_label: <?= json_encode($lang === 'es' ? 'Validar datos' : 'Validate data') ?>,
            validating_label: <?= json_encode($lang === 'es' ? 'Validando...' : 'Validating...') ?>,
            identity_ok: <?= json_encode($lang === 'es' ? 'Datos validados. Ahora seleccione el estudiante y complete la solicitud.' : 'Data validated. Now select the student and complete the request.') ?>,
            no_children: <?= json_encode($lang === 'es' ? 'No encontramos estudiantes asociados. Puede escribir el nombre manualmente.' : 'We did not find associated students. You can type the name manually.') ?>
        };

        // Toggle placeholder based on request type
        document.getElementById('request_type').addEventListener('change', function() {
            const textarea = document.getElementById('details');
            const help = document.getElementById('detailsHelp');
            const corrBlock = document.getElementById('correctionRecordBlock');
            const recordType = document.getElementById('record_type');

            if (this.value === 'correction') {
                textarea.placeholder = translations.placeholder_correction;
                help.textContent = translations.details_help_correction;
                if (corrBlock) corrBlock.style.display = 'block';
                if (recordType) recordType.required = true;
            } else {
                textarea.placeholder = translations.placeholder_access;
                help.textContent = translations.details_help_access;
                if (corrBlock) corrBlock.style.display = 'none';
                if (recordType) recordType.required = false;
            }
        });

        // Paso 1: Validar identidad y cargar hijos
        document.getElementById('validateIdentityBtn').addEventListener('click', async function() {
            const form = document.getElementById('ferpaForm');
            const messageDiv = document.getElementById('responseMessage');
            const identitySection = document.getElementById('identitySection');
            const requestSection = document.getElementById('requestSection');
            const childSelectGroup = document.getElementById('childSelectGroup');
            const childNameGroup = document.getElementById('childNameGroup');
            const childSelect = document.getElementById('child_id');

            // Honeypot simple
            if (form.querySelector('input[name="website_check"]').value) return;

            const email = document.getElementById('requester_email').value.trim();
            const phone = document.getElementById('requester_phone').value.trim();
            if (!email || !phone) {
                messageDiv.textContent = '<?= $lang === 'es' ? 'Por favor complete correo y teléfono.' : 'Please fill in email and phone.' ?>';
                messageDiv.className = 'message error';
                messageDiv.style.display = 'block';
                return;
            }

            this.disabled = true;
            const originalText = this.textContent;
            this.textContent = translations.validating_label;
            messageDiv.style.display = 'none';

            const formData = new FormData();
            formData.append('requester_email', email);
            formData.append('requester_phone', phone);
            formData.append('mode', 'validate');

            try {
                const response = await fetch('../set/privacy/submit_ferpa.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (!result.success) {
                    messageDiv.textContent = result.message || translations.error_connection;
                    messageDiv.className = 'message error';
                    messageDiv.style.display = 'block';
                    this.disabled = false;
                    this.textContent = originalText;
                    return;
                }

                // Limpiar select de hijos
                childSelect.innerHTML = '';

                if (result.children && result.children.length > 0) {
                    // Mostrar solo el select de hijos
                    const placeholderOpt = document.createElement('option');
                    placeholderOpt.value = '';
                    placeholderOpt.textContent = '<?= $lang === 'es' ? 'Seleccione un estudiante' : 'Select a student' ?>';
                    placeholderOpt.disabled = true;
                    placeholderOpt.selected = true;
                    childSelect.appendChild(placeholderOpt);

                    result.children.forEach(child => {
                        if (!child.id) return;
                        const opt = document.createElement('option');
                        opt.value = child.id;
                        opt.textContent = child.name;
                        childSelect.appendChild(opt);
                    });

                    // Reglas de visibilidad / required
                    childSelectGroup.style.display = 'block';
                    childSelect.required = true;

                    childNameGroup.style.display = 'none';
                    document.getElementById('child_name').required = false;
                } else {
                    // No hay hijos: solo campo manual
                    childSelectGroup.style.display = 'none';
                    childSelect.required = false;

                    childNameGroup.style.display = 'block';
                    document.getElementById('child_name').required = true;
                    document.getElementById('childNameHelp').textContent = translations.no_children;
                }

                // Bloquear campos de identidad y mostrar siguiente sección
                document.getElementById('requester_email').readOnly = true;
                document.getElementById('requester_phone').readOnly = true;
                this.style.display = 'none';
                requestSection.style.display = 'block';

                messageDiv.textContent = translations.identity_ok;
                messageDiv.className = 'message success';
                messageDiv.style.display = 'block';
            } catch (error) {
                console.error(error);
                messageDiv.textContent = translations.error_connection;
                messageDiv.className = 'message error';
                messageDiv.style.display = 'block';
                this.disabled = false;
                this.textContent = originalText;
            }
        });

        // Paso 2: Enviar solicitud completa
        document.getElementById('ferpaForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const messageDiv = document.getElementById('responseMessage');
            const button = this.querySelector('button[type="submit"]');

            // Honeypot check
            if (this.querySelector('input[name="website_check"]').value) return;

            // Time-lock check (3s detection against rapid bots)
            if (Date.now() - loadTime < 3000) {
                messageDiv.textContent = translations.bot_detected;
                messageDiv.className = 'message error';
                messageDiv.style.display = 'block';
                return;
            }

            // Captcha check
            let captchaResponse = '';
            if (window.grecaptcha) {
                try {
                    captchaResponse = grecaptcha.getResponse();
                } catch (err) { }
            }

            const formData = new FormData(this);
            if (captchaResponse) formData.append('g-recaptcha-response', captchaResponse);

            button.disabled = true;
            button.textContent = translations.btn_processing;
            messageDiv.style.display = 'none';

            try {
                const response = await fetch('../set/privacy/submit_ferpa.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                messageDiv.textContent = result.message;
                messageDiv.className = 'message ' + (result.success ? 'success' : 'error');
                messageDiv.style.display = 'block';

                if (result.success) {
                    this.reset();
                    if (window.grecaptcha) grecaptcha.reset();
                }
            } catch (error) {
                console.error(error);
                messageDiv.textContent = translations.error_connection;
                messageDiv.className = 'message error';
                messageDiv.style.display = 'block';
            } finally {
                button.disabled = false;
                button.textContent = translations.btn_submit;
            }
        });
    </script>
</body>

</html>
