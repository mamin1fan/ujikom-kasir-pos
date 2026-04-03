<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('Location: index.php');
    exit();
}

include 'koneksi.php';

$nama = $_SESSION['nama'] ?? 'User';
$id_sekolah = $_SESSION['id_sekolah'] ?? null;

// ══════════════════════════════════════════════════════════
//  AJAX HANDLER
// ══════════════════════════════════════════════════════════
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    $action = $_POST['action'];

    if ($action === 'tambah') {
        $nama_kelompok = trim($_POST['nama_kelompok'] ?? '');
        $keterangan = trim($_POST['keterangan'] ?? '');
        if ($nama_kelompok === '') {
            echo json_encode(['success' => false, 'message' => 'Nama kelompok tidak boleh kosong.']);
            exit;
        }
        // Cek duplikat dalam sekolah yang sama
        $cek = $pdo->prepare("SELECT COUNT(*) FROM tb_kelompok_kategori WHERE nama = ? AND id_sekolah = ?");
        $cek->execute([$nama_kelompok, $id_sekolah]);
        if ($cek->fetchColumn() > 0) {
            echo json_encode(['success' => false, 'message' => 'Nama kelompok sudah ada.']);
            exit;
        }
        $stmt = $pdo->prepare("INSERT INTO tb_kelompok_kategori (nama, keterangan, id_sekolah) VALUES (?, ?, ?)");
        $stmt->execute([$nama_kelompok, $keterangan, $id_sekolah]);
        echo json_encode(['success' => true, 'message' => 'Kelompok berhasil ditambahkan.', 'id' => $pdo->lastInsertId()]);
        exit;
        $stmt = $pdo->prepare("INSERT INTO tb_kelompok_kategori (nama_kelompok, id_sekolah) VALUES (?, ?)");
        $stmt->execute([$nama_kelompok, $id_sekolah]);
        echo json_encode(['success' => true, 'message' => 'Kelompok berhasil ditambahkan.', 'id' => $pdo->lastInsertId()]);
        exit;
    }

    if ($action === 'edit') {
        $id = intval($_POST['id_kelompok'] ?? 0);
        $nama_kelompok = trim($_POST['nama_kelompok'] ?? '');
        $keterangan = trim($_POST['keterangan'] ?? '');
        if ($nama_kelompok === '') {
            echo json_encode(['success' => false, 'message' => 'Nama kelompok tidak boleh kosong.']);
            exit;
        }
        // Cek duplikat (kecuali diri sendiri)
        $cek = $pdo->prepare("SELECT COUNT(*) FROM tb_kelompok_kategori WHERE nama = ? AND id_sekolah = ? AND id_kelompok_kategori != ?");
        $cek->execute([$nama_kelompok, $id_sekolah, $id]);
        if ($cek->fetchColumn() > 0) {
            echo json_encode(['success' => false, 'message' => 'Nama kelompok sudah digunakan.']);
            exit;
        }
        $stmt = $pdo->prepare("UPDATE tb_kelompok_kategori SET nama = ?, keterangan = ? WHERE id_kelompok_kategori = ? AND id_sekolah = ?");
        $stmt->execute([$nama_kelompok, $keterangan, $id, $id_sekolah]);
        echo json_encode(['success' => true, 'message' => 'Kelompok berhasil diperbarui.']);
        exit;
    }

    if ($action === 'hapus') {
        $id = intval($_POST['id_kelompok'] ?? 0);
        // Cek apakah kelompok masih dipakai di kategori
        $cek = $pdo->prepare("SELECT COUNT(*) FROM tb_kategori WHERE id_kelompok_kategori = ? AND is_delete = 0");
        $cek->execute([$id]);
        if ($cek->fetchColumn() > 0) {
            echo json_encode(['success' => false, 'message' => 'Kelompok masih digunakan oleh kategori, tidak bisa dihapus.']);
            exit;
        }
        $stmt = $pdo->prepare("DELETE FROM tb_kelompok_kategori WHERE id_kelompok_kategori = ? AND id_sekolah = ?");
        $stmt->execute([$id, $id_sekolah]);
        echo json_encode(['success' => true, 'message' => 'Kelompok berhasil dihapus.']);
        exit;   
    }

    echo json_encode(['success' => false, 'message' => 'Action tidak dikenal.']);
    exit;
}

