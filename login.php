<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Jenis Login - PT. Sumber Ganda Mekar</title>

    <!-- Link ke Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Link ke Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">

    <!-- Style CSS -->
    <style>
        /* Tema Konsisten */
        :root {
            --primary-color: #6C63FF;
            --secondary-color: #FF6584;
            --background-color: #f0f2f5;
            --light-bg: #ffffff;
            --dark-bg: #1a1a1a;
            --text-color: #333;
            --transition-speed: 0.3s;
            --font-primary: 'Poppins', sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-primary);
            background-color: var(--background-color);
            color: var(--text-color);
        }

        /* Header */
        header {
            background: var(--light-bg);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
        }

        .logo h1 {
            color: var(--primary-color);
            font-size: 1.8rem;
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 20px;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-color);
            font-weight: 600;
            transition: color var(--transition-speed);
        }

        .nav-links a:hover {
            color: var(--primary-color);
        }

        /* Login Selection Page */
        .login-selection {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding-top: 70px;
        }

        .login-card {
            margin: 10px;
            background: var(--light-bg);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 40px;
            text-align: center;
            transition: transform var(--transition-speed), box-shadow var(--transition-speed);
            margin-bottom: 20px;
        }

        .login-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(108, 99, 255, 0.3);
        }

        .login-card i {
            font-size: 50px;
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        .login-card h2 {
            font-size: 1.5rem;
            color: var(--text-color);
            margin-bottom: 10px;
        }

        .login-card p {
            color: #666;
            margin-bottom: 20px;
        }

        .login-btn {
            background: var(--primary-color);
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 50px;
            transition: background var(--transition-speed);
        }

        .login-btn:hover {
            background: var(--secondary-color);
        }

        /* Footer */
        footer {
            background: var(--dark-bg);
            color: #fff;
            text-align: center;
            padding: 15px;
            border-top: 3px solid var(--primary-color);
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <nav>
            <div class="logo">
                <h1>PT. Sumber Ganda Mekar</h1>
            </div>
            <ul class="nav-links">
                <li><a href="index.html">Beranda</a></li>
            </ul>
        </nav>
    </header>

    <!-- Login Selection -->
    <div class="login-selection">
        <div class="login-card">
            <i class="fas fa-user-tie"></i>
            <h2>Login Pegawai</h2>
            <p>Masuk untuk pegawai PT. Sumber Ganda Mekar</p>
            <a href="login-pegawai.php" class="login-btn">Masuk Sebagai Pegawai</a>
        </div>

        <!-- Admin Login Card -->
        <div class="login-card">
            <i class="fas fa-user-shield"></i>
            <h2>Login Admin</h2>
            <p>Masuk untuk admin PT. Sumber Ganda Mekar</p>
            <a href="login-admin.php" class="login-btn">Masuk Sebagai Admin</a>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; <?php echo date("Y"); ?> PT. Sumber Ganda Mekar. All rights reserved.</p>
    </footer>
</body>
</html>
