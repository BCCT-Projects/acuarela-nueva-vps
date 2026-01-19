<?php
session_start();
include "../includes/sdk.php";
$a = new Acuarela();
$grupos = $a->getGrupos(isset($_GET['id']) ? $_GET['id'] : "");

// Descifrar datos de niños en los grupos
if (is_array($grupos)) {
    foreach ($grupos as &$grupo) {
        if (isset($grupo->children) && is_array($grupo->children)) {
            foreach ($grupo->children as &$child) {
                $child = $a->decryptChildData($child);
            }
        }
    }
} elseif (is_object($grupos) && isset($grupos->children)) {
    // Si es un solo grupo
    foreach ($grupos->children as &$child) {
        $child = $a->decryptChildData($child);
    }
}

echo json_encode($grupos);