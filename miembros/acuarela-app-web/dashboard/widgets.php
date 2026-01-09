<?php $classBody = "widgets";
include $_SERVER['DOCUMENT_ROOT'] . "/miembros/acuarela-app-web/includes/header.php"; ?>
<main>
    <?php
    $mainHeaderTitle = "Dashboard";
    $action = '
    <a href="/miembros/acuarela-app-web/inspeccion" class="btn btn-action-secondary enfasis btn-big">Cancelar</a>
    <a href="/miembros/acuarela-app-web/inspeccion" class="btn btn-action-primary enfasis btn-big">Agregar</a>
    ';
   include $_SERVER['DOCUMENT_ROOT'] . "/miembros/acuarela-app-web/templates/sectionHeader.php";
    ?>
    <div class="content">
        <h2>Tus widgets activos</h2>
        <div class="my-widgets">
            <canvas id="socialChart"></canvas>
            <canvas id="niñosChart"></canvas>
            <canvas id="asistenciaNiñosChart"></canvas>
            <canvas id="tareasChart"></canvas>
            <canvas id="finanzasChart"></canvas>
        </div>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('socialChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['D', 'L', 'M', 'M', 'J', 'V', 'L'],
            datasets: [
                {
                    label: 'Me gusta',
                    backgroundColor: '#42c3d3',
                    data: [12, 19, 3, 5, 2, 3, 9],
                },
                {
                    label: 'Me encanta',
                    backgroundColor: '#f66e9b',
                    data: [5, 2, 4, 3, 7, 2, 1],
                },
                {
                    label: 'Me asombra',
                    backgroundColor: '#ffc542',
                    data: [2, 3, 5, 7, 1, 6, 4],
                },
                {
                    label: 'Me enorgullece',
                    backgroundColor: '#69c86d',
                    data: [1, 1, 1, 2, 2, 2, 2],
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
                title: { display: true, text: 'Interacciones por día' }
            }
        }
    });
</script>
<script>
    const niñosCtx = document.getElementById('niñosChart');
    new Chart(niñosCtx, {
        type: 'doughnut',
        data: {
            labels: ['Niñas', 'Niños', 'Nuevos'],
            datasets: [{
                label: 'Inscritos',
                data: [20, 15, 7],
                backgroundColor: ['#fa7d91', '#66a6ff', '#84d9d2'],
                hoverOffset: 4
            }]
        },
        options: {
            plugins: {
                legend: { position: 'bottom' },
                title: { display: true, text: 'Niñxs inscritos' }
            }
        }
    });
</script>
<script>
    const asistenciaCtx = document.getElementById('asistenciaNiñosChart');
    new Chart(asistenciaCtx, {
        type: 'bar',
        data: {
            labels: ['Aún en el Daycare', 'Llegadas tarde', 'Ausentes'],
            datasets: [{
                label: 'Cantidad',
                data: [4, 3, 5],
                backgroundColor: ['#42c3d3', '#f4a261', '#c2c2c2']
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            plugins: {
                legend: { display: false },
                title: { display: true, text: 'Asistencia niñxs' }
            }
        }
    });
</script>
<script>
    const tareasCtx = document.getElementById('tareasChart');
    new Chart(tareasCtx, {
        type: 'pie',
        data: {
            labels: ['Pendientes', 'Finalizadas', 'Vencidas'],
            datasets: [{
                label: 'Tareas',
                data: [10, 15, 5],
                backgroundColor: ['#f4a261', '#2a9d8f', '#e76f51']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
                title: { display: true, text: 'Estado de tareas' }
            }
        }
    });
</script>

<script>
    const finanzasCtx = document.getElementById('finanzasChart');
    new Chart(finanzasCtx, {
        type: 'line',
        data: {
            labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
            datasets: [
                {
                    label: 'Ingresos',
                    data: [1600, 1800, 1400, 2000, 2100, 1900],
                    borderColor: '#2a9d8f',
                    backgroundColor: 'rgba(42, 157, 143, 0.1)',
                    tension: 0.3
                },
                {
                    label: 'Gastos',
                    data: [1200, 1500, 1300, 1600, 1700, 1500],
                    borderColor: '#e76f51',
                    backgroundColor: 'rgba(231, 111, 81, 0.1)',
                    tension: 0.3
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                title: { display: true, text: 'Ingresos vs Gastos' }
            }
        }
    });
</script>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php" ?>