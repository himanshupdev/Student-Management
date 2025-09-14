<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Result Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Hero Section */
        .hero {
            height: 70vh;
            background: url('https://images.unsplash.com/photo-1581091215368-0c6f2d23f331?auto=format&fit=crop&w=1470&q=80') no-repeat center center/cover;
            display: flex;
            align-items: center;
            position: relative;
            color: #fff;
        }
        .hero::after {
            content: "";
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.5); /* overlay */
        }
        .hero-content {
            position: relative;
            z-index: 1;
            text-align: center;
            width: 100%;
            padding: 0 20px;
        }
        .hero h1 {
            font-size: 3rem;
            font-weight: 700;
        }
        .hero p {
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
        }
        .btn-hero {
            min-width: 140px;
            margin: 0 5px;
        }

        /* Features */
        .features {
            padding: 60px 15px;
            background: #f8f9fa;
        }
        .feature-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            padding: 30px 20px;
            text-align: center;
            transition: transform 0.3s;
            background: #fff;
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
        .feature-card i {
            font-size: 3rem;
            color: #2575fc;
            margin-bottom: 15px;
        }

        /* Info Section */
        .info-section {
            padding: 60px 15px;
        }

        /* Footer */
        footer {
            background: #222;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }

        @media (max-width: 768px) {
            .hero h1 { font-size: 2rem; }
            .hero p { font-size: 1rem; }
        }
    </style>
</head>
<body>

<!-- Hero Section -->
<section class="hero d-flex justify-content-center align-items-center">
    <div class="hero-content">
        <h1>Welcome to Student Result Management</h1>
        <p>Efficiently manage student records, track results, and maintain secure dashboards.</p>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="dashboard.php" class="btn btn-primary btn-lg btn-hero">Dashboard</a>
            <a href="logout.php" class="btn btn-outline-light btn-lg btn-hero">Logout</a>
        <?php else: ?>
            <a href="login.php" class="btn btn-primary btn-lg btn-hero">Login</a>
            <a href="signup.php" class="btn btn-outline-light btn-lg btn-hero">Signup</a>
        <?php endif; ?>
    </div>
</section>

<!-- Features Section -->
<section class="features container text-center">
    <div class="mb-5">
        <h2>Core Features</h2>
        <p class="text-muted">Everything you need to manage student results securely and efficiently.</p>
    </div>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="feature-card">
                <i class="bi bi-person-check"></i>
                <h4>Secure Login</h4>
                <p>Each user has a private dashboard with safe access to student records.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card">
                <i class="bi bi-journal-text"></i>
                <h4>CRUD Operations</h4>
                <p>Easily add, edit, delete, and view student records in real-time.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card">
                <i class="bi bi-file-earmark-text"></i>
                <h4>XML Export</h4>
                <p>All student data is synced with XML for offline reporting and backups.</p>
            </div>
        </div>
    </div>
</section>

<!-- Info Section -->
<section class="info-section container">
    <div class="row align-items-center">
        <div class="col-md-6 mb-4 mb-md-0">
            <img src="https://images.unsplash.com/photo-1581091012184-5a0e8ec9a1c2?auto=format&fit=crop&w=800&q=80" class="img-fluid rounded" alt="Student Records">
        </div>
        <div class="col-md-6">
            <h3>Why Choose This System?</h3>
            <p>Designed for colleges and small institutions, this system allows seamless management of student data. It ensures accuracy, quick access to results, and smooth administrative workflows.</p>
            <ul>
                <li>Login-protected user dashboards</li>
                <li>Easy CRUD operations for student records</li>
                <li>XML-based export for offline use</li>
                <li>Printable reports and data security</li>
            </ul>
        </div>
    </div>
</section>

<!-- Footer -->
<footer>
    &copy; <?php echo date("Y"); ?> Student Result Management. All rights reserved.
</footer>

</body>
</html>
