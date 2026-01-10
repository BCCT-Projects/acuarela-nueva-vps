<?php
include '../includes/config.php';
echo json_encode($a->getMenus($_GET["age"]));