// ══════════════════════════════════════════════════════════
//  AMBIL DATA
// ══════════════════════════════════════════════════════════
$kelompok = [];
try {
    $stmt = $pdo->prepare("
        SELECT k.*, 
               COUNT(CASE WHEN c.is_delete = 0 THEN 1 END) AS jumlah_kategori
        FROM tb_kelompok_kategori k
        LEFT JOIN tb_kategori c ON c.id_kelompok_kategori = k.id_kelompok_kategori
        WHERE k.id_sekolah = ?
        GROUP BY k.id_kelompok_kategori
        ORDER BY k.id_kelompok_kategori DESC
    ");
    $stmt->execute([$id_sekolah]);
    $kelompok = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $kelompok = [];
}

$jumlahHapus = 0;
try {
    $jumlahHapus = $pdo->query("SELECT COUNT(*) FROM tb_kategori WHERE is_delete = 1")->fetchColumn();
} catch (Exception $e) {
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelompok Kategori - PosKasir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f0f2f5;
            font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background: linear-gradient(180deg, #1e2a3a 0%, #2d3e50 100%);
            z-index: 1000;
            transition: width 0.3s ease, transform 0.3s ease;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 20px 18px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            white-space: nowrap;
            min-height: 70px;
        }

        .sidebar-brand .brand-icon {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, #0d6efd, #0dcaf0);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1rem;
            color: white;
        }

        .sidebar-brand .brand-text {
            overflow: hidden;
        }

        .sidebar-brand .brand-text h6 {
            color: white;
            font-weight: 700;
            margin: 0;
            font-size: 1rem;
        }

        .sidebar-brand .brand-text small {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.75rem;
        }

        .sidebar-nav {
            flex: 1;
            padding: 12px 0;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
        }

        .nav-label {
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.35);
            padding: 12px 20px 4px;
            white-space: nowrap;
            transition: opacity 0.2s;
        }

        .sidebar.collapsed .nav-label {
            opacity: 0;
        }

        .nav-item a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 18px;
            color: rgba(255, 255, 255, 0.65);
            text-decoration: none;
            border-radius: 8px;
            margin: 2px 10px;
            transition: all 0.2s;
            white-space: nowrap;
            position: relative;
        }

        .nav-item a:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .nav-item a.active {
            background: linear-gradient(135deg, #0d6efd, #0dcaf0);
            color: white;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.4);
        }

        .nav-item a .nav-icon {
            width: 20px;
            text-align: center;
            font-size: 0.95rem;
            flex-shrink: 0;
        }

        .nav-item a .nav-text {
            font-size: 0.875rem;
            font-weight: 500;
            overflow: hidden;
        }

        .sidebar.collapsed .nav-item a {
            justify-content: center;
            margin: 2px 8px;
            padding: 11px;
        }

        .sidebar.collapsed .nav-item a .nav-text {
            display: none;
        }

        .sidebar.collapsed .nav-label {
            padding: 12px 0 4px;
            text-align: center;
        }

        .sidebar-divider {
            border-color: rgba(255, 255, 255, 0.1);
            margin: 8px 16px;
        }

        .nav-item a.logout {
            color: #ff6b6b;
        }

        .nav-item a.logout:hover {
            background: rgba(255, 107, 107, 0.15);
            color: #ff6b6b;
        }

        .nav-item a.restore-link {
            color: #20c997;
        }

        .nav-item a.restore-link:hover {
            background: rgba(32, 201, 151, 0.15);
            color: #20c997;
        }

        .restore-badge {
            background: #dc3545;
            color: white;
            font-size: 0.6rem;
            font-weight: 700;
            border-radius: 10px;
            padding: 1px 6px;
            min-width: 18px;
            text-align: center;
            line-height: 1.4;
            margin-left: auto;
        }

        .sidebar.collapsed .restore-badge {
            position: absolute;
            top: 6px;
            right: 6px;
            font-size: 0.55rem;
            padding: 1px 4px;
        }

        .nav-item a.user-mgmt {
            color: #fbbf24;
        }

        .nav-item a.user-mgmt:hover {
            background: rgba(251, 191, 36, 0.15);
            color: #fbbf24;
        }

        /* ── TOPBAR ── */
        .topbar {
            position: fixed;
            top: 0;
            right: 0;
            left: 250px;
            height: 65px;
            background: white;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            z-index: 900;
            transition: left 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .topbar.expanded {
            left: 70px;
        }

        .toggle-btn {
            width: 36px;
            height: 36px;
            border: none;
            background: #f0f2f5;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #555;
            transition: background 0.2s;
        }

        .toggle-btn:hover {
            background: #e2e6ea;
        }

        .profile-badge {
            background: #f0f2f5;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.875rem;
            cursor: pointer;
        }

        .main-content {
            margin-left: 250px;
            padding-top: 65px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        .main-content.expanded {
            margin-left: 70px;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        /* ── TABLE CARD ── */
        .table-card {
            background: white;
            border-radius: 14px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .table-card .table-header {
            padding: 16px 20px;
            border-bottom: 1px solid #f0f2f5;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }

        .table thead th {
            background: #f8f9fa;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6c757d;
            font-weight: 700;
            border: none;
            padding: 12px 16px;
        }

        .table tbody td {
            vertical-align: middle;
            border-color: #f0f2f5;
            padding: 13px 16px;
            font-size: 0.875rem;
        }

        .table tbody tr:hover {
            background: #f8f9ff;
        }

        .search-wrapper {
            position: relative;
        }

        .search-wrapper .search-icon {
            position: absolute;
            left: 11px;
            top: 50%;
            transform: translateY(-50%);
            color: #adb5bd;
            font-size: 0.8rem;
            pointer-events: none;
        }

        .search-wrapper input {
            padding-left: 32px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            height: 36px;
            width: 220px;
            font-size: 0.875rem;
            font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .search-wrapper input:focus {
            outline: none;
            border-color: #0d6efd;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.12);
        }

        #noResult {
            display: none;
        }

        /* ── STATS CARD ── */
        .stat-card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
        }

        /* ── TOAST ── */
        .toast-wrap {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 9999;
        }

        .toast-inner {
            background: white;
            border-radius: 10px;
            padding: 12px 18px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.875rem;
            font-weight: 500;
            min-width: 240px;
        }

        .toast-inner.success {
            border-left: 4px solid #20c997;
        }

        .toast-inner.error {
            border-left: 4px solid #ff4757;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 250px !important;
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .sidebar-overlay.active {
                display: block;
            }

            .topbar {
                left: 0 !important;
            }

            .main-content {
                margin-left: 0 !important;
            }

            .search-wrapper input {
                width: 160px;
            }
        }
    </style>
</head>

<body>

    <!-- Toast -->
    <div class="toast-wrap" id="toastWrap" style="display:none;">
        <div class="toast-inner" id="toastInner"></div>
    </div>

    <!-- ══ MODAL TAMBAH ══ -->
    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-plus-circle me-2 text-primary"></i>Tambah Kelompok Kategori
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="alertTambah" class="alert d-none mb-3"></div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Kelompok <span class="text-danger">*</span></label>
                        <input type="text" id="tambah_nama" class="form-control"
                            placeholder="Contoh: Perlengkapan Sekolah">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Keterangan</label>
                        <input type="text" id="tambah_keterangan" class="form-control"
                            placeholder="Keterangan (opsional)">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="btnTambahSimpan">
                        <span id="btnTambahText"><i class="fas fa-save me-1"></i> Simpan</span>
                        <span id="btnTambahSpinner" class="d-none"><span
                                class="spinner-border spinner-border-sm me-1"></span> Menyimpan...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ══ MODAL EDIT ══ -->
    <div class="modal fade" id="modalEdit" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-edit me-2 text-warning"></i>Edit Kelompok Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_id">
                    <div id="alertEdit" class="alert d-none mb-3"></div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Kelompok <span class="text-danger">*</span></label>
                        <input type="text" id="edit_nama" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Keterangan</label>
                        <input type="text" id="edit_keterangan" class="form-control"
                            placeholder="Keterangan (opsional)">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-warning text-white" id="btnEditSimpan">
                        <span id="btnEditText"><i class="fas fa-save me-1"></i> Simpan Perubahan</span>
                        <span id="btnEditSpinner" class="d-none"><span
                                class="spinner-border spinner-border-sm me-1"></span> Menyimpan...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ══ MODAL HAPUS ══ -->
    <div class="modal fade" id="modalHapus" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger"><i class="fas fa-trash me-2"></i>Hapus Kelompok</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="hapus_id">
                    <p>Yakin ingin menghapus kelompok <strong id="hapus_nama"></strong>?</p>
                    <p class="text-muted small">Kelompok yang masih memiliki kategori tidak bisa dihapus.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="btnHapusOk"><i class="fas fa-trash me-1"></i>
                        Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Overlay mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- ══ SIDEBAR ══ -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon"><i class="fas fa-cash-register"></i></div>
            <div class="brand-text">
                <h6>PosKasir</h6><small>Administrator</small>
            </div>
        </div>
        <div class="sidebar-nav">
            <div class="nav-label">Menu Utama</div>
            <div class="nav-item"><a href="dashboard.php"><span class="nav-icon"><i
                            class="fas fa-tachometer-alt"></i></span><span class="nav-text">Dashboard</span></a></div>
            <div class="nav-item"><a href="master_barang.php"><span class="nav-icon"><i
                            class="fas fa-box"></i></span><span class="nav-text">Master Barang</span></a></div>
            <div class="nav-item"><a href="kategori.php"><span class="nav-icon"><i class="fas fa-tags"></i></span><span
                        class="nav-text">Kategori</span></a></div>
            <div class="nav-item"><a href="kelompok_kategori.php" class="active"><span class="nav-icon"><i
                            class="fas fa-layer-group"></i></span><span class="nav-text">Kelompok Kategori</span></a>
            </div>
            <div class="nav-item"><a href="pelanggan.php"><span class="nav-icon"><i
                            class="fas fa-users"></i></span><span class="nav-text">Pelanggan</span></a></div>

            <div class="nav-label">Transaksi</div>
            <div class="nav-item"><a href="pembelian.php"><span class="nav-icon"><i
                            class="fas fa-truck"></i></span><span class="nav-text">Pembelian</span></a></div>
            <div class="nav-item"><a href="supplier.php"><span class="nav-icon"><i
                            class="fas fa-industry"></i></span><span class="nav-text">Supplier</span></a></div>

            <div class="nav-label">Data</div>
            <div class="nav-item">
                <a href="restore_kategori.php" class="restore-link">
                    <span class="nav-icon"><i class="fas fa-tags"></i></span>
                    <span class="nav-text">Restore Kategori</span>
                    <?php if ($jumlahHapus > 0): ?>
                        <span class="restore-badge"><?= $jumlahHapus ?></span>
                    <?php endif; ?>
                </a>
            </div>

            <div class="nav-label">Sistem</div>
            <div class="nav-item"><a href="manajemen_user.php" class="user-mgmt"><span class="nav-icon"><i
                            class="fas fa-user-shield"></i></span><span class="nav-text">Manajemen User</span></a></div>
            <div class="nav-item"><a href="setting.php"><span class="nav-icon"><i class="fas fa-cogs"></i></span><span
                        class="nav-text">Setting</span></a></div>
            <hr class="sidebar-divider">
            <div class="nav-item"><a href="logout.php" class="logout"><span class="nav-icon"><i
                            class="fas fa-sign-out-alt"></i></span><span class="nav-text">Logout</span></a></div>
        </div>
    </div>

    <!-- ══ TOPBAR ══ -->
    <div class="topbar" id="topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="toggle-btn" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
            <h6 class="mb-0 text-secondary fw-semibold">Kelompok Kategori</h6>
        </div>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-dark gap-2"
                data-bs-toggle="dropdown">
                <div class="profile-badge"><i
                        class="fas fa-user-circle me-2 text-primary"></i><?= htmlspecialchars($nama) ?></div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2 text-primary"></i> Profil Saya</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item text-danger" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>
                        Logout</a></li>
            </ul>
        </div>
    </div>

    <!-- ══ MAIN CONTENT ══ -->
    <div class="main-content" id="mainContent">
        <div class="p-4">

            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-1">Kelompok Kategori</h4>
                    <p class="text-muted mb-0">Kelola pengelompokan kategori barang</p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <div class="search-wrapper">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" id="searchKelompok" placeholder="Cari kelompok...">
                    </div>
                    <button class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="fas fa-plus me-2"></i> Tambah Kelompok
                    </button>
                </div>
            </div>

            <!-- Stats -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card stat-card p-3" style="background: linear-gradient(135deg, #0d6efd, #0dcaf0);">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-white">
                                <p class="mb-1 small opacity-75">Total Kelompok</p>
                                <h3 class="fw-bold mb-0"><?= count($kelompok) ?></h3>
                            </div>
                            <div
                                style="width:48px;height:48px;background:rgba(255,255,255,0.2);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-layer-group text-white fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card stat-card p-3" style="background: linear-gradient(135deg, #198754, #20c997);">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-white">
                                <p class="mb-1 small opacity-75">Total Kategori Terhubung</p>
                                <h3 class="fw-bold mb-0"><?= array_sum(array_column($kelompok, 'jumlah_kategori')) ?>
                                </h3>
                            </div>
                            <div
                                style="width:48px;height:48px;background:rgba(255,255,255,0.2);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-tags text-white fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card stat-card p-3" style="background: linear-gradient(135deg, #6f42c1, #d63384);">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-white">
                                <p class="mb-1 small opacity-75">Kelompok Kosong</p>
                                <h3 class="fw-bold mb-0">
                                    <?= count(array_filter($kelompok, fn($k) => $k['jumlah_kategori'] == 0)) ?>
                                </h3>
                            </div>
                            <div
                                style="width:48px;height:48px;background:rgba(255,255,255,0.2);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-inbox text-white fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel -->
            <div class="table-card">
                <div class="table-header">
                    <h6 class="fw-bold mb-0"><i class="fas fa-list me-2 text-primary"></i>Daftar Kelompok Kategori</h6>
                    <span class="badge bg-primary rounded-pill"><?= count($kelompok) ?> kelompok</span>
                </div>

                <?php if (count($kelompok) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="tabelKelompok">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kelompok</th>
                                    <th>Keterangan</th>
                                    <th class="text-center">Jumlah Kategori</th>
                                    <th class="text-center" width="120">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($kelompok as $k): ?>
                                    <tr id="row-<?= $k['id_kelompok_kategori'] ?>">
                                        <td class="text-muted"><?= $no++ ?></td>
                                        <td class="fw-semibold"><?= htmlspecialchars($k['nama']) ?></td>
                                        <td class="text-muted"><?= htmlspecialchars($k['keterangan'] ?? '-') ?></td>
                                        <td class="text-center">
                                            <?php if ($k['jumlah_kategori'] > 0): ?>
                                                <a href="kategori.php"
                                                    class="badge bg-primary-subtle text-primary text-decoration-none fw-semibold">
                                                    <?= $k['jumlah_kategori'] ?> kategori
                                                </a>
                                            <?php else: ?>
                                                <span class="badge bg-secondary-subtle text-secondary fw-semibold">Kosong</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-warning"
                                                onclick="openEdit(<?= $k['id_kelompok_kategori'] ?>, '<?= htmlspecialchars(addslashes($k['nama'])) ?>', '<?= htmlspecialchars(addslashes($k['keterangan'] ?? '')) ?>')">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger ms-1"
                                                onclick="openHapus(<?= $k['id_kelompok_kategori'] ?>, '<?= htmlspecialchars(addslashes($k['nama'])) ?>')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div id="noResult" class="text-center text-muted py-4">
                        <i class="fas fa-search fa-2x mb-2 d-block opacity-50"></i>
                        <p class="mb-0">Tidak ada kelompok yang cocok</p>
                    </div>
                <?php else: ?>
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-layer-group fa-3x mb-3 d-block opacity-50"></i>
                        <p class="mb-1">Belum ada data kelompok kategori</p>
                        <button class="btn btn-primary btn-sm rounded-pill px-4 mt-2" data-bs-toggle="modal"
                            data-bs-target="#modalTambah">
                            <i class="fas fa-plus me-1"></i> Tambah Sekarang
                        </button>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // ── SIDEBAR ──
        const sidebar = document.getElementById('sidebar');
        const topbar = document.getElementById('topbar');
        const mainContent = document.getElementById('mainContent');
        const overlay = document.getElementById('sidebarOverlay');
        const isMobile = () => window.innerWidth <= 768;

        function toggleSidebar() {
            if (isMobile()) { sidebar.classList.toggle('mobile-open'); overlay.classList.toggle('active'); }
            else { sidebar.classList.toggle('collapsed'); topbar.classList.toggle('expanded'); mainContent.classList.toggle('expanded'); }
        }
        window.addEventListener('resize', () => { if (!isMobile()) { sidebar.classList.remove('mobile-open'); overlay.classList.remove('active'); } });

        // ── TOAST ──
        let toastTimer;
        function showToast(msg, type = 'success') {
            clearTimeout(toastTimer);
            const wrap = document.getElementById('toastWrap');
            const inner = document.getElementById('toastInner');
            inner.className = 'toast-inner ' + type;
            inner.innerHTML = (type === 'success'
                ? '<i class="fas fa-check-circle" style="color:#20c997;"></i>'
                : '<i class="fas fa-exclamation-circle" style="color:#ff4757;"></i>') + ' ' + msg;
            wrap.style.display = 'block';
            toastTimer = setTimeout(() => { wrap.style.display = 'none'; }, 2500);
        }

        // ── AJAX ──
        async function postAction(data) {
            const fd = new FormData();
            for (const k in data) fd.append(k, data[k]);
            const res = await fetch('kelompok_kategori.php', { method: 'POST', body: fd });
            return await res.json();
        }

        // ── TAMBAH ──
        document.getElementById('btnTambahSimpan').addEventListener('click', async function () {
            const nama = document.getElementById('tambah_nama').value.trim();
            const keterangan = document.getElementById('tambah_keterangan').value.trim();
            const alertBox = document.getElementById('alertTambah');
            if (!nama) { alertBox.className = 'alert alert-danger mb-3'; alertBox.textContent = '❌ Nama kelompok wajib diisi!'; return; }

            const btnText = document.getElementById('btnTambahText');
            const btnSpinner = document.getElementById('btnTambahSpinner');
            this.disabled = true; btnText.classList.add('d-none'); btnSpinner.classList.remove('d-none');

            const res = await postAction({ action: 'tambah', nama_kelompok: nama, keterangan });
            this.disabled = false; btnText.classList.remove('d-none'); btnSpinner.classList.add('d-none');

            if (res.success) {
                bootstrap.Modal.getInstance(document.getElementById('modalTambah')).hide();
                document.getElementById('tambah_nama').value = '';
                document.getElementById('tambah_keterangan').value = '';
                alertBox.className = 'alert d-none mb-3';
                showToast(res.message);
                setTimeout(() => location.reload(), 800);
            } else {
                alertBox.className = 'alert alert-danger mb-3';
                alertBox.textContent = '❌ ' + res.message;
            }
        });

        // Reset alert saat modal ditutup
        document.getElementById('modalTambah').addEventListener('hidden.bs.modal', () => {
            document.getElementById('alertTambah').className = 'alert d-none mb-3';
        });

        // ── EDIT ──
        function openEdit(id, nama, keterangan) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_keterangan').value = keterangan;
            document.getElementById('alertEdit').className = 'alert d-none mb-3';
            new bootstrap.Modal(document.getElementById('modalEdit')).show();
        }

        document.getElementById('btnEditSimpan').addEventListener('click', async function () {
            const id = document.getElementById('edit_id').value;
            const nama = document.getElementById('edit_nama').value.trim();
            const keterangan = document.getElementById('edit_keterangan').value.trim();
            const alertBox = document.getElementById('alertEdit');
            if (!nama) { alertBox.className = 'alert alert-danger mb-3'; alertBox.textContent = '❌ Nama kelompok wajib diisi!'; return; }

            const btnText = document.getElementById('btnEditText');
            const btnSpinner = document.getElementById('btnEditSpinner');
            this.disabled = true; btnText.classList.add('d-none'); btnSpinner.classList.remove('d-none');

            const res = await postAction({ action: 'edit', id_kelompok: id, nama_kelompok: nama, keterangan });
            this.disabled = false; btnText.classList.remove('d-none'); btnSpinner.classList.add('d-none');

            if (res.success) {
                bootstrap.Modal.getInstance(document.getElementById('modalEdit')).hide();
                showToast(res.message);
                // Update baris tanpa reload
                const row = document.getElementById('row-' + id);
                if (row) {
                    row.cells[1].textContent = nama;
                    row.cells[2].textContent = keterangan || '-';
                }
            } else {
                alertBox.className = 'alert alert-danger mb-3';
                alertBox.textContent = '❌ ' + res.message;
            }
        });

        // ── HAPUS ──
        function openHapus(id, nama) {
            document.getElementById('hapus_id').value = id;
            document.getElementById('hapus_nama').textContent = nama;
            new bootstrap.Modal(document.getElementById('modalHapus')).show();
        }

        document.getElementById('btnHapusOk').addEventListener('click', async function () {
            const id = document.getElementById('hapus_id').value;
            const res = await postAction({ action: 'hapus', id_kelompok: id });
            bootstrap.Modal.getInstance(document.getElementById('modalHapus')).hide();
            if (res.success) {
                showToast(res.message);
                const row = document.getElementById('row-' + id);
                if (row) { row.style.transition = 'opacity 0.4s'; row.style.opacity = '0'; setTimeout(() => row.remove(), 400); }
            } else {
                showToast(res.message, 'error');
            }
        });

        // ── SEARCH ──
        document.getElementById('searchKelompok').addEventListener('input', function () {
            const keyword = this.value.toLowerCase().trim();
            const rows = document.querySelectorAll('#tabelKelompok tbody tr');
            let visible = 0;
            rows.forEach(row => {
                const match = row.innerText.toLowerCase().includes(keyword);
                row.style.display = match ? '' : 'none';
                if (match) visible++;
            });
            document.getElementById('noResult').style.display = visible === 0 ? 'block' : 'none';
        });
    </script>
</body>

</html>