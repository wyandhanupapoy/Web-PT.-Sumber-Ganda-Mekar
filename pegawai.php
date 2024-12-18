<?php
// pegawai.php
session_start();
include 'db.php';  // Koneksi ke database

// Cek apakah pegawai sudah login, jika tidak redirect ke halaman login
if (!isset($_SESSION['pegawai_id'])) {
    header('Location: login-pegawai.php');
    exit();
}

// Ambil data pegawai berdasarkan session
$pegawai_id = $_SESSION['pegawai_id'];

try {
    // Ambil data pegawai berdasarkan ID
    $stmt = $pdo->prepare("SELECT * FROM pegawai WHERE id = ?");
    $stmt->execute([$pegawai_id]);
    $pegawai = $stmt->fetch();

    if ($pegawai) {
        $nama = $pegawai['nama'];
        $email = $pegawai['email'];
        $posisi = $pegawai['posisi']; 
        $spreadsheet_links = [
            ['link' => $pegawai['spreadsheet_link_1'], 'name' => $pegawai['spreadsheet_link_name_1']],
            ['link' => $pegawai['spreadsheet_link_2'], 'name' => $pegawai['spreadsheet_link_name_2']],
            ['link' => $pegawai['spreadsheet_link_3'], 'name' => $pegawai['spreadsheet_link_name_3']],
            ['link' => $pegawai['spreadsheet_link_4'], 'name' => $pegawai['spreadsheet_link_name_4']],
            ['link' => $pegawai['spreadsheet_link_5'], 'name' => $pegawai['spreadsheet_link_name_5']],
        ];
    } else {
        echo "Data pegawai tidak ditemukan!";
        exit();
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pegawai - PT. Sumber Ganda Mekar</title>
    
    <!-- Link ke Font Awesome untuk Ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Link ke Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">

    <style>
        /* Reuse the CSS from index.php with some modifications */
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
            padding-top: 70px; /* Add padding to account for fixed header */
        }

        /* Header Styles */
        header {
            background: var(--light-bg);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            transition: background 0.3s ease;
        }

        .navbar {
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

        .nav-links {
            list-style: none;
            display: flex;
            gap: 20px;
        }

        .nav-links li a {
            text-decoration: none;
            color: var(--text-color);
            font-weight: 600;
            transition: color var(--transition-speed);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-links li a:hover {
            color: var(--primary-color);
        }

        /* Container Styles */
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
            background: var(--light-bg);
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(108, 99, 255, 0.1);
        }

        .box {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .header-section {
            text-align: center;
            padding: 20px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 10px;
        }

        .header-section h2 {
            margin-bottom: 10px;
            font-size: 2rem;
        }
        
        .profile-info {
            background: #f4f4f4;
            padding: 20px;
            border-radius: 10px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 15px;
        }

        .profile-detail {
            flex: 1;
            min-width: 250px;
            background: white;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .profile-detail:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(108, 99, 255, 0.1);
        }

        .profile-detail-icon {
            background: var(--primary-color);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .profile-detail-text {
            flex-grow: 1;
        }

        .profile-detail-text strong {
            color: var(--primary-color);
            display: block;
            margin-bottom: 5px;
        }

        .profile-detail-text p {
            margin: 0;
            color: #666;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .profile-info {
                flex-direction: column;
            }

            .profile-detail {
                width: 100%;
            }
        }

        .actions {
            text-align: center;
            margin: 20px 0;
        }

        .actions a {
            text-decoration: none;
            background: var(--primary-color);
            color: white;
            padding: 12px 25px;
            border-radius: 50px;
            transition: background var(--transition-speed);
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .actions a:hover {
            background: var(--secondary-color);
        }
        .spreadsheet-link-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .spreadsheet-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .spreadsheet-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(108, 99, 255, 0.2);
        }

        .spreadsheet-card-icon {
            background: var(--primary-color);
            color: white;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            margin: 0 auto 15px;
            transition: background 0.3s ease;
        }

        .spreadsheet-card:hover .spreadsheet-card-icon {
            background: var(--secondary-color);
        }

        .spreadsheet-card-title {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 15px;
            font-size: 1.1rem;
            min-height: 50px; /* Ensure consistent height */
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .spreadsheet-card-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .spreadsheet-card a {
            text-decoration: none;
            background: var(--primary-color);
            color: white;
            padding: 12px 20px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: background 0.3s ease;
        }

        .spreadsheet-card a:hover {
            background: var(--secondary-color);
        }

        .no-links-message {
            text-align: center;
            padding: 40px 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            color: var(--primary-color);
            font-weight: 600;
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

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .spreadsheet-link-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <nav class="navbar">
            <div class="logo">
                <h1>PT. Sumber Ganda Mekar</h1>
            </div>
            <ul class="nav-links">
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </nav>
    </header>

    <!-- Dashboard Container -->
    <div class="container">
        <div class="box">
            <!-- Dashboard Header -->
            <div class="header-section">
                <h2>Selamat Datang, <?php echo htmlspecialchars($nama); ?></h2>
                <p>Anda berhasil login ke sistem pegawai PT. Sumber Ganda Mekar.</p>
            </div>

            <!-- Profile Info -->
            <div class="profile-info">
                <div class="profile-detail">
                    <div class="profile-detail-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="profile-detail-text">
                        <strong>Nama</strong>
                        <p><?php echo htmlspecialchars($nama); ?></p>
                    </div>
                </div>

                <div class="profile-detail">
                    <div class="profile-detail-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="profile-detail-text">
                        <strong>Email</strong>
                        <p><?php echo htmlspecialchars($email); ?></p>
                    </div>
                </div>

                <div class="profile-detail">
                    <div class="profile-detail-icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <div class="profile-detail-text">
                        <strong>Posisi</strong>
                        <p><?php echo htmlspecialchars($posisi); ?></p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="actions">
                <a href="input-links.php"><i class="fas fa-plus"></i> Tambah/Edit Link Spreadsheet</a>
            </div>

            <!-- Link Spreadsheet -->
            <?php 
            // Check if there are any links
            $has_links = false;
            foreach ($spreadsheet_links as $link_info) {
                if (!empty($link_info['link'])) {
                    $has_links = true;
                    break;
                }
            }
            ?>
            <?php if ($has_links): ?>
        <div class="spreadsheet-link-container">
            <?php for ($i = 0; $i < 5; $i++): ?>
                <?php if (!empty($spreadsheet_links[$i]['link'])): ?>
                    <div class="spreadsheet-card">
                        <div class="spreadsheet-card-icon">
                            <i class="fas fa-table"></i>
                        </div>
                        <div class="spreadsheet-card-title">
                            <?php echo htmlspecialchars($spreadsheet_links[$i]['name'] ?? "Link Spreadsheet " . ($i + 1)); ?>
                        </div>
                        <div class="spreadsheet-card-actions">
                            <a href="<?php echo htmlspecialchars($spreadsheet_links[$i]['link']); ?>" target="_blank">
                                <i class="fas fa-external-link-alt"></i> Buka Spreadsheet
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
    <?php else: ?>
        <div class="no-links-message">
            <i class="fas fa-folder-open" style="font-size: 3rem; margin-bottom: 15px;"></i>
            <p>Belum ada link spreadsheet yang ditambahkan.</p>
        </div>
    <?php endif; ?>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; <?php echo date("Y"); ?> PT. Sumber Ganda Mekar. Semua Hak Dilindungi.</p>
    </footer>
</body>
</html>