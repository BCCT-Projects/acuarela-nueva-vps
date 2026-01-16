<?php
//Este archivo nos da la info de los usuarios  y los posts realizados en sus daycares
session_start();
include "../includes/sdk.php";
$a = new Acuarela();
$result = $a->getChildren(isset($_GET['id']) ? $_GET['id'] : "");

// Enriquecer con estado COPPA
if (isset($result->response) && is_array($result->response)) {
    foreach ($result->response as &$child) {
        $child->coppa_status = 'pending'; // Default as pending is safer

        if (isset($child->id)) {
            $childId = $child->id;
            // Buscar consentimiento
            $consents = $a->queryStrapi("parental-consents?child_id=$childId&_sort=createdAt:desc&_limit=1");
            if (is_array($consents) && count($consents) > 0) {
                $child->coppa_status = $consents[0]->consent_status ?? 'pending';
            }
        }
    }
}

echo json_encode($result);