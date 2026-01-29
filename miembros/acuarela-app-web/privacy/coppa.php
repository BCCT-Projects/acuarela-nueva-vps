<?php
// Página pública del Aviso COPPA - No requiere autenticación
require_once __DIR__ . '/../includes/env.php';

// 1. Lógica de Traducción e i18n
// Detectar idioma (default: es)
$lang = isset($_GET['lang']) && in_array($_GET['lang'], ['es', 'en']) ? $_GET['lang'] : 'es';

// Diccionario de traducciones
$translations = [
    'es' => [
        'title' => 'Aviso de Privacidad COPPA',
        'subtitle' => 'Para Padres y Tutores',
        'version' => 'Versión',
        'published' => 'Fecha de publicación',
        'verify_id' => 'ID de verificación',
        'executive_summary' => 'Resumen Ejecutivo',
        'full_notice' => 'Aviso Completo de Privacidad COPPA',
        'operator_identity' => '1. Identidad del Operador',
        'legal_name' => 'Nombre Legal',
        'contact_info' => 'Información de Contacto',
        'privacy_email' => 'Para consultas sobre privacidad:',
        'data_collected' => '2. Datos Recopilados del Menor',
        'data_usage' => '3. Uso de la Información',
        'third_party' => '4. Divulgación a Terceros',
        'parent_rights' => '5. Derechos del Padre/Tutor',
        'rights_contact' => 'Para ejercer estos derechos, contacte a:',
        'retention' => '6. Retención y Eliminación de Datos',
        'contact_section' => 'Contacto',
        'contact_desc' => 'Para preguntas sobre este aviso o para ejercer sus derechos, contacte:',
        'footer_rights' => 'Bilingual Child Care Training (BCCT). Todos los derechos reservados.',
        'back_to_app' => 'Volver a la aplicación',
        'revocation_title' => '¿Desea Revocar el Consentimiento?',
        'revocation_desc' => 'Si desea retirar su consentimiento para el procesamiento de datos de su hijo(a), puede hacerlo en cualquier momento usando nuestra herramienta de revocación.',
        'revocation_btn' => 'Solicitar Revocación',
        'dsar_section_title' => '7. Tus derechos sobre tus datos',
        'dsar_text' => 'Además de lo que dice COPPA para menores, tú puedes pedir ver, corregir o eliminar tu información personal (y la de tus hijos cuando aplique).',
        'dsar_p1' => 'Puedes solicitar, por ejemplo:',
        'dsar_li_1' => 'Ver una copia de la información que tenemos sobre ti.',
        'dsar_li_2' => 'Corregir datos que estén mal o desactualizados.',
        'dsar_li_3' => 'Recibir tu información en un formato que puedas usar en otro servicio.',
        'dsar_li_4' => 'Pedir que eliminemos tu información (cuando aplique).',
        'dsar_p2' => 'Esto es distinto de los registros educativos: aquí hablamos de tu privacidad en general; los registros escolares tienen su propio formulario más abajo.',
        'dsar_btn' => 'Ir al formulario de solicitudes',
        'ferpa_section_title' => '8. Registros educativos de tu hijo',
        'ferpa_text' => 'Si eres padre o tutor, puedes ver y, si hace falta, corregir los registros educativos de tu hijo en Acuarela (asistencia, actividades, reportes, etc.).',
        'ferpa_p1' => 'Desde el formulario puedes:',
        'ferpa_li_1' => 'Solicitar ver o recibir copia de los registros educativos.',
        'ferpa_li_2' => 'Pedir que corrijamos algo que consideres incorrecto (con una breve explicación).',
        'ferpa_p2' => 'Revisamos cada solicitud y te respondemos en un plazo razonable (normalmente en 45 días o menos).',
        'ferpa_p3' => '',
        'ferpa_p4' => '',
        'ferpa_btn' => 'Ir al formulario de registros educativos'
    ],
    'en' => [
        'title' => 'COPPA Privacy Notice',
        'subtitle' => 'For Parents and Guardians',
        'version' => 'Version',
        'published' => 'Date of publication',
        'verify_id' => 'Verification ID',
        'executive_summary' => 'Executive Summary',
        'full_notice' => 'Full COPPA Privacy Notice',
        'operator_identity' => '1. Operator Identity',
        'legal_name' => 'Legal Name',
        'contact_info' => 'Contact Information',
        'privacy_email' => 'For privacy inquiries:',
        'data_collected' => '2. Data Collected from Children',
        'data_usage' => '3. Data Usage',
        'third_party' => '4. Disclosure to Third Parties',
        'parent_rights' => '5. Parental Rights',
        'rights_contact' => 'To exercise these rights, contact:',
        'retention' => '6. Data Retention and Deletion',
        'contact_section' => 'Contact',
        'contact_desc' => 'For questions regarding this notice or to exercise your rights, please contact:',
        'footer_rights' => 'Bilingual Child Care Training (BCCT). All rights reserved.',
        'back_to_app' => 'Back to Application',
        'revocation_title' => 'Want to Revoke Consent?',
        'revocation_desc' => 'If you wish to withdraw your consent for processing your child\'s data, you can do so at any time using our revocation tool.',
        'revocation_btn' => 'Request Revocation',
        'dsar_section_title' => '7. Your rights over your data',
        'dsar_text' => 'Besides what COPPA says for children, you can ask to view, correct, or delete your personal information (and your children\'s when it applies).',
        'dsar_p1' => 'You can request, for example:',
        'dsar_li_1' => 'A copy of the information we have about you.',
        'dsar_li_2' => 'To correct data that is wrong or outdated.',
        'dsar_li_3' => 'Your information in a format you can use elsewhere.',
        'dsar_li_4' => 'To delete your information (when applicable).',
        'dsar_p2' => 'This is separate from education records: here we\'re talking about your general privacy; school records have their own form below.',
        'dsar_btn' => 'Go to request form',
        'ferpa_section_title' => '8. Your child\'s education records',
        'ferpa_text' => 'If you're a parent or guardian, you can view and, when needed, correct your child's education records in Acuarela (attendance, activities, reports, etc.).',
        'ferpa_p1' => 'From the form you can:',
        'ferpa_li_1' => 'Request to view or get a copy of education records.',
        'ferpa_li_2' => 'Ask us to correct something you believe is wrong (with a brief explanation).',
        'ferpa_p2' => 'We review each request and respond within a reasonable time (usually 45 days or less).',
        'ferpa_p3' => '',
        'ferpa_p4' => '',
        'ferpa_btn' => 'Go to education records form'
    ]
];

