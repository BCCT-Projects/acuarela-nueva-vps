<?php
$classBody = "finanzas";
include "includes/header.php";
$date = new DateTime();
$date_formateada = isset($_GET['desde-reporte']) ? $_GET['desde-reporte'] : $date->format('Y-m-d');
$date->modify('+7 day');
$future_formateada = isset($_GET['hasta-reporte']) ? $_GET['hasta-reporte'] : $date->format('Y-m-d');
$movements = $a->getMovements($date_formateada, $future_formateada);
$text = array("0" => "PAGO RECHAZADO", "1" => "PAGO APROBADO", "2" => "PAGO PENDIENTE");
$color = array("0" => "#eb5d5e", "1" => "#3fb072", "2" => "#f5aa16");
$categories = $a->getCategories();

// Verificar tipo de cuenta para mostrar información de comisiones
$validProIdsFinanzas = ["66df29c33f91241d635ae818", "66dfcce23f91241d635ae934"];
$isProUserFinanzas = false;
$suscripcionesFinanzas = isset($a->daycareInfo->suscriptions) ? $a->daycareInfo->suscriptions : [];
if (is_array($suscripcionesFinanzas) || is_object($suscripcionesFinanzas)) {
    foreach ($suscripcionesFinanzas as $suscripcion) {
        if (isset($suscripcion->service->id) && in_array($suscripcion->service->id, $validProIdsFinanzas)) {
            $isProUserFinanzas = true;
            break;
        }
    }
}

// Verificar si el daycare tiene cuenta Stripe vinculada
$hasStripeAccount = isset($a->daycareInfo->paypal->client_id) && !empty($a->daycareInfo->paypal->client_id);

$gastosCat = [];
$ingresosCat = [];

foreach ($categories as $category) {
    if ($category->type_category === 'gasto') {
        $gastosCat[] = $category;
    } elseif ($category->type_category === 'ingreso') {
        $ingresosCat[] = $category;
    }
}

// Suponiendo que $movements es tu array de objetos
$ingresos = [];
$gastos = [];
$pendientes = [];

$ingresosTotal = 0;
$gastosTotal = 0;
$pendientesTotal = 0;

