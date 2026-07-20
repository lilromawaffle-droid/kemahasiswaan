<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Isi Testimoni Alumni' ?> | Fakultas Industri Kreatif</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { 
            font-family: 'Montserrat', sans-serif; 
            background: #f8fafc; 
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        /* ── Centered Container ── */
        .form-container-wrapper {
            width: 100%;
            max-width: 850px;
        }

        /* ── Header Box ── */
        .form-header-box {
            background: linear-gradient(135deg, #f97316 0%, #fdba74 100%);
            color: white;
            padding: 2.5rem;
            border-radius: 16px 16px 0 0;
            box-shadow: 0 4px 15px rgba(249, 115, 22, 0.15);
        }
        .form-header-box h1 { font-size: 1.75rem; font-weight: 800; margin: 0; }
        .form-header-box p { margin: 0.5rem 0 0; font-size: 0.9rem; opacity: 0.9; font-weight: 500; }

        /* ── Form Card ── */
        .form-card {
            background: white; 
            border-radius: 0 0 16px 16px; 
            padding: 2.5rem;
            box-shadow: 0 10px 30px rgba(0,0,0,.04); 
            border: 1px solid #e2e8f0;
            border-top: none;
        }

        .form-label { font-weight: 600; color: #2C3E50; font-size: 0.88rem; }
        .form-control, .form-select {
            border: 1px solid #cbd5e1; border-radius: 10px; padding: 0.7rem 1rem; font-size: 0.9rem;
            transition: all 0.3s; color: #334155;
        }
        .form-control:focus, .form-select:focus {
            border-color: #f97316; box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.15);
        }

        .img-preview { width: 90px; height: 90px; object-fit: cover; border-radius: 50%; border: 3px solid #f97316; margin-top: 10px; }

        /* ── Action Buttons ── */
        .btn-save {
            background: linear-gradient(135deg, #f97316, #ea580c); color: white; border: none;
            padding: .75rem 2rem; border-radius: 10px; font-weight: 700; font-size: .9rem;
            cursor: pointer; transition: all .25s; text-decoration: none; display: inline-flex;
            align-items: center; gap: .5rem; box-shadow: 0 4px 12px rgba(249, 115, 22, 0.2);
        }
        .btn-save:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(249,115,22,.35); color: white; }
        
        .btn-cancel {
            background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1;
            padding: .75rem 2rem; border-radius: 10px; font-weight: 600; font-size: .9rem;
            cursor: pointer; transition: all .25s; text-decoration: none; display: inline-flex;
            align-items: center; gap: .5rem;
        }
        .btn-cancel:hover { background: #e2e8f0; color: #1e293b; }

        .required-star { color: #ef4444; }
    </style>
</head>
<body>

    <div class="form-container-wrapper">
        <div class="form-header-box d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1><?= isset($title) ? $title : 'Bagikan Ceritamu' ?></h1>
                <p>Ulasan dan pengalaman berharga Anda selama kuliah di Fakultas Industri Kreatif</p>
            </div>
            <div class="user-badge bg-white px-3 py-2 rounded-pill d-flex align-items-center gap-2 shadow-sm">
                <i class="fas fa-user-circle" style="color: #ea580c;"></i>
                <span style="font-size: 0.85rem; font-weight: 700; color: #1e293b;"><?= $this->session->userdata('nama') ? $this->session->userdata('nama') : 'Alumni' ?></span>
            </div>
        </div>

        <div class="form-card">
            <?php
            $action = isset($item) ? 'testimoni/edit/' . $item->id : 'testimoni/simpan';
            echo form_open_multipart($action);
            ?>
            
            <div class="row mb-3">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label for="nama" class="form-label mb-1">Nama Lengkap <span class="required-star">*</span></label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?= set_value('nama', isset($item) ? $item->nama : ($this->session->userdata('nama') ? $this->session->userdata('nama') : '')) ?>" placeholder="Contoh: Mitchela Smith" required>
                    <?= form_error('nama', '<small class="text-danger">', '</small>') ?>
                </div>
                <div class="col-md-6">
                    <label for="posisi" class="form-label mb-1">Pekerjaan / Program Studi <span class="required-star">*</span></label>
                    <input type="text" class="form-control" id="posisi" name="posisi" value="<?= set_value('posisi', isset($item) ? $item->posisi : '') ?>" placeholder="Contoh: UI/UX Design / S1 Desain Komunikasi Visual" required>
                    <?= form_error('posisi', '<small class="text-danger">', '</small>') ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="testimoni" class="form-label mb-1">Testimoni / Kesan Selama Kuliah <span class="required-star">*</span></label>
                <textarea class="form-control" id="testimoni" name="testimoni" rows="5" placeholder="Tuliskan pengalaman inspiratif, kritik membangun, atau kesan pesan Anda selama menempuh pendidikan..." required><?= set_value('testimoni', isset($item) ? $item->testimoni : '') ?></textarea>
                <?= form_error('testimoni', '<small class="text-danger">', '</small>') ?>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-12">
                    <label for="rating" class="form-label mb-1">Rating Pengalaman Anda</label>
                    <select class="form-select" id="rating" name="rating">
                        <?php $curr_rating = isset($item) ? $item->rating : 5; ?>
                        <?php for($i=5; $i>=1; $i--): ?>
                            <option value="<?= $i ?>" <?= $curr_rating == $i ? 'selected' : '' ?>><?= $i ?> Bintang <?= $i == 5 ? '(Sangat Puas)' : '' ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>

            <?php if($this->session->userdata('role') === 'admin'): ?>
            <div class="mb-3">
                <div class="form-check pt-2">
                    <input class="form-check-input" type="checkbox" id="aktif" name="aktif" value="1" <?= (!isset($item) || $item->aktif) ? 'checked' : '' ?>>
                    <label class="form-check-label form-label" for="aktif">
                        Tampilkan langsung di halaman utama Dashboard
                    </label>
                </div>
            </div>
            <?php endif; ?>

            <div class="row mb-3">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label for="linkedin" class="form-label mb-1">Tautan LinkedIn <span class="text-muted fw-normal">(Opsional)</span></label>
                    <input type="url" class="form-control" id="linkedin" name="linkedin" value="<?= set_value('linkedin', isset($item) ? $item->linkedin : '') ?>" placeholder="https://linkedin.com/in/username">
                </div>
                <div class="col-md-6">
                    <label for="pinterest" class="form-label mb-1">Portofolio / Website Personal <span class="text-muted fw-normal">(Opsional)</span></label>
                    <input type="url" class="form-control" id="pinterest" name="pinterest" value="<?= set_value('pinterest', isset($item) ? $item->pinterest : '') ?>" placeholder="https://pinterest.com/username atau web personal">
                </div>
            </div>

            <div class="mb-4 p-3 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                <div class="d-flex align-items-center gap-3">
                    <?php if ($this->session->userdata('foto') && file_exists('uploads/users/' . $this->session->userdata('foto'))): ?>
                        <img src="<?= base_url('uploads/users/' . $this->session->userdata('foto')) ?>" class="img-preview mt-0" style="width: 60px; height: 60px; border-width: 2px;" alt="Profile Photo">
                    <?php else: ?>
                        <div class="d-flex align-items-center justify-content-center bg-secondary text-white rounded-circle shadow-sm" style="width: 60px; height: 60px;">
                            <i class="fas fa-user fa-lg"></i>
                        </div>
                    <?php endif; ?>
                    <div>
                        <label class="form-label mb-1 d-block" style="color: #1e293b;">Foto Testimoni</label>
                        <small class="text-muted">Testimoni akan otomatis menggunakan foto dari profil akun Anda.</small>
                    </div>
                </div>
            </div>

            <hr class="my-4" style="color: #cbd5e1;">

            <div class="d-flex justify-content-end gap-2">
                <a href="<?= base_url('dashboard') ?>" class="btn-cancel">
                    <i class="fas fa-times"></i> Batal
                </a>
                <button type="submit" class="btn-save">
                    <i class="fas fa-paper-plane"></i> Kirim Testimoni
                </button>
            </div>

            <?= form_close() ?>
        </div>
    </div>

</body>
</html> 