<?php
include '../includes/config.php';

echo json_encode($a->getDomain($_GET["id"]));
