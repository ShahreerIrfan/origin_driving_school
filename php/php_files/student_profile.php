<?php 
  include("../includes/header.php"); 
  include("../includes/student_dashboard_sidebar.php"); 
?>
<link rel="stylesheet" href="../../assets/css/students/student_profile.css">
<main class="main-content">
  <div class="profile-container">
    <h2>👤 My Profile</h2>

    <div class="profile-card">
      <p><strong>Full Name:</strong> John Doe</p>
      <p><strong>Email:</strong> johndoe@example.com</p>
      <p><strong>Phone:</strong> +1 234 567 890</p>
      <p><strong>License Status:</strong> 
        <span class="status active">Active</span>
      </p>
    </div>

    <!-- Example error block -->
    <!--
    <div class="error">
      ⚠️ Your profile was not found in the student records.<br>
      Please contact the admin to verify your account.
    </div>
    -->
  </div>
</main>

<?php include("../includes/footer.php"); ?>
