<?php
// privacy/dsar.php
require_once __DIR__ . '/../includes/env.php';
$siteKey = Env::get('RECAPTCHA_SITE_KEY', '');

// Detectar idioma (default: es)
$lang = isset($_GET['lang']) && in_array($_GET['lang'], ['es', 'en']) ? $_GET['lang'] : 'es';

$t = [
    'es' => [
        'title' => 'Centro de Privacidad',
        'subtitle' => 'Solicitud de Ejercicio de Derechos (DSAR)',
        'desc' => 'Utilice este formulario para ejercer sus derechos de privacidad bajo CCPA/CPRA y otras leyes aplicables. Para proteger su información, verificaremos su identidad utilizando los datos de contacto registrados en su cuenta.',
        'label_type' => 'Tipo de Solicitud',
        'opt_access' => 'Acceso a mis datos',
        'opt_rectification' => 'Corregir mis datos',
        'opt_deletion' => 'Eliminar mis datos',
        'opt_optout' => 'No vender/compartir mis datos',
        'label_email' => 'Correo Electrónico Registrado',
        'placeholder_email' => 'ejemplo@correo.com',
        'label_phone' => 'Número de Teléfono Registrado',
        'placeholder_phone' => 'Ej: 555-123-4567',
        'label_details' => 'Detalles Adicionales',
        'placeholder_details' => 'Proporcione cualquier contexto adicional que nos ayude a procesar su solicitud...',
        'btn_submit' => 'Enviar Solicitud',
        'btn_processing' => 'Procesando...',
        'back_home' => 'Volver al inicio',
        'footer_rights' => 'Bilingual Child Care Training (BCCT). Todos los derechos reservados.',
        'error_connection' => 'Ocurrió un error de conexión. Por favor intente nuevamente.',
        'bot_detected' => 'Error de validación de seguridad. Por favor intente nuevamente.',
        'note_verification' => 'Nota: Enviaremos un enlace de confirmación a su correo electrónico.'
    ],
    'en' => [
        'title' => 'Privacy Center',
        'subtitle' => 'Data Subject Access Request (DSAR)',
        'desc' => 'Use this form to exercise your privacy rights under CCPA/CPRA and other applicable laws. To protect your information, we will verify your identity using the contact details registered in your account.',
        'label_type' => 'Request Type',
        'opt_access' => 'Access my data',
        'opt_rectification' => 'Correct my data',
        'opt_deletion' => 'Delete my data',
        'opt_optout' => 'Do not sell/share my data',
        'label_email' => 'Registered Email',
        'placeholder_email' => 'example@email.com',
        'label_phone' => 'Registered Phone Number',
        'placeholder_phone' => 'Ex: 555-123-4567',
        'label_details' => 'Additional Details',
        'placeholder_details' => 'Provide any additional context to help us process your request...',
        'btn_submit' => 'Submit Request',
        'btn_processing' => 'Processing...',
        'back_home' => 'Back to Home',
        'footer_rights' => 'Bilingual Child Care Training (BCCT). All rights reserved.',
        'error_connection' => 'A connection error occurred. Please try again.',
        'bot_detected' => 'Security validation error. Please try again.',
        'note_verification' => 'Note: We will send a confirmation link to your email address.'
    ]
][$lang];
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $t['title'] ?> - Acuarela
    </title>
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
            max-width: 600px;
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
            min-height: 100px;
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

        .note {
            font-size: 0.85rem;
            color: var(--gris-text-light);
            margin-top: 1rem;
            text-align: center;
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

        @media (max-width: 640px) {
            .card {
                padding: 1.5rem;
            }

            .main-wrapper {
                padding: 1rem;
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
            <h1>
                <?= $t['title'] ?>
            </h1>
            <p class="subtitle">
                <?= $t['subtitle'] ?>
            </p>
        </header>

        <div class="card">
            <p class="description">
                <?= $t['desc'] ?>
            </p>

            <form id="dsarForm">
                <!-- Honeypot -->
                <input type="text" name="website_check" class="website-bot" tabindex="-1" autocomplete="off">

                <div class="form-group">
                    <label for="request_type">
                        <?= $t['label_type'] ?>
                    </label>
                    <select name="request_type" id="request_type" required>
                        <option value="access">
                            <?= $t['opt_access'] ?>
                        </option>
                        <option value="rectification">
                            <?= $t['opt_rectification'] ?>
                        </option>
                        <option value="deletion">
                            <?= $t['opt_deletion'] ?>
                        </option>
                        <option value="opt_out">
                            <?= $t['opt_optout'] ?>
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="requester_email">
                        <?= $t['label_email'] ?>
                    </label>
                    <input type="email" id="requester_email" name="requester_email"
                        placeholder="<?= $t['placeholder_email'] ?>" required>
                </div>

                <div class="form-group">
                    <label for="requester_phone">
                        <?= $t['label_phone'] ?>
                    </label>
                    <input type="text" id="requester_phone" name="requester_phone"
                        placeholder="<?= $t['placeholder_phone'] ?>" required>
                </div>

                <div class="form-group">
                    <label for="details">
                        <?= $t['label_details'] ?>
                    </label>
                    <textarea id="details" name="details" placeholder="<?= $t['placeholder_details'] ?>"></textarea>
                </div>

                <?php if (!empty($siteKey)): ?>
                    <div style="display: flex; justify-content: center; margin: 1.5rem 0;">
                        <div class="g-recaptcha" data-sitekey="<?= htmlspecialchars($siteKey) ?>"></div>
                    </div>
                <?php endif; ?>

                <button type="submit" class="btn-submit">
                    <?= $t['btn_submit'] ?>
                </button>
                <p class="note">
                    <?= $t['note_verification'] ?>
                </p>
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
            <p>&copy;
                <?= date('Y') ?>
                <?= $t['footer_rights'] ?>
            </p>
        </footer>
    </div>

    <script>
        const loadTime = Date.now();

        document.getElementById('dsarForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            const messageDiv = document.getElementById('responseMessage');
            const button = this.querySelector('button[type="submit"]');
            const originalBtnText = button.textContent;

            // Honeypot check
            if (this.querySelector('input[name="website_check"]').value) return;

            // Time-lock check (3s detection against rapid bots)
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
                const response = await fetch('../set/privacy/submit_dsar.php', {
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