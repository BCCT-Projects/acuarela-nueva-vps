<?php
// privacy/revocation_request.php
require_once __DIR__ . '/../includes/env.php';
$siteKey = Env::get('RECAPTCHA_SITE_KEY', '');

// Detectar idioma (default: es)
$lang = isset($_GET['lang']) && in_array($_GET['lang'], ['es', 'en']) ? $_GET['lang'] : 'es';

$t = [
    'es' => [
        'title' => 'Revocación de Consentimiento',
        'subtitle' => 'Formulario de Solicitud para Padres',
        'desc' => 'Para revocar el consentimiento del uso de datos de su hijo en la plataforma, por favor ingrese los datos utilizados durante el registro.',
        'label_email' => 'Correo Electrónico del Tutor',
        'placeholder_email' => 'ejemplo@correo.com',
        'label_child' => 'Nombre del Niño/a',
        'placeholder_child' => 'Nombre completo',
        'btn_submit' => 'Solicitar Enlace de Revocación',
        'btn_processing' => 'Procesando...',
        'back_home' => 'Volver al inicio',
        'footer_rights' => 'Bilingual Child Care Training (BCCT). Todos los derechos reservados.',
        'error_connection' => 'Ocurrió un error de conexión. Por favor intente nuevamente.',
        'captcha_label' => 'Verificación de seguridad',
        'bot_detected' => 'Error de validación de seguridad. Por favor intente nuevamente.'
    ],
    'en' => [
        'title' => 'Consent Revocation',
        'subtitle' => 'Parent Request Form',
        'desc' => 'To revoke consent for the use of your child\'s data on the platform, please enter the details used during registration.',
        'label_email' => 'Parent/Guardian Email',
        'placeholder_email' => 'example@email.com',
        'label_child' => 'Child\'s Name',
        'placeholder_child' => 'Full Name',
        'btn_submit' => 'Request Revocation Link',
        'btn_processing' => 'Processing...',
        'back_home' => 'Back to Home',
        'footer_rights' => 'Bilingual Child Care Training (BCCT). All rights reserved.',
        'error_connection' => 'A connection error occurred. Please try again.',
        'captcha_label' => 'Security Verification',
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

    <style>
        /* Modern Clean Styling */
        :root {
            --cielo: #0CB5C3;
            --sandia: #FA6F5C;
            --sandia-dark: #E65252;
            --blanco: #FFFFFF;
            --gris-bg: #F4F7F6;
            --gris-text-dark: #1F2937;
            --gris-text-light: #6B7280;
            --border-input: #E5E7EB;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: var(--gris-bg);
            color: var(--gris-text-dark);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main-wrapper {
            width: 100%;
            max-width: 480px;
            padding: 20px;
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
            background: rgba(0, 0, 0, 0.05);
            color: var(--gris-text-light);
            padding: 4px 12px;
            border-radius: 20px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .lang-btn:hover,
        .lang-btn.active {
            background: var(--gris-text-dark);
            color: white;
        }

        /* Header */
        .header-section {
            text-align: center;
            margin-bottom: 2rem;
            width: 100%;
        }

        .logo {
            max-height: 50px;
            /* Ajustar según tu logo real */
            max-width: 200px;
            margin-bottom: 1rem;
            /* Si usas logotipo_invertido.svg en fondo claro, inviértelo para que sea negro/color */
            filter: invert(1) hue-rotate(180deg);
        }

        h1 {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
            color: var(--gris-text-dark);
        }

        .subtitle {
            font-size: 0.95rem;
            color: var(--gris-text-light);
            margin-top: 0.5rem;
        }

        /* Card */
        .card {
            background: white;
            padding: 2.5rem;
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
            width: 100%;
        }

        .description {
            font-size: 0.95rem;
            line-height: 1.5;
            text-align: center;
            color: var(--gris-text-light);
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--gris-text-dark);
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-input);
            border-radius: 8px;
            font-size: 1rem;
            background: #F9FAFB;
            transition: border-color 0.2s, background 0.2s;
        }

        input:focus {
            background: white;
            border-color: var(--cielo);
            outline: none;
            box-shadow: 0 0 0 3px rgba(12, 181, 195, 0.1);
        }

        .btn-submit {
            width: 100%;
            padding: 0.875rem;
            background-color: var(--sandia);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
            margin-top: 1rem;
        }

        .btn-submit:hover {
            background-color: var(--sandia-dark);
        }

        .btn-submit:active {
            transform: scale(0.98);
        }

        .btn-submit:disabled {
            opacity: 0.7;
            cursor: wait;
        }

        /* Messages */
        .message {
            margin-top: 1.5rem;
            padding: 1rem;
            border-radius: 8px;
            font-size: 0.9rem;
            text-align: center;
            display: none;
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
            font-size: 0.8rem;
            color: var(--gris-text-light);
        }

        .back-link {
            color: var(--cielo);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-block;
            margin-bottom: 1rem;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        /* Honeypot */
        .website-bot {
            display: none !important;
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
            <!-- Usamos el logo invertido pero lo filtramos para que sea visible en fondo claro -->
            <img src="../img/logos/logotipo_invertido.svg" alt="Acuarela" class="logo">
            <h1><?= $t['title'] ?></h1>
            <p class="subtitle"><?= $t['subtitle'] ?></p>
        </header>

        <div class="card">
            <p class="description"><?= $t['desc'] ?></p>

            <form id="revocationForm">
                <!-- Honeypot -->
                <input type="text" name="website_check" class="website-bot" tabindex="-1" autocomplete="off">

                <div class="form-group">
                    <label for="parent_email"><?= $t['label_email'] ?></label>
                    <input type="email" id="parent_email" name="parent_email"
                        placeholder="<?= $t['placeholder_email'] ?>" required>
                </div>

                <div class="form-group">
                    <label for="child_name"><?= $t['label_child'] ?></label>
                    <input type="text" id="child_name" name="child_name" placeholder="<?= $t['placeholder_child'] ?>"
                        required>
                </div>

                <?php if (!empty($siteKey)): ?>
                    <div style="display: flex; justify-content: center; margin: 1.5rem 0;">
                        <div class="g-recaptcha" data-sitekey="<?= htmlspecialchars($siteKey) ?>"></div>
                    </div>
                <?php endif; ?>

                <button type="submit" class="btn-submit"><?= $t['btn_submit'] ?></button>
            </form>

            <div id="responseMessage" class="message"></div>
        </div>

        <footer class="footer">
            <a href="../" class="back-link">← <?= $t['back_home'] ?></a>
            <p>&copy; <?= date('Y') ?> <?= $t['footer_rights'] ?></p>
        </footer>
    </div>

    <script>
        const loadTime = Date.now();

        document.getElementById('revocationForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            const messageDiv = document.getElementById('responseMessage');
            const button = this.querySelector('button[type="submit"]');
            const originalBtnText = button.textContent;

            // Honeypot check
            if (this.querySelector('input[name="website_check"]').value) return;

            // Time-lock check (3s)
            if (Date.now() - loadTime < 3000) {
                messageDiv.textContent = "<?= $t['bot_detected'] ?>";
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
            button.textContent = '<?= $t['btn_processing'] ?>';
            messageDiv.style.display = 'none';

            try {
                const response = await fetch('../set/consent/request_revocation.php', {
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
                messageDiv.textContent = '<?= $t['error_connection'] ?>';
                messageDiv.className = 'message error';
                messageDiv.style.display = 'block';
            } finally {
                button.disabled = false;
                button.textContent = originalBtnText;
            }
        });
    </script>
</body>

</html>