<?php 
session_start();
include "../includes/sdk.php";
$a = new Acuarela();

// Explicit inputs
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
$acuarelauser = filter_input(INPUT_POST, 'acuarelauser', FILTER_SANITIZE_SPECIAL_CHARS);
$age_range = filter_input(INPUT_POST, 'edades', FILTER_SANITIZE_SPECIAL_CHARS);
$shift = filter_input(INPUT_POST, 'shift', FILTER_SANITIZE_SPECIAL_CHARS);

if (!$name || !$acuarelauser) {
    echo json_encode(['error' => 'Missing required fields (name, acuarelauser)']);
    exit;
}

// Inicializar el array de children
$children = [];

// Recorrer $_POST para encontrar los checkboxes activados
// The goal is to avoid iterating blindly over $_POST. 
// However, if the frontend sends dynamic keys (child IDs), we might have to.
// A better approach would be to send 'children' as an array, but we are fixing backend only without breaking frontend if possible.
// If the frontend sends <input name="ID" value="on">, then we have to iterate.
// To be safe, we iterate $_POST but validate keys.

foreach ($_POST as $key => $value) {
    if ($value === 'on') {
        // Validation: key should be alphanumeric, likely MongoDB ID (hex)
        // MongoDB IDs are 24 hex chars.
        if (preg_match('/^[a-fA-F0-9]{24}$/', $key)) {
             $children[] = $key;
        }
    }
}

$data = [
    'name'=> $name,
    'acuarelauser'=> $acuarelauser,
    'age_range'=> $age_range,
    'shift'=> $shift,
    'children' => $children,
];
$grupo = $a->createGroup($data);
echo json_encode($grupo);
?>
