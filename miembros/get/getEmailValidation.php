<?php
// Obtener el correo electrónico del usuario que ha iniciado sesión
$correo_usuario = $_SESSION["user"]->email;

// Verificar si el correo electrónico termina con "@bilingualchildcaretraining.com" o "@unimilitar.edu.co"
if (strpos($correo_usuario, '@bilingualchildcaretraining.com') !== false || strpos($correo_usuario, '@unimilitar.edu.co') !== false) {
    // Codificar el correo electrónico para incluirlo en la URL
    $correo_usuario_encoded = urlencode($correo_usuario);
    
    echo '
        <a href="https://zfrmz.com/AP0RTSX7XZnplg0s7jVI?email_vendedora=' . $correo_usuario_encoded . '" class="btn" target="_blank">Crear Website
            <div class="sign">+</div>
        </a>
    ';

    echo '
        <a href="https://bilingualchildcareuniversity.com/course/view.php?id=52' . $correo_usuario_encoded . '" class="btn" target="_blank">Indice Tutoriales BCCT
            <div class="sign">+</div>
        </a>
    ';
}

// Verificar si el correo electrónico es exactamente "info@bilingualchildcaretraining.com"
if ($correo_usuario === 'info@bilingualchildcaretraining.com' || $correo_usuario === 'javier@bilingualchildcaretraining.com' || $correo_usuario === 'julieramirez@bilingualchildcaretraining.com' || $correo_usuario === 'jullie@bilingualchildcaretraining.com') {
    // Muestra el segundo botón para crear un código de descuento
    echo '
        <a href="https://zfrmz.com/UbhYf27bxkCtugodefd1" class="btn" target="_blank">Agregar Daycare
            <div class="sign">+</div>
        </a>
        <a href="https://zfrmz.com/K01DIJiV3OEgFncNbjPo" class="btn" target="_blank">Crear Código de Descuento
            <div class="sign">%</div>
        </a>
    ';
}
?>