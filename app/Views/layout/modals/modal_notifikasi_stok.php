<!-- Modal Notifikasi Stok Menipis & Kritis -->
<div class="modal fade" id="modalNotifikasiStok" tabindex="-1" aria-labelledby="modalNotifikasiStokLabel" aria-hidden="true" style="z-index: 1080;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom py-3">
                <div class="d-flex align-items-center">
                    <div class="bg-light text-warning border rounded-3 d-flex align-items-center justify-content-center me-3" style="width: 38px; height: 38px;">
                        <i class="pe-7s-bell fs-3"></i>
                    </div>
                    <div>
                        <h5 class="modal-title font-weight-bold text-dark fs-6 mb-0" id="modalNotifikasiStokLabel">Peringatan Stok Menipis & Kritis</h5>
                        <small class="text-muted fs-8">Menampilkan daftar inventaris dengan jumlah stok di bawah batas kritis</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3.5">
                <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center justify-content-between mb-3 p-2.5 fs-7" role="alert">
                    <div class="d-flex align-items-center me-2">
                        <i class="pe-7s-info me-2 fs-4 text-warning flex-shrink-0"></i>
                        <div>Item di bawah ini membutuhkan pengadaan ulang (*restock*). Klik tombol <strong>Restok</strong> untuk membuka modul Kasir mutasi IN.</div>
                    </div>
                </div>

                <div class="table-responsive rounded border bg-white" style="max-height: 380px; overflow-y: auto;">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light sticky-top" style="z-index: 2;">
                            <tr class="fs-8 text-uppercase text-secondary fw-bold">
                                <th class="ps-3 py-2.5">Produk</th>
                                <th class="py-2.5">Kategori</th>
                                <th class="py-2.5 text-center">Harga Beli</th>
                                <th class="py-2.5 text-center">Sisa Stok</th>
                                <th class="text-end pe-3 py-2.5">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="notifStokListTableBody">
                            <!-- Dynamic rows rendered via JS -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-light border-top py-2.5 px-3 d-flex justify-content-between">
                <small class="text-muted fs-8" id="notifStokFooterCount">0 item stok kritis ditemukan</small>
                <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
