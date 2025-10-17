<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>K.Palafox Realty - Discover Properties</title>
    @vite('resources/css/app.css')
</head>

<body>
    <!-- Header -->
    <header class=>
        <div class="container">
            <div class="logo"><img src="assets/kpalafox_logo.png" alt="K.Palafox Realty"> K.Palafox Realty</div>
            <nav class="nav">
                <ul>
                    <li><a href="#discover">Discover Properties</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#signup">Sign Up</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>YOUR GROWTH PARTNER WITH VISION</h1>
        </div>
        <!-- Search Bar -->
        <section class="search-section">
            <div class="container">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search">
                </div>
            </div>
        </section>



    </section>

    <!-- Stats Section -->
    <div class="overlay">
        <section class="stats">
            <div class="container">
                <div class="stat-item">
                    <i class="fas fa-home"></i>
                    <div class="stat-number">00</div>
                    <div class="stat-label">Houses</div>
                </div>
                <div class="stat-item">
                    <i class="fas fa-users"></i>
                    <div class="stat-number">00</div>
                    <div class="stat-label">Developers</div>
                </div>
                <div class="stat-item">
                    <i class="fas fa-user-tie"></i>
                    <div class="stat-number">00</div>
                    <div class="stat-label">House Owners</div>
                </div>
            </div>
        </section>
    </div>

    <!-- House Developers Section -->
    <section class="house-developers">
        <div class="container">
            <h2>House Developers</h2>
            <div class="developers-grid">
                <div class="developer-item">
                    <div class="dev-card">
                        <a href="developer1.html" class="dev-card">
                            <img src="assets/vistaland_logo.png" alt="Developer Logo">
                        </a>
                    </div>
                    <p>The quick brown fox jumps over the lazy dog the quick...</p>
                </div>

                <div class="developer-item">
                    <div class="dev-card">
                        <a href="developer1.html" class="dev-card">
                            <img src="assets/century_logo.png" alt="Developer Logo">
                        </a>
                    </div>
                    <p>The quick brown fox jumps over the lazy dog the quick...</p>
                </div>

                <div class="developer-item">
                    <div class="dev-card">
                        <a href="developer1.html" class="dev-card">
                            <img src="assets/borland_logo.png" alt="Developer Logo">
                        </a>
                    </div>
                    <p>The quick brown fox jumps over the lazy dog the quick...</p>
                </div>

                <div class="developer-item">
                    <div class="dev-card">
                        <a href="developer1.html" class="dev-card">
                            <img src="assets/ayala_logo.png" alt="Developer Logo">
                        </a>
                    </div>
                    <p>The quick brown fox jumps over the lazy dog the quick...</p>
                </div>

                <div class="developer-item">
                    <div class="dev-card">
                        <a href="developer1.html" class="dev-card">
                            <img src="assets/atlanta_logo.png" alt="Developer Logo">
                        </a>
                    </div>
                    <p>The quick brown fox jumps over the lazy dog the quick...</p>
                </div>

                <div class="developer-item">
                    <div class="dev-card">
                        <a href="developer1.html" class="dev-card">
                            <img src="assets/servequest_logo.png" alt="Developer Logo">
                        </a>
                    </div>
                    <p>The quick brown fox jumps over the lazy dog the quick...</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Property Types Section -->
    <section class="property-types">
        <div class="container">
            <h2>Property Type</h2>
            <div class="types-grid">
                <a href="luxury-homes.html" class="type-card-link">
                    <div class="type-card">
                        <i class="fas fa-home"></i>
                        <h3>Luxury Homes</h3>
                    </div>
                </a>

                <a href="modern-flats.html" class="type-card-link">
                    <div class="type-card">
                        <i class="fas fa-building"></i>
                        <h3>Modern Flats</h3>
                    </div>
                </a>

                <a href="suburban.html" class="type-card-link">
                    <div class="type-card">
                        <i class="fas fa-home"></i>
                        <h3>Suburban</h3>
                    </div>
                </a>

                <a href="urban.html" class="type-card-link">
                    <div class="type-card">
                        <i class="fas fa-city"></i>
                        <h3>Urban</h3>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="map-section">
        <div class="container">
            <div class="map-content">
                <div class="map-placeholder">
                    <!-- Replace with actual map embed, e.g., Google Maps iframe -->
                    <img src="assets/k_map.png" alt="City Map" style="width:100%; height:400px;">
                </div>
                <div class="map-text">
                    <h2 style="align-center"> Frequently Asked Questions</h2>

                    <div class="map-card">
                        <h3>Question 1</h3>
                    </div>
                    <div class="map-card">
                        <h3>Question 2</h3>
                    </div>
                    <div class="map-card">
                        <h3>Question 3</h3>
                    </div>
                    <div class="map-card">
                        <h3>Question 4</h3>
                    </div>
                    <div class="map-card">
                        <h3>Question 5</h3>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-brand">
                    <h3>Kaplan Realty</h3>
                    <p>Your Home</p>
                </div>
                <div class="footer-links">
                    <ul>
                        <li><a href="#home">Home</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="#services">Services</a></li>
                    </ul>
                </div>
                <div class="footer-contact">
                    <p>123 Realty Street, City, State 12345</p>
                    <p>Phone: (123) 456-7890</p>
                    <p>Email: info@kaplanrealty.com</p>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>