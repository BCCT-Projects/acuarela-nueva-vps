<?php
if (!isset($_SESSION["user"])) return;

$usuario = $_SESSION["user"];
$correo = $usuario->email ?? '';
$id = $usuario->id ?? null;

function tieneSuscripcionActiva($usuario): bool {
    if (empty($usuario->suscriptions)) return false;

    $hoy = date("Y-m-d");

    foreach ($usuario->suscriptions as $suscripcion) {
        if (
            !empty($suscripcion->suscription_expiration) &&
            !$suscripcion->cancel &&
            $suscripcion->suscription_expiration >= $hoy
        ) {
            return true;
        }
    }

    return false;
}

$tieneDominioPermitido = strpos($correo, '@bilingualchildcaretraining.com') !== false;
$tieneSuscripcion = tieneSuscripcionActiva($usuario);

if ($tieneDominioPermitido || $tieneSuscripcion) {
    echo '
        <a href="/miembros/id-card?id=' . $id . '" class="btn" target="_blank">
            <i class="acuarela acuarela-Nivel_educativo" style="font-size: 16px;"></i> Mi ID Card
        </a>
    ';
}
?>