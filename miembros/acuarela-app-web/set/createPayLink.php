<?php 
session_start();
include "../includes/sdk.php";

// Check if the POST data is set
if (!isset($_POST["name"])) {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "Missing required parameters: name or type"]);
    exit;
}

// Include error handling for debug purposes
try {
    $a = new Acuarela();
    // Prepare the data
    $data = [
        "name" => $_POST["name"], 
        "type_category" => $_POST["type"],
        "amount" => (float) $_POST["amount"],
        "date" => $_POST["date"],
        "name" => $_POST["name"],
        "status" => true,
        "type" => 2,
        "daycare" => $a->daycareID,
        "extra_info" => "",
        "payer_name" => $_POST["payer_name"],
        "payer" => $_POST["payer_name"]
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
