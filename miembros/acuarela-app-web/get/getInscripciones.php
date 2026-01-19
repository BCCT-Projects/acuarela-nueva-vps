<?php
//Este archivo nos da la info de los usuarios  y los posts realizados en sus daycares
session_start();
include "../includes/sdk.php";
$a = new Acuarela();
$posts = $a->getInscripciones("", $a->daycareID);

// Descifrar datos sensibles de niños en inscripciones
if (is_array($posts)) {
    foreach ($posts as &$post) {
        // Descifrar datos del niño
        $post = $a->decryptChildData($post);

        // Si hay un objeto child, descifrarlo también
        if (isset($post->child) && is_object($post->child)) {
            $post->child = $a->decryptChildData($post->child);
        }
    }
}

// Enriquecer con estado de consentimiento COPPA
if (is_array($posts)) {
    foreach ($posts as &$post) {
        $post->coppa_status = 'N/A'; // Default

        // Intentar obtener child ID
        // La estructura puede variar, a veces es 'child' objeto, a veces 'kid', a veces solo ID dentro de post
        $childId = null;
        if (isset($post->child) && is_object($post->child)) {
            $childId = $post->child->id;
        } elseif (isset($post->child) && is_string($post->child)) {
            $childId = $post->child;
        }

        if ($childId) {
            // Buscar consentimiento para este niño
            // Ordenar por createdAt desc para obtener el más reciente
            $consents = $a->queryStrapi("parental-consents?child_id=$childId&_sort=createdAt:desc&_limit=1");

            if (is_array($consents) && count($consents) > 0) {
                $post->coppa_status = $consents[0]->consent_status ?? 'pending';
            }
        }
    }
}

echo json_encode($posts);