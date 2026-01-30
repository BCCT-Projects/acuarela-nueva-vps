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
    }
    unset($child);

    // Enriquecer con estado COPPA (una sola petición para todos los niños)
    $childIds = [];
    foreach ($result->response as $c) {
        if (isset($c->id)) {
            $childIds[] = $c->id;
        }
    }
    $coppaMap = $a->getLatestParentalConsentsForChildIds($childIds);
    foreach ($result->response as &$child) {
        $child->coppa_status = null;
        if (isset($child->id)) {
            $child->coppa_status = $coppaMap[(string)$child->id] ?? null;
        }
    }
    unset($child);
}


echo json_encode($result);