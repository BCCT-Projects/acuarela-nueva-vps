<?php 
session_start();
include "../includes/sdk.php";

$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
$type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_SPECIAL_CHARS);

// Check if the POST data is set
if (!$name || !$type) {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "Missing required parameters: name or type"]);
    exit;
}

// Include error handling for debug purposes
try {
    $a = new Acuarela();
    
    // Prepare the data
    $data = [
        "name" => $name, 
        "type_category" => $type
    ];

    // Call the method to set categories
    $category = $a->setCategories($data);

    // Return the response as JSON
    echo json_encode($category);

} catch (Exception $e) {
    // Log the error and return a generic error message
    error_log("Error in setCategories: " . $e->getMessage());
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "An unexpected error occurred. Please try again later."]);
}
?>
