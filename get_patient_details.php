<?php
require 'db.php';

// Check if patient_id is passed
if (isset($_GET['patient_id'])) {
    $patient_id = $_GET['patient_id'];

    // Fetch patient details from the database
    $stmt = $pdo->prepare("SELECT * FROM patients WHERE patient_id = ?");
    $stmt->execute([$patient_id]);
    $patient = $stmt->fetch();

    if ($patient) {
        // Return patient data as JSON
        echo json_encode($patient);
    } else {
        echo json_encode(["error" => "Patient not found"]);
    }
} else {
    echo json_encode(["error" => "No patient ID provided"]);
}
