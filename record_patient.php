<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_id = $_POST['patient_id'];
    $name = $_POST['name'];
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $contact_number = $_POST['contact_number'];
    $diagnosis_date = $_POST['diagnosis_date'];
    $treatment_status = $_POST['treatment_status'];

    $stmt = $pdo->prepare("INSERT INTO patients (patient_id, name, date_of_birth, gender, contact_number, diagnosis_date, treatment_status) 
                          VALUES (?, ?, ?, ?, ?, ?, ?)");
    if ($stmt->execute([$patient_id, $name, $date_of_birth, $gender, $contact_number, $diagnosis_date, $treatment_status])) {
        echo "Patient data recorded successfully!";
    } else {
        echo "Error recording patient data!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Patient Data</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        // Function to generate a unique patient ID in the format of 8 digits and year
        function generatePatientId() {
            const randomDigits = Math.floor(10000000 + Math.random() * 90000000); // 8 random digits
            const year = new Date().getFullYear().toString().slice(-2); // Get last 2 digits of the year (e.g., "24")
            const patientId = randomDigits + '-' + year; // Combine random digits and year
            document.getElementById("patient_id").value = patientId; // Set the patient ID in the form field
        }

        // Call the function when the page loads
        window.onload = function() {
            generatePatientId();
        };
    </script>
</head>
<body>
    <div class="form-container">
        <h1>Record Patient Data</h1>
        <form action="record_patient.php" method="POST">
            <input type="text" id="patient_id" name="patient_id" placeholder="Patient ID" readonly>
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="date" name="date_of_birth" placeholder="Date of Birth" required>
            <select name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
            <input type="text" name="contact_number" placeholder="Contact Number">
            <input type="date" name="diagnosis_date" placeholder="Diagnosis Date" required>
            <select name="treatment_status" required>
                <option value="On Treatment">On Treatment</option>
                <option value="Awaiting Treatment">Awaiting Treatment</option>
                <option value="Not On Treatment">Not On Treatment</option>
            </select>
            <button type="submit">Record Data</button>
        </form>
    </div>
</body>
</html>
