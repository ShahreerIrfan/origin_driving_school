<?php
session_start(); // ✅ Always start session at the top

// Ensure only logged-in students can access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit;
}

include("../includes/header.php");
include("../includes/student_dashboard_sidebar.php");
?>

<style>
/* ===== Global Layout ===== */
.dashboard-container {
  width: 900px;
  margin: 30px auto;
  padding: 20px;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  color: #1e293b;
}

/* ===== Hero Section ===== */
.hero {
  background: linear-gradient(135deg, #2563eb, #9333ea);
  color: white;
  padding: 50px 30px;
  border-radius: 20px;
  text-align: center;
  margin-bottom: 40px;
  position: relative;
  overflow: hidden;
  box-shadow: 0 10px 25px rgba(0,0,0,0.25);
}

.hero img.avatar {
  width: 90px;
  height: 90px;
  border-radius: 50%;
  border: 4px solid #fff;
  margin-bottom: 15px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.hero h2 {
  font-size: 28px;
  margin-bottom: 8px;
}

.hero p {
  font-size: 15px;
  opacity: 0.9;
}

/* ===== Quick Stats ===== */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 20px;
  margin-bottom: 40px;
}

.stat-card {
  background: #fff;
  border-radius: 15px;
  padding: 25px 20px;
  text-align: center;
  box-shadow: 0 6px 18px rgba(0,0,0,0.08);
  transition: transform 0.25s, box-shadow 0.25s;
}

.stat-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.stat-card h3 {
  font-size: 26px;
  margin: 10px 0 5px;
  color: #2563eb;
  font-weight: bold;
}

.stat-card p {
  font-size: 14px;
  color: #555;
}

/* ===== Dashboard Grid ===== */
.dashboard-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
  gap: 25px;
}

.dashboard-card {
  background: #fff;
  border-radius: 18px;
  padding: 30px 20px;
  box-shadow: 0 6px 20px rgba(0,0,0,0.08);
  transition: transform 0.25s, box-shadow 0.25s;
  position: relative;
  overflow: hidden;
}

.dashboard-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 12px 28px rgba(0,0,0,0.18);
}

.dashboard-card h3 {
  font-size: 18px;
  margin-bottom: 10px;
  color: #0f172a;
}

.dashboard-card p {
  font-size: 14px;
  color: #555;
  margin-bottom: 20px;
}

.dashboard-card a {
  display: inline-block;
  text-decoration: none;
  padding: 9px 16px;
  font-size: 14px;
  color: #fff;
  background: linear-gradient(135deg, #2563eb, #9333ea);
  border-radius: 10px;
  transition: opacity 0.2s;
}

.dashboard-card a:hover {
  opacity: 0.85;
}
</style>

<div class="dashboard-container">
    <!-- Hero Section -->
    <div class="hero">
        <img src="https://via.placeholder.com/90" alt="Student Avatar" class="avatar">
        <h2>🎓 Welcome, <?= htmlspecialchars($_SESSION['username'] ?? "Student"); ?>!</h2>
        <p>Your personalized student dashboard</p>
    </div>

    <!-- Quick Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <h3>3</h3>
            <p>Enrolled Classes</p>
        </div>
        <div class="stat-card">
            <h3>1</h3>
            <p>Pending Payments</p>
        </div>
    </div>

    <!-- Dashboard Links -->
    <div class="dashboard-grid">
        <div class="dashboard-card">
            <h3>My Profile</h3>
            <p>View your personal details and account information.</p>
            <a href="student_profile.php">View Profile</a>
        </div>

        <div class="dashboard-card">
            <h3>My Classes</h3>
            <p>Check your enrolled driving classes and schedules.</p>
            <a href="student_enrolled_class.php">View Classes</a>
        </div>

        <div class="dashboard-card">
            <h3>Payments</h3>
            <p>Check invoices, payment history, and pending dues.</p>
            <a href="#">View Payments</a>
        </div>

        <div class="dashboard-card">
            <h3>Support</h3>
            <p>Need help? Contact admin or raise a support ticket.</p>
            <a href="#">Get Support</a>
        </div>
    </div>
</div>

<?php include("../includes/footer.php"); ?>
