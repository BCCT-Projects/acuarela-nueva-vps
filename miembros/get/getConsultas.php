<?php

// Verificar si la cookie "conversation_state" está presente y si hay sesión activa
if ((isset($_COOKIE["conversation_state"]) || !isset($_COOKIE["conversation_state"])) && isset($_SESSION["userLogged"])) {
    // Hacer la consulta
    $idUser = $_SESSION["user"]->id;

    $data = $a->queryStrapi('threads-open-ais?bilingual_user=' . $idUser);
    // Decodificar el JSON
    //$data = json_decode($response, true);

    // Inicializar un contador para los id_threads
    $idThreadsCount = 0;

    // Iterar sobre los datos recibidos
    foreach ($data as $thread) {
        // Obtener id_thread y fecha de creación
        $idThread = $thread->id_thread;
        $createdAt = $thread->createdAt;
        $estado = ucwords(str_replace('_', ' ', $thread->estado_seleccionado)); // Convertir guiones bajos a espacios y aplicar ucwords para capitalizar cada palabra
        $tipo = ucwords(str_replace('_', ' ', $thread->tipo_daycare_seleccionado)); // Convertir guiones bajos a espacios y aplicar ucwords para capitalizar cada palabra

        // Formatear la fecha (solo día/mes/año)
        $formattedDate = date('d/m/Y', strtotime($createdAt));

        // Crear el botón con el id_thread como atributo
        echo '<button class="thread-button" btn-thread-id="' . $idThread . '">Conversación creada: ' . $formattedDate . ' - Estado: ' . $estado . ' - Tipo: ' . $tipo . '<i class="acuarela acuarela-Eliminar"></i></button>' . PHP_EOL;

        // Incrementar el contador de id_threads
        $idThreadsCount++;
    }

    // Mostrar el número total de id_threads
    //echo 'Número total de id_threads: ' . $idThreadsCount . PHP_EOL;
} else {
    // No hacer la consulta
    echo '<div class="message-container">';
    echo '<p class="message">¡Hola! Crea una cuenta para acceder y guardar tus consultas con LunAI. <a href="/miembros/crear-cuenta"  target="_blank" style="text-decoration: underline; color: #140a4c;"> Regístrate ahora.</a></p>';
    echo '</div>';
}