$t = $translations[$lang];

// Helper para obtener contenido según idioma
function get_content($notice, $field, $lang)
{
    if ($lang === 'en') {
        $field_en = $field . '_en';
        if (isset($notice->$field_en) && !empty($notice->$field_en)) {
            return $notice->$field_en;
        }
    }
    return isset($notice->$field) ? $notice->$field : null;
}

// 2. Lógica API (usando la versión robusta proporcionada)
function getPublicCoppaNotice()
{
    $domain = Env::get('ACUARELA_API_URL', 'https://acuarelacore.com/api/');
    $endpoint = $domain . 'aviso-coppas?status=active&_sort=notice_published_date:DESC&_limit=1';

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $endpoint,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
    ));

    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $error = curl_error($curl);
    curl_close($curl);

    if ($httpCode === 200) {
        $data = json_decode($response, true);
        if (is_array($data) && !empty($data)) {
            return (object) [
                'response' => array_map(function ($item) {
                    return (object) $item;
                }, $data)
            ];
        }
    } else {
        error_log("COPPA Notice API Error (endpoint: $endpoint): HTTP $httpCode - $error");
    }
    return null;
}

$coppaNotice = getPublicCoppaNotice();

// Manejo de error si no hay aviso
if (!$coppaNotice || !isset($coppaNotice->response) || empty($coppaNotice->response)) {
    // Fallback silencioso
    $notice = (object) [];
    $version = 'N/A';
    $publishedAt = date('d/m/Y');
} else {
    $notice = $coppaNotice->response[0];
    $version = $notice->version ?? 'v1.0';
    $publishedAt = isset($notice->notice_published_date) ? date('d/m/Y', strtotime($notice->notice_published_date)) : date('d/m/Y');
}
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $t['title'] ?> - Acuarela</title>
    <link rel="stylesheet" href="../css/acuarela_theme.css?v=<?= time() ?>">
    <link rel="stylesheet" href="../css/styles.css?v=<?= time() ?>">
    <link rel="shortcut icon" href="../img/favicon.png">
    <style>
        /* CRITICAL: Fix Scroll & Layout */
        html {
            overflow-y: auto !important;
            height: auto !important;
        }

        /* DESIGN SYSTEM VARIABLES */
        :root {
            --cielo: #0CB5C3;
            --sandia: #FA6F5C;
            --pollito: #FBCB43;
            --morita: #7155A4;
            --blanco: #FFFFFF;
            --fondo1: #F0FEFF;
            --fondo2: #E8F7F9;
            --gris1: #140A4C;
            --gris2: #4A4A68;
            --gris3: #9EA0A5;
        }

        /* Reset & Override global App styles */
        body.coppa-page {
            display: block !important;
            margin: 0;
            padding: 0;
            width: 100%;
            max-width: 100%;
            height: auto !important;
            overflow-y: auto !important;
            position: relative !important;
            background: var(--fondo1);
            font-family: 'Outfit', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--gris1);
            line-height: 1.6;
        }

        .coppa-container {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            width: 100%;
        }

        /* TYPOGRAPHY RULES */
        h1,
        .display,
        .coppa-header__title {
            font-size: 2.7rem;
            font-weight: bold;
            line-height: 3.6rem;
            color: #ffffff !important;
        }

        h2,
        .title,
        .coppa-section__title {
            font-size: 2.1rem;
            font-weight: bold;
            line-height: 2.7rem;
            color: var(--morita);
        }

        h3,
        .subtitle,
        .coppa-subsection__title {
            font-size: 1.8rem;
            font-weight: bold;
            line-height: 2.4rem;
            color: var(--cielo);
        }

        p,
        li,
        .regular,
        .coppa-section__content,
        .coppa-subsection__content {
            font-size: 1.4rem;
            font-weight: normal;
            line-height: 2rem;
            margin-bottom: 15px;
            color: var(--gris2);
        }

        .bold,
        b,
        strong {
            font-size: 1.4rem;
            font-weight: bold;
            line-height: 2rem;
            color: var(--gris1);
        }

        .caption,
        small,
        .coppa-footer {
            font-size: 1.2rem;
            font-weight: normal;
            line-height: 1.4rem;
            color: var(--gris3);
        }

        /* COMPONENT STYLES */
        .coppa-header {
            background: linear-gradient(135deg, var(--morita) 0%, var(--cielo) 100%);
            padding: 5rem 2rem 8rem;
            text-align: center;
            position: relative;
            z-index: 10;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .coppa-header__subtitle {
            font-size: 1.8rem !important;
            font-weight: normal;
            color: rgba(255, 255, 255, 0.9);
            margin-top: 5px;
        }

        .coppa-header__logo {
            max-width: 200px;
            margin-bottom: 2rem;
            filter: brightness(0) invert(1);
        }

        .coppa-main {
            padding: 0 20px 4rem;
            width: 100%;
            max-width: 1000px;
            margin: -5rem auto 0;
            position: relative;
            z-index: 20;
        }

        .coppa-notice {
            background: var(--blanco);
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
            padding: 4rem;
        }

        .coppa-section {
            margin-bottom: 4rem;
        }

        .coppa-section__title {
            margin: 3rem 0 2rem;
            border-bottom: 2px solid var(--fondo2);
            padding-bottom: 1rem;
        }

        /* Ajuste visual para coincidir con el diseño "Original" (Barra Morada) */
        .coppa-subsection {
            margin-bottom: 2.5rem;
        }

        .coppa-subsection__title {
            border-left: 5px solid var(--morita);
            padding-left: 15px;
        }

        .coppa-notice__meta {
            background: var(--fondo2);
            padding: 2rem;
            border-radius: 12px;
            border-left: 6px solid var(--cielo);
            margin-bottom: 3rem;
        }

        .coppa-section--summary {
            background: rgba(12, 181, 195, 0.05);
            border: 1px solid rgba(12, 181, 195, 0.1);
            border-radius: 16px;
            padding: 2.5rem;
        }

        .coppa-contact {
            background: var(--fondo2);
            padding: 2.5rem;
            border-radius: 16px;
            border-top: 5px solid var(--pollito);
            margin-top: 3rem;
        }

        a {
            color: var(--cielo);
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            color: var(--morita);
        }

        .coppa-footer {
            text-align: center;
            padding: 4rem 1rem;
        }

        /* Lang Selector */
        .lang-selector {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 100;
            display: flex;
            gap: 10px;
        }

        .lang-btn {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.4);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            text-decoration: none;
            font-weight: bold;
            font-size: 0.9rem;
            backdrop-filter: blur(4px);
            transition: all 0.3s;
        }

        .lang-btn:hover {
            background: rgba(255, 255, 255, 0.4);
        }

        .lang-btn.active {
            background: white;
            color: var(--cielo);
        }

        /* Revocation Box Styles */
        .coppa-revocation-box {
            background: linear-gradient(135deg, rgba(250, 111, 92, 0.05) 0%, rgba(250, 111, 92, 0.02) 100%);
            border: 2px solid rgba(250, 111, 92, 0.2);
            border-radius: 16px;
            padding: 2.5rem;
            margin-top: 2rem;
        }

        .coppa-revocation-box .coppa-subsection__title {
            border-left-color: var(--sandia);
            color: var(--sandia) !important;
        }

        .btn-revocation {
            display: inline-flex;
            align-items: center;
            background: var(--sandia);
            color: white !important;
            padding: 14px 28px;
            border-radius: 12px;
            font-size: 1.5rem;
            font-weight: bold;
            text-decoration: none;
            margin-top: 1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 14px rgba(250, 111, 92, 0.3);
        }

        .btn-revocation:hover {
            background: #d85d4b;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(250, 111, 92, 0.4);
            color: white !important;
        }

        .btn-revocation:active {
            transform: translateY(0);
        }

        @media (max-width: 768px) {
            .coppa-header {
                padding: 4rem 1.5rem 6rem;
            }

            .coppa-notice {
                padding: 2rem;
                border-radius: 16px;
            }

            .coppa-main {
                padding: 0 15px 3rem;
                margin-top: -4rem;
            }

            .btn-revocation {
                width: 100%;
                justify-content: center;
                font-size: 1.4rem;
            }
        }

        /* DSAR Box Styles */
        .coppa-dsar-box {
            background: linear-gradient(135deg, rgba(12, 181, 195, 0.05) 0%, rgba(12, 181, 195, 0.02) 100%);
            border: 2px solid rgba(12, 181, 195, 0.2);
            border-radius: 16px;
            padding: 2.5rem;
            margin-top: 2rem;
        }

        .btn-dsar {
            display: inline-flex;
            align-items: center;
            background: var(--cielo);
            color: white !important;
            padding: 14px 28px;
            border-radius: 12px;
            font-size: 1.5rem;
            font-weight: bold;
            text-decoration: none;
            margin-top: 1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 14px rgba(12, 181, 195, 0.3);
        }

        .btn-dsar:hover {
            background: #099ca8;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(12, 181, 195, 0.4);
            color: white !important;
        }
    </style>
