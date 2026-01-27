<?php
//Este archivo nos da la info de los usuarios  y los posts realizados en sus daycares
session_start();
include "../includes/sdk.php";
$a = new Acuarela();

$result = $a->getChildren(isset($_GET['id']) ? $_GET['id'] : "");

// Descifrar datos sensibles de los niños
if (isset($result->response) && is_array($result->response)) {

    // PERFORMANCE FIX: Get ALL consents for this daycare in ONE query
    // Instead of N queries (one per child), we do 1 query and match locally
    $allConsents = [];
    try {
        // Get all parental consents, sorted by createdAt desc
        $consentsResult = $a->queryStrapi("parental-consents?daycare=" . $a->daycareID . "&_sort=createdAt:desc");
        if (is_array($consentsResult)) {
            // Index by child_id for O(1) lookup
            foreach ($consentsResult as $consent) {
                $childId = $consent->child_id ?? null;
                if ($childId && !isset($allConsents[$childId])) {
                    // Only keep the most recent consent per child (first one due to sort)
                    $allConsents[$childId] = $consent->consent_status ?? 'pending';
                }
            }
        }
    } catch (Exception $e) {
        error_log("Error fetching consents: " . $e->getMessage());
    }

    foreach ($result->response as &$child) {
        // Descifrar datos del niño
        $child = $a->decryptChildData($child);

        // Descifrar datos de salud si existen
        if (isset($child->healthinfo)) {
            $child->healthinfo = $a->decryptHealthData($child->healthinfo);
        }

        // Descifrar datos de padres si existen
        if (isset($child->acuarelausers) && is_array($child->acuarelausers)) {
            foreach ($child->acuarelausers as &$parent) {
                $parent = $a->decryptParentData($parent);
            }
        }

        // Enriquecer con estado COPPA
        // GRANDFATHER CLAUSE: Default to null (legacy kid, pre-COPPA)
        // null = implicitly approved (kid existed before COPPA implementation)
        $child->coppa_status = null;

        if (isset($child->id)) {
            // O(1) lookup from our pre-fetched index
            if (isset($allConsents[$child->id])) {
                $child->coppa_status = $allConsents[$child->id];
            }
        }
    }
}


echo json_encode($result);