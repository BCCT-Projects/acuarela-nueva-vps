<?php 
session_start();
include "../includes/sdk.php";

$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
$type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_SPECIAL_CHARS);
$amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);
$date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_SPECIAL_CHARS);
$payer_name = filter_input(INPUT_POST, 'payer_name', FILTER_SANITIZE_SPECIAL_CHARS);

// Check if the POST data is set
if (!$name || !$type || !$amount || !$date || !$payer_name) {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "Missing required parameters: name, type, amount, date, payer_name"]);
    exit;
}

// Include error handling for debug purposes
try {
    $a = new Acuarela();
    // Prepare the data
    $data = [
        "name" => $name, 
        "type_category" => $type,
        "amount" => $amount,
        "date" => $date,
        "status" => true,
        "type" => 2,
        "daycare" => $a->daycareID,
        "extra_info" => "",
        "payer_name" => $payer_name,
        "payer" => $payer_name
    ];

    // Call the method to set categories
    $movements = $a->setMovements($data);

    // Return the response as JSON
    echo json_encode($movements);

} catch (Exception $e) {
    // Log the error and return a generic error message
    error_log("Error in setMovements: " . $e->getMessage());
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "An unexpected error occurred. Please try again later."]);
}
?>
