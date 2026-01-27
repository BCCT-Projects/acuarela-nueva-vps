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

// Enriquecer con estado de consentimiento COPPA
if (is_array($posts)) {
    foreach ($posts as $key => $val) {
        $post = &$posts[$key];

        // GRANDFATHER CLAUSE: Default to null (legacy kid, pre-COPPA)
        $post->coppa_status = null; // Default no status

        // Intentar obtener child ID
        $childId = null;
        // Robust check: object or integer/string ID matches
        if (isset($post->child) && is_object($post->child)) {
            $childId = $post->child->id;
        } elseif (isset($post->child) && !is_object($post->child)) {
            $childId = $post->child;
        }

        if ($childId) {
            // SLOW BUT SAFE METHOD (Temporary rollback to verify 500 fix)
            // Hacemos la consulta individual para ver si esto elimina el error 500
            try {
                $consents = $a->queryStrapi("parental-consents?child_id=$childId&_sort=createdAt:desc&_limit=1");
                if (is_array($consents) && count($consents) > 0) {
                    $post->coppa_status = $consents[0]->consent_status ?? 'pending';
                }
            } catch (Exception $e) {
                // Silent catch
            }
        }
    }
    unset($post);
}

echo json_encode($posts);