foreach ($movements as $movement) {
    // Clasifica los movimientos en los arrays correspondientes según su tipo
    switch ($movement->type) {
        case 0:
            $gastos[] = $movement;
            $gastosTotal += $movement->amount; // Suma el monto al total de gastos
            break;
        case 1:
            $ingresos[] = $movement;
            $ingresosTotal += $movement->amount; // Suma el monto al total de ingresos
            break;
        case 2:
            $pendientes[] = $movement;
            $pendientesTotal += $movement->amount; // Suma el monto al total de pendientes si es un pago pendiente
            break;
    }
}
// Calcula el balance
$balance = $ingresosTotal - $gastosTotal;
?>
<main id="Finanzas">
    <?php
    include "templates/paypalAlert.php";
    $mainHeaderTitle = "Finanzas";
    $action = '';
    include "templates/sectionHeader.php";
    ?>

    <?php if (!$hasStripeAccount): ?>
        <!-- Modal para vincular cuenta Stripe -->
        <div id="modal-stripe-required" class="lightbox" style="display: flex; opacity: 1; visibility: visible; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 9999; justify-content: center; align-items: center;">
            <div class="lightbox-content" style="background: white; border-radius: 16px; padding: 0; max-width: 480px; width: 90%; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);">
                <!-- Header con gradiente -->
                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; text-align: center;">
                    <div style="background: rgba(255,255,255,0.2); border-radius: 50%; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="acuarela acuarela-Pago" style="font-size: 36px; color: white;"></i>
                    </div>
                    <h2 style="color: white; margin: 20px 0 10px 0; font-size: 1.8rem;">Activa los Pagos Electrónicos</h2>
                    <p style="color: rgba(255,255,255,0.9); margin: 0; font-size: 1.2rem;">Para usar Finanzas necesitas vincular tu cuenta de Stripe</p>
                </div>
                <!-- Contenido -->
                <div style="padding: 25px;">
                    <div style="background: #f8fafc; border-radius: 12px; padding: 22px; margin-bottom: 20px;">
                        <h4 style="margin: 0 0 18px 0; color: #1e293b; font-size: 1.25rem;">¿Qué necesitas?</h4>
                        <ul style="margin: 0; padding: 0; list-style: none;">
                            <li style="display: flex; align-items: center; gap: 12px; margin-bottom: 14px; color: #475569; font-size: 1.1rem;">
                                <span style="color: #667eea; font-size: 1.2rem;">✓</span> Cuenta bancaria de tu daycare
                            </li>
                            <li style="display: flex; align-items: center; gap: 12px; margin-bottom: 14px; color: #475569; font-size: 1.1rem;">
                                <span style="color: #667eea; font-size: 1.2rem;">✓</span> Información fiscal del negocio
                            </li>
                            <li style="display: flex; align-items: center; gap: 12px; color: #475569; font-size: 1.1rem;">
                                <span style="color: #667eea; font-size: 1.2rem;">✓</span> 5 minutos para completar el registro
                            </li>
                        </ul>
                    </div>
                    <?php if (!$isProUserFinanzas): ?>
                    <div style="background: #fffbeb; border-left: 4px solid #f5aa16; padding: 16px 18px; border-radius: 0 8px 8px 0; margin-bottom: 20px;">
                        <p style="margin: 0; color: #92400e; font-size: 1.1rem; line-height: 1.6;">
                            <strong>Cuenta LITE:</strong> Se aplicará una comisión de $0.50 USD por cada pago recibido.
                            <a href="/miembros/acuarela-app-web/configuracion#planes" style="color: #d97706; text-decoration: underline;">Actualiza a PRO</a> para no tener comisiones.
                        </p>
                    </div>
                    <?php endif; ?>
                    <div style="display: flex; gap: 12px;">
                        <a href="/miembros/acuarela-app-web/configuracion#metodos" class="btn btn-action-primary enfasis" style="flex: 1; text-align: center; padding: 16px; font-size: 1.1rem;">
                            <i class="acuarela acuarela-Configuracion"></i> Configurar pagos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <?php if ($isProUserFinanzas): ?>
            <!-- Usuario PRO - Sin comisión - Banner compacto -->
            <div style="display: flex; align-items: center; gap: 12px; padding: 12px 18px; margin-bottom: 20px; border-radius: 8px; background: #f0fdfa; border-left: 4px solid #00A099;">
                <i class="acuarela acuarela-Verificado" style="font-size: 26px; color: #00A099;"></i>
                <span style="color: #115e59; font-size: 1.25rem;"><strong>Cuenta PRO:</strong> Sin comisiones de Acuarela en tus pagos</span>
            </div>
        <?php else: ?>
            <!-- Usuario LITE - Con comisión - Banner compacto -->
            <div style="display: flex; align-items: center; gap: 12px; padding: 12px 18px; margin-bottom: 20px; border-radius: 8px; background: #fffbeb; border-left: 4px solid #f5aa16;">
                <i class="acuarela acuarela-Informacion" style="font-size: 26px; color: #d97706;"></i>
                <span style="color: #92400e; font-size: 1.25rem;"><strong>Cuenta LITE:</strong> Comisión de $0.50 USD por pago</span>
                <a href="/miembros/acuarela-app-web/configuracion#planes" style="margin-left: auto; color: #d97706; font-size: 1.15rem; text-decoration: underline; font-weight: 600;">Actualizar a PRO</a>
            </div>
        <?php endif; ?>

    <div class="navtabs">
        <div class="navtab active" data-target="reporte">Reporte contable</div>
        <div class="navtab" data-target="ingresos">Ingresos</div>
        <div class="navtab" data-target="gastos">Gastos</div>
        <div class="navtab" data-target="pendientes">Pagos</div>
        <div class="underline"></div>
    </div>
    <div class="content">
        <form action="" id="filterReporte" method="GET">
            <span class="calendar">
                <label for="desde-reporte">Desde</label>
                <input type="date" name="desde-reporte" id="desde-reporte" value="<?= $date_formateada ?>" />
                <button type="button" class="calendar-icon" aria-label="Mostrar calendario"></button>
            </span>
            <span class="calendar">
                <label for="hasta-reporte">Hasta</label>
                <input type="date" name="hasta-reporte" id="hasta-reporte" value="<?= $future_formateada ?>" />
                <button type="button" class="calendar-icon" aria-label="Mostrar calendario"></button>
            </span>
            <button type="submit" class="btn btn-action-primary enfasis btn-big">Aplicar filtros</button>
        </form>
        <div id="reporte" class="tab-content active">
            <div class="tab-content-header">
            </div>
            <div class="cardsFinanza">
                <div class="cardFinanza">
                    <div class="txt">
                        <small>Ingresos</small>
                        <strong>$
                            <?= $ingresosTotal ?> USD
                        </strong>
                    </div>
                    <i class="acuarela acuarela-Ingresos"></i>
                </div>
                <div class="cardFinanza">
                    <div class="txt">
                        <small>Gastos</small>
                        <strong>$
                            <?= $gastosTotal ?> USD
                        </strong>
                    </div>
                    <i class="acuarela acuarela-Gastos"></i>
                </div>
                <div class="cardFinanza">
                    <div class="txt">
                        <small>Balance</small>
                        <strong>$
                            <?= $balance ?> USD
                        </strong>
                    </div>
                    <i class="acuarela acuarela-Balance"></i>
                </div>
            </div>
            <table>
                <tbody>
                    <?php
                    if (count($movements) == 0) {
                    ?>
                        <tr>
                            <td>
                                <p style="text-align:center;font-weight:bold;">No se encontraron registros en estas fechas
                                </p>
                            </td>
                        </tr>
                    <?php
                    } else {
                    ?>
                        <?php
                        for ($i = 0; $i < count($movements); $i++) {
                            $movement = $movements[$i];
                        ?>
                            <tr>
                                <td>
                                    <h4>
                                        <?= $movement->name ?>
                                    </h4>
                                </td>
                                <td><span class="status" style="color:<?= $color[$movement->type] ?>;">
                                        <?= $text[$movement->type] ?>
                                    </span></td>
                                <td><span class="date">
                                        <?php
                                        // Crea un objeto DateTime desde la cadena ISO 8601
                                        $movementDate = new DateTime($movement->date);
                                        // Formatea la fecha al formato MM-DD-YYYY
                                        $payDate_formateada = $movementDate->format('m-d-Y');
                                        echo $payDate_formateada;
                                        ?>
                                    </span></td>
                                <td> <span class="amount">
                                        $
                                        <?= $movement->amount ?>
                                    </span></td>
                            </tr>
                        <?php } ?>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div id="ingresos" class="tab-content">
            <div class="tab-content-header">
                <button type="button" class="btn btn-action-primary enfasis btn-big">Agregar ingreso</button>
            </div>
            <div class="card lg ingresos-categories">
                <div class="card__header">
                    <div class="card__header-title">Categorías</div>
                    <div class="card__header-actions">
                        <button type="button" class="btn btn-action-tertiary enfasis"
                            onclick="fadeIn(document.querySelector('#lightbox-categories-ingresos'))"><i
                                class="acuarela acuarela-Editar"></i> Editar categorías</button>
                    </div>
                </div>
                <div class="card__body">
                    <p>
                        <?php for ($i = 0; $i < count($ingresosCat); $i++) { ?>
                            <?= $ingresosCat[$i]->name ?>,
                        <?php } ?>
                    </p>

                </div>
            </div>
            <table>
                <tbody>
                    <?php
                    if (count($ingresos) == 0) {
                    ?>
                        <tr>
                            <td>
                                <p style="text-align:center;font-weight:bold;">No se encontraron ingresos en estas fechas
                                </p>
                            </td>
                        </tr>
                    <?php
                    } else {
                    ?>
                        <?php
                        for ($i = 0; $i < count($ingresos); $i++) {
                            $ingreso = $ingresos[$i];
                        ?>
                            <tr>
                                <td>
                                    <h4>
                                        <?= $ingreso->name ?>
                                    </h4>
                                </td>
                                <td><span class="status" style="color:<?= $color[$ingreso->type] ?>;">
                                        <?= $text[$ingreso->type] ?>
                                    </span></td>
                                <td><span class="date">
                                        <?php
                                        // Crea un objeto DateTime desde la cadena ISO 8601
                                        $ingresoDate = new DateTime($ingreso->date);
                                        // Formatea la fecha al formato MM-DD-YYYY
                                        $payDate_formateada = $ingresoDate->format('m-d-Y');
                                        echo $payDate_formateada;
                                        ?>
                                    </span></td>
                                <td> <span class="amount">
                                        $
                                        <?= $ingreso->amount ?>
                                    </span></td>
                            </tr>
                        <?php } ?>
                    <?php
                    }
                    ?>


                </tbody>
            </table>
            <div id="lightbox-categories-ingresos" class="lightbox">
                <div class="lightbox-content">
                    <form id="addCategoriesGastos" onsubmit="handleAddCategories(event,'ingreso')">
                        <label for="categories-input">Agregar categorías (separadas por comas):</label>
                        <textarea id="categories-input" name="categories" rows="4"
                            placeholder="Ejemplo: comida, transporte, entretenimiento"></textarea>
                        <button type="submit" class="btn btn-action-primary enfasis btn-big">Agregar</button>
                    </form>
                    <button id="activities-close-button"
                        onclick="fadeOut(document.querySelector('#lightbox-categories-ingresos'))"
                        class="lightbox-button">
                        <!-- SVG content as provided -->
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="16" cy="16" r="15.5" stroke="#E1E4E9" />
                            <g clip-path="url(#clip0_1_41059)">
                                <path
                                    d="M23.3796 20.3855L18.9948 16.0006L23.3796 11.6157C24.2066 10.7888 24.2066 9.44797 23.3796 8.62104C22.5527 7.79411 21.2119 7.79411 20.385 8.62104L15.9997 13.0059L11.6149 8.62069C10.7876 7.79376 9.44677 7.79376 8.6202 8.62069C7.79327 9.44797 7.79327 10.7888 8.6202 11.6153L13.0054 16.0002L8.6202 20.3851C7.79327 21.2124 7.79327 22.5532 8.6202 23.3798C9.03419 23.7934 9.57559 23.9999 10.1177 23.9999C10.6595 23.9999 11.2016 23.7931 11.6152 23.3798L15.9997 18.9952L20.385 23.3801C20.799 23.7934 21.3404 24.0002 21.8825 24.0002C22.4246 24.0002 22.9663 23.7934 23.38 23.3801C24.2066 22.5532 24.2066 21.2127 23.3796 20.3855Z"
                                    fill="#98A2B7" />
                            </g>
                            <defs>
                                <clipPath id="clip0_1_41059">
                                    <rect width="16" height="16" fill="white" transform="translate(8 8)" />
                                </clipPath>
                            </defs>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div id="gastos" class="tab-content">
            <div class="tab-content-header">
                <button type="button" class="btn btn-action-primary enfasis btn-big">Agregar gasto</button>
            </div>
            <div class="card lg gastos-categories">
                <div class="card__header">
                    <div class="card__header-title">Categorías</div>
                    <div class="card__header-actions">
                        <button type="button" class="btn btn-action-tertiary enfasis"
                            onclick="fadeIn(document.querySelector('#lightbox-categories-gastos'))"><i
                                class="acuarela acuarela-Editar"></i>Editar categorías</button>
                    </div>
                </div>
                <div class="card__body">
                    <p>
                        <?php for ($i = 0; $i < count($gastosCat); $i++) { ?>
                            <?= $gastosCat[$i]->name ?>,
                        <?php } ?>
                    </p>
                </div>
            </div>
            <table>
                <tbody>
                    <?php
                    if (count($gastos) == 0) {
                    ?>
                        <tr>
                            <td>
                                <p style="text-align:center;font-weight:bold;">No se encontraron gastos en estas fechas</p>
                            </td>
                        </tr>
                    <?php
                    } else {
                    ?>
                        <?php
                        for ($i = 0; $i < count($gastos); $i++) {
                            $gasto = $gastos[$i];
                        ?>
                            <tr>
                                <td>
                                    <h4>
                                        <?= $gasto->name ?>
                                    </h4>
                                </td>
                                <td><span class="status" style="color:<?= $color[$gasto->type] ?>;">
                                        <?= $text[$gasto->type] ?>
                                    </span></td>
                                <td><span class="date">
                                        <?php
                                        // Crea un objeto DateTime desde la cadena ISO 8601
                                        $gastoDate = new DateTime($gasto->date);
                                        // Formatea la fecha al formato MM-DD-YYYY
                                        $payDate_formateada = $gastoDate->format('m-d-Y');
                                        echo $payDate_formateada;
                                        ?>
                                    </span></td>
                                <td> <span class="amount">
                                        $
                                        <?= $gasto->amount ?>
                                    </span></td>
                            </tr>
                        <?php } ?>
                    <?php
                    }
                    ?>

                </tbody>
            </table>
            <div id="lightbox-categories-gastos" class="lightbox">
                <div class="lightbox-content">
                    <form id="addCategoriesGastos" onsubmit="handleAddCategories(event,'gasto')">
                        <label for="categories-input">Agregar categorías (separadas por comas):</label>
                        <textarea id="categories-input" name="categories" rows="4"
                            placeholder="Ejemplo: comida, transporte, entretenimiento"></textarea>
                        <button type="submit" class="btn btn-action-primary enfasis btn-big">Agregar</button>
                    </form>
                    <button id="activities-close-button"
                        onclick="fadeOut(document.querySelector('#lightbox-categories-gastos'))"
                        class="lightbox-button">
                        <!-- SVG content as provided -->
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="16" cy="16" r="15.5" stroke="#E1E4E9" />
                            <g clip-path="url(#clip0_1_41059)">
                                <path
                                    d="M23.3796 20.3855L18.9948 16.0006L23.3796 11.6157C24.2066 10.7888 24.2066 9.44797 23.3796 8.62104C22.5527 7.79411 21.2119 7.79411 20.385 8.62104L15.9997 13.0059L11.6149 8.62069C10.7876 7.79376 9.44677 7.79376 8.6202 8.62069C7.79327 9.44797 7.79327 10.7888 8.6202 11.6153L13.0054 16.0002L8.6202 20.3851C7.79327 21.2124 7.79327 22.5532 8.6202 23.3798C9.03419 23.7934 9.57559 23.9999 10.1177 23.9999C10.6595 23.9999 11.2016 23.7931 11.6152 23.3798L15.9997 18.9952L20.385 23.3801C20.799 23.7934 21.3404 24.0002 21.8825 24.0002C22.4246 24.0002 22.9663 23.7934 23.38 23.3801C24.2066 22.5532 24.2066 21.2127 23.3796 20.3855Z"
                                    fill="#98A2B7" />
                            </g>
                            <defs>
                                <clipPath id="clip0_1_41059">
                                    <rect width="16" height="16" fill="white" transform="translate(8 8)" />
                                </clipPath>
                            </defs>
                        </svg>
                    </button>
                </div>
            </div>

        </div>
        <div id="pendientes" class="tab-content">
            <div class="tab-content-header">
                <button type="button" class="btn btn-action-primary enfasis btn-big"
                    onclick="fadeIn(document.querySelector('#lightbox-newInvoice'))">Crear Pago</button>
            </div>
            <table>
                <tbody>
                    <?php
                    if (count($pendientes) == 0) {
                    ?>
                        <tr>
                            <td>
                                <p style="text-align:center;font-weight:bold;">No se encontraron pagos pendiente en estas
                                    fechas</p>
                            </td>
                        </tr>
                    <?php
                    } else {
                    ?>
                        <?php
                        for ($i = 0; $i < count($pendientes); $i++) {
                            $pendiente = $pendientes[$i];
                        ?>
                            <tr>
                                <td>
                                    <h4>
                                        <?= $pendiente->name ?>
                                    </h4>
                                </td>
                                <td><span class="status" style="color:<?= $color[$pendiente->type] ?>;">
                                        <?= $text[$pendiente->type] ?>
                                    </span></td>
                                <td><span class="date">
                                        <?php
                                        // Crea un objeto DateTime desde la cadena ISO 8601
                                        $pendienteDate = new DateTime($pendiente->date);
                                        // Formatea la fecha al formato MM-DD-YYYY
                                        $payDate_formateada = $pendienteDate->format('m-d-Y');
                                        echo $payDate_formateada;
                                        ?>
                                    </span></td>
                                <td> <span class="amount">
                                        $
                                        <?= $pendiente->amount ?>
                                    </span></td>
                            </tr>
                        <?php } ?>
                    <?php
                    }
                    ?>

                </tbody>
            </table>
            <div id="lightbox-newInvoice" class="lightbox">
                <div class="lightbox-content">
                    <form id="addInvoiceForm" onsubmit="handleAddMovement(event)">
                        <h3>Nueva Solicitud de Pago</h3>
                        <div class="content">
                            <span>
                                <i class="acuarela acuarela-Pago"></i>
                                <label for="name">Concepto de pago</label>
                                <input type="text" name="name" id="name" placeholder="Ej: Matrícula enero 2024" required />
                            </span>
                            <span>
                                <i class="acuarela acuarela-Evento"></i>
                                <label for="date">Fecha límite</label>
                                <input type="date" name="date" id="date" required />
                            </span>
                            <span>
                                <i class="acuarela acuarela-Ingresos"></i>
                                <label for="amount">Valor a pagar (USD)</label>
                                <input type="number" step="0.01" min="0.01" name="amount" id="amount" placeholder="0.00" required />
                            </span>
                            <button type="submit" id="createInvoice" class="btn btn-action-primary enfasis btn-big">Generar link de pago</button>
                        </div>
                        <div class="payment-result" style="display:none;">
                            <div style="text-align: center; margin-bottom: 20px;">
                                <i class="acuarela acuarela-Verificado" style="font-size: 48px; color: #3fb072;"></i>
                                <h3 style="margin-top: 10px;">Link de pago generado</h3>
                            </div>
                            <p style="margin-bottom: 15px; color: #a0aec0;">Comparte este link con quien deba realizar el pago:</p>
                            <div style="background: #1e293b; border-radius: 8px; padding: 12px; margin-bottom: 15px; display: flex; align-items: center; gap: 10px;">
                                <input type="text" id="generatedPaymentLink" readonly style="flex: 1; background: transparent; border: none; color: #00A099; font-size: 14px; outline: none;" />
                                <button type="button" onclick="copyPaymentLink()" style="background: #00A099; color: white; border: none; padding: 8px 12px; border-radius: 6px; cursor: pointer; display: flex; align-items: center; gap: 5px;">
                                    <i class="acuarela acuarela-Copiar" style="font-size: 16px;"></i>
                                    Copiar
                                </button>
                            </div>
                            <div class="flex-btn" style="gap: 10px;">
                                <button type="button" onclick="fadeOut(document.querySelector('#lightbox-newInvoice')); resetInvoiceForm();" class="btn btn-action-primary enfasis btn-big">Cerrar</button>
                                <a id="openPaymentLink" href="" target="_blank" class="btn btn-action-secondary enfasis btn-big" style="text-decoration: none; display: flex; align-items: center; justify-content: center;">Abrir link</a>
                            </div>
                        </div>
                    </form>
                    <button id="activities-close-button"
                        onclick="fadeOut(document.querySelector('#lightbox-newInvoice')); resetInvoiceForm();" class="lightbox-button">
                        <!-- SVG content as provided -->
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="16" cy="16" r="15.5" stroke="#E1E4E9" />
                            <g clip-path="url(#clip0_1_41059)">
                                <path
                                    d="M23.3796 20.3855L18.9948 16.0006L23.3796 11.6157C24.2066 10.7888 24.2066 9.44797 23.3796 8.62104C22.5527 7.79411 21.2119 7.79411 20.385 8.62104L15.9997 13.0059L11.6149 8.62069C10.7876 7.79376 9.44677 7.79376 8.6202 8.62069C7.79327 9.44797 7.79327 10.7888 8.6202 11.6153L13.0054 16.0002L8.6202 20.3851C7.79327 21.2124 7.79327 22.5532 8.6202 23.3798C9.03419 23.7934 9.57559 23.9999 10.1177 23.9999C10.6595 23.9999 11.2016 23.7931 11.6152 23.3798L15.9997 18.9952L20.385 23.3801C20.799 23.7934 21.3404 24.0002 21.8825 24.0002C22.4246 24.0002 22.9663 23.7934 23.38 23.3801C24.2066 22.5532 24.2066 21.2127 23.3796 20.3855Z"
                                    fill="#98A2B7" />
                            </g>
                            <defs>
                                <clipPath id="clip0_1_41059">
                                    <rect width="16" height="16" fill="white" transform="translate(8 8)" />
                                </clipPath>
                            </defs>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

</main>
<?php include "includes/footer.php" ?>