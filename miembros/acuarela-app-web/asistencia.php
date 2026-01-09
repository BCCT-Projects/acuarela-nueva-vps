<?php $classBody = "asistencia";
include "includes/header.php"; ?>
<dialog class="dialog-container">
    <div id="dialog-code" class="dialogCode">
        <div class="dialog-header">
            <button class="back-btn"><i class="acuarela acuarela-Flecha_izquierda"></i></button>
            <h2>Ingresa el código del padre</h2>
            <button class="close-btn"><i class="acuarela acuarela-Cancelar"></i></button>
        </div>
        <div class="dialog-body">
            <p>
                Por favor, ingrese el código de seguridad del padre o tutor para
                autorizar la salida del niño.
            </p>
            <div class="code-inputs">
                <input type="number" id="input-1" maxlength="1" placeholder="0" />
                <input type="number" id="input-2" maxlength="1" placeholder="0" />
                <input type="number" id="input-3" maxlength="1" placeholder="0" />
                <input type="number" id="input-4" maxlength="1" placeholder="0" />
                <input type="number" id="input-5" maxlength="1" placeholder="0" />
                <input type="number" id="input-6" maxlength="1" placeholder="0" />
            </div>
            <div id="reminder">
                <i class="acuarela acuarela-Informacion" style="font-size: 50px; color: #00b0b9;"></i>
                <p>Recuerda informar a los padres que el código de seguridad está disponible en la aplicación
                    <strong>Acuarela for Families</strong> o en el <strong>correo</strong> que acaban de recibir.
                </p>
            </div>
            <button class="validate-btn">Validar</button>
        </div>
    </div>
    <div id="exitoCodigo" class="dialogCode">
        <div class="dialog-header">
            <button class="back-btn"><i class="acuarela acuarela-Flecha_izquierda"></i></button>
            <button class="close-btn"><i class="acuarela acuarela-Cancelar"></i></button>
        </div>
        <svg class="checkmark success" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
            <circle class="checkmark_circle_success" cx="26" cy="26" r="25" fill="none" />
            <path class="checkmark_check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" stroke-linecap="round" />
        </svg>
        <h2>Código correcto</h2>
        <p>Registro de salida exitoso</p>
    </div>
    <div id="errorCodigo" class="dialogCode">
        <div class="dialog-header">
            <button class="back-btn"><i class="acuarela acuarela-Flecha_izquierda"></i></button>
            <button class="close-btn"><i class="acuarela acuarela-Cancelar"></i></button>
        </div>
        <svg class="checkmark error" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
            <circle class="checkmark_circle_error" cx="26" cy="26" r="25" fill="none" />
            <path class="checkmark_check" stroke-linecap="round" fill="none" d="M16 16 36 36 M36 16 16 36" />
        </svg>
        <h2></h2>
        <p></p>
    </div>
</dialog>
<main>
    <?php
    $mainHeaderTitle = "Asistencia";
    $action = '<a href="/miembros/acuarela-app-web/inspeccion" class="btn btn-action-primary enfasis btn-big"><i class="acuarela acuarela-Pago"></i>Generar informe</a>';
    $videoPath = 'videos/asistencia.mp4';
    include "templates/sectionHeader.php";
    ?>
    <div class="content">
        <?php
        // Define los nombres de los meses en español
        $meses = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre'
        ];

        // Crea un objeto DateTime para la fecha deseada
        $fecha = new DateTime();
        $fecha->modify('-1 day'); // Agregar un día
        // Obtiene el día, mes y año
        $dia = $fecha->format('d');
        $mes = $meses[(int) $fecha->format('m')];
        $anio = $fecha->format('Y');

        // Forma la fecha en el formato deseado
        $fecha_formateada = "$mes $dia, $anio";
        ?>
        <h2>
            <?= $fecha_formateada ?>
        </h2>
        <div class="info">
            <i class="acuarela acuarela-Informacion"></i>
            <p>
                Hacer clic al niño y selecciona la persona que lo entrega
                o lo recoge
            </p>
        </div>
        <h3>¿Quiénes están en el daycare?</h3>
        <p class="emptyindaycare">Aún no has ingresado ningún niño a tu Daycare, realiza el primer registro del día.</p>
        <ul class="indaycare"></ul>
        <hr />
        <h3>¿Quiénes están en casa?</h3>
        <p class="emptyinhome">Todos los niños se encuentran contigo en el Daycare. No olvides registrar la salida y
            entregarlo al
            responsable
            correspondiente.</p>
        <ul class="inhome"></ul>
        <hr />
        <h3>¿Quiénes están inactivos?</h3>
        <ul class="inactive"></ul>
    </div>

</main>
<?php include "includes/footer.php" ?>