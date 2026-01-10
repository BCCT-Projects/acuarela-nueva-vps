<?php 
session_start();
include "../includes/sdk.php";
$a = new Acuarela();
// Reestructurar los datos

// Inicializar el array de children
$children = [];

// Recorrer $_POST para encontrar los checkboxes activados
foreach ($_POST as $key => $value) {
    if ($value === 'on') {
        // Si el valor es "on" y la clave parece un ID de 24 caracteres (MongoDB ObjectId)
        $children[] = $key;
    }
}

$data = [
    'name'=> $_POST['name'],
    'acuarelauser'=> $_POST['acuarelauser'],
    'age_range'=> $_POST['edades'],
    'shift'=> $_POST['shift'],
    'children' => $children,
];
$grupo = $a->editGroup($_POST['id'], $data);
echo json_encode($grupo);
?>