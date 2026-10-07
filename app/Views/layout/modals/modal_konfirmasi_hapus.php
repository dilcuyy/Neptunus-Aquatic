<!-- Modal Konfirmasi Hapus Global -->
<div class="modal fade" id="modalKonfirmasiHapus" tabindex="-1" aria-labelledby="modalKonfirmasiHapusLabel" aria-hidden="true" style="z-index: 1085;">
    <div class="modal-dialog modal-dialog-centered modal-sm modal-dialog-modern">
        <div class="modal-content modal-content-modern">
            <div class="modal-header-modern">
                <div class="d-flex align-items-center gap-2.5">
                    <div class="modal-header-icon" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">
                        <i class="pe-7s-trash"></i>
                    </div>
                    <div>
                        <h5 class="modal-title-text" id="konfirmasiJudul">Konfirmasi Hapus</h5>
                        <div class="modal-subtitle-text">Tindakan ini tidak dapat dibatalkan</div>
                    </div>
                </div>
                <button type="button" class="modal-btn-close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">
                    <i class="pe-7s-close"></i>
                </button>
            </div>
            <div class="modal-body-modern">
                <p class="text-muted mb-0" style="font-size: 0.8125rem; line-height: 1.5;" id="konfirmasiText">Apakah Anda yakin ingin menghapus data ini?</p>
            </div>
            <div class="modal-footer-modern">
                <button type="button" class="modal-btn-secondary" data-bs-dismiss="modal" data-dismiss="modal">Batal</button>
                <button type="button" class="modal-btn-danger" id="btnEksekusiHapus">
                    <i class="pe-7s-trash"></i>
                    <span>Ya, Hapus Data</span>
                </button>
            </div>
        </div>
    </div>
</div>
