<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Search</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: linear-gradient(to bottom, rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('hero-image.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            text-align: center;
        }
        .hero h1 {
            font-size: 3rem;
        }
        .search-bar {
            max-width: 700px;
            margin: 20px auto;
            padding: 15px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="logo-placeholder.png" alt="Logo" height="40">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact Us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Find the Right Doctor for You</h1>
            <p class="lead">Search by specialization and location to connect with the best doctors in your area.</p>

            <!-- Search Bar -->
            <div class="search-bar">
                <form action="search_results.php" method="GET" class="row g-2">
                    <div class="col-md-6">
                        <input type="text" name="query" class="form-control" placeholder="Search doctors by name or keyword" required>
                    </div>
                    <div class="col-md-3">
                        <select name="specialization" class="form-select" required>
                            <option value="" disabled selected>Specialization</option>
                            <option value="cardiologist">Cardiologist</option>
                            <option value="dermatologist">Dermatologist</option>
                            <option value="neurologist">Neurologist</option>
                            <option value="pediatrician">Pediatrician</option>
                            <option value="general_practitioner">General Practitioner</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="location" class="form-select" required>
                            <option value="" disabled selected>Location</option>
                            <option value="new_york">New York</option>
                            <option value="los_angeles">Los Angeles</option>
                            <option value="chicago">Chicago</option>
                            <option value="houston">Houston</option>
                            <option value="miami">Miami</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary w-100">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
