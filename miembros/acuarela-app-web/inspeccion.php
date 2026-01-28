<?php $classBody = "inspeccion";
include "includes/header.php" ?>
<main>
    <?php
    $mainHeaderTitle = "Modo inspección";
    $action = '<button type="button" onclick="generateReport()" class="btn btn-action-secondary enfasis btn-big">Generar informe</button>';
    $videoPath = 'videos/inspeccion.mp4';
    include "templates/sectionHeader.php";
    ?>
    <div class="content">
        <h2>Fecha del informe</h2>
        <p>Utiliza el filtro de fecha para generar el informe desde y hasta la fecha que lo necesites</p>

        <div class="date-filter">
            <span class="calendar">
                <label for="start-date">Desde</label>
                <input type="date" name="start-date" id="start-date" />
            </span>
            <span class="calendar">
                <label for="end-date">Hasta</label>
                <input type="date" name="end-date" id="end-date" />
            </span>
        </div>
        <h2>Contenido del informe</h2>
        <p>Selecciona lo que quieres que incluya el reporte</p>
        <div class="report-content">
            <div class="cntr-check">
                <input type="checkbox" class="hidden-xs-up" id="fichasNinos">
                <label for="fichasNinos" class="cbx"></label>
                <span> Fichas de niños</span>
            </div>
            <div class="cntr-check">
                <input type="checkbox" class="hidden-xs-up" id="registroActividades">
                <label for="registroActividades" class="cbx"></label>
                <span> Registro de actividades</span>
            </div>
            <div class="cntr-check">
                <input type="checkbox" class="hidden-xs-up" id="registroAsistencia">
                <label for="registroAsistencia" class="cbx"></label>
                <span> Registro de asistencia</span>
            </div>
            <div class="cntr-check">
                <input type="checkbox" class="hidden-xs-up" id="fichasAsistentes">
                <label for="fichasAsistentes" class="cbx"></label>
                <span> Fichas de asistentes</span>
            </div>
            <!-- <div class="cntr-check">
                <input type="checkbox" class="hidden-xs-up" id="ingresos">
                <label for="ingresos" class="cbx"></label>
                <span> Ingresos</span>
            </div>
            <div class="cntr-check">
                <input type="checkbox" class="hidden-xs-up" id="gastos">
                <label for="gastos" class="cbx"></label>
                <span> Gastos</span>
            </div>
            <div class="cntr-check">
                <input type="checkbox" class="hidden-xs-up" id="payrolls">
                <label for="payrolls" class="cbx"></label>
                <span> Payrolls</span>
            </div> -->
        </div>
        <input type="hidden" name="daycare" id="daycare" value="<?= $a->daycareID ?>">
    </div>

    <!-- SECCIÓN GESTIÓN FERPA (Integrada) -->
    <?php
    // Obtener solicitudes FERPA
    $ferpaList = [];
    if ($a->daycareID) {
        $ferpaList = $a->getDaycareFerpaRequests($a->daycareID);
    }
    ?>
    <div class="content" style="margin-top: 40px; border-top: 1px solid #eee; padding-top: 40px;">
        <h2>Solicitudes Educativas (FERPA)</h2>
        <p>Gestione las solicitudes de acceso y corrección de registros de los padres.</p>

        <!-- Tabla FERPA -->
        <div class="card-table"
            style="background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); padding: 15px; margin-top: 20px;">
            <?php if (empty($ferpaList)): ?>
                <div style="text-align: center; padding: 40px; color: #888;">
                    <i class="acuarela acuarela-Info"
                        style="font-size: 48px; display: block; margin-bottom: 10px; color: #ddd;"></i>
                    No hay solicitudes FERPA registradas.
                </div>
            <?php else: ?>
                <table class="table" style="width: 100%; border-collapse: separate; border-spacing: 0;">
                    <thead>
                        <tr style="text-align: left; color: #555;">
                            <th style="padding: 15px; border-bottom: 2px solid #f0f0f0;">ID</th>
                            <th style="padding: 15px; border-bottom: 2px solid #f0f0f0;">Fecha</th>
                            <th style="padding: 15px; border-bottom: 2px solid #f0f0f0;">Tipo</th>
                            <th style="padding: 15px; border-bottom: 2px solid #f0f0f0;">Solicitante (Padre)</th>
                            <th style="padding: 15px; border-bottom: 2px solid #f0f0f0;">Estudiante</th>
                            <th style="padding: 15px; border-bottom: 2px solid #f0f0f0;">Estado</th>
                            <th style="padding: 15px; border-bottom: 2px solid #f0f0f0;">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ferpaList as $req):
                            $statusMap = [
                                'received' => ['Verif. Pendiente', '#fff3cd', '#856404'],
                                'under_review' => ['En Revisión', '#e3f2fd', '#0277bd'],
                                'approved' => ['Aprobada', '#e8f5e9', '#2e7d32'],
                                'denied' => ['Rechazada', '#ffebee', '#c62828'],
                                'completed' => ['Completada', '#e8f5e9', '#2e7d32']
                            ];
                            $st = $statusMap[$req->status] ?? [$req->status, '#f5f5f5', '#666'];

                            // Fechas (compatibilidad created_at / createdAt / received_at)
                            $rawDate = null;
                            if (isset($req->created_at)) {
                                $rawDate = $req->created_at;
                            } elseif (isset($req->createdAt)) {
                                $rawDate = $req->createdAt;
                            } elseif (isset($req->received_at)) {
                                $rawDate = $req->received_at;
                            }
                            $dateStr = $rawDate ? date('d/m/Y', strtotime($rawDate)) : 'N/A';

                            // Nombres (padre e hijo)
                            $parentName = 'N/A';
                            if (isset($req->requester_details)) {
                                $parentFirst = $req->requester_details->name ?? '';
                                $parentLast = $req->requester_details->lastname ?? '';
                                $parentName = trim($parentFirst . ' ' . $parentLast);
                            } elseif (isset($req->requester_email)) {
                                $parentName = $req->requester_email;
                            }

                            $childName = 'N/A';
                            if (isset($req->child_details)) {
                                $childFirst = $req->child_details->name ?? '';
                                $childLast = $req->child_details->lastname ?? '';
                                $childName = trim($childFirst . ' ' . $childLast);
                            }
                            ?>
                            <tr class="ferpa-row" style="border-bottom: 1px solid #f9f9f9;">
                                <td style="padding: 15px;">#<?= substr($req->id, -6) ?></td>
                                <td style="padding: 15px;"><?= $dateStr ?></td>
                                <td style="padding: 15px;">
                                    <span
                                        style="background: #eef2f7; color: #444; padding: 4px 8px; border-radius: 4px; font-size: 0.9em; font-weight: 600;">
                                        <?= $req->request_type == 'access' ? 'Acceso' : 'Corrección' ?>
                                    </span>
                                </td>
                                <td style="padding: 15px;"><?= $parentName ?></td>
                                <td style="padding: 15px;"><?= $childName ?></td>
                                <td style="padding: 15px;">
                                    <span
                                        style="background: <?= $st[1] ?>; color: <?= $st[2] ?>; padding: 6px 12px; border-radius: 20px; font-weight: 600; font-size: 0.9em;">
                                        <?= $st[0] ?>
                                    </span>
                                </td>
                                <td style="padding: 15px;">
                                    <button onclick='openFerpaModal(<?= json_encode($req) ?>)'
                                        style="background: #f0fbff; border: 1px solid #e1f5fe; color: #0CB5C3; cursor: pointer; padding: 8px; border-radius: 8px;">
                                        <i class="acuarela acuarela-Ver"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div id="ferpaPagination"
                    style="margin-top: 10px; display: none; justify-content: flex-end; align-items: center; gap: 8px; font-size: 0.9em; color:#555;">
                    <!-- Controles de paginación FERPA se inyectan vía JS -->
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal FERPA -->
    <div id="ferpaModal"
        style="display:none; position: fixed; top:0; left:0; width:100%; height:100%; z-index: 1000; align-items: center; justify-content: center;">
        <div style="position: absolute; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.5);"
            onclick="closeFerpaModal()"></div>
        <div style="background: white; width: 95%; max-width: 720px; border-radius: 16px; position: relative; z-index: 1001; max-height: 92vh; display: flex; flex-direction: column; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
            
            <!-- Modal Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 24px 30px; border-bottom: 1px solid #e5e7eb; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
                <h3 style="margin:0; font-size: 1.4rem; color: #1e293b; font-weight: 600;">Detalle Solicitud FERPA</h3>
                <button onclick="closeFerpaModal()"
                    style="background: #f1f5f9; border: none; width: 36px; height: 36px; border-radius: 50%; font-size: 20px; cursor: pointer; color: #64748b; display: flex; align-items: center; justify-content: center; transition: all 0.2s;"
                    onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">&times;</button>
            </div>

            <!-- Modal Body -->
            <div style="padding: 30px; overflow-y: auto; flex: 1;">
                <div id="ferpaModalContent" style="line-height: 1.7; font-size: 1rem;"></div>

                <!-- Área de envío de informes FERPA (solo para solicitudes de acceso) -->
                <div id="ferpaReportArea" style="margin-top: 25px; padding-top: 25px; border-top: 2px solid #e5e7eb; display: none;">
                    <h4 style="margin-top:0; margin-bottom:15px; font-size: 1.15rem; color: #1e293b;">📧 Enviar Informes al Padre</h4>
                    <p style="font-size: 1rem; color:#64748b; margin-bottom:15px;">
                        Selecciona los informes educativos que deseas generar y enviar al padre.
                    </p>
                    <div class="report-content" style="margin-bottom: 20px;">
                        <div class="cntr-check" style="margin-bottom: 10px;">
                            <input type="checkbox" class="hidden-xs-up" id="ferpaRepNinos" checked>
                            <label for="ferpaRepNinos" class="cbx"></label>
                            <span style="font-size: 1rem;"> Fichas de niños</span>
                        </div>
                        <div class="cntr-check" style="margin-bottom: 10px;">
                            <input type="checkbox" class="hidden-xs-up" id="ferpaRepActividades" checked>
                            <label for="ferpaRepActividades" class="cbx"></label>
                            <span style="font-size: 1rem;"> Registro de actividades</span>
                        </div>
                        <div class="cntr-check" style="margin-bottom: 10px;">
                            <input type="checkbox" class="hidden-xs-up" id="ferpaRepAsistencia" checked>
                            <label for="ferpaRepAsistencia" class="cbx"></label>
                            <span style="font-size: 1rem;"> Registro de asistencia</span>
                        </div>
                        <div class="cntr-check">
                            <input type="checkbox" class="hidden-xs-up" id="ferpaRepAsistentes">
                            <label for="ferpaRepAsistentes" class="cbx"></label>
                            <span style="font-size: 1rem;"> Fichas de asistentes</span>
                        </div>
                    </div>
                    <div style="display:flex; gap:15px; margin-bottom:20px; flex-wrap:wrap;">
                        <div>
                            <label for="ferpaFrom" style="display:block; font-size: 0.95rem; color:#475569; margin-bottom: 6px; font-weight: 500;">Desde</label>
                            <input type="date" id="ferpaFrom" style="padding: 12px 16px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 1rem;">
                        </div>
                        <div>
                            <label for="ferpaTo" style="display:block; font-size: 0.95rem; color:#475569; margin-bottom: 6px; font-weight: 500;">Hasta</label>
                            <input type="date" id="ferpaTo" style="padding: 12px 16px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 1rem;">
                        </div>
                    </div>
                    <button type="button" onclick="sendFerpaReports()"
                        style="background: #0CB5C3; color: white; border: none; padding: 14px 28px; border-radius: 10px; cursor: pointer; font-size: 1rem; font-weight: 600; transition: all 0.2s;"
                        onmouseover="this.style.background='#0a9ca8'" onmouseout="this.style.background='#0CB5C3'">
                        Enviar Informes al Padre
                    </button>
                    <p id="ferpaReportStatus" style="font-size: 1rem; margin-top: 12px; color:#64748b; display:none;"></p>
                </div>

                <!-- Campos de acción para Correcciones -->
                <div id="ferpaActionFields" style="margin-top: 25px; padding-top: 25px; border-top: 2px solid #e5e7eb; display: none;">
                    
                    <!-- Nota de Resolución -->
                    <div id="ferpaNoteBlock" style="margin-bottom: 25px;">
                        <label style="display:block; margin-bottom: 10px; font-weight: 600; font-size: 1.05rem; color: #1e293b;">
                            ✍️ Nota de Resolución
                        </label>
                        <p style="font-size: 0.95rem; color: #64748b; margin: 0 0 12px 0;">Esta nota será enviada al padre como respuesta oficial.</p>
                        <textarea id="ferpaResolutionNote"
                            style="width: 100%; padding: 16px; border: 2px solid #e2e8f0; border-radius: 10px; min-height: 100px; resize: vertical; font-family: inherit; font-size: 1rem; transition: border-color 0.2s;"
                            placeholder="Escribe aquí la respuesta o justificación para el padre..."
                            onfocus="this.style.borderColor='#0CB5C3'" onblur="this.style.borderColor='#e2e8f0'"
                            rows="3"></textarea>
                    </div>

                    <!-- Interfaz sencilla para Corrección: Antes / Después -->
                    <div id="ferpaCorrectionPatchBlock" style="display:none; background: #f8fafc; padding: 20px; border-radius: 12px; border: 1px solid #e2e8f0;">
                        <label style="display:block; margin-bottom: 15px; font-weight: 600; font-size: 1.05rem; color: #1e293b;">
                            ✏️ Datos de la Corrección
                        </label>
                        <p style="font-size: 0.95rem; color:#64748b; margin: 0 0 16px 0;">
                            Describe brevemente qué estaba mal y cómo lo corregiste. Esto se usará como evidencia FERPA.
                        </p>

                        <div style="margin-bottom: 16px;">
                            <label for="ferpaCorrectionBefore" style="display:block; font-size: 0.95rem; color:#475569; margin-bottom: 6px; font-weight: 500;">
                                Antes (qué estaba mal):
                            </label>
                            <textarea id="ferpaCorrectionBefore"
                                style="width: 100%; padding: 14px 16px; border: 2px solid #e2e8f0; border-radius: 10px; min-height: 80px; resize: vertical; font-size: 1rem;"
                                placeholder="Ej: Asistencia marcada como ausente el 20/01 pero el niño sí asistió."></textarea>
                        </div>

                        <div style="margin-bottom: 4px;">
                            <label for="ferpaCorrectionAfter" style="display:block; font-size: 0.95rem; color:#475569; margin-bottom: 6px; font-weight: 500;">
                                Después (cómo quedó corregido):
                            </label>
                            <textarea id="ferpaCorrectionAfter"
                                style="width: 100%; padding: 14px 16px; border: 2px solid #e2e8f0; border-radius: 10px; min-height: 80px; resize: vertical; font-size: 1rem;"
                                placeholder="Ej: Actualicé la asistencia del 20/01 a 'Presente' y agregué nota interna indicando la corrección."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer (Botones) -->
            <div id="ferpaActionArea" style="display: none; padding: 20px 30px; border-top: 1px solid #e5e7eb; background: #f8fafc;">
                <div style="display: flex; gap: 12px; justify-content: flex-end; flex-wrap: wrap;">
                    <button id="ferpaDenyBtn" onclick="updateFerpa('denied')"
                        style="background: white; color: #dc2626; border: 2px solid #dc2626; padding: 14px 28px; border-radius: 10px; cursor: pointer; font-size: 1rem; font-weight: 600; transition: all 0.2s;"
                        onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='white'">
                        Rechazar
                    </button>
                    <button id="ferpaReviewBtn" onclick="updateFerpa('under_review')"
                        style="background: white; color: #0891b2; border: 2px solid #0891b2; padding: 14px 28px; border-radius: 10px; cursor: pointer; font-size: 1rem; font-weight: 600; transition: all 0.2s;"
                        onmouseover="this.style.background='#ecfeff'" onmouseout="this.style.background='white'">
                        En Revisión
                    </button>
                    <button id="ferpaApproveBtn" onclick="updateFerpa('approved')"
                        style="background: #16a34a; color: white; border: 2px solid #16a34a; padding: 14px 28px; border-radius: 10px; cursor: pointer; font-size: 1rem; font-weight: 600; transition: all 0.2s;"
                        onmouseover="this.style.background='#15803d'" onmouseout="this.style.background='#16a34a'">
                        Aprobar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentFerpaId = null;
        let currentFerpaReq = null;
        const FERPA_PAGE_SIZE = 5;
        let ferpaCurrentPage = 1;

        function openFerpaModal(req) {
            currentFerpaId = req.id;
            currentFerpaReq = req;
            const content = document.getElementById('ferpaModalContent');
            const actionArea = document.getElementById('ferpaActionArea'); // Footer con botones
            const actionFields = document.getElementById('ferpaActionFields'); // Campos de nota/JSON
            const reportArea = document.getElementById('ferpaReportArea');
            const noteBlock = document.getElementById('ferpaNoteBlock');
            const corrPatchBlock = document.getElementById('ferpaCorrectionPatchBlock');
            const corrPatch = document.getElementById('ferpaCorrectedPatch');
            const note = document.getElementById('ferpaResolutionNote');
            const approveBtn = document.getElementById('ferpaApproveBtn');
            const denyBtn = document.getElementById('ferpaDenyBtn');
            const reviewBtn = document.getElementById('ferpaReviewBtn');

            // Ocultar evidencia técnica de auditoría (JSON) en la UI del modal
            const sanitizeResolutionNotes = (raw) => {
                if (!raw) return '';
                let txt = String(raw);
                // Cortar todo lo que venga desde el marcador de evidencia
                const marker = '---FERPA_CORRECTION_EVIDENCE---';
                const idx = txt.indexOf(marker);
                if (idx !== -1) {
                    txt = txt.slice(0, idx);
                }
                // Compatibilidad con versiones que incluyan END marker
                txt = txt.replace(/---END_FERPA_CORRECTION_EVIDENCE---[\s\S]*$/m, '');
                return txt.trim();
            };

            // Llenar contenido principal
            let details = req.description || 'Sin detalles proporcionados.';
            const humanNotes = sanitizeResolutionNotes(req.resolution_notes);
            let notes = humanNotes
                ? `<div style="background: #f9f9f9; padding: 12px; border-radius: 6px; margin-top: 15px;"><strong>Notas Previas:</strong><br>${humanNotes}</div>`
                : '';

            // Meta extra para correcciones: mostrar tipo de registro y referencia
            let extraMeta = '';
            if (req.request_type === 'correction') {
                let recordTypeLabel = 'N/A';
                if (req.record_type) {
                    const map = {
                        children: 'Perfil de estudiante',
                        posts: 'Registro de actividades',
                        checkins: 'Registro de asistencia (Check-in)',
                        checkouts: 'Registro de asistencia (Check-out)'
                    };
                    recordTypeLabel = map[req.record_type] || req.record_type;
                }
                extraMeta = `
                    <div><strong>Tipo de Registro:</strong> ${recordTypeLabel}</div>
                    <div><strong>Referencia:</strong> <code style="background:#f5f5f5; padding:2px 6px; border-radius:4px;">${req.record_ref || '-'}</code></div>
                `;
            }

            // Mapeo de tipo y estado para mostrar etiquetas legibles
            const typeLabel = req.request_type === 'access' ? 'Acceso a registros' : 'Corrección de datos';
            const statusMap = {
                received: 'Recibida',
                under_review: 'En revisión',
                approved: 'Aprobada',
                completed: 'Completada',
                denied: 'Rechazada'
            };
            const statusLabel = statusMap[req.status] || req.status;

            content.innerHTML = `
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px;">
                    <div><strong>Tipo:</strong> ${typeLabel}</div>
                    <div><strong>Estado:</strong> <span style="background: ${req.status === 'denied' ? '#fdecea' : req.status === 'approved' || req.status === 'completed' ? '#e8f5e9' : '#fff3e0'}; padding: 3px 8px; border-radius: 4px; font-size: 0.9em;">${statusLabel}</span></div>
                    <div><strong>Padre:</strong> ${
                        req.requester_details
                            ? [req.requester_details.name || '', req.requester_details.lastname || ''].join(' ').trim()
                            : (req.requester_email || 'N/A')
                    }</div>
                    <div><strong>Estudiante:</strong> ${
                        req.child_details
                            ? [req.child_details.name || '', req.child_details.lastname || ''].join(' ').trim()
                            : 'N/A'
                    }</div>
                    ${extraMeta}
                </div>
                <div>
                    <strong>Detalle de Solicitud:</strong>
                    <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-top: 8px; border-left: 3px solid #0CB5C3;">${details}</div>
                </div>
                ${notes}
            `;

            // Reset de campos
            note.value = '';
            if (corrPatch) corrPatch.value = '';
            const corrBefore = document.getElementById('ferpaCorrectionBefore');
            const corrAfter = document.getElementById('ferpaCorrectionAfter');
            if (corrBefore) corrBefore.value = '';
            if (corrAfter) corrAfter.value = '';

            // Configuración según tipo de solicitud
            if (req.request_type === 'access') {
                // Botones para acceso
                approveBtn.textContent = 'Completar';
                reviewBtn.textContent = 'En Revisión';

                // Para acceso: no mostramos campos de nota/JSON
                if (actionFields) actionFields.style.display = 'none';
                noteBlock.style.display = 'none';
                if (corrPatchBlock) corrPatchBlock.style.display = 'none';

                if (req.status === 'received') {
                    // Etapa inicial: solo Rechazar o pasar a Revisión
                    actionArea.style.display = 'block';
                    denyBtn.style.display = 'inline-block';
                    reviewBtn.style.display = 'inline-block';
                    approveBtn.style.display = 'none';
                    reportArea.style.display = 'none';
                } else if (req.status === 'under_review') {
                    // Etapa de revisión: solo Rechazar + Enviar Informes
                    actionArea.style.display = 'block';
                    denyBtn.style.display = 'inline-block';
                    reviewBtn.style.display = 'none';
                    approveBtn.style.display = 'none';

                    // Mostrar área de reportes
                    reportArea.style.display = 'block';

                    // Inicializar checkboxes
                    document.getElementById('ferpaRepNinos').checked = true;
                    document.getElementById('ferpaRepActividades').checked = true;
                    document.getElementById('ferpaRepAsistencia').checked = true;
                    document.getElementById('ferpaRepAsistentes').checked = false;

                    // Prefijar fechas con último mes
                    const today = new Date();
                    const toStr = today.toISOString().slice(0, 10);
                    const fromDate = new Date();
                    fromDate.setMonth(fromDate.getMonth() - 1);
                    const fromStr = fromDate.toISOString().slice(0, 10);
                    document.getElementById('ferpaFrom').value = fromStr;
                    document.getElementById('ferpaTo').value = toStr;
                } else {
                    // Otros estados: solo lectura
                    actionArea.style.display = 'none';
                    reportArea.style.display = 'none';
                }
            } else {
                // Para solicitudes de corrección
                reportArea.style.display = 'none';
                approveBtn.textContent = 'Aprobar Corrección';
                reviewBtn.textContent = 'En Revisión';

                // Flujo en dos etapas (igual que acceso):
                //  - received      -> solo Rechazar / En Revisión (sin capturar corrección todavía)
                //  - under_review  -> Rechazar / Aprobar Corrección (aquí se describe Antes / Después)
                //  - approved/denied/completed -> solo lectura

                if (req.status === 'received') {
                    // Etapa inicial: solo Rechazar o pasar a Revisión
                    actionArea.style.display = 'block';
                    denyBtn.style.display = 'inline-block';
                    reviewBtn.style.display = 'inline-block';
                    approveBtn.style.display = 'none';

                    // Aún no pedimos descripción de corrección
                    noteBlock.style.display = 'none';
                    if (actionFields) actionFields.style.display = 'none';
                    if (corrPatchBlock) corrPatchBlock.style.display = 'none';
                } else if (req.status === 'under_review') {
                    // Etapa de revisión: Rechazar o Aprobar corrección, con campos visibles
                    actionArea.style.display = 'block';
                    denyBtn.style.display = 'inline-block';
                    reviewBtn.style.display = 'none';
                    approveBtn.style.display = 'inline-block';

                    if (actionFields) actionFields.style.display = 'block';
                    noteBlock.style.display = 'block';
                    if (corrPatchBlock) corrPatchBlock.style.display = 'block';
                } else {
                    // Estado final: ocultar botones y campos de edición
                    actionArea.style.display = 'none';
                    if (actionFields) actionFields.style.display = 'none';
                }
            }

            document.getElementById('ferpaModal').style.display = 'flex';
        }

        function closeFerpaModal() {
            document.getElementById('ferpaModal').style.display = 'none';
        }

        // ----- Paginación tabla FERPA -----
        function applyFerpaPagination() {
            const rows = Array.from(document.querySelectorAll('.ferpa-row'));
            const pagContainer = document.getElementById('ferpaPagination');
            if (!rows.length || !pagContainer) {
                if (pagContainer) {
                    pagContainer.style.display = 'none';
                    pagContainer.innerHTML = '';
                }
                return;
            }

            const totalPages = Math.max(1, Math.ceil(rows.length / FERPA_PAGE_SIZE));
            if (ferpaCurrentPage > totalPages) ferpaCurrentPage = totalPages;
            if (ferpaCurrentPage < 1) ferpaCurrentPage = 1;

            rows.forEach((row, idx) => {
                const start = (ferpaCurrentPage - 1) * FERPA_PAGE_SIZE;
                const end = ferpaCurrentPage * FERPA_PAGE_SIZE;
                row.style.display = (idx >= start && idx < end) ? '' : 'none';
            });

            // Renderizar controles
            if (totalPages <= 1) {
                pagContainer.style.display = 'none';
                pagContainer.innerHTML = '';
                return;
            }
            pagContainer.style.display = 'flex';

            let html = '';
            const disabledPrev = ferpaCurrentPage === 1 ? 'opacity:0.5; cursor:default;' : '';
            const disabledNext = ferpaCurrentPage === totalPages ? 'opacity:0.5; cursor:default;' : '';
            html += `<button type="button" onclick="changeFerpaPage(${ferpaCurrentPage - 1})" style="border:1px solid #e5e7eb; background:#fff; padding:4px 10px; border-radius:6px; ${disabledPrev}">Anterior</button>`;
            html += `<span style="min-width:110px; text-align:center;">Página ${ferpaCurrentPage} de ${totalPages}</span>`;
            html += `<button type="button" onclick="changeFerpaPage(${ferpaCurrentPage + 1})" style="border:1px solid #e5e7eb; background:#fff; padding:4px 10px; border-radius:6px; ${disabledNext}">Siguiente</button>`;
            pagContainer.innerHTML = html;
        }

        function changeFerpaPage(page) {
            ferpaCurrentPage = page;
            applyFerpaPagination();
        }

        async function sendFerpaReports() {
            if (!currentFerpaId || !currentFerpaReq) return;

            const from = document.getElementById('ferpaFrom').value;
            const to = document.getElementById('ferpaTo').value;
            const ninos = document.getElementById('ferpaRepNinos').checked;
            const actividades = document.getElementById('ferpaRepActividades').checked;
            const asistencia = document.getElementById('ferpaRepAsistencia').checked;
            const asistentes = document.getElementById('ferpaRepAsistentes').checked;
            const statusLabel = document.getElementById('ferpaReportStatus');

            if (!from || !to) {
                alert('Por favor selecciona el rango de fechas.');
                return;
            }

            if (!ninos && !actividades && !asistencia && !asistentes) {
                alert('Debes seleccionar al menos un tipo de informe.');
                return;
            }

            if (!confirm('Se enviará un enlace de informes al padre. ¿Continuar?')) return;

            const formData = new FormData();
            formData.append('id', currentFerpaId);
            formData.append('from', from);
            formData.append('to', to);
            formData.append('ninos', ninos ? '1' : '0');
            formData.append('actividades', actividades ? '1' : '0');
            formData.append('asistencia', asistencia ? '1' : '0');
            formData.append('asistentes', asistentes ? '1' : '0');

            statusLabel.style.display = 'block';
            statusLabel.style.color = '#666';
            statusLabel.textContent = 'Enviando informes al padre...';

            try {
                const res = await fetch('set/privacy/send_ferpa_reports.php', {
                    method: 'POST',
                    body: formData
                });
                const data = await res.json();

                if (data.success) {
                    statusLabel.style.color = '#2e7d32';
                    statusLabel.textContent = data.message || 'Informes enviados correctamente.';
                    // Opcional: recargar para actualizar estado en tabla
                    setTimeout(() => location.reload(), 1500);
                } else {
                    statusLabel.style.color = '#c62828';
                    statusLabel.textContent = data.message || 'Error al enviar los informes.';
                }
            } catch (e) {
                statusLabel.style.color = '#c62828';
                statusLabel.textContent = 'Error de conexión al enviar los informes.';
            }
        }

        async function updateFerpa(status) {
            if (!currentFerpaId) return;
            const actionFields = document.getElementById('ferpaActionFields');
            const noteElem = document.getElementById('ferpaResolutionNote');
            const note = noteElem ? noteElem.value : '';

            const isCorrection = currentFerpaReq && currentFerpaReq.request_type === 'correction';
            const corrBeforeElem = document.getElementById('ferpaCorrectionBefore');
            const corrAfterElem = document.getElementById('ferpaCorrectionAfter');
            const corrBefore = corrBeforeElem ? corrBeforeElem.value : '';
            const corrAfter = corrAfterElem ? corrAfterElem.value : '';

            // Solo exigir nota si los campos de acción están visibles (correcciones)
            const noteRequired = actionFields && actionFields.style.display !== 'none';
            if (noteRequired && (status === 'denied' || status === 'approved') && !note.trim()) {
                alert('Por favor agrega una nota de resolución para explicar la decisión al padre.');
                return;
            }

            // Para correcciones aprobadas, exigir descripción de antes/después
            if (isCorrection && status === 'approved' && !corrAfter.trim()) {
                alert('Por favor describe cómo quedó la información corregida (campo \"Después\").');
                return;
            }

            // Mensaje de confirmación más claro según la acción
            let actionText = '';
            if (status === 'denied') {
                actionText = 'rechazar esta solicitud';
            } else if (status === 'approved') {
                actionText = 'aprobar esta solicitud y registrar la corrección';
            } else if (status === 'under_review') {
                actionText = 'marcar esta solicitud como EN REVISIÓN';
            }
            if (actionText && !confirm('¿Estás seguro de ' + actionText + '?')) return;

            const formData = new FormData();
            formData.append('id', currentFerpaId);
            formData.append('reply_message', note);

            // Correcciones: solo la aprobación usa endpoint especial con evidencia; 
            // recibir/under_review/denied usan el endpoint genérico de estado.
            const needsApply = isCorrection && status === 'approved';
            const url = needsApply ? 'set/privacy/apply_ferpa_correction.php' : 'set/privacy/update_ferpa_status.php';

            if (needsApply) {
                formData.append('action', status === 'approved' ? 'approve' : 'deny');
                if (status === 'approved') {
                    formData.append('correction_before', corrBefore);
                    formData.append('correction_after', corrAfter);
                }
            } else {
                formData.append('status', status);
            }

            try {
                const res = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                const data = await res.json();

                if (data.success) {
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            } catch (e) {
                alert('Error de conexión');
            }
        }
        // Inicializar paginación FERPA al cargar
        document.addEventListener('DOMContentLoaded', applyFerpaPagination);
    </script>
    <?php include "includes/footer.php" ?>