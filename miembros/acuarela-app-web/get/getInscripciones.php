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
    // CRITICAL FIX: Unset reference to avoid corruption in subsequent loops
    unset($post);
}

// Debugging (temporal)
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

// Enriquecer con estado de consentimiento COPPA (una sola petición)
if (is_array($posts)) {
    $childIds = [];
    foreach ($posts as $post) {
        $childId = null;
        if (isset($post->child) && is_object($post->child)) {
            $childId = $post->child->id ?? null;
        } elseif (isset($post->child) && !is_object($post->child)) {
            $childId = $post->child;
        }
        if ($childId) {
            $childIds[] = $childId;
        }
    }
    $coppaMap = $a->getLatestParentalConsentsForChildIds($childIds);
    foreach ($posts as $key => $val) {
        $posts[$key]->coppa_status = null;
        $childId = null;
        if (isset($val->child) && is_object($val->child)) {
            $childId = $val->child->id ?? null;
        } elseif (isset($val->child) && !is_object($val->child)) {
            $childId = $val->child;
        }
        if ($childId !== null) {
            $posts[$key]->coppa_status = $coppaMap[(string)$childId] ?? null;
        }
    }
}

echo json_encode($posts);