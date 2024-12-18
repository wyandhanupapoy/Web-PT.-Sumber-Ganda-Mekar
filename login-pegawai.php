<?php
session_start();
include 'db.php'; // Pastikan file ini ada dan terhubung ke database

// Aktifkan error reporting untuk melihat detail kesalahan
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Tangkap data dari form
    $email = $_POST['pegawai_email'];
    $password = $_POST['pegawai_password'];

    try {
        // Siapkan query untuk mengambil data pegawai berdasarkan email
        $stmt = $pdo->prepare("SELECT * FROM pegawai WHERE email = ?");
        $stmt->execute([$email]);
        $pegawai = $stmt->fetch();

        if ($pegawai && password_verify($password, $pegawai['password'])) {
            // Jika email dan password cocok, buat session dan redirect ke halaman dashboard
            $_SESSION['pegawai_id'] = $pegawai['id'];
            $_SESSION['pegawai_nama'] = $pegawai['nama'];
            echo '<script>
                alert("Login Berhasil!");
                window.location.href = "pegawai.php"; // Ganti dengan halaman dashboard pegawai
            </script>';
            exit();
        } else {
            // Jika gagal login
            echo '<script>
                alert("Email atau Password salah!");
            </script>';
        }
    } catch(PDOException $e) {
        echo '<script>
            alert("Login Gagal: ' . $e->getMessage() . '");
        </script>';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pegawai - PT. Sumber Ganda Mekar</title>
    
    <!-- Link ke Font Awesome untuk Ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Link ke Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">

    <!-- Style Khusus untuk Halaman Login Pegawai -->
    <style>
        /* CSS Variables for Theme */
        :root {
            --primary-color: #6C63FF;
            --secondary-color: #FF6584;
            --background-color: #f0f2f5;
            --text-color: #333;
            --light-bg: #ffffff;
            --dark-bg: #1a1a1a;
            --transition-speed: 0.3s;
            --font-primary: 'Poppins', sans-serif;
            --font-secondary: 'Roboto', sans-serif;
        }
        
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: var(--font-primary);
            color: var(--text-color);
            background-color: var(--background-color);
            line-height: 1.6;
            overflow-x: hidden;
        }
        
        /* Navbar Styles */
        header {
            background: var(--light-bg);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: fixed;
            width: 100%;
            z-index: 1000;
            transition: background 0.3s ease;
        }
        
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 70px;
            padding: 0 20px;
        }
        
        .logo h1 {
            font-size: 1.8rem;
            color: var(--primary-color);
            transition: color var(--transition-speed);
        }
        
        .logo h1:hover {
            color: var(--secondary-color);
        }
        
        .nav-menu {
            list-style: none;
            display: flex;
            gap: 25px;
        }
        
        .nav-menu li a {
            text-decoration: none;
            color: var(--text-color);
            font-weight: 600;
            position: relative;
            transition: color var(--transition-speed);
        }
        
        .nav-menu li a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            background: var(--primary-color);
            left: 0;
            bottom: -5px;
            transition: width var(--transition-speed);
        }
        
        .nav-menu li a:hover {
            color: var(--primary-color);
        }
        
        .nav-menu li a:hover::after {
            width: 100%;
        }
        
        .nav-toggle {
            display: none;
            flex-direction: column;
            cursor: pointer;
        }
        
        .nav-toggle span {
            height: 3px;
            width: 30px;
            background: var(--text-color);
            margin: 4px 0;
            border-radius: 3px;
            transition: all var(--transition-speed);
        }
        
        /* Login Form Container Styles */
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 70px); /* To offset fixed navbar */
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            padding: 20px;
            box-sizing: border-box;
            animation: fadeIn 1s ease-out;
        }
        
        /* Login Form Styles */
        .login-form {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
            padding: 60px 40px;
            width: 100%;
            max-width: 450px;
            transition: transform var(--transition-speed), box-shadow var(--transition-speed);
            position: relative;
            overflow: hidden;
            color: #fff;
        }
        
        .login-form::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: rgba(255, 255, 255, 0.2);
            transform: rotate(45deg);
            transition: transform var(--transition-speed);
            z-index: -1; /* Ensure the pseudo-element is behind the content */
        }
        
        .login-form:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(108, 99, 255, 0.3);
        }
        
        .login-form:hover::before {
            transform: rotate(0deg);
        }
        
        /* Heading Styles */
        .login-form h2 {
            text-align: center;
            color: var(--light-bg);
            margin-bottom: 30px;
            font-size: 2.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-family: var(--font-secondary);
            animation: slideInLeft 0.5s ease-out forwards;
            opacity: 0;
        }
        
        /* Form Group Styles */
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--light-bg);
            font-weight: 600;
            font-family: var(--font-secondary);
            font-size: 1rem;
        }
        
        .form-group input {
            width: 100%;
            padding: 14px 16px;
            border: none;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.3);
            color: #fff;
            transition: background 0.3s ease, transform 0.3s ease;
            font-family: var(--font-secondary);
            font-size: 1rem;
        }
        
        .form-group input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        
        .form-group input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
        }
        
        /* Submit Button Styles */
        .submit-button {
            width: 100%;
            padding: 14px;
            background: var(--primary-color);
            color: #fff;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: background-color var(--transition-speed), transform var(--transition-speed), box-shadow var(--transition-speed);
            font-weight: 600;
            font-size: 1rem;
            box-shadow: 0 6px 15px rgba(108, 99, 255, 0.3);
            margin-top: 10px;
        }
        
        .submit-button:hover {
            background: var(--secondary-color);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(108, 99, 255, 0.4);
        }
        
        /* Authentication Switch Styles */
        .auth-switch {
            text-align: center;
            margin-top: 20px;
        }
        
        .auth-switch a {
            color: var(--light-bg);
            text-decoration: none;
            font-weight: 500;
            transition: color var(--transition-speed);
            font-family: var(--font-secondary);
            font-size: 0.95rem;
        }
        
        .auth-switch a:hover {
            color: var(--secondary-color);
        }
        
        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        /* Responsive Styles */
        @media (max-width: 768px) {
            .nav-menu {
                position: fixed;
                top: 70px;
                left: -100%;
                width: 100%;
                height: calc(100vh - 70px);
                background: var(--light-bg);
                flex-direction: column;
                align-items: center;
                justify-content: center;
                transition: left var(--transition-speed);
            }

            .nav-menu.active {
                left: 0;
            }

            .nav-menu li {
                margin: 20px 0;
            }

            .nav-toggle {
                display: flex;
            }

            .login-form {
                padding: 40px 30px;
            }

            .login-form h2 {
                font-size: 2rem;
            }

            .form-group input {
                padding: 12px 14px;
                font-size: 0.95rem;
            }

            .submit-button {
                padding: 12px;
                font-size: 0.95rem;
            }
        }
        
        @media (max-width: 480px) {
            .login-form {
                padding: 30px 20px;
            }
        
            .login-form h2 {
                font-size: 1.8rem;
            }
        
            .form-group label,
            .form-group input {
                font-size: 0.9rem;
            }
        
            .submit-button {
                padding: 10px;
                font-size: 0.9rem;
            }
        }
        /* Footer Styles */
