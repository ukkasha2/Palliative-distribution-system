<?php
include "../includes/connection.php";

// Check if beneficiary ID is provided
if (!isset($_GET['beneficiary_id'])) {
    $response = array('error' => true, 'message' => 'Beneficiary ID is missing');
    echo json_encode($response);
    exit;
}

$beneficiaryId = $_GET['beneficiary_id'];

$sql = "UPDATE tbl_beneficiaries SET status = 'Benefited' WHERE user_id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $beneficiaryId);

$response = array();

if ($stmt->execute()) {
    $response['error'] = false;
    $response['message'] = 'Beneficiary marked as benefited successfully';
} else {
    $response['error'] = true;
    $response['message'] = 'Failed to mark beneficiary as benefited';
}

echo json_encode($response);
?>
