<?php
include '../includes/config.php';
header('Content-Type: application/json');
echo json_encode($a->getAgeGroups());
