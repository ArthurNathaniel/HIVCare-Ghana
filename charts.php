<?php
// db.php - Connect to the database
require 'db.php';

// Fetch the total number of patients
$total_patients_query = $pdo->query("SELECT COUNT(*) AS total_patients FROM patients");
$total_patients = $total_patients_query->fetch()['total_patients'];

// Fetch Gender Distribution (Pie Chart)
$gender_query = $pdo->query("SELECT gender, COUNT(*) AS count FROM patients GROUP BY gender");
$gender_data = $gender_query->fetchAll();

// Fetch Age Groups (Bar Chart)
$age_groups_query = $pdo->query("
    SELECT 
        CASE 
            WHEN TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) <= 18 THEN '0-18'
            WHEN TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 19 AND 30 THEN '19-30'
            ELSE '31+' 
        END AS age_group,
        COUNT(*) AS count
    FROM patients
    GROUP BY age_group
");
$age_groups_data = $age_groups_query->fetchAll();

// Fetch Treatment Status (Bar Chart)
$treatment_status_query = $pdo->query("SELECT treatment_status, COUNT(*) AS count FROM patients GROUP BY treatment_status");
$treatment_status_data = $treatment_status_query->fetchAll();

// Fetch Diagnosis Year (Bar Chart)
$diagnosis_year_query = $pdo->query("
    SELECT YEAR(diagnosis_date) AS diagnosis_year, COUNT(*) AS count 
    FROM patients 
    GROUP BY diagnosis_year
");
$diagnosis_year_data = $diagnosis_year_query->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>
    
    <?php include 'cdn.php' ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/chart.css">
</head>
<body>
<?php include 'navbar.php' ?>
    <div class="container">
  
        <h1>Patient Data Dashboard</h1>
        
        <!-- Total Number of Patients -->
        <div class="total-patients">
            <h3>Total Patients: <?php echo $total_patients; ?></h3>
        </div>

        <!-- Pie Chart for Gender Distribution -->
        <div class="chart-container">
            <canvas id="genderChart"></canvas>
        </div>

        <!-- Bar Chart for Age Groups -->
        <div class="chart-container">
            <canvas id="ageGroupChart"></canvas>
        </div>

        <!-- Bar Chart for Treatment Status -->
        <div class="chart-container">
            <canvas id="treatmentStatusChart"></canvas>
        </div>

        <!-- Bar Chart for Diagnosis Year -->
        <div class="chart-container">
            <canvas id="diagnosisYearChart"></canvas>
        </div>
    </div>

    <script>
        // Gender Distribution Pie Chart
        const genderCtx = document.getElementById('genderChart').getContext('2d');
        const genderData = {
            labels: <?php echo json_encode(array_column($gender_data, 'gender')); ?>,
            datasets: [{
                label: 'Gender Distribution',
                data: <?php echo json_encode(array_column($gender_data, 'count')); ?>,
                backgroundColor: ['#FF6384', '#36A2EB'],
                borderWidth: 1
            }]
        };
        new Chart(genderCtx, {
            type: 'pie',
            data: genderData
        });

        // Age Group Bar Chart
        const ageGroupCtx = document.getElementById('ageGroupChart').getContext('2d');
        const ageGroupData = {
            labels: <?php echo json_encode(array_column($age_groups_data, 'age_group')); ?>,
            datasets: [{
                label: 'Age Group Distribution',
                data: <?php echo json_encode(array_column($age_groups_data, 'count')); ?>,
                backgroundColor: '#36A2EB',
                borderWidth: 1
            }]
        };
        new Chart(ageGroupCtx, {
            type: 'bar',
            data: ageGroupData
        });

        // Treatment Status Bar Chart
        const treatmentStatusCtx = document.getElementById('treatmentStatusChart').getContext('2d');
        const treatmentStatusData = {
            labels: <?php echo json_encode(array_column($treatment_status_data, 'treatment_status')); ?>,
            datasets: [{
                label: 'Treatment Status Distribution',
                data: <?php echo json_encode(array_column($treatment_status_data, 'count')); ?>,
                backgroundColor: '#FFCE56',
                borderWidth: 1
            }]
        };
        new Chart(treatmentStatusCtx, {
            type: 'bar',
            data: treatmentStatusData
        });

        // Diagnosis Year Bar Chart
        const diagnosisYearCtx = document.getElementById('diagnosisYearChart').getContext('2d');
        const diagnosisYearData = {
            labels: <?php echo json_encode(array_column($diagnosis_year_data, 'diagnosis_year')); ?>,
            datasets: [{
                label: 'Diagnosis Year Distribution',
                data: <?php echo json_encode(array_column($diagnosis_year_data, 'count')); ?>,
                backgroundColor: '#4BC0C0',
                borderWidth: 1
            }]
        };
        new Chart(diagnosisYearCtx, {
            type: 'bar',
            data: diagnosisYearData
        });
    </script>
</body>
</html>

<style>


</style>
