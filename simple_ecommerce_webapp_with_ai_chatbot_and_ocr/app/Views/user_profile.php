<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <style>
        body {
            background: #f4f6f8;
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            min-height: 100vh;
        }
        .profile-container {
            background: #fff;
            padding: 2rem 2.5rem;
            border-radius: 10px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            min-width: 350px;
            max-width: 400px;
            margin: 80px auto 0 auto;
            text-align: center;
        }
        h2 {
            color: #333;
            margin-bottom: 1.5rem;
        }
        .profile-info {
            font-size: 1.1rem;
            color: #444;
            margin-bottom: 1.2rem;
        }
        .profile-label {
            font-weight: 600;
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <h2>User Profile</h2>
        <div class="profile-info">
            <span class="profile-label">Name:</span> <?= esc($name) ?>
        </div>
        <div class="profile-info">
            <span class="profile-label">Email:</span> <?= esc($email) ?>
        </div>
    </div>
</body>
</html>