</head>

<body class="coppa-page">
    <div class="coppa-container">
        <!-- Traducción: Selector de idioma -->
        <div class="lang-selector">
            <a href="?lang=es" class="lang-btn <?= $lang == 'es' ? 'active' : '' ?>">ES</a>
            <a href="?lang=en" class="lang-btn <?= $lang == 'en' ? 'active' : '' ?>">EN</a>
        </div>

        <header class="coppa-header">
            <div class="coppa-header__content">
                <img src="../img/logos/logotipo_invertido.svg" alt="Acuarela Logo" class="coppa-header__logo">
                <h1 class="coppa-header__title"><?= $t['title'] ?></h1>
                <p class="coppa-header__subtitle"><?= $t['subtitle'] ?></p>
            </div>
        </header>

        <main class="coppa-main">
            <div class="coppa-notice">
                <!-- Información de versión -->
                <div class="coppa-notice__meta">
                    <p class="coppa-notice__version"><?= $t['version'] ?>:
                        <strong><?= htmlspecialchars($version) ?></strong>
                    </p>
                    <p class="coppa-notice__date"><?= $t['published'] ?>:
                        <strong><?= htmlspecialchars($publishedAt) ?></strong>
                    </p>
                    <?php if (isset($notice->checksum)): ?>
                        <p class="coppa-notice__checksum"><?= $t['verify_id'] ?>:
                            <code><?= substr($notice->checksum, 0, 16) ?>...</code>
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Resumen ejecutivo -->
                <?php if ($summary = get_content($notice, 'summary', $lang)): ?>
                    <section class="coppa-section coppa-section--summary">
                        <h2 class="coppa-section__title"><?= $t['executive_summary'] ?></h2>
                        <div class="coppa-section__content">
                            <?= nl2br(htmlspecialchars($summary)) ?>
                        </div>
                    </section>
                <?php endif; ?>

                <!-- Contenido completo -->
                <section class="coppa-section">
                    <h2 class="coppa-section__title"><?= $t['full_notice'] ?></h2>

                    <!-- 1. Identidad del Operador -->
                    <div class="coppa-subsection">
                        <h3 class="coppa-subsection__title"><?= $t['operator_identity'] ?></h3>
                        <div class="coppa-subsection__content">
                            <?php if ($op_name = get_content($notice, 'operator_name', $lang)): ?>
                                <p><strong><?= $t['legal_name'] ?>:</strong> <?= htmlspecialchars($op_name) ?></p>
                            <?php endif; ?>

                            <?php if ($op_contact = get_content($notice, 'operator_contact', $lang)): ?>
                                <div class="coppa-contact">
                                    <?= nl2br(htmlspecialchars($op_contact)) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- 2. Datos Recopilados -->
                    <?php if ($collected = get_content($notice, 'data_collected', $lang)): ?>
                        <div class="coppa-subsection">
                            <h3 class="coppa-subsection__title"><?= $t['data_collected'] ?></h3>
                            <div class="coppa-subsection__content">
                                <?= nl2br(htmlspecialchars($collected)) ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- 3. Uso de la Información -->
                    <?php if ($usage = get_content($notice, 'data_usage', $lang)): ?>
                        <div class="coppa-subsection">
                            <h3 class="coppa-subsection__title"><?= $t['data_usage'] ?></h3>
                            <div class="coppa-subsection__content">
                                <?= nl2br(htmlspecialchars($usage)) ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- 4. Divulgación a Terceros -->
                    <?php if ($third = get_content($notice, 'third_party_disclosure', $lang)): ?>
                        <div class="coppa-subsection">
                            <h3 class="coppa-subsection__title"><?= $t['third_party'] ?></h3>
                            <div class="coppa-subsection__content">
                                <?= nl2br(htmlspecialchars($third)) ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- 5. Derechos del Padre/Tutor -->
                    <?php if ($rights = get_content($notice, 'parent_rights', $lang)): ?>
                        <div class="coppa-subsection">
                            <h3 class="coppa-subsection__title"><?= $t['parent_rights'] ?></h3>
                            <div class="coppa-subsection__content">
                                <?= nl2br(htmlspecialchars($rights)) ?>
                            </div>
                        </div>

                        <!-- NUEVA SECCION: Herramienta de Revocación -->
                        <div class="coppa-subsection coppa-revocation-box">
                            <h3 class="coppa-subsection__title" style="color: var(--sandia);"><?= $t['revocation_title'] ?>
                            </h3>
                            <div class="coppa-subsection__content">
                                <p><?= $t['revocation_desc'] ?></p>
                                <a href="revocation_request.php?lang=<?= $lang ?>" class="btn-revocation">
                                    <?= $t['revocation_btn'] ?>
                                    <svg style="width:16px; height:16px; margin-left:8px; vertical-align:middle;"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- 6. Retención y Eliminación -->
                    <?php if ($retention = get_content($notice, 'retention_policy', $lang)): ?>
                        <div class="coppa-subsection">
                            <h3 class="coppa-subsection__title"><?= $t['retention'] ?></h3>
                            <div class="coppa-subsection__content">
                                <?= nl2br(htmlspecialchars($retention)) ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Contenido adicional personalizado -->
                    <?php if ($additional = get_content($notice, 'additional_content', $lang)): ?>
                        <div class="coppa-subsection">
                            <div class="coppa-subsection__content">
                                <?= nl2br(htmlspecialchars($additional)) ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- 7. Sección DSAR -->
                    <div class="coppa-subsection coppa-dsar-box">
                        <h3 class="coppa-subsection__title"><?= $t['dsar_section_title'] ?></h3>
                        <div class="coppa-subsection__content">
                            <p><?= $t['dsar_text'] ?></p>
                            <p><?= $t['dsar_p1'] ?></p>
                            <ul style="margin: 0 0 14px 18px; color:#4A4A68; line-height:1.6;">
                                <li><?= $t['dsar_li_1'] ?></li>
                                <li><?= $t['dsar_li_2'] ?></li>
                                <li><?= $t['dsar_li_3'] ?></li>
                                <li><?= $t['dsar_li_4'] ?></li>
                            </ul>
                            <p style="margin-top: 10px; color:#6B7280;"><?= $t['dsar_p2'] ?></p>
                            <a href="dsar.php?lang=<?= $lang ?>" class="btn-dsar">
                                <?= $t['dsar_btn'] ?>
                                <svg style="width:16px; height:16px; margin-left:8px; vertical-align:middle;"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- 8. Sección FERPA -->
                    <div class="coppa-subsection coppa-dsar-box" id="ferpa">
                        <h3 class="coppa-subsection__title"><?= $t['ferpa_section_title'] ?></h3>
                        <div class="coppa-subsection__content">
                            <p><?= $t['ferpa_text'] ?></p>
                            <p><?= $t['ferpa_p1'] ?></p>
                            <ul style="margin: 0 0 14px 18px; color:#4A4A68; line-height:1.6;">
                                <li><?= $t['ferpa_li_1'] ?></li>
                                <li><?= $t['ferpa_li_2'] ?></li>
                            </ul>
                            <p style="margin-top: 10px;"><?= $t['ferpa_p2'] ?></p>
                            <?php if (!empty($t['ferpa_p3'])): ?><p style="margin-top: 10px; color:#6B7280;"><?= $t['ferpa_p3'] ?></p><?php endif; ?>
                            <?php if (!empty($t['ferpa_p4'])): ?><p style="margin-top: 10px; color:#6B7280;"><?= $t['ferpa_p4'] ?></p><?php endif; ?>
                            <a href="ferpa.php?lang=<?= $lang ?>" class="btn-dsar">
                                <?= $t['ferpa_btn'] ?>
                                <svg style="width:16px; height:16px; margin-left:8px; vertical-align:middle;"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                        </div>
                    </div>

                </section>

                <!-- Información de contacto -->
                <section class="coppa-section coppa-section--contact">
                    <h2 class="coppa-section__title"><?= $t['contact_section'] ?></h2>
                    <div class="coppa-section__content">
                        <p><?= $t['contact_desc'] ?> <a href="mailto:privacy@acuarela.app">privacy@acuarela.app</a></p>
                    </div>
                </section>
            </div>
        </main>

        <footer class="coppa-footer">
            <div class="coppa-footer__content">
                <p>&copy; <?= date('Y') ?> <?= $t['footer_rights'] ?></p>
                <p><a href="/miembros/acuarela-app-web/" class="coppa-footer__link"><?= $t['back_to_app'] ?></a></p>
            </div>
        </footer>
    </div>
</body>

</html>