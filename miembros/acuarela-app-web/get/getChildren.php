<?php
//Este archivo nos da la info de los usuarios  y los posts realizados en sus daycares
session_start();
include "../includes/sdk.php";
$a = new Acuarela();

$result = $a->getChildren(isset($_GET['id']) ? $_GET['id'] : "");

// Descifrar datos sensibles de los niños
if (isset($result->response) && is_array($result->response)) {
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
        $child->coppa_status = null;

        if (isset($child->id)) {
            $childId = $child->id;
            // SLOW BUT SAFE: Individual query to prevent 500 error from massive URL
            try {
                $consents = $a->queryStrapi("parental-consents?child_id=$childId&_sort=createdAt:desc&_limit=1");
                if (is_array($consents) && count($consents) > 0) {
                    // Kid has an explicit consent record - use its status
                    $child->coppa_status = $consents[0]->consent_status ?? 'pending';
                }
            } catch (Exception $e) {
                // Silent failure
            }
        }
    }
    unset($child); // Break reference safely
}


echo json_encode($result);