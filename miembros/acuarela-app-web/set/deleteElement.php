<?php 
    session_start();
    include "../includes/sdk.php";
    $a = new Acuarela();
    
    // Explicit inputs
    $type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_SPECIAL_CHARS);
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);

    if (!$type || !$id) {
        echo json_encode(['error' => 'Invalid or missing parameters']);
        exit;
    }

    $posts = $a->deleteElement($type, $id);
    if ($a->daycareID && in_array($type, ['children', 'inscripciones'], true)) {
        $a->invalidateStrapiCache("children/?daycare=" . $a->daycareID);
        $a->invalidateStrapiCache("inscripciones?daycare=" . $a->daycareID);
    }
    echo json_encode($posts);
?>
