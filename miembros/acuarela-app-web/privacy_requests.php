<?php
$classBody = "privacy";
include "includes/header.php";

// Obtener daycare y solicitudes
$activeDaycare = isset($_SESSION['activeDaycare']) ? $_SESSION['activeDaycare'] : null;
$dsarList = [];

if ($activeDaycare) {
    // Traemos TODAS las solicitudes del daycare siempre
    $dsarList = $a->getDaycareDSARs($activeDaycare);
}
?>
<main>
    <?php
    $mainHeaderTitle = "Solicitudes de Privacidad";
    $action = '';
    include "templates/sectionHeader.php";
    ?>

    <!-- Guía de Gestión -->
    <div class="admin-guide">
        <div class="guide-header" onclick="toggleGuide()">
            <div class="header-left">
                <i class="acuarela acuarela-Info"></i>
                <span>Guía de Gestión de Solicitudes de Privacidad</span>
            </div>
            <i class="acuarela acuarela-Arriba arrow" id="guideArrow"></i>
        </div>
        <div class="guide-content" id="guideContent">
            <div class="step">
                <span class="step-num">1</span>
                <div class="step-text">
                    <strong>Revisión (En Revisión):</strong> Verifica la identidad del solicitante y la validez de lo
                    que pide. Si todo es correcto, marca la solicitud como "En Progreso". Si es inválida o sospechosa,
                    puedes "Rechazarla".
                </div>
            </div>
            <div class="step">
                <span class="step-num">2</span>
                <div class="step-text">
                    <strong>Ejecución (En Progreso):</strong> Realiza las acciones necesarias en el sistema (ej. buscar
                    datos, corregirlos o borrarlos). Este paso es manual por parte del administrador.
                </div>
            </div>
            <div class="step">
                <span class="step-num">3</span>
                <div class="step-text">
                    <strong>Cierre (Completada):</strong> Una vez realizada la acción, marca la solicitud como
                    "Completada". Deberás incluir un mensaje final que se enviará por correo al usuario confirmando la
                    acción.
                </div>
            </div>
        </div>
    </div>

    <!-- Navegación por Tabs (Cliente) -->
    <div class="tabs-container" style="margin-bottom: 20px; border-bottom: 2px solid #eee;">
        <nav class="privacy-tabs" id="privacyTabs">
            <button onclick="filterTable('all')" class="tab-btn active" data-tab="all">Todas</button>
            <button onclick="filterTable('pending')" class="tab-btn" data-tab="pending">En Revisión</button>
            <button onclick="filterTable('in_progress')" class="tab-btn" data-tab="in_progress">En Progreso</button>
            <button onclick="filterTable('completed')" class="tab-btn" data-tab="completed">Completadas</button>
            <button onclick="filterTable('rejected')" class="tab-btn" data-tab="rejected">Rechazadas</button>
        </nav>
    </div>

    <div class="content" style="background: transparent; padding: 0;">
        <!-- Card de Tabla -->
        <div class="card-table" id="tableContainer" style="<?= empty($dsarList) ? 'display:none;' : '' ?>">
            <table class="table" id="dsarTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>Usuario / Contacto</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($dsarList)) {
                        $typeMap = [
                            'access' => 'Acceso a Datos',
                            'rectification' => 'Rectificación',
                            'erasure' => 'Borrado / Derecho al Olvido',
                            'restriction' => 'Limitar Procesamiento',
                            'portability' => 'Portabilidad',
                            'objection' => 'Oposición'
                        ];

                        foreach ($dsarList as $dsar) {
                            $statusClass = '';
                            $statusLabel = '';
                            // Normalizar estado para visualización
                            switch ($dsar->status) {
                                case 'received':
                                    $statusClass = 'pending-verify';
                                    $statusLabel = 'Verificación Pendiente';
                                    break;
                                case 'in_review':
                                    $statusClass = 'warning';
                                    $statusLabel = 'En Revisión';
                                    break;
                                case 'in_progress':
                                    $statusClass = 'info';
                                    $statusLabel = 'En Progreso';
                                    break;
                                case 'completed':
                                    $statusClass = 'success';
                                    $statusLabel = 'Completada';
                                    break;
                                case 'rejected':
                                    $statusClass = 'danger';
                                    $statusLabel = 'Rechazada';
                                    break;
                                default:
                                    $statusClass = 'secondary';
                                    $statusLabel = $dsar->status;
                            }

                            $typeLabel = isset($typeMap[$dsar->request_type]) ? $typeMap[$dsar->request_type] : ucfirst($dsar->request_type);

                            // Determinación robusta de fecha (misma lógica que en JS)
                            $dsarDate = isset($dsar->created_at) ? $dsar->created_at :
                                (isset($dsar->createdAt) ? $dsar->createdAt :
                                    (isset($dsar->received_at) ? $dsar->received_at :
                                        (isset($dsar->published_at) ? $dsar->published_at : null)));

                            // Fallback si strtotime falla
                            $dateDisplay = 'N/A';
                            if ($dsarDate) {
                                $ts = strtotime($dsarDate);
                                if ($ts) {
                                    $dateDisplay = date('d/m/Y', $ts);
                                } else {
                                    $dateDisplay = $dsarDate; // Mostrar raw si no se puede parsear
                                }
                            }
                            ?>
                            <tr class="dsar-row" data-status="<?= $dsar->status ?>">
                                <td style="font-weight:600; color:#555;">#<?= substr($dsar->id, -6) ?></td>
                                <td><?= $dateDisplay ?></td>
                                <td>
                                    <span class="badge-type"><?= $typeLabel ?></span>
                                </td>
                                <td>
                                    <?php if (isset($dsar->user_details)) { ?>
                                        <div class="user-info">
                                            <span
                                                class="name"><?= $dsar->user_details->name . ' ' . $dsar->user_details->lastname ?></span>
                                            <span class="email"><?= $dsar->requester_email ?></span>
                                        </div>
                                    <?php } else { ?>
                                        <div class="user-info">
                                            <span class="email"><?= $dsar->requester_email ?></span>
                                        </div>
                                    <?php } ?>
                                </td>
                                <td><span class="status-badge <?= $statusClass ?>"><?= $statusLabel ?></span></td>
                                <td>
                                    <button class="btn-icon" onclick="openDsarDetails('<?= $dsar->id ?>')" title="Ver Detalles">
                                        <i class="acuarela acuarela-Ver"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php }
                    } ?>
                </tbody>
            </table>
            <div id="dsarPagination"
                style="margin-top: 10px; display:none; justify-content: flex-end; align-items: center; gap: 8px; font-size: 0.9em; color:#555;">
                <!-- Controles de paginación DSAR se inyectan via JS -->
            </div>
        </div>

        <!-- Estado Vacío (Visible por defecto si no hay datos, o vía JS si el filtro no da resultados) -->
        <div class="empty-state-card" id="emptyState" style="<?= !empty($dsarList) ? 'display:none;' : '' ?>">
            <div class="icon-wrap">
                <i class="acuarela acuarela-Candado"></i>
            </div>
            <h3>No hay solicitudes para mostrar</h3>
            <p id="emptyMsg">No se encontraron solicitudes.</p>
        </div>
    </div>