footer {
    background: var(--dark-bg);
    color: #fff;
    text-align: center;
    padding: 30px 20px;
    position: relative;
    border-top: 3px solid var(--primary-color);
}
footer p {
    font-size: 1rem;
}
    </style>
</head>
<body>
    <!-- Navbar (Navigation Bar) -->
    <header>
        <nav>
            <div class="logo">
                <h1>PT. Sumber Ganda Mekar</h1>
            </div>
            <div class="nav-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <ul class="nav-menu">
                <li><a href="index.html">Beranda</a></li>
            </ul>
        </nav>
    </header>

    <!-- Login Form Container -->
    <div class="login-container">
        <form class="login-form" action="login-pegawai.php" method="POST">
            <h2>Login Pegawai</h2>
            <div class="form-group">
                <label for="pegawai-email">Email Pegawai</label>
                <input type="email" id="pegawai-email" name="pegawai_email" required placeholder="Masukkan email pegawai">
            </div>
            <div class="form-group">
                <label for="pegawai-password">Kata Sandi</label>
                <input type="password" id="pegawai-password" name="pegawai_password" required placeholder="Masukkan kata sandi">
            </div>
            <button type="submit" class="submit-button">Login</button>
            <div class="auth-switch">
                <a href="login.php">Kembali ke Pilihan Login</a>
            </div>
        </form>
    </div>
    <footer>
    <p>&copy; <?php echo date("Y"); ?> PT. Sumber Ganda Mekar. Semua Hak Dilindungi.</p>
</footer>

    <!-- Mobile Navigation Toggle Script -->
    <script>
        document.querySelector('.nav-toggle').addEventListener('click', function() {
            document.querySelector('.nav-menu').classList.toggle('active');
            this.classList.toggle('active');
        });

        // Animate the heading on load
        window.addEventListener('load', function() {
            const heading = document.querySelector('.login-form h2');
            heading.style.opacity = '1';
        });
    </script>
</body>
</html>
