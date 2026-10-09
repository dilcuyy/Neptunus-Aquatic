<?php
$modAkunModel = new \App\Models\AkunModel();
$modUser = $modAkunModel->find(1);
$modFoto = $modUser['foto'] ?? '1.jpg';
$modFotoUrl = base_url('assets/images/avatars/' . $modFoto);
if (!empty($modFoto) && file_exists(FCPATH . 'uploads/profile/' . $modFoto)) {
    $modFotoUrl = base_url('uploads/profile/' . $modFoto);
}
?>
<!-- Modal Edit Profil Administrator -->
<div class="modal fade" id="modalProfil" tabindex="-1" aria-labelledby="modalProfilLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-modern">
        <div class="modal-content modal-content-modern">
            <div class="modal-header-modern">
                <div class="d-flex align-items-center gap-2.5">
                    <div class="modal-header-icon">
                        <i class="pe-7s-user"></i>
                    </div>
                    <div>
                        <h5 class="modal-title-text" id="modalProfilLabel">Edit Profil Administrator</h5>
                        <div class="modal-subtitle-text">Perbarui informasi identitas dan foto akun Anda</div>
                    </div>
                </div>
                <button type="button" class="modal-btn-close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">
                    <i class="pe-7s-close"></i>
                </button>
            </div>
            <form id="formUpdateProfil" enctype="multipart/form-data">
                <div class="modal-body-modern">
                    <div class="text-center mb-3.5">
                        <div class="position-relative d-inline-block">
                            <img id="avatarPreview" src="<?= $modFotoUrl ?>" class="modal-avatar-preview" alt="Avatar">
                            <label for="fotoInput" class="modal-avatar-btn" title="Ganti Foto Profil">
                                <i class="pe-7s-camera"></i>
                            </label>
                            <input type="file" id="fotoInput" name="foto" class="d-none" accept="image/*">
                        </div>
                        <div class="small text-muted mt-1.5" style="font-size: 0.75rem;">Format JPG, PNG atau WebP (Maks. 2MB)</div>
                    </div>

                    <div class="row g-2.5">
                        <div class="col-12">
                            <label class="modal-label" for="profilNamaLengkap">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control modal-input" name="nama_lengkap" id="profilNamaLengkap" value="<?= esc($modUser['nama_lengkap'] ?? '') ?>" placeholder="Nama lengkap admin" required maxlength="100" autocomplete="off">
                        </div>
                        <div class="col-md-6">
                            <label class="modal-label" for="profilUsername">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control modal-input" name="username" id="profilUsername" value="<?= esc($modUser['username'] ?? '') ?>" placeholder="Username login" required maxlength="50" autocomplete="off">
                        </div>
                        <div class="col-md-6">
                            <label class="modal-label" for="profilNomorHp">Nomor WhatsApp</label>
                            <input type="text" class="form-control modal-input" name="nomor_hp" id="profilNomorHp" value="<?= esc($modUser['nomor_hp'] ?? '') ?>" placeholder="08xxxxxxxxxx" maxlength="20" autocomplete="off" inputmode="tel">
                        </div>
                    </div>
                </div>
                <div class="modal-footer-modern">
                    <button type="button" class="modal-btn-secondary" data-bs-dismiss="modal" data-dismiss="modal">Batal</button>
                    <button type="submit" class="modal-btn-primary">
                        <i class="pe-7s-check"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
