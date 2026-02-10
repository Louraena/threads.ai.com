<?php
// Simple redirect page - no backend processing needed for this page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaving Threads</title>
    <link rel="stylesheet" href="forgot-password.css">
</head>
<body>
    <div class="container">
        <div class="threads-logo">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="10" stroke="#000" stroke-width="2"/>
                <path d="M8 12h8M12 8v8" stroke="#000" stroke-width="2"/>
            </svg>
        </div>
        
        <h1>Leaving Threads</h1>
        
        <p class="description">
            You're about to visit a link on threads.com that redirects to this website:<br>
            <strong>https://www.instagram.com/accounts/password/reset/</strong>
        </p>
        
        <p class="warning">
            Make sure to only access links you trust.
        </p>
        
        <div class="button-container">
            <button class="continue-btn" onclick="window.location.href='https://www.instagram.com/accounts/password/reset/'">
                Continue
            </button>
        </div>
    </div>
</body>
</html>