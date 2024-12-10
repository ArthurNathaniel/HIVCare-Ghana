<?php
// db.php - Connect to the database
require 'db.php';
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Check if a search term has been submitted
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Fetch patients from the database, filtered by search term if provided
if ($search) {
    $stmt = $pdo->prepare("SELECT * FROM patients WHERE patient_id LIKE ? OR name LIKE ?");
    $stmt->execute(["%$search%", "%$search%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM patients");
}

$patients = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Patients</title>
    <?php include 'cdn.php' ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/patients.css">
    <script>
        // Function to open the modal and populate it with patient details
        function openModal(patientId) {
            // Use AJAX to fetch patient details by ID
            const xhr = new XMLHttpRequest();
            xhr.open("GET", "get_patient_details.php?patient_id=" + patientId, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    const patient = JSON.parse(xhr.responseText);
                    document.getElementById("modal_patient_id").innerText = patient.patient_id;
                    document.getElementById("modal_name").innerText = patient.name;
                    document.getElementById("modal_dob").innerText = patient.date_of_birth;
                    document.getElementById("modal_gender").innerText = patient.gender;
                    document.getElementById("modal_contact").innerText = patient.contact_number;
                    document.getElementById("modal_diagnosis_date").innerText = patient.diagnosis_date;
                    document.getElementById("modal_treatment_status").innerText = patient.treatment_status;

                    // Open the modal
                    document.getElementById("patientModal").style.display = "block";
                }
            };
            xhr.send();
        }

        // Function to close the modal
        function closeModal() {
            document.getElementById("patientModal").style.display = "none";
        }
    </script>
</head>
<body>
<?php include 'navbar.php' ?>

   <div class="all_patients">
   <h1>View Patients</h1>

   <!-- Search Form -->

 <form method="GET" action="view_patients.php">
 <div class="forms">      
 <input type="text" name="search" placeholder="Search by Patient ID or Name" value="<?php echo htmlspecialchars($search); ?>" />
 </div>     
 <div class="forms">
      <button type="submit">Search</button>
      </div>
   </form>

 <br>
 <br>
 <br>
<!-- Table to display patient IDs and names -->
<table border="1">
    <thead>
        <tr>
            <th>Patient ID</th>
            <th>Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($patients) > 0): ?>
            <?php foreach ($patients as $patient): ?>
            <tr>
                <td><?php echo $patient['patient_id']; ?></td>
                <td><?php echo $patient['name']; ?></td>
                <td><button onclick="openModal('<?php echo $patient['patient_id']; ?>')">View Details</button></td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">No patients found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
   </div>

    <!-- Modal for viewing patient details -->
    <div id="patientModal" style="display: none;">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Patient Details</h2>
            <p><strong>Patient ID:</strong> <span id="modal_patient_id"></span></p>
            <p><strong>Name:</strong> <span id="modal_name"></span></p>
            <p><strong>Date of Birth:</strong> <span id="modal_dob"></span></p>
            <p><strong>Gender:</strong> <span id="modal_gender"></span></p>
            <p><strong>Contact Number:</strong> <span id="modal_contact"></span></p>
            <p><strong>Diagnosis Date:</strong> <span id="modal_diagnosis_date"></span></p>
            <p><strong>Treatment Status:</strong> <span id="modal_treatment_status"></span></p>
        </div>
    </div>
</body>
</html>
