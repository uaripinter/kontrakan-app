<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Kontrakan App</title>
    <style>
        body { display: flex; align-items: center; justify-content: center; min-height: 100vh; background: #2563EB; font-family: 'Segoe UI', sans-serif; }
        .login-box { background: #fff; padding: 40px; border-radius: 16px; width: 100%; max-width: 400px; }
        .field { margin-bottom: 16px; }
        .field label { display: block; margin-bottom: 8px; font-weight: 600; }
        .field input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 8px; }
        .btn { width: 100%; padding: 12px; background: #2563EB; color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2 style="margin-bottom: 20px;">Login Sistem</h2>
        <?php if(isset($_GET['error'])): ?>
            <p style="color: red; margin-bottom: 10px;"><?= $_GET['error'] ?></p>
        <?php endif; ?>
        <form action="proses_login.php" method="POST">
            <div class="field">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>
            <div class="field">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</body>
</html>