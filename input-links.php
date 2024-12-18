<?php
// input-links.php
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
        $posisi = $pegawai['posisi']; // Sesuaikan dengan kolom posisi di database Anda
        $spreadsheet_links = [
            ['link' => $pegawai['spreadsheet_link_1'], 'name' => $pegawai['spreadsheet_link_name_1']],
            ['link' => $pegawai['spreadsheet_link_2'], 'name' => $pegawai['spreadsheet_link_name_2']],
            ['link' => $pegawai['spreadsheet_link_3'], 'name' => $pegawai['spreadsheet_link_name_3']],
            ['link' => $pegawai['spreadsheet_link_4'], 'name' => $pegawai['spreadsheet_link_name_4']],
            ['link' => $pegawai['spreadsheet_link_5'], 'name' => $pegawai['spreadsheet_link_name_5']],
        ]; // Ambil 5 link spreadsheet beserta namanya
    } else {
        echo "Data pegawai tidak ditemukan!";
        exit();
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
    exit();
}

// Proses penginputan link spreadsheet dan nama link
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // CSRF Protection (Opsional, direkomendasikan)
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo "Invalid CSRF token.";
        exit();
    }

    $new_links = [];
    $new_names = [];
    for ($i = 1; $i <= 5; $i++) {
        $link = !empty($_POST["spreadsheet_link_$i"]) ? filter_var($_POST["spreadsheet_link_$i"], FILTER_SANITIZE_URL) : null;
        $name = !empty($_POST["spreadsheet_link_name_$i"]) ? htmlspecialchars(trim($_POST["spreadsheet_link_name_$i"])) : null;

        $new_links[] = $link;
        $new_names[] = $name;
    }

    // Update link dan nama link spreadsheet di database
    try {
        $stmt = $pdo->prepare("UPDATE pegawai SET 
            spreadsheet_link_1 = ?, 
            spreadsheet_link_name_1 = ?,
            spreadsheet_link_2 = ?, 
            spreadsheet_link_name_2 = ?,
            spreadsheet_link_3 = ?, 
            spreadsheet_link_name_3 = ?,
            spreadsheet_link_4 = ?, 
            spreadsheet_link_name_4 = ?,
            spreadsheet_link_5 = ?, 
            spreadsheet_link_name_5 = ?
            WHERE id = ?");
        $stmt->execute([
            $new_links[0], $new_names[0],
            $new_links[1], $new_names[1],
            $new_links[2], $new_names[2],
            $new_links[3], $new_names[3],
            $new_links[4], $new_names[4],
            $pegawai_id
        ]);
        // Redirect ke halaman dashboard setelah update dengan status sukses
        header('Location: pegawai.php?status=success');
        exit();
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
        exit();
    }
}

// Buat token CSRF
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Link Spreadsheet - PT. Sumber Ganda Mekar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        /* Variabel CSS untuk Tema */
:root {
    --primary-color: #6C63FF;
    --secondary-color: #FF6584;
    --background-color: #f0f2f5;
    --text-color: #333;
    --light-bg: #ffffff;
    --dark-bg: #1a1a1a;
    --transition-speed: 0.3s;
    --font-primary: 'Poppins', sans-serif;
}

/* Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body Styling */
body {
    font-family: var(--font-primary);
    background-color: var(--background-color);
    color: var(--text-color);
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

/* Header Styling */
header {
    background: var(--light-bg);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1000;
}

.navbar {
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

.nav-links li a {
    text-decoration: none;
    color: var(--text-color);
    font-weight: 600;
    transition: color var(--transition-speed);
}

.nav-links li a:hover {
    color: var(--primary-color);
}

/* Main Content Styling */
.container {
    margin: 100px auto 30px auto;
    width: 90%;
    max-width: 1200px;
    flex: 1;
}

.box {
    background: var(--light-bg);
    border-radius: 10px;
    box-shadow: 0 10px 20px rgba(108, 99, 255, 0.1);
    padding: 30px;
}

/* Form Group Styling */
.form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 20px;
}

.form-group label {
    font-weight: 600;
    color: var(--text-color);
    margin-bottom: 5px;
}

.form-group input {
    padding: 10px;
    font-size: 1rem;
    border: 1px solid #ddd;
    border-radius: 8px;
    transition: border-color var(--transition-speed);
}

.form-group input:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 5px rgba(108, 99, 255, 0.5);
    outline: none;
}

