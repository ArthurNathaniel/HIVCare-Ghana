<?php
// db.php - Connect to the database
require 'db.php';
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

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
        echo "<script>alert('Patient data recorded successfully!');</script>";
    } else {
        echo "<script>alert('Error recording patient data!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Patient Data</title>
    <?php include 'cdn.php' ?>
    <link rel="stylesheet" href="./css/base.css">
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
<?php include 'navbar.php' ?>
    <div class="form-container">
        <h1>Record Patient Data</h1>
        <form action="record_patient.php" method="POST">
          <div class="forms">
          <input type="text" id="patient_id" name="patient_id" placeholder="Patient ID" readonly>
          </div>
          <div class="forms">
            <input type="text" name="name" placeholder="Full Name" required>
            </div>
            <div class="forms">
            <input type="date" name="date_of_birth" placeholder="Date of Birth" required>
            </div>
            <div class="forms">
            <select name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
            </div>
            <div class="forms">
            <input type="text" name="contact_number" placeholder="Contact Number">
            </div>
            <div class="forms">
            <input type="date" name="diagnosis_date" placeholder="Diagnosis Date" required>
            </div>
            <div class="forms">
            <select name="treatment_status" required>
                <option value="On Treatment">On Treatment</option>
                <option value="Awaiting Treatment">Awaiting Treatment</option>
                <option value="Not On Treatment">Not On Treatment</option>
            </select>
            </div>
            <div class="forms">
            <button type="submit">Record Data</button>
            </div>
       
        </form>
    </div>
</body>
</html>
