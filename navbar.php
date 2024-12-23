<?php
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page name
?>

<div class="navbar_all">
    <div class="logo"></div>
    <button id="toggleButton">
        <i class="fa-solid fa-bars-staggered"></i> 
    </button>
   
    <div class="mobile">
        <div class="logo"></div>
        <div class="dashed"></div>
        <a href="charts.php" class="<?= $current_page === 'charts.php' ? 'active' : '' ?>">Charts</a>
        <a href="record_patient.php" class="<?= $current_page === 'record_patient.php' ? 'active' : '' ?>">Record Patient</a>
        <a href="view_patients.php" class="<?= $current_page === 'view_patients.php' ? 'active' : '' ?>">View Patient</a>

<a href="logout.php">Logout</a>
    </div>
</div>


<script>
    // Get the button and sidebar elements
    var toggleButton = document.getElementById("toggleButton");
    var sidebar = document.querySelector(".mobile");
    var icon = toggleButton.querySelector("i");

    // Add click event listener to the button
    toggleButton.addEventListener("click", function() {
        // Toggle the visibility of the sidebar
        if (sidebar.style.display === "none" || sidebar.style.display === "") {
            sidebar.style.display = "flex";
            sidebar.style.flexDirection = "column";
            icon.classList.remove("fa-bars-staggered" );
            icon.classList.add("fa-xmark" );
       
        } else {
            sidebar.style.display = "none";
            icon.classList.remove("fa-xmark");
            icon.classList.add("fa-bars-staggered");
        }
    });
</script>