/* Actions */
.actions {
    text-align: center;
}

.actions button {
    margin-top: 20px;
    background: var(--primary-color);
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 50px;
    font-size: 1rem;
    cursor: pointer;
    transition: background var(--transition-speed);
}

.actions button:hover {
    background: var(--secondary-color);
}

/* Footer Styling */
footer {
    background: var(--dark-bg);
    color: white;
    text-align: center;
    padding: 20px;
    margin-top: auto;
    border-top: 3px solid var(--primary-color);
}

/* Responsive */
@media (max-width: 768px) {
    .form-group {
        margin-bottom: 15px;
    }

    .form-group input {
        font-size: 0.875rem;
    }

    .actions button {
        font-size: 0.875rem;
        padding: 8px 16px;
    }
}
.spreadsheet-card {
    background: var(--light-bg);
    padding: 20px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    text-align: center;
    transition: all 0.3s ease;
}

.spreadsheet-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(108, 99, 255, 0.2);
}

.spreadsheet-card-icon {
    background: var(--primary-color);
    color: white;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    margin: 0 auto 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.spreadsheet-card .form-group label {
    color: var(--primary-color);
    font-weight: 600;
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
                <li><a href="pegawai.php"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </nav>
    </header>

    <!-- Input Links Container -->
    <div class="container">
    <div class="box">
        <!-- Header Section -->
        <div class="header-section">
            <h2>Input Link Spreadsheet</h2>
            <p>Masukkan link spreadsheet Anda beserta nama yang sesuai.</p>
        </div>

        <!-- Spreadsheet Form -->
        <div class="spreadsheet-form">
            <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
                <div style="color: green; text-align: center; margin-bottom: 20px;">
                    <i class="fas fa-check-circle"></i> Link spreadsheet berhasil disimpan.
                </div>
            <?php endif; ?>

            <form action="input-links.php" method="POST">
                <!-- CSRF Token -->
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                <!-- Form dengan Konsistensi UI -->
                <div class="spreadsheet-link-container">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <div class="spreadsheet-card">
                            <div class="spreadsheet-card-icon">
                                <i class="fas fa-link"></i>
                            </div>
                            <div class="form-group">
                                <label for="spreadsheet_link_<?php echo $i; ?>">Link Spreadsheet <?php echo $i; ?></label>
                                <input type="url" id="spreadsheet_link_<?php echo $i; ?>" name="spreadsheet_link_<?php echo $i; ?>" placeholder="Masukkan link spreadsheet" value="<?php echo htmlspecialchars($spreadsheet_links[$i - 1]['link'] ?? ''); ?>">
                            </div>
                            <div class="form-group">
                                <label for="spreadsheet_link_name_<?php echo $i; ?>">Nama Link <?php echo $i; ?></label>
                                <input type="text" id="spreadsheet_link_name_<?php echo $i; ?>" name="spreadsheet_link_name_<?php echo $i; ?>" placeholder="Nama link" value="<?php echo htmlspecialchars($spreadsheet_links[$i - 1]['name'] ?? ''); ?>">
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>

                <!-- Tombol Simpan -->
                <div class="actions">
                    <button type="submit">
                        <i class="fas fa-save"></i> Simpan Link
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


    <!-- Footer -->
    <footer>
        <p>&copy; <?php echo date("Y"); ?> PT. Sumber Ganda Mekar. All rights reserved.</p>
    </footer>

</body>
</html>