</main>

<!-- Modal Detalles -->
<div id="dsarModal" class="custom-modal" style="display:none;">
    <div class="modal-backdrop" onclick="closeDsarModal()"></div>
    <div class="modal-card">
        <div class="modal-header">
            <h3>Detalles de Solicitud</h3>
            <button class="close-btn" onclick="closeDsarModal()">&times;</button>
        </div>
        <div id="modalBody" class="modal-body">
            Cargando...
        </div>

        <!-- Área de respuesta (oculta por defecto) -->
        <div id="responseArea" style="display:none; padding: 0 30px 20px 30px; background: #fff;">
            <label style="display:block; font-weight:600; margin-bottom:10px; color:#333;">Mensaje al Usuario
                (Obligatorio para enviar correo):</label>
            <textarea id="adminMessage" rows="4"
                style="width:100%; padding:15px; border:2px solid #eee; border-radius:8px; font-size:1rem; resize:vertical;"
                placeholder="Escribe aquí la razón del rechazo o los detalles de la finalización..."></textarea>
        </div>

        <div class="modal-footer" id="modalFooter">
            <!-- Botones dinámicos se inyectan via JS -->
            <button class="btn-flat" onclick="closeDsarModal()">Cerrar</button>
        </div>
    </div>
</div>

<script>
    // Datos globales para el modal y paginación
    const allDsars = <?php echo json_encode($dsarList); ?>;
    let currentDsarId = null;
    let currentDsar = null;
    let pendingStatusChange = null;
    const DSAR_PAGE_SIZE = 5;
    let dsarCurrentPage = 1;
    let dsarCurrentFilter = 'all';

    const typeMapJS = {
        'access': 'Acceso a Datos',
        'rectification': 'Rectificación',
        'erasure': 'Borrado / Derecho al Olvido',
        'restriction': 'Limitar Procesamiento',
        'portability': 'Portabilidad',
        'objection': 'Oposición'
    };

    function toggleGuide() {
        const content = document.getElementById('guideContent');
        const arrow = document.getElementById('guideArrow');

        // Detecta el estado real computado (ya que iniciamos sin style inline pero visible por CSS)
        const isVisible = window.getComputedStyle(content).display !== 'none';

        if (isVisible) {
            // Cerramos
            content.style.display = 'none';
            arrow.classList.remove('acuarela-Arriba');
            arrow.classList.add('acuarela-Abajo');
        } else {
            // Abrimos
            content.style.display = 'flex';
            arrow.classList.remove('acuarela-Abajo');
            arrow.classList.add('acuarela-Arriba');
        }
    }

    // Inicializar filtro/paginación al cargar
    document.addEventListener('DOMContentLoaded', function () {
        filterTable('all');
    }

    // ----- Filtrado + Paginación (Cliente) -----
    function filterTable(filterType) {
        dsarCurrentFilter = filterType;
        dsarCurrentPage = 1;
        applyDsarFilterAndPagination();
    }

    function applyDsarFilterAndPagination() {
        const rows = Array.from(document.querySelectorAll('.dsar-row'));
        const tableContainer = document.getElementById('tableContainer');
        const emptyState = document.getElementById('emptyState');
        const emptyMsg = document.getElementById('emptyMsg');
        const pagContainer = document.getElementById('dsarPagination');

        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        const activeBtn = document.querySelector(`.tab-btn[data-tab="${dsarCurrentFilter}"]`);
        if (activeBtn) activeBtn.classList.add('active');

        const filtered = [];
        rows.forEach(row => {
            const status = row.getAttribute('data-status');
            let match = false;
            if (dsarCurrentFilter === 'all') {
                match = true;
            } else if (dsarCurrentFilter === 'pending') {
                if (status === 'received' || status === 'in_review') match = true;
            } else {
                if (status === dsarCurrentFilter) match = true;
            }
            if (match) filtered.push(row);
        });

        if (!allDsars || allDsars.length === 0) {
            tableContainer.style.display = 'none';
            emptyState.style.display = 'block';
            emptyMsg.textContent = "No hay solicitudes registradas en el sistema.";
            if (pagContainer) { pagContainer.style.display = 'none'; pagContainer.innerHTML = ''; }
            return;
        }

        if (filtered.length === 0) {
            tableContainer.style.display = 'none';
            emptyState.style.display = 'block';
            emptyMsg.textContent = "No se encontraron solicitudes con el filtro seleccionado.";
            if (pagContainer) { pagContainer.style.display = 'none'; pagContainer.innerHTML = ''; }
            return;
        }

        const totalPages = Math.max(1, Math.ceil(filtered.length / DSAR_PAGE_SIZE));
        if (dsarCurrentPage > totalPages) dsarCurrentPage = totalPages;
        if (dsarCurrentPage < 1) dsarCurrentPage = 1;

        rows.forEach(row => { row.style.display = 'none'; });
        filtered.forEach((row, idx) => {
            const start = (dsarCurrentPage - 1) * DSAR_PAGE_SIZE;
            const end = dsarCurrentPage * DSAR_PAGE_SIZE;
            if (idx >= start && idx < end) row.style.display = '';
        });

        tableContainer.style.display = 'block';
        emptyState.style.display = 'none';

        renderDsarPagination(totalPages);
    }

    function renderDsarPagination(totalPages) {
        const pagContainer = document.getElementById('dsarPagination');
        if (!pagContainer) return;

        if (totalPages <= 1) {
            pagContainer.style.display = 'none';
            pagContainer.innerHTML = '';
            return;
        }

        pagContainer.style.display = 'flex';
        const disabledPrev = dsarCurrentPage === 1 ? 'opacity:0.5; cursor:default;' : '';
        const disabledNext = dsarCurrentPage === totalPages ? 'opacity:0.5; cursor:default;' : '';

        let html = '';
        html += `<button type="button" onclick="changeDsarPage(${dsarCurrentPage - 1})" style="border:1px solid #e5e7eb; background:#fff; padding:4px 10px; border-radius:6px; ${disabledPrev}">Anterior</button>`;
        html += `<span style="min-width:110px; text-align:center;">Página ${dsarCurrentPage} de ${totalPages}</span>`;
        html += `<button type="button" onclick="changeDsarPage(${dsarCurrentPage + 1})" style="border:1px solid #e5e7eb; background:#fff; padding:4px 10px; border-radius:6px; ${disabledNext}">Siguiente</button>`;
        pagContainer.innerHTML = html;
    }

    function changeDsarPage(page) {
        dsarCurrentPage = page;
        applyDsarFilterAndPagination();
    }

    // ----- Lógica del Modal -----
    function openDsarDetails(id) {
        currentDsarId = id;
        currentDsar = allDsars.find(d => d.id == id);
        if (!currentDsar) return;

        const modal = document.getElementById('dsarModal');
        const body = document.getElementById('modalBody');
        const footer = document.getElementById('modalFooter');
        const responseArea = document.getElementById('responseArea');
        const adminMsg = document.getElementById('adminMessage');

        // Reset UI
        responseArea.style.display = 'none';
        adminMsg.value = '';
        pendingStatusChange = null;

        let requesterHtml = `
            <div class="detail-group">
                <label>Solicitante</label>
                <div class="detail-value">${currentDsar.requester_email}</div>
                <div class="detail-sub">${currentDsar.requester_phone || 'Sin teléfono'}</div>
            </div>
        `;

        let userHtml = '';
        if (currentDsar.user_details) {
            userHtml = `
                 <div class="detail-group">
                    <label>Usuario Vinculado</label>
                    <div class="detail-value">${currentDsar.user_details.name} ${currentDsar.user_details.lastname}</div>
                </div>
            `;
        }

        let notesHtml = currentDsar.notes ? `
            <div class="detail-group full-width">
                <label>Notas / Detalles Adicionales</label>
                <div class="detail-box">${currentDsar.notes}</div>
            </div>` : '';

        // Formato de fecha seguro con múltiples fallbacks para Strapi v3/v4/custom
        let rawDate = currentDsar.created_at || currentDsar.createdAt || currentDsar.received_at || currentDsar.published_at;
        let createdDate = 'Fecha no disponible';

        if (rawDate) {
            const d = new Date(rawDate);
            if (!isNaN(d.getTime())) {
                createdDate = d.toLocaleDateString('es-ES', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
            } else {
                console.warn("Fecha inválida recibida:", rawDate);
                createdDate = rawDate; // Mostrar raw si falla parseo
            }
        }

        let typeLabel = typeMapJS[currentDsar.request_type] || (currentDsar.request_type ? currentDsar.request_type.toUpperCase() : 'DESCONOCIDO');

        body.innerHTML = `
            <div class="details-grid">
                <div class="detail-group">
                    <label>ID Solicitud</label>
                    <div class="detail-value" style="font-family:monospace; color:#555;">${currentDsar.id}</div>
                </div>
                <div class="detail-group">
                    <label>Tipo</label>
                    <div class="detail-value"><span class="badge-type">${typeLabel}</span></div>
                </div>
                ${requesterHtml}
                ${userHtml}
                <div class="detail-group">
                    <label>Estado Actual</label>
                    <div class="detail-value">${currentDsar.status}</div>
                </div>
                 <div class="detail-group">
                    <label>Fecha Creación</label>
                    <div class="detail-value">${createdDate}</div>
                </div>
                ${notesHtml}
            </div>
        `;

        // Construir Footer con botones dinámicos
        let buttonsHtml = `<button class="btn-flat" onclick="closeDsarModal()">Cerrar</button>`;

        if (currentDsar.status === 'in_review' || currentDsar.status === 'received') {
            buttonsHtml += `
                <button class="btn-primary" style="background-color: #dc3545;" onclick="prepareStatusChange('rejected')">Rechazar</button>
                <button class="btn-primary" onclick="updateDsarStatus('in_progress')">Aceptar y Marcar En Progreso</button>
            `;
        } else if (currentDsar.status === 'in_progress') {
            buttonsHtml += `
                <button class="btn-primary" style="background-color: #dc3545;" onclick="prepareStatusChange('rejected')">Cancelar / Rechazar</button>
                <button class="btn-success" onclick="prepareStatusChange('completed')">Finalizar Solicitud</button>
            `;
        }

        footer.innerHTML = buttonsHtml;
        modal.style.display = 'flex';
    }

    function closeDsarModal() {
        document.getElementById('dsarModal').style.display = 'none';
    }

    // Prepara la UI para escribir el mensaje (para Rejected o Completed)
    function prepareStatusChange(status) {
        pendingStatusChange = status;
        const responseArea = document.getElementById('responseArea');
        const footer = document.getElementById('modalFooter');

        responseArea.style.display = 'block';
        document.getElementById('adminMessage').focus();

        let actionLabel = status === 'completed' ? 'Finalizar y Enviar' : 'Rechazar y Notificar';
        let actionClass = status === 'completed' ? 'btn-success' : 'btn-primary';
        let colorStyle = status === 'rejected' ? 'background-color:#dc3545;' : '';

        footer.innerHTML = `
            <button class="btn-flat" onclick="cancelStatusChange()">Cancelar</button>
            <button class="${actionClass}" style="${colorStyle}" onclick="submitStatusChange()">${actionLabel}</button>
        `;
    }

    function cancelStatusChange() {
        openDsarDetails(currentDsarId);
    }

    function submitStatusChange() {
        const msg = document.getElementById('adminMessage').value;
        if (!msg.trim()) {
            alert("Por favor escribe un mensaje explicativo para el usuario.");
            return;
        }
        updateDsarStatus(pendingStatusChange, msg);
    }

    function updateDsarStatus(newStatus, message = '') {
        if (!currentDsarId) return;

        if (!message && newStatus === 'in_progress') {
            // Confirmación rápida para in_progress sin mensaje
            if (!confirm("¿Iniciar progreso de esta solicitud?")) return;
        }

        const formData = new FormData();
        formData.append('id', currentDsarId);
        formData.append('status', newStatus);
        if (message) formData.append('reply_message', message);

        const footer = document.getElementById('modalFooter');
        if (footer) footer.innerHTML = '<button class="btn-flat" disabled>Procesando...</button>';

        fetch('set/privacy/update_status.php', {
            method: 'POST',
            body: formData
        })
            .then(r => r.json())
            .then(d => {
                if (d.success) {
                    location.reload();
                } else {
                    alert('Error: ' + d.message);
                    if (pendingStatusChange) prepareStatusChange(pendingStatusChange);
                    else openDsarDetails(currentDsarId);
                }
            })
            .catch(err => {
                alert('Error de conexión');
                console.error(err);
            });
    }

    // Inicializar el filtro al cargar la página
    document.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        const initialStatus = urlParams.get('status') || 'all';
        filterTable(initialStatus);
    });
