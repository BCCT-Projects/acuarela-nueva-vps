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

// PERFORMANCE FIX: Get ALL consents for this daycare in ONE query
// Instead of N queries (one per inscription), we do 1 query and match locally
$allConsents = [];
try {
    $consentsResult = $a->queryStrapi("parental-consents?daycare=" . $a->daycareID . "&_sort=createdAt:desc");
    if (is_array($consentsResult)) {
        foreach ($consentsResult as $consent) {
            $childId = $consent->child_id ?? null;
            if ($childId && !isset($allConsents[$childId])) {
                $allConsents[$childId] = $consent->consent_status ?? 'pending';
            }
        }
    }
} catch (Exception $e) {
    error_log("Error fetching consents: " . $e->getMessage());
}

// Enriquecer con estado de consentimiento COPPA
if (is_array($posts)) {
    foreach ($posts as &$post) {
        // GRANDFATHER CLAUSE: Default to null (legacy kid, pre-COPPA)
        $post->coppa_status = null;

        // Intentar obtener child ID
        $childId = null;
        if (isset($post->child) && is_object($post->child)) {
            $childId = $post->child->id;
        } elseif (isset($post->child) && is_string($post->child)) {
            $childId = $post->child;
        }

        if ($childId) {
            // O(1) lookup from our pre-fetched index
            if (isset($allConsents[$childId])) {
                $post->coppa_status = $allConsents[$childId];
            }
        }
    }
}

echo json_encode($posts);