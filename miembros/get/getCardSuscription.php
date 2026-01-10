<?php
include '../includes/config.php';

function getServiceName($serviceId) {
    if (!$serviceId) return null;
    global $a; // viene de config.php
    try {
        $service = $a->getService($serviceId); // ya llama a Strapi
        return $service->name ?? null;
    } catch (Throwable $e) {
        return null;
    }
}