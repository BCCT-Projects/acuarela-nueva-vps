<?php
$texts = [
  'es' => [
    'planeacion' => 'Sobre mi planeación',
    'materiales' => 'Lista de Materiales',
    'temas' => 'Temas del Mes',
    'adicional' => 'Material Básico',
    'letra_semanal'=>'Letra semanal',
    'numero_semanal'=>'Número Semanal',
    'gratis' => 'Actividades Gratis',
    'objetivo_semanal' => 'Objetivo Semanal',
    'bienvenido' => 'Bienvenido',
    'tematicas' => 'Temáticas Mensuales',
    'semana' => 'Semana',
    'evaluacion' => 'Evaluación de Proceso',
    'menu' => 'Generar Menú',
    'print_curriculum' => 'Imprimir Curriculum',
    'print_newsletter' => 'Imprimir Newsletter',
    'infantes' => 'Infantes (3-11 meses)',
    'toddlers' => 'Toddlers (1 año)',
    'two_plus' => '2+ años',
    'whatsapp' => 'Whatsapp',
    'link' => 'Link'
  ],
  'en' => [
    'planeacion' => 'About my planning',
    'materiales' => "Material's List",
    'temas' => 'Topics of the Month',
    'material' => 'Basic Material',
    'adicional' => 'Basic material',
    'letra_semanal'=>'Weekly Letter',
    'numero_semanal'=>'Weekly Number',
    'gratis' => 'Free activities',
    'objetivo_semanal' => 'Weekly Goal',
    'bienvenido' => 'Welcome',
    'tematicas' => 'Monthly Themes',
    'semana' => 'Week',
    'evaluacion' => 'Process Evaluation',
    'menu' => 'Generate Menu',
    'print_curriculum' => 'Print Curriculum',
    'print_newsletter' => 'Print Newsletter',
    'infantes' => 'Infants (3-11 months)',
    'toddlers' => 'Toddlers (1 year)',
    'two_plus' => '2+ years',
    'whatsapp' => 'Whatsapp',
    'link' => 'Link'
  ]
];

$selectedLang = $_POST['selectedLang'] ?? 'es';
$response = $texts[$selectedLang] ?? $texts['es'];

echo json_encode($response);
