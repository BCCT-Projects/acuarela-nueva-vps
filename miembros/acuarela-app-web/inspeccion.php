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
   
</main>
<?php include "includes/footer.php" ?>