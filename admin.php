<?php
// ================= PASSWORD PROTECTION =================
session_start();

// Apna password yahan set karein
$ADMIN_PASSWORD = 'Kuldeep@2026';

// Agar logged in nahi hai
if (!isset($_SESSION['admin_logged_in'])) {
    if (isset($_POST['admin_password'])) {
        if ($_POST['admin_password'] === $ADMIN_PASSWORD) {
            $_SESSION['admin_logged_in'] = true;
            header('Location: admin.php');
            exit;
        } else {
            $error = "Galat password!";
        }
    }
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>TraceX | Admin Login</title>
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body {
                background: #060b14;
                color: #00d4ff;
                font-family: 'Courier New', monospace;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .login-box {
                background: #0d1421;
                border: 2px solid #00d4ff;
                border-radius: 10px;
                padding: 40px;
                width: 90%;
                max-width: 400px;
                box-shadow: 0 0 30px rgba(0, 212, 255, 0.3);
            }
            h1 {
                text-align: center;
                margin-bottom: 20px;
                font-size: 24px;
                text-shadow: 0 0 15px #00d4ff;
            }
            input {
                width: 100%;
                padding: 15px;
                background: #000;
                border: 1px solid #00d4ff;
                color: #00d4ff;
                border-radius: 5px;
                font-family: inherit;
                font-size: 16px;
                margin-bottom: 15px;
                outline: none;
            }
            button {
                width: 100%;
                padding: 15px;
                background: #00d4ff;
                color: #000;
                border: none;
                border-radius: 5px;
                font-family: inherit;
                font-size: 16px;
                font-weight: bold;
                cursor: pointer;
                transition: all 0.3s;
            }
            button:hover {
                background: transparent;
                color: #00d4ff;
                border: 2px solid #00d4ff;
            }
            .error {
                background: rgba(255, 0, 0, 0.1);
                border: 1px solid #ff3333;
                color: #ff6666;
                padding: 10px;
                border-radius: 5px;
                text-align: center;
                margin-bottom: 15px;
            }
        </style>
    </head>
    <body>
        <div class="login-box">
            <h1>🔐 ADMIN LOGIN</h1>
            <?php if (isset($error)): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            <form method="POST">
                <input type="password" name="admin_password" placeholder="Enter admin password" required>
                <button type="submit">LOGIN</button>
            </form>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// ================= BAAD KA CODE =================
// Yahan se aapka purana admin.php ka code shuru hota hai
// (jo logs table dikhata hai)
?>
