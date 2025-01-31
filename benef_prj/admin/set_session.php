<?php
session_start();

// Check if parameter is received
if (isset($_POST['fingerprint_template'])) {
    // Get the parameter value
    $param_value = $_POST['fingerprint_template'];
    
    // Set the session variable
    $_SESSION['fingerprint_template'] = $param_value;
    
    // Respond with a success message
    echo json_encode(array('success' => true));
} else {
    // Respond with an error message if parameter is not received
    echo json_encode(array('success' => false, 'error' => 'Parameter not provided'));
}
?>
