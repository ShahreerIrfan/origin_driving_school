<?php
session_start();
include("../includes/header.php");
include("../includes/student_dashboard_sidebar.php");

// Dummy logged in student
$studentName = "John Doe";

// Static test data
$averageScore = 82;
$latestScore  = 90;
$totalTests   = 6;
$classCompletion = 7; // out of 10
$totalClasses = 10;

$dates  = ["Sep 01", "Sep 05", "Sep 10", "Sep 15", "Sep 20", "Sep 25"];
$scores = [65, 72, 78, 85, 90, 88];
$feedbacks = [
    "Great improvement in reversing techniques 🚗",
    "Still needs work on parallel parking ⛔",
    "Quick reflexes in traffic situations 👏",
    "Excellent lane discipline 🌟"
];
$achievements = [
    "🏅 Perfect Attendance (September)",
    "⭐ Top Scorer of the Week",
    "🎯 Completed 5 Consecutive Assessments"
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Performance</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* --- Layout --- */
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f9;
            display: flex;
        }
        
        
        .content {
            margin-left: 220px;
            padding: 25px;
            display: flex;
            justify-content: center;
        }
        .container {
            width: 900px;
            max-width: 100%;
        }

        /* --- Cards --- */
        .summary {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }
        .card {
            background: #fff;
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
            flex: 1;
            text-align: center;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card h3 {
            margin: 0;
            color: #6c63ff;
            font-size: 28px;
        }
        .card p {
            margin-top: 6px;
            color: #666;
        }

        /* --- Chart --- */
        canvas {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
            padding: 15px;
            margin-bottom: 30px;
        }

        /* --- Progress Bar --- */
        .progress-box {
            background: #fff;
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .progress-bar-bg {
            background: #e0e0e0;
            border-radius: 12px;
            overflow: hidden;
            height: 22px;
            margin-top: 10px;
        }
        .progress-bar-fill {
            background: linear-gradient(90deg, #6c63ff, #4e54c8);
            height: 100%;
            text-align: center;
            color: #fff;
            font-size: 14px;
            font-weight: bold;
            transition: width 0.5s;
        }

        /* --- Feedback --- */
        h2, h3 {
            color: #333;
        }
       
        /* --- Achievements --- */
        .achievements {
            background: #fff;
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
        }
        .achievements li {
            font-weight: bold;
            color: #444;
        }
    </style>
</head>
<body>



<!-- Header -->

<div style="width:900px; margin-left:270px; margin-top:60px;" class="container">

    <!-- Summary Cards -->
    <div class="summary">
        <div class="card">
            <h3><?= $averageScore ?>%</h3>
            <p>Average Score</p>
        </div>
        <div class="card">
            <h3><?= $latestScore ?>%</h3>
            <p>Latest Score</p>
        </div>
        <div class="card">
            <h3><?= $totalTests ?></h3>
            <p>Total Assessments</p>
        </div>
    </div>

    <!-- Progress Bar -->
    <div class="progress-box">
        <h3>Course Completion</h3>
        <div class="progress-bar-bg">
            <div class="progress-bar-fill" style="width: <?= round(($classCompletion/$totalClasses)*100) ?>%">
                <?= $classCompletion ?>/<?= $totalClasses ?>
            </div>
        </div>
    </div>

    <!-- Chart -->
    <canvas id="progressChart" width="800" height="350"></canvas>
    <script>
    const ctx = document.getElementById('progressChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($dates) ?>,
            datasets: [{
                label: 'Performance Score',
                data: <?= json_encode($scores) ?>,
                borderColor: '#6c63ff',
                backgroundColor: 'rgba(108,99,255,0.2)',
                fill: true,
                tension: 0.3,
                pointRadius: 5,
                pointBackgroundColor: '#6c63ff'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: true } },
            scales: { y: { min: 0, max: 100 } }
        }
    });
    </script>

    <!-- Feedback -->
    <h3>📌 Instructor Feedback</h3>
    <ul>
        <?php foreach ($feedbacks as $f): ?>
            <li><?= htmlspecialchars($f) ?></li>
        <?php endforeach; ?>
    </ul>

    <!-- Achievements -->
    <div class="achievements">
        <h3>🏆 Achievements</h3>
        <ul>
            <?php foreach ($achievements as $a): ?>
                <li><?= $a ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

</div>
</div>

</body>
</html>
