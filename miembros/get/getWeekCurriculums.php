<?php
function getCurrentWeekNumber() {
    // Obtiene el número de la semana actual
    $weekNumber = date("W");
    return $weekNumber;
}

// Datos de ejemplo
$data = [
    [
        "curriculum" => "Intermedio",
        "id_curriculum" => 194,
        "lang" => "es",
        "semana" => getCurrentWeekNumber()
    ],
    [
        "curriculum" => "Intermedio",
        "id_curriculum" => 194,
        "lang" => "en",
        "semana" => getCurrentWeekNumber()
    ],
    [
        "curriculum" => "Basico",
        "id_curriculum" => 79,
        "lang" => "es",
        "semana" => getCurrentWeekNumber()
    ],
    [
        "curriculum" => "Basico",
        "id_curriculum" => 79,
        "lang" => "en",
        "semana" => getCurrentWeekNumber()
    ],
    [
        "curriculum" => "Infantes",
        "id_curriculum" => 647,
        "lang" => "es",
        "semana" => getCurrentWeekNumber()
    ],
    [
        "curriculum" => "Infantes",
        "id_curriculum" => 647,
        "lang" => "en",
        "semana" => getCurrentWeekNumber()
    ],
    [
        "curriculum" => "Homeschooling",
        "id_curriculum" => 5828,
        "lang" => "es",
        "semana" => getCurrentWeekNumber()
    ],
    [
        "curriculum" => "Homeschooling",
        "id_curriculum" => 5828,
        "lang" => "en",
        "semana" => getCurrentWeekNumber()
    ],
    [
        "curriculum" => "3K",
        "id_curriculum" => 195,
        "lang" => "es",
        "semana" => getCurrentWeekNumber()
    ],
    [
        "curriculum" => "3K",
        "id_curriculum" => 195,
        "lang" => "en",
        "semana" => getCurrentWeekNumber()
    ],
    [
        "curriculum" => "Verano",
        "id_curriculum" => 96224,
        "lang" => "es",
        "semana" => getCurrentWeekNumber()
    ],
    [
        "curriculum" => "Verano",
        "id_curriculum" => 96224,
        "lang" => "en",
        "semana" => getCurrentWeekNumber()
    ]
];

// Establece el encabezado de contenido a JSON
header('Content-Type: application/json');

// Imprime el JSON
echo json_encode($data);
?>
