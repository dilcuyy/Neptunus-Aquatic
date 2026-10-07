let confirmActionCallback = null;

function showToast(type, title, message) {
    const container = document.getElementById("toastContainer");
    if (!container) return;

    const toastId = "toast_" + Date.now();
    let bgColor = "#30b6ff"; // info blue
    let iconClass = "fa-info-circle";

    if (type === "success") {
        bgColor = "#3ac47d"; // success green
        iconClass = "fa-check";
    } else if (type === "danger" || type === "error") {
        bgColor = "#d92550"; // danger red
        iconClass = "fa-times-circle";
    } else if (type === "warning") {
        bgColor = "#f7b924"; // warning yellow
        iconClass = "fa-exclamation-triangle";
    } else if (type === "info") {
        bgColor = "#30b6ff"; // info cyan/blue
        iconClass = "fa-info-circle";
    }

    const toastHtml = `
        <div id="${toastId}" class="toast-item-template mb-2 p-3 text-white rounded-3 d-flex align-items-center justify-content-between position-relative"
             style="background-color: ${bgColor}; min-width: 290px; max-width: 360px; pointer-events: auto; transition: all 0.3s ease; box-shadow: 0 0.5rem 1.2rem rgba(0,0,0,0.18) !important;">
            <div class="d-flex align-items-center me-2">
                <div class="me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="font-size: 20px; width: 32px; height: 32px; background: rgba(255,255,255,0.22); border-radius: 50%;">
                    <i class="fa ${iconClass} text-white"></i>
                </div>
                <div>
                    <div class="fw-bold fs-6 text-white leading-tight mb-0">${title}</div>
                    <div class="fs-7 text-white text-opacity-90 leading-tight mt-0.5">${message}</div>
                </div>
            </div>
            <button type="button" class="btn-close btn-close-white ms-2 flex-shrink-0 align-self-start" onclick="document.getElementById('${toastId}').remove()" aria-label="Close" style="font-size: 10px;"></button>
        </div>
    `;

    container.insertAdjacentHTML("beforeend", toastHtml);
    setTimeout(() => {
        const el = document.getElementById(toastId);
        if (el) {
            el.style.opacity = "0";
            el.style.transform = "translateY(-10px)";
            setTimeout(() => el.remove(), 300);
        }
    }, 4000);
}

function showConfirmModal(title, text, onConfirm) {
    document.getElementById("konfirmasiJudul").textContent = title || "Konfirmasi Hapus";
    document.getElementById("konfirmasiText").innerHTML = text || "Apakah Anda yakin ingin menghapus data ini?";
    confirmActionCallback = onConfirm;
    showModalSafely("modalKonfirmasiHapus");
}

function showModalSafely(modalId) {
    const modalEl = document.getElementById(modalId);
    if (!modalEl) return;

    // Delegate to native trigger button if present
    const triggerBtn = document.querySelector(`[data-bs-target="#${modalId}"], [data-target="#${modalId}"]`);
    if (triggerBtn && typeof triggerBtn.click === 'function') {
        triggerBtn.click();
        return;
    }

    // Lock background scrolling
    document.body.classList.add('modal-open');
    document.body.style.overflow = 'hidden';

    const jq = window.jQuery || window.$;
    if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        let modalObj = bootstrap.Modal.getInstance(modalEl);
        if (!modalObj) {
            modalObj = new bootstrap.Modal(modalEl);
        }
        modalObj.show();
    } else if (jq && jq.fn && jq.fn.modal) {
        jq(modalEl).modal('show');
    } else {
        modalEl.classList.add('show');
        modalEl.style.display = 'block';
    }
}

function hideModalSafely(modalId) {
    const modalEl = document.getElementById(modalId);
    if (!modalEl) return;
    const jq = window.jQuery || window.$;
    if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        const modalObj = bootstrap.Modal.getInstance(modalEl);
        if (modalObj) modalObj.hide();
    } else if (jq && jq.fn && jq.fn.modal) {
        jq(modalEl).modal('hide');
    }
    modalEl.classList.remove('show');
    modalEl.style.display = 'none';

    setTimeout(() => {
        const openModals = document.querySelectorAll('.modal.show');
        if (openModals.length === 0) {
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
        }
    }, 100);
}