</script>

<style>
    /* Estilos Guía Admin - CORREGIDO */
    .admin-guide {
        background: white;
        margin-top: 40px;
        /* Separación del título */
        margin-bottom: 40px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        border: 1px solid #eef2f7;
    }

    .guide-header {
        padding: 20px 30px;
        background: #fff;
        font-weight: 700;
        font-size: 1.3rem;
        color: #333;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #f0f0f0;
        transition: background 0.2s;
    }

    .guide-header:hover {
        background: #f9fbfd;
    }

    /* Grupo Izquierdo */
    .header-left {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .guide-header i.acuarela-Info {
        color: #0CB5C3;
        font-size: 1.6rem;
    }

    /* Flecha limpia y visible */
    .arrow {
        color: #0CB5C3;
        font-size: 1.8rem;
        /* Más grande */
        transition: transform 0.3s ease;
        background: none;
        /* Sin fondo */
        width: auto;
        height: auto;
        display: inline-block;
    }

    .guide-content {
        display: flex;
        flex-direction: row;
        /* Horizontal forzado */
        flex-wrap: wrap;
        /* Permitir wrap si es muy estrecho */
        gap: 20px;
        padding: 30px;
        background: white;
    }

    .guide-content .step {
        flex: 1 1 300px;
        /* Base 300px, puede crecer y encoger */
        background: #fafbfc;
        padding: 25px;
        /* Más padding interno */
        border-radius: 12px;
        border: 1px solid #eee;
        display: flex;
        gap: 20px;
        align-items: flex-start;
        min-width: 0;
        /* Prevenir desborde flex */
    }

    .step-num {
        background: #0CB5C3;
        color: white;
        width: 40px;
        height: 40px;
        /* Número más grande */
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 1.4rem;
        flex-shrink: 0;
        margin-top: -5px;
    }

    .step-text {
        font-size: 1.15rem;
        color: #555;
        line-height: 1.6;
    }

    /* Texto base más grande */

    .step-text strong {
        color: #222;
        display: block;
        margin-bottom: 8px;
        font-size: 1.25rem;
    }

    /* Título paso más grande */

    /* Estilos Pestañas botón */
    .privacy-tabs {
        display: flex;
        gap: 15px;
        padding: 0 10px;
    }

    .tab-btn {
        background: none;
        border: none;
        padding: 12px 20px;
        color: #666;
        font-weight: 600;
        font-family: inherit;
        font-size: 1.1rem;
        /* Más grande */
        cursor: pointer;
        border-bottom: 4px solid transparent;
        transition: all 0.2s;
    }

    .tab-btn:hover {
        color: #0CB5C3;
        background: #fcfcfc;
    }

    .tab-btn.active {
        color: #0CB5C3;
        border-bottom-color: #0CB5C3;
    }

    /* Resto de estilos mejorados */
    .empty-state-card {
        text-align: center;
        padding: 80px 20px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    }

    .empty-state-card .icon-wrap {
        font-size: 64px;
        /* Icono más grande */
        color: #ddd;
        margin-bottom: 20px;
    }

    .empty-state-card h3 {
        font-size: 1.5rem;
        margin-bottom: 10px;
    }

    .empty-state-card p {
        font-size: 1.1rem;
        color: #888;
    }

    .card-table {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        overflow: hidden;
        padding: 15px;
    }

    .table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table th {
        padding: 18px 20px;
        color: #555;
        font-size: 0.95rem;
        /* Header más legible */
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #f0f0f0;
    }

    .table td {
        padding: 20px 20px;
        vertical-align: middle;
        border-bottom: 1px solid #f9f9f9;
        font-size: 1.05rem;
        /* Texto tabla más grande */
        color: #333;
    }

    .table tr:last-child td {
        border-bottom: none;
    }

    .table tr:hover td {
        background-color: #fafafa;
    }

    .user-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .user-info .name {
        font-weight: 600;
        color: #333;
        font-size: 1.1rem;
    }

    .user-info .email {
        font-size: 0.95rem;
        color: #666;
    }

    .badge-type {
        background: #eef2f7;
        color: #444;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.9rem;
        /* Badge más grande */
        font-weight: 600;
        display: inline-block;
    }

    .status-badge {
        padding: 8px 14px;
        border-radius: 30px;
        font-size: 0.95rem;
        /* Badge más grande */
        font-weight: 600;
        display: inline-flex;
        align-items: center;
    }

    .status-badge::before {
        content: '';
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        margin-right: 8px;
        background: currentColor;
    }

    .status-badge.pending-verify {
        background: #fff3cd;
        color: #856404;
    }

    .status-badge.warning {
        background: #fff8e1;
        color: #f57f17;
    }

    /* Amarillo más intenso */
    .status-badge.info {
        background: #e3f2fd;
        color: #0277bd;
    }

    .status-badge.success {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .status-badge.danger {
        background: #ffebee;
        color: #c62828;
    }

    .status-badge.secondary {
        background: #f5f5f5;
        color: #616161;
    }

    .btn-icon {
        background: #f0fbff;
        border: 1px solid #e1f5fe;
        cursor: pointer;
        color: #0CB5C3;
        font-size: 1.4rem;
        /* Ojo más grande */
        padding: 8px;
        border-radius: 8px;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-icon:hover {
        background: #0CB5C3;
        color: white;
        border-color: #0CB5C3;
    }

    /* Modal Styles - AUMENTADO */
    .custom-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-backdrop {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(4px);
    }

    .modal-card {
        background: white;
        width: 95%;
        max-width: 800px;
        /* Modal más ancho */
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        max-height: 90vh;
    }

    .modal-header {
        padding: 25px 30px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fafafa;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 1.6rem;
        color: #222;
    }

    .close-btn {
        background: none;
        border: none;
        font-size: 2rem;
        cursor: pointer;
        color: #aaa;
        line-height: 1;
    }

    .close-btn:hover {
        color: #333;
    }

    .modal-body {
        padding: 30px;
        overflow-y: auto;
    }

    .modal-footer {
        padding: 25px 30px;
        border-top: 1px solid #eee;
        background: #fbfbfb;
        display: flex;
        justify-content: flex-end;
        gap: 15px;
    }

    .details-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
    }

    /* Más espacio */

    .detail-group label {
        display: block;
        font-size: 0.9rem;
        /* Label más grande */
        color: #777;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .detail-value {
        font-weight: 500;
        font-size: 1.3rem;
        /* Valor MUCHO más grande */
        color: #222;
        line-height: 1.4;
    }

    .detail-sub {
        font-size: 1rem;
        color: #666;
        margin-top: 4px;
    }

    .full-width {
        grid-column: 1 / -1;
    }

    .detail-box {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        font-size: 1.1rem;
        /* Texto de notas más grande */
        color: #444;
        white-space: pre-wrap;
        border: 1px solid #eee;
    }

    /* Botones Grandes */
    .btn-primary,
    .btn-success,
    .btn-flat {
        font-size: 1.05rem;
        padding: 12px 24px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: transform 0.1s;
    }

    .btn-primary {
        background: #0CB5C3;
        color: white;
        border: none;
    }

    .btn-primary:hover {
        background: #0aa3b0;
    }

    .btn-success {
        background: #28a745;
        color: white;
        border: none;
    }

    .btn-success:hover {
        background: #218838;
    }

    .btn-flat {
        background: white;
        color: #666;
        border: 1px solid #ddd;
    }

    .btn-flat:hover {
        background: #f5f5f5;
        color: #333;
    }
</style>

<?php include "includes/footer.php"; ?>