<?php 
session_start();
include "../includes/sdk.php";
$a = new Acuarela();

// Explicit inputs
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
$acuarelauser = filter_input(INPUT_POST, 'acuarelauser', FILTER_SANITIZE_SPECIAL_CHARS);
$age_range = filter_input(INPUT_POST, 'edades', FILTER_SANITIZE_SPECIAL_CHARS);
$shift = filter_input(INPUT_POST, 'shift', FILTER_SANITIZE_SPECIAL_CHARS);

if (!$id || !$name || !$acuarelauser) {
    echo json_encode(['error' => 'Missing required fields (id, name, acuarelauser)']);
    exit;
}

// Inicializar el array de children
$children = [];

// Recorrer $_POST para encontrar los checkboxes activados
foreach ($_POST as $key => $value) {
    if ($value === 'on') {
        // Validation: key should be alphanumeric, likely MongoDB ID (hex)
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
$grupo = $a->editGroup($id, $data);
echo json_encode($grupo);
?>