document.addEventListener("DOMContentLoaded", function () {
    document.addEventListener('hidden.bs.modal', function () {
        setTimeout(() => {
            const openModals = document.querySelectorAll('.modal.show');
            if (openModals.length === 0) {
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
            }
        }, 100);
    });
    const btnEksekusi = document.getElementById("btnEksekusiHapus");
    if (btnEksekusi) {
        btnEksekusi.addEventListener("click", function () {
            hideModalSafely("modalKonfirmasiHapus");
            if (confirmActionCallback) {
                confirmActionCallback();
                confirmActionCallback = null;
            } else if (window.confirmActionCallback) {
                window.confirmActionCallback();
                window.confirmActionCallback = null;
            }
        });
    }

    // --- 1. PROFIL & PENGATURAN LOGIC ---
    function loadProfilData() {
        fetch((window.BASE_URL || "") + 'profil/get')
            .then(res => res.json())
            .then(res => {
                if (res.status === 'success') {
                    const elNama = document.getElementById("profilNamaLengkap");
                    const elUser = document.getElementById("profilUsername");
                    const elHp = document.getElementById("profilNomorHp");
                    const elPass = document.getElementById("profilPassword");
                    const elAvatar = document.getElementById("avatarPreview");

                    if (elNama) elNama.value = res.data.nama_lengkap || '';
                    if (elUser) elUser.value = res.data.username || '';
                    if (elHp) elHp.value = res.data.nomor_hp || '';
                    if (elPass) elPass.value = '';
                    if (elAvatar && res.foto_url) elAvatar.src = res.foto_url;
                }
            })
            .catch(err => {
                console.error("Gagal memuat profil:", err);
            });
    }

    function loadPengaturanData() {
        fetch((window.BASE_URL || "") + 'pengaturan/get')
            .then(res => res.json())
            .then(res => {
                if (res.status === 'success') {
                    const elNamaToko = document.getElementById("settingNamaToko");
                    const elSubTitle = document.getElementById("settingSubTitle");
                    const elStokKritis = document.getElementById("settingStokKritis");

                    if (elNamaToko) elNamaToko.value = res.data.nama_toko || '';
                    if (elSubTitle) elSubTitle.value = res.data.sub_title || '';
                    if (elStokKritis) elStokKritis.value = res.data.stok_kritis || '5';
                }
            })
            .catch(err => {
                console.error("Gagal memuat pengaturan:", err);
            });
    }

    // Immediately load profile and settings data on ready
    loadProfilData();
    loadPengaturanData();

    // Re-trigger load when Modal Profil is opened
    const modalProfilEl = document.getElementById("modalProfil");
    if (modalProfilEl) {
        modalProfilEl.addEventListener("show.bs.modal", function () {
            loadProfilData();
        });
    }

    // Re-trigger load when Modal Pengaturan is opened
    const modalPengaturanEl = document.getElementById("modalPengaturan");
    if (modalPengaturanEl) {
        modalPengaturanEl.addEventListener("show.bs.modal", function () {
            loadPengaturanData();
        });
    }

    // Toggle filter section & note in Backup Modal
    const backupTargetSelect = document.getElementById("backupTargetSelect");
    const backupFilterSection = document.getElementById("backupFilterSection");
    const stokNoteText = document.getElementById("stokNoteText");

    function updateBackupFilterState() {
        if (!backupTargetSelect) return;
        if (backupTargetSelect.value === 'stok') {
            if (backupFilterSection) backupFilterSection.style.display = 'none';
            if (stokNoteText) stokNoteText.style.display = 'block';
        } else {
            if (backupFilterSection) backupFilterSection.style.display = 'block';
            if (stokNoteText) stokNoteText.style.display = 'none';
        }
    }

    if (backupTargetSelect) {
        backupTargetSelect.addEventListener("change", updateBackupFilterState);
        updateBackupFilterState();
    }

    // --- KASIR POS LOGIC ---
    let kasirIkanData = [];
    let kasirCart = []; // Array of { id_ikan, nama_ikan, nama_kategori, jenis, jumlah, harga_satuan, keterangan, max_stok, foto }
    let kasirActiveCategory = 'ALL';
    let kasirSearchQuery = '';
    let isKasirLoadingData = false;

    function loadKasirIkanList(callback) {
        isKasirLoadingData = true;
        const gridEl = document.getElementById("kasirProductGrid");
        if (gridEl && kasirIkanData.length === 0) {
            gridEl.innerHTML = `
                <div class="col-12 text-center py-5 text-muted">
                    <div class="spinner-border text-primary me-2" role="status"></div>
                    <div>Memuat katalog ikan hias...</div>
                </div>
            `;
        }

        fetch((window.BASE_URL || "") + 'kasir/get-ikan')
            .then(res => res.json())
            .then(res => {
                isKasirLoadingData = false;
                if (res.status === 'success') {
                    kasirIkanData = res.data || [];
                    renderKasirCategoryPills();
                    renderKasirCatalog();
                    updateKasirManualSelectOptions();
                    renderNotifikasiStokDropdown();
                    if (callback) callback();
                }
            })
            .catch(err => {
                isKasirLoadingData = false;
                console.error("Gagal memuat data ikan kasir:", err);
            });
    }

    function renderNotifikasiStokDropdown() {
        const container = document.getElementById("notifDropdownList");
        const badgeHeader = document.getElementById("headerNotifBadgeCount");
        const headerBadge = document.getElementById("notifDropdownHeaderBadge");
        const footerCount = document.getElementById("notifDropdownFooterCount");

        const limitKritis = parseInt(document.getElementById("settingStokKritis") ? document.getElementById("settingStokKritis").value : 5) || 5;
        const lowStockItems = kasirIkanData.filter(item => parseInt(item.stok) <= limitKritis);

        // Update header notification badge count
        if (badgeHeader) {
            if (lowStockItems.length > 0) {
                badgeHeader.textContent = lowStockItems.length;
                badgeHeader.classList.remove("d-none");
            } else {
                badgeHeader.classList.add("d-none");
            }
        }

        if (headerBadge) {
            if (lowStockItems.length > 0) {
                headerBadge.textContent = `${lowStockItems.length} Item`;
                headerBadge.classList.remove("d-none");
            } else {
                headerBadge.classList.add("d-none");
            }
        }

        if (footerCount) {
            footerCount.textContent = `${lowStockItems.length} item kritis (â‰¤ ${limitKritis} ekor)`;
        }

        if (!container) return;

        if (lowStockItems.length === 0) {
            container.innerHTML = `
                <div class="text-center py-4 text-muted" style="font-size: 0.8125rem;">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light mb-2 text-success" style="width: 40px; height: 40px;">
                        <i class="pe-7s-check" style="font-size: 1.25rem;"></i>
                    </div>
                    <div class="fw-medium text-dark">Stok persediaan aman</div>
                    <div class="text-muted" style="font-size: 0.75rem;">Tidak ada item yang menipis atau kritis.</div>
                </div>
            `;
            return;
        }

        let html = '';
        lowStockItems.forEach(item => {
            let avatar = '';
            if (item.foto) {
                avatar = `<img src="${item.foto}" class="notif-item-avatar me-2 flex-shrink-0" alt="${item.nama_ikan}">`;
            } else {
                avatar = `
                    <div class="notif-item-avatar-placeholder me-2 flex-shrink-0">
                        <i class="pe-7s-photo"></i>
                    </div>
                `;
            }

            const isHabis = parseInt(item.stok) <= 0;
            const stockBadge = isHabis 
                ? `<span class="badge bg-danger-subtle text-danger border border-danger-subtle" style="font-size: 0.6875rem; font-weight: 600; padding: 2px 6px;">Habis (0)</span>`
                : `<span class="badge bg-warning-subtle text-warning border border-warning-subtle" style="font-size: 0.6875rem; font-weight: 600; padding: 2px 6px; color: #b45309 !important; background-color: #fef3c7 !important; border-color: #fde68a !important;">Sisa: ${item.stok}</span>`;

            html += `
                <div class="notif-item-card d-flex align-items-center justify-content-between mb-1.5">
                    <div class="d-flex align-items-center me-2 overflow-hidden" style="min-width: 0;">
                        ${avatar}
                        <div class="overflow-hidden" style="min-width: 0;">
                            <div class="fw-semibold text-dark text-truncate mb-0.5" title="${item.nama_ikan}" style="font-size: 0.8125rem; line-height: 1.25;">${item.nama_ikan}</div>
                            <div class="d-flex align-items-center gap-1.5" style="font-size: 0.6875rem;">
                                <span class="text-muted text-truncate" style="max-width: 90px;">${item.nama_kategori || 'Umum'}</span>
                                <span class="text-muted opacity-50">â€¢</span>
                                ${stockBadge}
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-notif-restock flex-shrink-0 btn-quick-restock" onclick="window.handleQuickRestock('${item.id_ikan}', event)">
                        <i class="pe-7s-plus me-1" style="font-weight: bold;"></i>Restok
                    </button>
                </div>
            `;
        });

        container.innerHTML = html;
    }

    function updateKasirManualSelectOptions() {
        const select = document.getElementById("kasirManualSelectIkan");
        if (!select) return;

        let html = '<option value="">-- Pilih Ikan Hias --</option>';
        kasirIkanData.forEach(item => {
            html += `<option value="${item.id_ikan}">${item.nama_ikan} (${item.nama_kategori || 'Umum'}) - Stok: ${item.stok}</option>`;
        });
        select.innerHTML = html;
    }

    function renderKasirCategoryPills() {
        const container = document.getElementById("kasirCategoryPills");
        if (!container) return;

        // Collect unique categories
        const categories = [];
        kasirIkanData.forEach(item => {
            const cat = item.nama_kategori || 'Umum';
            if (!categories.includes(cat)) {
                categories.push(cat);
            }
        });

        let html = `
            <button type="button" class="kasir-cat-pill ${kasirActiveCategory === 'ALL' ? 'active' : ''}" data-cat="ALL">
                Semua
            </button>
        `;

        categories.forEach(cat => {
            const isActive = kasirActiveCategory === cat;
            html += `
                <button type="button" class="kasir-cat-pill ${isActive ? 'active' : ''}" data-cat="${cat}">
                    ${cat}
                </button>
            `;
        });

        container.innerHTML = html;
    }

    function renderKasirCatalog() {
        const gridEl = document.getElementById("kasirProductGrid");
        const countEl = document.getElementById("kasirCatalogCount");
        if (!gridEl) return;

        const currentJenis = document.querySelector('input[name="kasirJenis"]:checked') ? document.querySelector('input[name="kasirJenis"]:checked').value : 'Keluar';

        let filtered = kasirIkanData;

        // Filter by category
        if (kasirActiveCategory !== 'ALL') {
            filtered = filtered.filter(i => (i.nama_kategori || 'Umum') === kasirActiveCategory);
        }

        // Filter by search query
        if (kasirSearchQuery.trim() !== '') {
            const q = kasirSearchQuery.toLowerCase().trim();
            filtered = filtered.filter(i => 
                i.nama_ikan.toLowerCase().includes(q) || 
                (i.nama_kategori && i.nama_kategori.toLowerCase().includes(q))
            );
        }

        if (countEl) {
            countEl.textContent = `(${filtered.length} Item)`;
        }

        if (filtered.length === 0) {
            gridEl.innerHTML = `
                <div class="col-12 text-center py-5 text-muted">
                    <i class="pe-7s-search fs-1 mb-2 opacity-50 d-block"></i>
                    <div class="fs-7 fw-semibold">Tidak ada produk ikan yang sesuai</div>
                    <div class="text-muted fs-8">Coba kata kunci pencarian atau kategori lain</div>
                </div>
            `;
            return;
        }

        let html = '';
        filtered.forEach(item => {
            const hargaFmt = currentJenis === 'Masuk' ? item.harga_beli_fmt : item.harga_jual_fmt;
            const isOutOfStock = currentJenis === 'Keluar' && item.stok <= 0;

            let imgHtml = '';
            if (item.foto) {
                imgHtml = `<img src="${item.foto}" alt="${item.nama_ikan}" class="kasir-product-thumb" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"><div class="kasir-product-thumb-placeholder" style="display: none;"><i class="pe-7s-photo"></i></div>`;
            } else {
                imgHtml = `
                    <div class="kasir-product-thumb-placeholder">
                        <i class="pe-7s-photo"></i>
                    </div>
                `;
            }

            const stockBadge = item.stok > 0
                ? `<span class="kasir-badge-stock bg-white text-dark border">Stok: ${item.stok}</span>`
                : `<span class="kasir-badge-stock bg-danger text-white">Habis</span>`;

            html += `
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="kasir-product-card ${isOutOfStock ? 'opacity-60' : ''}" data-id="${item.id_ikan}">
                        <div>
                            <div class="kasir-thumb-box mb-2">
                                ${imgHtml}
                                ${stockBadge}
                            </div>
                            <div class="mb-1">
                                <span class="kasir-badge-category">${item.nama_kategori || 'Umum'}</span>
                            </div>
                            <h6 class="fw-bold text-dark text-truncate mb-1" style="font-size: 0.8125rem; line-height: 1.3;" title="${item.nama_ikan}">${item.nama_ikan}</h6>
                        </div>
                        <div class="pt-1 mt-1 border-top d-flex align-items-center justify-content-between">
                            <span class="text-muted" style="font-size: 0.6875rem;">Harga</span>
                            <div class="fw-bold text-success" style="font-size: 0.8125rem;">${hargaFmt}</div>
                        </div>
                    </div>
                </div>
            `;
        });

        gridEl.innerHTML = html;
    }

    function addKasirItemToCart(id_ikan) {
        const fish = kasirIkanData.find(i => i.id_ikan == id_ikan);
        if (!fish) return;

        const jenis = document.querySelector('input[name="kasirJenis"]:checked') ? document.querySelector('input[name="kasirJenis"]:checked').value : 'Keluar';

        if (jenis === 'Keluar' && fish.stok <= 0) {
            showToast("danger", "Stok Habis", `Stok ${fish.nama_ikan} saat ini sudah habis.`);
            return;
        }

        const hargaSatuan = jenis === 'Masuk' ? fish.harga_beli : fish.harga_jual;

        const existingIndex = kasirCart.findIndex(c => c.id_ikan == id_ikan && c.jenis == jenis);
        if (existingIndex !== -1) {
            const newQty = kasirCart[existingIndex].jumlah + 1;
            if (jenis === 'Keluar' && newQty > fish.stok) {
                showToast("warning", "Stok Melebihi Batas", `Jumlah di keranjang (${newQty} ekor) melebihi stok yang ada (${fish.stok} ekor).`);
                return;
            }
            kasirCart[existingIndex].jumlah = newQty;
        } else {
            kasirCart.push({
                id_ikan: fish.id_ikan,
                nama_ikan: fish.nama_ikan,
                nama_kategori: fish.nama_kategori,
                jenis: jenis,
                jumlah: 1,
                harga_satuan: hargaSatuan,
                keterangan: '',
                max_stok: fish.stok,
                foto: fish.foto
            });
        }

        renderKasirCartList();
        showToast("success", "Ditambahkan", `${fish.nama_ikan} masuk ke keranjang.`);
    }

    function renderKasirCartList() {
        const cartListContainer = document.getElementById("kasirCartList");
        const summaryTotalJenis = document.getElementById("kasirSummaryTotalJenis");
        const summaryTotalQty = document.getElementById("kasirSummaryTotalQty");
        const grandTotalText = document.getElementById("kasirGrandTotalText");

        if (!cartListContainer) return;

        if (kasirCart.length === 0) {
            cartListContainer.innerHTML = `
                <div class="text-center py-5 text-muted">
                    <i class="pe-7s-cart fs-1 mb-2 opacity-50 text-secondary"></i>
                    <div class="fs-7 fw-semibold">Belum ada item di keranjang</div>
                    <small class="text-muted fs-8">Pilih ikan dari katalog di sebelah kiri</small>
                </div>
            `;
            if (summaryTotalJenis) summaryTotalJenis.textContent = "0 Jenis";
            if (summaryTotalQty) summaryTotalQty.textContent = "0 Ekor";
            if (grandTotalText) grandTotalText.textContent = "Rp 0";
            return;
        }

        let html = '';
        let totalQtySum = 0;
        let grandTotalSum = 0;

        kasirCart.forEach((item, index) => {
            const subtotal = item.jumlah * item.harga_satuan;
            totalQtySum += item.jumlah;
            grandTotalSum += subtotal;

            let avatar = '';
            if (item.foto) {
                avatar = `<img src="${item.foto}" class="kasir-cart-thumb" alt="${item.nama_ikan}" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"><div class="kasir-cart-thumb-placeholder" style="display: none;"><i class="pe-7s-photo"></i></div>`;
            } else {
                avatar = `
                    <div class="kasir-cart-thumb-placeholder">
                        <i class="pe-7s-photo"></i>
                    </div>
                `;
            }

            html += `
                <div class="kasir-cart-card">
                    <!-- Header: Avatar, Name, Category & Delete Button -->
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center gap-2 overflow-hidden me-2">
                            ${avatar}
                            <div class="overflow-hidden">
                                <div class="fw-bold text-dark text-truncate" style="font-size: 0.8125rem;" title="${item.nama_ikan}">${item.nama_ikan}</div>
                                <span class="kasir-badge-category" style="font-size: 0.625rem; padding: 1px 5px;">${item.nama_kategori || 'Umum'}</span>
                            </div>
                        </div>
                        <button type="button" class="kasir-cart-delete-btn btn-delete-cart-item" data-index="${index}" title="Hapus Item">
                            <i class="pe-7s-trash fs-6"></i>
                        </button>
                    </div>

                    <!-- Inputs Row: Qty Stepper & Unit Price -->
                    <div class="row g-2 align-items-center mb-2">
                        <div class="col-5">
                            <div class="kasir-qty-stepper">
                                <button class="kasir-qty-btn btn-cart-qty-minus" type="button" data-index="${index}"><i class="pe-7s-less"></i></button>
                                <input type="number" class="kasir-qty-input input-cart-qty" data-index="${index}" value="${item.jumlah}" min="1">
                                <button class="kasir-qty-btn btn-cart-qty-plus" type="button" data-index="${index}"><i class="pe-7s-plus"></i></button>
                            </div>
                        </div>

                        <div class="col-7">
                            <div class="kasir-price-input-group">
                                <span class="kasir-price-prefix">Rp</span>
                                <input type="number" class="kasir-price-input input-cart-harga" data-index="${index}" value="${item.harga_satuan}" placeholder="0">
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Row: Note & Subtotal -->
                    <div class="pt-2 border-top d-flex align-items-center justify-content-between gap-2" style="border-color: #f1f5f9 !important;">
                        <input type="text" class="form-control form-control-sm border-0 bg-light text-dark input-cart-keterangan" data-index="${index}" placeholder="+ Catatan (opsional)" value="${item.keterangan ? item.keterangan : ''}" style="font-size: 0.6875rem; height: 26px; border-radius: 6px; padding: 2px 8px;">
                        <div class="text-end flex-shrink-0">
                            <span class="fw-bold text-success" style="font-size: 0.8125rem;">Rp ${subtotal.toLocaleString('id-ID')}</span>
                        </div>
                    </div>
                </div>
            `;
        });

        cartListContainer.innerHTML = html;

        if (summaryTotalJenis) summaryTotalJenis.textContent = kasirCart.length + " Jenis";
        if (summaryTotalQty) summaryTotalQty.textContent = totalQtySum + " Ekor";
        if (grandTotalText) grandTotalText.textContent = "Rp " + grandTotalSum.toLocaleString('id-ID');

        setTimeout(checkKasirCartScroll, 50);
    }

    function checkKasirCartScroll() {
        const container = document.getElementById("kasirCartListContainer");
        const indicator = document.getElementById("kasirScrollDownIndicator");
        if (!container || !indicator) return;

        const isScrollable = container.scrollHeight > container.clientHeight + 10;
        const isAtBottom = container.scrollTop + container.clientHeight >= container.scrollHeight - 15;

        if (kasirCart.length > 1 && isScrollable && !isAtBottom) {
            indicator.classList.remove("d-none");
        } else {
            indicator.classList.add("d-none");
        }
    }

    const kasirCartContainerEl = document.getElementById("kasirCartListContainer");
    if (kasirCartContainerEl) {
        kasirCartContainerEl.addEventListener("scroll", checkKasirCartScroll);
    }

    // Real-time live clock function for modal header
    function updateKasirLiveClock() {
        const clockEl = document.getElementById("kasirLiveClockText");
        if (!clockEl) return;
        const now = new Date();
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        
        const dayName = days[now.getDay()];
        const dayNum = String(now.getDate()).padStart(2, '0');
        const monthName = months[now.getMonth()];
        const year = now.getFullYear();
        
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        
        clockEl.textContent = `${dayName}, ${dayNum} ${monthName} ${year} - ${hours}:${minutes}:${seconds} WIB`;
    }
    setInterval(updateKasirLiveClock, 1000);
    updateKasirLiveClock();

    // Manual input select fish change auto-fill price
    const manualSelect = document.getElementById("kasirManualSelectIkan");
    if (manualSelect) {
        manualSelect.addEventListener("change", function () {
            const id = this.value;
            const fish = kasirIkanData.find(i => i.id_ikan == id);
            const hargaInput = document.getElementById("kasirManualHarga");
            if (fish && hargaInput) {
                const jenis = document.querySelector('input[name="kasirJenis"]:checked') ? document.querySelector('input[name="kasirJenis"]:checked').value : 'Keluar';
                hargaInput.value = (jenis === 'Masuk') ? fish.harga_beli : fish.harga_jual;
            }
        });
    }

    // Manual input submit handler
    const btnTambahManual = document.getElementById("btnTambahManualKeKeranjang");
    if (btnTambahManual) {
        btnTambahManual.addEventListener("click", function () {
            const id = document.getElementById("kasirManualSelectIkan").value;
            if (!id) {
                showToast("warning", "Pilih Ikan", "Silakan pilih jenis ikan hias terlebih dahulu.");
                return;
            }

            const fish = kasirIkanData.find(i => i.id_ikan == id);
            if (!fish) return;

            const jenis = document.querySelector('input[name="kasirJenis"]:checked') ? document.querySelector('input[name="kasirJenis"]:checked').value : 'Keluar';
            const jumlah = parseInt(document.getElementById("kasirManualJumlah").value) || 1;
            let hargaSatuan = parseFloat(document.getElementById("kasirManualHarga").value);
            if (isNaN(hargaSatuan) || hargaSatuan <= 0) {
                hargaSatuan = (jenis === 'Masuk') ? fish.harga_beli : fish.harga_jual;
            }
            const keterangan = document.getElementById("kasirManualKeterangan").value.trim();

            if (jumlah <= 0) {
                showToast("danger", "Jumlah Tidak Valid", "Jumlah ekor harus lebih dari 0.");
                return;
            }

            if (jenis === 'Keluar' && jumlah > fish.stok) {
                showToast("danger", "Stok Tidak Cukup", `Stok ${fish.nama_ikan} saat ini hanya ${fish.stok} ekor.`);
                return;
            }

            const existingIndex = kasirCart.findIndex(c => c.id_ikan == fish.id_ikan && c.jenis == jenis);
            if (existingIndex !== -1) {
                const newQty = kasirCart[existingIndex].jumlah + jumlah;
                if (jenis === 'Keluar' && newQty > fish.stok) {
                    showToast("warning", "Stok Melebihi Batas", `Jumlah total (${newQty} ekor) melebihi stok yang ada (${fish.stok} ekor).`);
                    return;
                }
                kasirCart[existingIndex].jumlah = newQty;
                kasirCart[existingIndex].harga_satuan = hargaSatuan;
                if (keterangan) kasirCart[existingIndex].keterangan = keterangan;
            } else {
                kasirCart.push({
                    id_ikan: fish.id_ikan,
                    nama_ikan: fish.nama_ikan,
                    nama_kategori: fish.nama_kategori,
                    jenis: jenis,
                    jumlah: jumlah,
                    harga_satuan: hargaSatuan,
                    keterangan: keterangan,
                    max_stok: fish.stok,
                    foto: fish.foto
                });
            }

            renderKasirCartList();
            showToast("success", "Ditambahkan", `${fish.nama_ikan} (${jumlah} ekor) masuk ke keranjang.`);

            // Reset manual form fields
            document.getElementById("kasirManualSelectIkan").value = "";
            document.getElementById("kasirManualJumlah").value = "1";
            document.getElementById("kasirManualHarga").value = "";
            document.getElementById("kasirManualKeterangan").value = "";
        });
    }

    // Category pill click delegate
    const categoryPillsContainer = document.getElementById("kasirCategoryPills");
    if (categoryPillsContainer) {
        categoryPillsContainer.addEventListener("click", function (e) {
            const pill = e.target.closest(".kasir-cat-pill");
            if (pill) {
                kasirActiveCategory = pill.getAttribute("data-cat");
                renderKasirCategoryPills();
                renderKasirCatalog();
            }
        });
    }

    // Live search catalog
    const catalogSearchInput = document.getElementById("kasirSearchCatalog");
    const btnClearCatalogSearch = document.getElementById("btnClearCatalogSearch");

    if (catalogSearchInput) {
        catalogSearchInput.addEventListener("input", function () {
            kasirSearchQuery = this.value;
            if (btnClearCatalogSearch) {
                if (kasirSearchQuery.length > 0) {
                    btnClearCatalogSearch.classList.remove("d-none");
                } else {
                    btnClearCatalogSearch.classList.add("d-none");
                }
            }
            renderKasirCatalog();
        });
    }

    if (btnClearCatalogSearch) {
        btnClearCatalogSearch.addEventListener("click", function () {
            if (catalogSearchInput) catalogSearchInput.value = "";
            kasirSearchQuery = "";
            this.classList.add("d-none");
            renderKasirCatalog();
        });
    }

    // Click product card delegate
    const productGrid = document.getElementById("kasirProductGrid");
    if (productGrid) {
        productGrid.addEventListener("click", function (e) {
            const card = e.target.closest(".kasir-product-card");
            if (card) {
                const id = card.getAttribute("data-id");
                addKasirItemToCart(id);
            }
        });
    }

    // Cart action delegation (qty minus, plus, delete, manual input, item notes)
    const cartListEl = document.getElementById("kasirCartList");
    if (cartListEl) {
        cartListEl.addEventListener("click", function (e) {
            const btnMinus = e.target.closest(".btn-cart-qty-minus");
            if (btnMinus) {
                const idx = parseInt(btnMinus.getAttribute("data-index"));
                if (kasirCart[idx]) {
                    if (kasirCart[idx].jumlah > 1) {
                        kasirCart[idx].jumlah--;
                        renderKasirCartList();
                    }
                }
                return;
            }

            const btnPlus = e.target.closest(".btn-cart-qty-plus");
            if (btnPlus) {
                const idx = parseInt(btnPlus.getAttribute("data-index"));
                if (kasirCart[idx]) {
                    if (kasirCart[idx].jenis === 'Keluar' && kasirCart[idx].jumlah >= kasirCart[idx].max_stok) {
                        showToast("warning", "Stok Maksimal", `Stok ${kasirCart[idx].nama_ikan} hanya ${kasirCart[idx].max_stok} ekor.`);
                        return;
                    }
                    kasirCart[idx].jumlah++;
                    renderKasirCartList();
                }
                return;
            }

            const btnDelete = e.target.closest(".btn-delete-cart-item");
            if (btnDelete) {
                const idx = parseInt(btnDelete.getAttribute("data-index"));
                if (kasirCart[idx]) {
                    const removedName = kasirCart[idx].nama_ikan;
                    kasirCart.splice(idx, 1);
                    renderKasirCartList();
                    showToast("info", "Item Dihapus", `${removedName} dihapus dari keranjang.`);
                }
                return;
            }
        });

        cartListEl.addEventListener("change", function (e) {
            const inputHarga = e.target.closest(".input-cart-harga");
            if (inputHarga) {
                const idx = parseInt(inputHarga.getAttribute("data-index"));
                let val = parseFloat(inputHarga.value);
                if (isNaN(val) || val < 0) val = 0;

                if (kasirCart[idx]) {
                    kasirCart[idx].harga_satuan = val;
                    renderKasirCartList();
                }
                return;
            }

            const inputQty = e.target.closest(".input-cart-qty");
            if (inputQty) {
                const idx = parseInt(inputQty.getAttribute("data-index"));
                let val = parseInt(inputQty.value) || 1;
                if (val < 1) val = 1;

                if (kasirCart[idx]) {
                    if (kasirCart[idx].jenis === 'Keluar' && val > kasirCart[idx].max_stok) {
                        showToast("warning", "Stok Melebihi Batas", `Stok ${kasirCart[idx].nama_ikan} hanya ${kasirCart[idx].max_stok} ekor.`);
                        val = kasirCart[idx].max_stok;
                    }
                    kasirCart[idx].jumlah = val;
                    renderKasirCartList();
                }
                return;
            }

            const inputKet = e.target.closest(".input-cart-keterangan");
            if (inputKet) {
                const idx = parseInt(inputKet.getAttribute("data-index"));
                if (kasirCart[idx]) {
                    kasirCart[idx].keterangan = inputKet.value.trim();
                }
            }
        });
    }

    // Clear cart button
    const btnClearCart = document.getElementById("btnClearCart");
    if (btnClearCart) {
        btnClearCart.addEventListener("click", function () {
            if (kasirCart.length === 0) return;
            kasirCart = [];
            renderKasirCartList();
            showToast("info", "Keranjang Dibersihkan", "Semua item telah dihapus dari keranjang.");
        });
    }

    // Radio mutasi type switch event
    document.querySelectorAll('input[name="kasirJenis"]').forEach(radio => {
        radio.addEventListener("change", function () {
            renderKasirCatalog();
        });
    });

    // Load fish data & render initial state when modal is opened or DOM ready
    loadKasirIkanList();
    renderKasirCartList();

    const modalKasirEl = document.getElementById("modalKasir");
    if (modalKasirEl) {
        modalKasirEl.addEventListener("show.bs.modal", function () {
            loadKasirIkanList();
            renderKasirCartList();
        });
    }

    // Submit transaction handler
    const btnProsesKasirSemua = document.getElementById("btnProsesKasirSemua");
    if (btnProsesKasirSemua) {
        btnProsesKasirSemua.addEventListener("click", function () {
            if (kasirCart.length === 0) {
                showToast("warning", "Keranjang Kosong", "Keranjang transaksi masih kosong. Pilih produk terlebih dahulu.");
                return;
            }

            const formData = new FormData();
            formData.append("items", JSON.stringify(kasirCart));

            fetch((window.BASE_URL || "") + "kasir/proses", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    showToast("success", "Transaksi Berhasil", data.message);
                    kasirCart = [];
                    renderKasirCartList();
                    loadKasirIkanList();
                } else {
                    showToast("danger", "Gagal Transaksi", data.message);
                }
            })
            .catch(err => {
                console.error("Gagal memproses transaksi:", err);
                showToast("danger", "Error Server", "Terjadi kesalahan server saat memproses transaksi.");
            });
        });
    }

    // Foto Input Preview
    const fotoInput = document.getElementById("fotoInput");
    if (fotoInput) {
        fotoInput.addEventListener("change", function () {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById("avatarPreview").src = e.target.result;
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    }

    // Submit Profil Form
    const formProfil = document.getElementById("formUpdateProfil");
    if (formProfil) {
        formProfil.addEventListener("submit", function (e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch((window.BASE_URL || "") + "profil/update", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    document.querySelectorAll(".header-user-avatar").forEach(img => img.src = data.foto_url);
                    document.querySelectorAll(".header-user-name").forEach(el => el.textContent = data.nama_lengkap);
                    hideModalSafely("modalProfil");
                    showToast("success", "Profil Diperbarui", data.message);
                } else {
                    showToast("danger", "Gagal Update Profil", data.message || 'Gagal mengupdate profil.');
                }
            });
        });
    }

    // Submit Pengaturan Form
    const formPengaturan = document.getElementById("formUpdatePengaturan");
    if (formPengaturan) {
        formPengaturan.addEventListener("submit", function (e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch((window.BASE_URL || "") + "pengaturan/update", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    document.querySelectorAll(".header-app-title").forEach(el => el.textContent = data.nama_toko);
                    document.querySelectorAll(".header-user-subtitle").forEach(el => el.textContent = data.sub_title);
                    hideModalSafely("modalPengaturan");
                    showToast("success", "Pengaturan Disimpan", data.message);
                } else {
                    showToast("danger", "Gagal", 'Gagal mengupdate pengaturan.');
                }
            });
        });
    }

    // --- 2. INTERACTIVE CALENDAR WITH NOTES LOGIC ---
    let currentDate = new Date();
    let calendarNotesMap = {}; // 'YYYY-MM-DD' => note text
    let selectedDateStr = formatDateKey(new Date());

    const prevBtn = document.getElementById("calPrevMonth");
    if (prevBtn) {
        prevBtn.addEventListener("click", function () {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendarGrid();
        });
    }

    const nextBtn = document.getElementById("calNextMonth");
    if (nextBtn) {
        nextBtn.addEventListener("click", function () {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendarGrid();
        });
    }

    function formatDateKey(dateObj) {
        const y = dateObj.getFullYear();
        const m = String(dateObj.getMonth() + 1).padStart(2, '0');
        const d = String(dateObj.getDate()).padStart(2, '0');
        return `${y}-${m}-${d}`;
    }

    function loadCalendarNotesAndRender() {
        renderCalendarGrid(); // Instantly render grid dates!
        fetch((window.BASE_URL || "") + 'kalender/notes')
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    calendarNotesMap = data.notes || {};
                    renderCalendarGrid(); // Re-render to add note badges
                }
            })
            .catch(err => {
                console.error("Gagal memuat catatan kalender:", err);
            });
    }

    // Instantly load calendar dates on page ready
    loadCalendarNotesAndRender();

    // Re-render calendar grid whenever Calendar Modal is opened
    const modalKalenderEl = document.getElementById("modalKalenderNote");
    if (modalKalenderEl) {
        modalKalenderEl.addEventListener("show.bs.modal", function () {
            loadCalendarNotesAndRender();
        });
    }

    function escapeHtml(str) {
        if (!str) return '';
        return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    function renderCalendarGrid() {
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();

        const monthNames = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];
        const titleEl = document.getElementById("calMonthYearTitle");
        if (titleEl) titleEl.textContent = `${monthNames[month]} ${year}`;

        const firstDay = new Date(year, month, 1).getDay(); // 0 = Sunday
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const daysInPrevMonth = new Date(year, month, 0).getDate();

        const tbody = document.getElementById("calendarGridTableBody");
        if (!tbody) return;
        tbody.innerHTML = "";

        const todayObj = new Date();
        const todayStr = formatDateKey(todayObj);

        let dayCells = [];

        // Previous month padding days
        for (let i = firstDay - 1; i >= 0; i--) {
            const dayNum = daysInPrevMonth - i;
            const prevDateObj = new Date(year, month - 1, dayNum);
            const key = formatDateKey(prevDateObj);
            dayCells.push({ num: dayNum, key: key, otherMonth: true });
        }

        // Current month days
        for (let d = 1; d <= daysInMonth; d++) {
            const dateObj = new Date(year, month, d);
            const key = formatDateKey(dateObj);
            dayCells.push({ num: d, key: key, otherMonth: false });
        }

        // Next month padding days
        const totalCells = dayCells.length;
        const nextPadding = (totalCells % 7 === 0) ? 0 : 7 - (totalCells % 7);
        for (let n = 1; n <= nextPadding; n++) {
            const nextDateObj = new Date(year, month + 1, n);
            const key = formatDateKey(nextDateObj);
            dayCells.push({ num: n, key: key, otherMonth: true });
        }

        // Build <tr> rows with 7 <td> cells
        let trHtml = '';
        for (let i = 0; i < dayCells.length; i += 7) {
            trHtml += '<tr>';
            for (let j = i; j < i + 7; j++) {
                const cell = dayCells[j];
                const isSelected = (cell.key === selectedDateStr);
                const isToday = (cell.key === todayStr);

                let cellClass = 'calendar-day-cell';
                if (cell.otherMonth) cellClass += ' other-month';
                if (isSelected) cellClass += ' active-day';
                if (isToday) cellClass += ' today-day';

                const rawNote = calendarNotesMap[cell.key] || '';
                const noteText = rawNote.trim();

                let eventPill = '';
                if (noteText !== '') {
                    const shortNote = noteText.length > 10 ? noteText.substring(0, 10) + '...' : noteText;
                    eventPill = `<div class="cal-event-pill shadow-xs" title="${escapeHtml(noteText)}"><i class="fa fa-sticky-note me-1" style="font-size: 8px;"></i>${escapeHtml(shortNote)}</div>`;
                }

                trHtml += `
                    <td class="${cellClass}" data-date="${cell.key}">
                        <div class="d-flex justify-content-end align-items-center">
                            <span class="day-number-text">${cell.num}</span>
                        </div>
                        ${eventPill}
                    </td>
                `;
            }
            trHtml += '</tr>';
        }

        tbody.innerHTML = trHtml;

        // Attach click listeners to <td> cells
        tbody.querySelectorAll('.calendar-day-cell').forEach(td => {
            td.addEventListener('click', function () {
                tbody.querySelectorAll('.calendar-day-cell').forEach(c => c.classList.remove('active-day'));
                td.classList.add('active-day');
                selectedDateStr = td.getAttribute('data-date');
                updateNotePane(selectedDateStr);
            });
        });

        updateNotePane(selectedDateStr);
    }

    function updateNotePane(dateKeyStr) {
        const parts = dateKeyStr.split("-");
        const dateObj = new Date(parts[0], parts[1] - 1, parts[2]);

        const days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
        const months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        const dayName = days[dateObj.getDay()];
        const monthName = months[dateObj.getMonth()];

        document.getElementById("selectedDateBadge").textContent = `${parts[2]}/${parts[1]}/${parts[0]}`;
        document.getElementById("selectedDateText").textContent = `${dayName}, ${parts[2]} ${monthName} ${parts[0]}`;

        document.getElementById("calNoteInput").value = calendarNotesMap[dateKeyStr] || "";
    }

    // Save Note Button
    const btnSaveNote = document.getElementById("btnSaveCalNote");
    if (btnSaveNote) {
        btnSaveNote.addEventListener("click", function () {
            const noteContent = document.getElementById("calNoteInput").value.trim();

            const formData = new FormData();
            formData.append("tanggal", selectedDateStr);
            formData.append("catatan", noteContent);

            fetch((window.BASE_URL || "") + "kalender/save", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    if (noteContent !== "") {
                        calendarNotesMap[selectedDateStr] = noteContent;
                    } else {
                        delete calendarNotesMap[selectedDateStr];
                    }
                    renderCalendarGrid();
                    showToast("success", "Catatan Disimpan", data.message);
                }
            });
        });
    }

    // Delete Note Button - Direct Instant Delete
    const btnDeleteNote = document.getElementById("btnDeleteCalNote");
    if (btnDeleteNote) {
        btnDeleteNote.addEventListener("click", function () {
            const noteInput = document.getElementById("calNoteInput");
            const hasSavedNote = calendarNotesMap[selectedDateStr] && calendarNotesMap[selectedDateStr].trim() !== "";
            const hasDraftText = noteInput && noteInput.value.trim() !== "";

            if (!hasSavedNote && !hasDraftText) {
                showToast("info", "Catatan Kosong", "Tidak ada catatan pada tanggal ini.");
                return;
            }

            // Instantly clear UI input & local state
            if (noteInput) noteInput.value = "";

            if (hasSavedNote) {
                delete calendarNotesMap[selectedDateStr];
                renderCalendarGrid();

                const formData = new FormData();
                formData.append("tanggal", selectedDateStr);

                fetch((window.BASE_URL || "") + "kalender/delete", {
                    method: "POST",
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    showToast("warning", "Catatan Dihapus", "Catatan pada tanggal ini telah dihapus.");
                })
                .catch(err => {
                    console.error("Delete note error:", err);
                });
            } else {
                renderCalendarGrid();
                showToast("info", "Draf Dibersihkan", "Teks catatan telah dibersihkan.");
            }
        });
    }

    // --- LOW STOCK NOTIFICATION DROPDOWN LOGIC ---
    const btnTriggerNotif = document.getElementById("btnTriggerNotifikasiStok");
    if (btnTriggerNotif) {
        btnTriggerNotif.addEventListener("click", function () {
            renderNotifikasiStokDropdown();
        });
        btnTriggerNotif.addEventListener("show.bs.dropdown", function () {
            loadKasirIkanList(renderNotifikasiStokDropdown);
        });
    }

    window.handleQuickRestock = function (id_ikan, e) {
        if (e) {
            if (typeof e.preventDefault === 'function') e.preventDefault();
            if (typeof e.stopPropagation === 'function') e.stopPropagation();
        }

        // Close notification dropdown popover if open
        const notifBtn = document.getElementById("btnTriggerNotifikasiStok");
        if (notifBtn) {
            if (typeof bootstrap !== 'undefined' && bootstrap.Dropdown) {
                const dropObj = bootstrap.Dropdown.getInstance(notifBtn);
                if (dropObj) dropObj.hide();
            }
            const dropdownContainer = notifBtn.closest(".dropdown");
            if (dropdownContainer) {
                const menu = dropdownContainer.querySelector(".dropdown-menu");
                if (menu) menu.classList.remove("show");
            }
            notifBtn.classList.remove("show");
            notifBtn.setAttribute("aria-expanded", "false");
        }

        function runRestockFlow() {
            // 1. Set mode to Masuk (IN)
            const radioMasuk = document.getElementById("kasirJenisMasuk");
            if (radioMasuk) {
                radioMasuk.checked = true;
                radioMasuk.dispatchEvent(new Event('change'));
            }

            // 2. Add fish item to cart
            addKasirItemToCart(id_ikan);

            // 3. Trigger native Header Kasir button click
            const btnKasir = document.getElementById("btnTriggerKasir");
            if (btnKasir && typeof btnKasir.click === 'function') {
                btnKasir.click();
            } else {
                showModalSafely("modalKasir");
            }
        }

        if (!kasirIkanData || kasirIkanData.length === 0) {
            loadKasirIkanList(runRestockFlow);
        } else {
            runRestockFlow();
        }
    };

    document.addEventListener("click", function(e) {
        const btnRestock = e.target.closest(".btn-quick-restock");
        if (btnRestock && !btnRestock.getAttribute("onclick")) {
            const id = btnRestock.getAttribute("data-id");
            if (id && window.handleQuickRestock) {
                window.handleQuickRestock(id, e);
            }
        }
    });
});