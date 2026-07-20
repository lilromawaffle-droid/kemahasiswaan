<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Montserrat', sans-serif; background: #f0f2f5; }

        /* ── Sidebar ── */
        .admin-wrapper { display: flex; min-height: 100vh; }
        .admin-sidebar {
            width: 280px; background: linear-gradient(135deg, #2C3E50, #1a2632);
            color: white; position: fixed; height: 100vh; overflow-y: auto; z-index: 100;
        }
        .sidebar-header { padding: 2rem 1.5rem; border-bottom: 1px solid rgba(255,255,255,.1); }
        .sidebar-header h3 { margin: 0; font-size: 1.3rem; font-weight: 700; }
        .sidebar-header p  { margin: 0.5rem 0 0; font-size: 0.8rem; opacity: 0.7; }
        .sidebar-menu { padding: 1.5rem 0; }
        .sidebar-menu a {
            display: flex; align-items: center; gap: 1rem; padding: 0.8rem 1.5rem;
            color: rgba(255,255,255,0.8); text-decoration: none; transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }
        .sidebar-menu a:hover,
        .sidebar-menu a.active { background: rgba(230, 126, 34, 0.2); color: white; border-left-color: #E67E22; }
        .sidebar-menu a i { width: 20px; color: #E67E22; }
        .sidebar-menu .menu-divider { height: 1px; background: rgba(255,255,255,0.1); margin: 1rem 0; }
        
        /* ── Main ── */
        .admin-main { flex: 1; margin-left: 280px; padding: 2rem; }
        .admin-header {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 2rem; padding-bottom: 1.2rem; border-bottom: 2px solid #e8eaed;
        }
        .admin-header h1 { font-size: 1.8rem; font-weight: 700; color: #2C3E50; }
        .admin-header .user-info { display: flex; align-items: center; gap: 1rem; }
        .admin-header .user-info span { color: #666; font-size: .88rem; }
        .logout-btn {
            background: #e74c3c; color: white; padding: .45rem 1.3rem;
            border-radius: 25px; text-decoration: none; font-size: .85rem;
            transition: background .2s;
        }
        .logout-btn:hover { background: #c0392b; color: #fff; }

        /* ── Table Card & Tabs ── */
        .table-card {
            background: white; border-radius: 14px; padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0,0,0,.05); margin-top: 1rem;
        }
        .nav-tabs-custom {
            display: flex; gap: 1rem; border-bottom: 2px solid #e8eaed; margin-bottom: 1.5rem;
        }
        .tab-btn {
            background: none; border: none; padding: .75rem 1.2rem; font-size: .92rem;
            font-weight: 600; color: #7f8c8d; cursor: pointer; border-bottom: 3px solid transparent;
            transition: all .2s;
        }
        .tab-btn.active { color: #E67E22; border-bottom-color: #E67E22; }
        
        table { width: 100%; border-collapse: collapse; margin-top: .5rem; }
        th { font-weight: 700; color: #7f8c8d; text-align: left; padding: 1rem .8rem; border-bottom: 2px solid #f0f2f5; font-size: .88rem; }
        td { padding: 1rem .8rem; border-bottom: 1px solid #f0f2f5; font-size: .9rem; vertical-align: middle; color: #2c3e50; }
        tr:hover td { background-color: #fafbfc; }

        .logo-thumb { height: 45px; max-width: 120px; object-fit: contain; border-radius: 6px; }
        .logo-placeholder {
            width: 45px; height: 45px; background: #e8eaed; border-radius: 8px;
            display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: #95a5a6;
        }

        .toggle-btn {
            width: 46px; height: 24px; border-radius: 20px; background: #bdc3c7;
            position: relative; border: none; cursor: pointer; transition: background .25s;
        }
        .toggle-btn::after {
            content: ''; position: absolute; width: 18px; height: 18px; border-radius: 50%;
            background: white; top: 3px; left: 3px; transition: transform .25s;
            box-shadow: 0 1px 3px rgba(0,0,0,.2);
        }
        .toggle-btn.on { background: #2ecc71; }
        .toggle-btn.on::after { transform: translateX(22px); }

        .action-btns { display: flex; gap: .4rem; }
        .btn-edit {
            background: rgba(230, 126, 34, 0.1); color: #E67E22; border: none;
            padding: .4rem .9rem; border-radius: 8px; font-size: .8rem; font-weight: 600;
            text-decoration: none; display: inline-flex; align-items: center; gap: .3rem; transition: all .2s;
        }
        .btn-edit:hover { background: #E67E22; color: white; }
        .btn-del {
            background: rgba(231, 76, 60, 0.1); color: #e74c3c; border: none;
            width: 32px; height: 32px; border-radius: 8px; font-size: .85rem;
            cursor: pointer; display: inline-flex; align-items: center; justify-content: center; transition: all .2s;
        }
        .btn-del:hover { background: #e74c3c; color: white; }

        .btn-primary-custom {
            background: linear-gradient(135deg, #E67E22, #d35400); color: white; border: none;
            padding: .55rem 1.4rem; border-radius: 10px; font-weight: 600; font-size: .88rem;
            cursor: pointer; transition: all .25s; text-decoration: none; display: inline-flex;
            align-items: center; gap: .5rem;
        }
        .btn-primary-custom:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(230,126,34,.4); color: white; }

        .empty-state { text-align: center; padding: 3rem 1rem; color: #95a5a6; }
        .empty-state i { font-size: 3rem; margin-bottom: 1rem; color: #bdc3c7; }

        /* === MOBILE RESPONSIVE === */
        * { box-sizing: border-box; }
        html, body { overflow-x: hidden; max-width: 100%; }
        .mobile-topbar { display: none; position: fixed; top: 0; left: 0; right: 0; z-index: 1100; background: linear-gradient(135deg, #2C3E50, #1a2632); box-shadow: 0 2px 12px rgba(0,0,0,0.3); }
        .topbar-inner { display: flex; align-items: center; justify-content: space-between; height: 54px; padding: 0 0.75rem; gap: 0.5rem; }
        .hamburger-btn { display: none; background: rgba(255,255,255,0.15); color: white; border: none; border-radius: 8px; width: 38px; height: 38px; align-items: center; justify-content: center; font-size: 1.1rem; cursor: pointer; flex-shrink: 0; }
        .hamburger-btn:hover { background: rgba(230,126,34,0.6); }
        .topbar-right { display: flex; align-items: center; gap: 0.5rem; flex: 1; min-width: 0; justify-content: flex-end; }
        .topbar-username { display: flex; align-items: center; gap: 0.35rem; color: rgba(255,255,255,0.9); font-size: 0.78rem; font-weight: 500; flex: 1; min-width: 0; }
        .topbar-username i { color: #E67E22; font-size: 1rem; flex-shrink: 0; }
        .topbar-username .name-text { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block; min-width: 0; }
        .topbar-logout { background: #e74c3c; color: white; border: none; border-radius: 8px; padding: 0.38rem 0.8rem; font-size: 0.75rem; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 0.3rem; white-space: nowrap; flex-shrink: 0; }
        .topbar-logout:hover { background: #c0392b; color: white; }
        .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 999; backdrop-filter: blur(2px); }
        .sidebar-overlay.active { display: block; }
        @media (max-width: 768px) {
            .mobile-topbar { display: block; } .hamburger-btn { display: flex; }
            .admin-sidebar { position: fixed !important; left: -280px !important; z-index: 1000; transition: left 0.3s ease; width: 280px !important; }
            .admin-sidebar.open { left: 0 !important; }
            .admin-main { margin-left: 0 !important; padding: 1rem !important; padding-top: 4.5rem !important; max-width: 100vw; overflow-x: hidden; }
            .admin-header { flex-direction: column !important; align-items: stretch !important; gap: 0.75rem; }
            .admin-header h1 { font-size: 1.3rem !important; word-break: break-word; }
            .admin-header .user-info > span, .admin-header .user-info .logout-btn { display: none; }
        }
    </style>
</head>
<body>

    <!-- Mobile Topbar -->
    <div class="mobile-topbar" id="mobileTopbar">
        <div class="topbar-inner">
            <button class="hamburger-btn" id="hamburgerBtn" onclick="toggleSidebar()" aria-label="Toggle Menu">
                <i class="fas fa-bars" id="hamburgerIcon"></i>
            </button>
            <div class="topbar-right">
                <span class="topbar-username">
                    <i class="fas fa-user-circle"></i>
                    <span class="name-text"><?= $this->session->userdata('nama') ?></span>
                </span>
                <a href="<?= base_url('login/logout') ?>" class="topbar-logout">
                    <i class="fas fa-sign-out-alt"></i>Logout
                </a>
            </div>
        </div>
    </div>
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <div class="admin-wrapper">
        <!-- Sidebar -->
        <div class="admin-sidebar" id="adminSidebar">
            <div class="sidebar-header">
                <h3>Admin FIK</h3>
                <p>Manajemen Mitra & Recog</p>
            </div>
            
            <div class="sidebar-menu">
                <a href="<?= base_url('admin/proposal') ?>">
                    <i class="fas fa-file-alt"></i>
                    <span>Proposal</span>
                </a>
                <a href="<?= base_url('sertifikat/admin') ?>">
                    <i class="fas fa-certificate"></i>
                    <span>Sertifikat</span>
                </a>
                <a href="<?= base_url('tak_admin') ?>">
                    <i class="fas fa-file-signature"></i>
                    <span>TAK</span>
                </a>
                <a href="<?= base_url('berita/admin') ?>">
                    <i class="fas fa-newspaper"></i>
                    <span>Berita</span>
                </a>
                <a href="<?= base_url('admin/organisasi') ?>">
                    <i class="fas fa-users"></i>
                    <span>Organisasi</span>
                </a>
                <a href="<?= base_url('admin/mitra') ?>" class="active">
                    <i class="fas fa-handshake"></i>
                    <span>Mitra & Recog</span>
                </a>
                <a href="<?= base_url('admin/testimoni') ?>">
                    <i class="fas fa-comments"></i>
                    <span>Testimoni Alumni</span>
                </a>
                
                <div class="menu-divider"></div>
                
                <a href="<?= base_url('admin/history_log') ?>">
                    <i class="fas fa-history"></i>
                    <span>History Log</span>
                </a>
                
                <div class="menu-divider"></div>
                
                <a href="<?= base_url('dashboard') ?>">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali ke Dashboard</span>
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <main class="admin-main">
            <!-- Header -->
            <div class="admin-header">
                <h1><i class="fas fa-handshake" style="color:#E67E22; font-size:1.4rem;"></i> Manajemen Mitra & Recognitions</h1>
                <div class="user-info">
                    <span><i class="fas fa-user-circle me-2" style="color: #E67E22;"></i> <?= $this->session->userdata('nama') ?></span>
                    <a href="<?= base_url('login/logout') ?>" class="logout-btn">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a>
                </div>
            </div>

            <!-- Flash Messages -->
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success"><i class="fas fa-check-circle me-2"></i> <?= $this->session->flashdata('success') ?></div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i> <?= $this->session->flashdata('error') ?></div>
            <?php endif; ?>

            <div class="table-card">
                <!-- Navigation Tabs -->
                <div class="nav-tabs-custom">
                    <button class="tab-btn active" onclick="switchTab('mitra')">Mitra Kerjasama</button>
                    <button class="tab-btn" onclick="switchTab('recog')">International Recognitions</button>
                </div>

                <!-- MITRA TAB CONTENT -->
                <div id="tab-mitra" class="tab-content">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 style="font-weight:700; color:#2C3E50;">Daftar Mitra Kerjasama</h4>
                        <a href="<?= base_url('admin/mitra_tambah/mitra') ?>" class="btn-primary-custom">
                            <i class="fas fa-plus"></i> Tambah Mitra
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th style="width:60px;">Urutan</th>
                                    <th style="width:120px;">Logo</th>
                                    <th>Nama Mitra</th>
                                    <th>Fallback Icon</th>
                                    <th style="width:100px; text-align:center;">Tampil</th>
                                    <th style="width:150px; text-align:center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($mitra_list)): ?>
                                    <tr>
                                        <td colspan="6">
                                            <div class="empty-state">
                                                <i class="fas fa-handshake"></i>
                                                <p>Belum ada data mitra.</p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php else: foreach($mitra_list as $m): ?>
                                    <tr id="mitra-row-<?= $m->id ?>">
                                        <td style="text-align:center; font-weight:700; color:#E67E22;"><?= $m->urutan ?></td>
                                        <td>
                                            <?php if ($m->logo): ?>
                                                <img src="<?= base_url($m->logo) ?>" alt="<?= htmlspecialchars($m->name) ?>" class="logo-thumb" onerror="this.parentElement.innerHTML='<div class=\'logo-placeholder\'><i class=\'<?= htmlspecialchars($m->default_icon) ?>\'></i></div>'">
                                            <?php else: ?>
                                                <div class="logo-placeholder"><i class="<?= htmlspecialchars($m->default_icon) ?>"></i></div>
                                            <?php endif; ?>
                                        </td>
                                        <td style="font-weight:600; color:#2C3E50;"><?= htmlspecialchars($m->name) ?></td>
                                        <td><code><?= htmlspecialchars($m->default_icon) ?></code></td>
                                        <td style="text-align:center;">
                                            <button class="toggle-btn <?= $m->aktif ? 'on' : 'off' ?>" onclick="toggleStatus('mitra', <?= $m->id ?>)"></button>
                                        </td>
                                        <td>
                                            <div class="action-btns justify-content-center">
                                                <a href="<?= base_url('admin/mitra_edit/mitra/' . $m->id) ?>" class="btn-edit">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <button class="btn-del" data-bs-toggle="modal" data-bs-target="#deleteMitraModal<?= $m->id ?>">
                                                    <i class="fas fa-trash"></i>
                                                </button>

                                                <!-- Modal Hapus Mitra -->
                                                <div class="modal fade" id="deleteMitraModal<?= $m->id ?>" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered text-start">
                                                        <div class="modal-content border-0 shadow">
                                                            <div class="modal-header border-bottom-0">
                                                                <h5 class="modal-title fw-bold">Konfirmasi Hapus</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body text-center pt-2 pb-4">
                                                                <div class="mb-3">
                                                                    <i class="fas fa-exclamation-triangle text-danger" style="font-size: 3.5rem;"></i>
                                                                </div>
                                                                <p class="mb-1 text-dark" style="font-size: 1.1rem;">Hapus mitra kerjasama ini?</p>
                                                                <p class="text-muted small mb-0"><strong><?= htmlspecialchars($m->name) ?></strong> akan dihapus permanen.</p>
                                                            </div>
                                                            <div class="modal-footer border-top-0 justify-content-center pb-4">
                                                                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                                                                <a href="<?= base_url('admin/mitra_hapus/mitra/' . $m->id) ?>" class="btn btn-danger px-4">Ya, Hapus</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- RECOG TAB CONTENT -->
                <div id="tab-recog" class="tab-content" style="display:none;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 style="font-weight:700; color:#2C3E50;">Daftar International Recognitions</h4>
                        <a href="<?= base_url('admin/mitra_tambah/recog') ?>" class="btn-primary-custom">
                            <i class="fas fa-plus"></i> Tambah Recognition
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th style="width:60px;">Urutan</th>
                                    <th style="width:120px;">Logo</th>
                                    <th>Nama Recognition</th>
                                    <th>Fallback Icon</th>
                                    <th style="width:100px; text-align:center;">Tampil</th>
                                    <th style="width:150px; text-align:center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($recog_list)): ?>
                                    <tr>
                                        <td colspan="6">
                                            <div class="empty-state">
                                                <i class="fas fa-trophy"></i>
                                                <p>Belum ada data recognition.</p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php else: foreach($recog_list as $r): ?>
                                    <tr id="recog-row-<?= $r->id ?>">
                                        <td style="text-align:center; font-weight:700; color:#E67E22;"><?= $r->urutan ?></td>
                                        <td>
                                            <?php if ($r->logo): ?>
                                                <img src="<?= base_url($r->logo) ?>" alt="<?= htmlspecialchars($r->name) ?>" class="logo-thumb" onerror="this.parentElement.innerHTML='<div class=\'logo-placeholder\'><i class=\'<?= htmlspecialchars($r->default_icon) ?>\'></i></div>'">
                                            <?php else: ?>
                                                <div class="logo-placeholder"><i class="<?= htmlspecialchars($r->default_icon) ?>"></i></div>
                                            <?php endif; ?>
                                        </td>
                                        <td style="font-weight:600; color:#2C3E50;"><?= htmlspecialchars($r->name) ?></td>
                                        <td><code><?= htmlspecialchars($r->default_icon) ?></code></td>
                                        <td style="text-align:center;">
                                            <button class="toggle-btn <?= $r->aktif ? 'on' : 'off' ?>" onclick="toggleStatus('recog', <?= $r->id ?>)"></button>
                                        </td>
                                        <td>
                                            <div class="action-btns justify-content-center">
                                                <a href="<?= base_url('admin/mitra_edit/recog/' . $r->id) ?>" class="btn-edit">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <button class="btn-del" data-bs-toggle="modal" data-bs-target="#deleteRecogModal<?= $r->id ?>">
                                                    <i class="fas fa-trash"></i>
                                                </button>

                                                <!-- Modal Hapus Recog -->
                                                <div class="modal fade" id="deleteRecogModal<?= $r->id ?>" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered text-start">
                                                        <div class="modal-content border-0 shadow">
                                                            <div class="modal-header border-bottom-0">
                                                                <h5 class="modal-title fw-bold">Konfirmasi Hapus</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body text-center pt-2 pb-4">
                                                                <div class="mb-3">
                                                                    <i class="fas fa-exclamation-triangle text-danger" style="font-size: 3.5rem;"></i>
                                                                </div>
                                                                <p class="mb-1 text-dark" style="font-size: 1.1rem;">Hapus international recognition ini?</p>
                                                                <p class="text-muted small mb-0"><strong><?= htmlspecialchars($r->name) ?></strong> akan dihapus permanen.</p>
                                                            </div>
                                                            <div class="modal-footer border-top-0 justify-content-center pb-4">
                                                                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                                                                <a href="<?= base_url('admin/mitra_hapus/recog/' . $r->id) ?>" class="btn btn-danger px-4">Ya, Hapus</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Tab switching
        function switchTab(tabName) {
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(content => content.style.display = 'none');
            
            event.currentTarget.classList.add('active');
            document.getElementById('tab-' + tabName).style.display = 'block';
            localStorage.setItem('active_mitra_tab', tabName);
        }

        // Restore tab on reload
        window.addEventListener('DOMContentLoaded', () => {
            const activeTab = localStorage.getItem('active_mitra_tab') || 'mitra';
            const buttons = document.querySelectorAll('.tab-btn');
            if (activeTab === 'recog') {
                buttons[1].click();
            } else {
                buttons[0].click();
            }
        });

        // Toggle Status Aktif/Tampil
        function toggleStatus(type, id) {
            const btn = event.currentTarget;
            fetch('<?= base_url("admin/mitra_toggle/") ?>' + type + '/' + id, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    if (data.aktif) {
                        btn.className = 'toggle-btn on';
                    } else {
                        btn.className = 'toggle-btn off';
                    }
                } else {
                    alert('Gagal: ' + data.message);
                }
            })
            .catch(() => alert('Terjadi kesalahan koneksi.'));
        }

        // Mobile Sidebar Toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const icon = document.getElementById('hamburgerIcon');
            const isOpen = sidebar.classList.toggle('open');
            overlay.classList.toggle('active', isOpen);
            icon.className = isOpen ? 'fas fa-times' : 'fas fa-bars';
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
