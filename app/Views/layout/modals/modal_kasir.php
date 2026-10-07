<!-- Modal Kasir  -->
<div class="modal fade" id="modalKasir" tabindex="-1" aria-labelledby="modalKasirLabel" aria-hidden="true" style="z-index: 1080;">
    <div class="modal-dialog modal-fullscreen m-0 p-0" style="max-width: 100vw; width: 100vw; height: 100vh;">
        <div class="modal-content border-0 rounded-0 h-100 d-flex flex-column bg-light" style="overflow: hidden;">
            <!-- Modal Header  -->
            <div class="kasir-modal-header px-3 px-md-4 py-2.5 flex-shrink-0 d-flex align-items-center justify-content-between" style="min-height: 56px;">
                <div class="d-flex align-items-center gap-3">
                    <div class="kasir-header-icon">
                        <i class="pe-7s-shopbag"></i>
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2">
                            <h5 class="fw-bold mb-0 text-dark fs-6" id="modalKasirLabel" style="letter-spacing: -0.01em;">Kasir & POS Ikan Hias</h5>
                        </div>
                        <div class="d-flex align-items-center gap-2 mt-0.5">
                            <span class="kasir-live-pill">
                                <span class="kasir-live-dot"></span>
                                <span id="kasirLiveClockText">--:--:-- WIB</span>
                            </span>
                        </div>
                    </div>
                </div>
                <button type="button" class="modal-btn-close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close" style="width: 32px; height: 32px; font-size: 1.25rem;">
                    <i class="pe-7s-close"></i>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body p-2 p-md-3 bg-light overflow-hidden flex-grow-1 d-flex flex-column" style="min-height: 0;">
                <div class="row flex-grow-1 g-2 g-md-3 m-0" style="min-height: 0; height: 100%;">
                    
                    <!-- Left Side: Catalog Grid & Search (col-lg-8) -->
                    <div class="col-lg-8 d-flex flex-column px-1" style="min-height: 0; height: 100%;">
                        
                        <!-- Top Filter & Search Container Card -->
                        <div class="kasir-filter-card mb-2 flex-shrink-0">
                            <div class="kasir-filter-card-header">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="fw-bold text-dark fs-7 d-flex align-items-center gap-1">
                                        <i class="pe-7s-albums text-primary"></i> Filter Kategori
                                    </span>
                                </div>
                                <!-- Search Input Box Modern -->
                                <div class="kasir-search-box">
                                    <i class="pe-7s-search kasir-search-prefix"></i>
                                    <input type="text" id="kasirSearchCatalog" class="form-control" placeholder="Cari nama / kategori ikan..." autocomplete="off">
                                    <button class="kasir-search-clear d-none" type="button" id="btnClearCatalogSearch" title="Clear">
                                        <i class="pe-7s-close-circle"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Category Pills Horizontal List -->
                            <div class="kasir-cat-pills-wrap" id="kasirCategoryPills">
                                <button type="button" class="kasir-cat-pill active" data-cat="ALL">
                                    Semua
                                </button>
                                <!-- Dynamic category pills inserted via JS -->
                            </div>
                        </div>

                        <!-- Catalog Title & Header Row -->
                        <div class="d-flex align-items-center justify-content-between mb-2 px-1 flex-shrink-0">
                            <div class="d-flex align-items-center gap-2">
                                <span class="fw-bold text-dark fs-7">Katalog Ikan Hias</span>
                                <span class="badge bg-white text-muted border rounded-pill px-2 py-1" style="font-size: 0.6875rem;" id="kasirCatalogCount">(0 Item)</span>
                            </div>
                            <span class="text-muted" style="font-size: 0.6875rem;">Klik kartu ikan untuk menambah ke keranjang</span>
                        </div>

                        <!-- Product Grid Container (Scrollable) -->
                        <div class="flex-grow-1 overflow-auto pe-1 pb-3" id="kasirProductGridScroll" style="min-height: 0;">
                            <div class="row g-2 g-md-3" id="kasirProductGrid">
                                <!-- Dynamic Product Cards rendered via JS -->
                            </div>
                        </div>

                    </div>

                    <!-- Right Side: Order Menu Cart Sidebar (col-lg-4) -->
                    <div class="col-lg-4 d-flex flex-column px-1" style="min-height: 0; height: 100%;">
                        <div class="card border rounded-3 flex-grow-1 d-flex flex-column bg-white overflow-hidden shadow-xs" style="min-height: 0; border-color: #e2e8f0 !important;">
                            
                            <!-- Sidebar Header -->
                            <div class="kasir-cart-header d-flex align-items-center justify-content-between border-bottom flex-shrink-0">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="text-primary d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; border-radius: 6px; background: #f0f9ff;">
                                        <i class="pe-7s-cart fs-5"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-0 fs-7">Keranjang Order</h6>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-light text-primary border rounded-pill px-2 py-1" style="font-size: 0.6875rem; font-weight: 600;" id="kasirCartItemCountBadge">0 Item</span>
                                    <button type="button" class="btn btn-sm text-danger p-0 d-flex align-items-center justify-content-center" id="btnClearCart" title="Kosongkan Keranjang" style="width: 28px; height: 28px; border-radius: 6px; border: 1px solid #fee2e2; background: #fef2f2;">
                                        <i class="pe-7s-trash fs-6"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Transaction Type Switch (OUT / IN) Modern Segment -->
                            <div class="kasir-segment-wrapper flex-shrink-0">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <label class="form-label fw-bold text-muted text-uppercase mb-0" style="font-size: 0.6875rem; letter-spacing: 0.04em;">Tipe Mutasi Transaksi</label>
                                </div>
                                <div class="kasir-type-segment" role="group">
                                    <input type="radio" class="btn-check" name="kasirJenis" id="kasirJenisKeluar" value="Keluar" checked autocomplete="off">
                                    <label class="kasir-segment-item kasir-segment-out" for="kasirJenisKeluar">
                                        <i class="pe-7s-up-arrow"></i> Penjualan (OUT)
                                    </label>

                                    <input type="radio" class="btn-check" name="kasirJenis" id="kasirJenisMasuk" value="Masuk" autocomplete="off">
                                    <label class="kasir-segment-item kasir-segment-in" for="kasirJenisMasuk">
                                        <i class="pe-7s-down-arrow"></i> Restock (IN)
                                    </label>
                                </div>
                            </div>

                            <!-- Cart Scrollable Item List Container -->
                            <div class="flex-grow-1 overflow-auto px-3 py-2 position-relative" id="kasirCartListContainer" style="min-height: 0;">
                                <div id="kasirCartList">
                                    <!-- Dynamic Cart Items rendered via JS -->
                                </div>
                                <!-- Floating Scroll Down Indicator -->
                                <div id="kasirScrollDownIndicator" class="position-sticky bottom-0 text-center py-1 d-none" style="margin-top: -36px; z-index: 10; pointer-events: none;">
                                    <div class="bg-white text-primary border shadow-sm rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 28px; height: 28px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); animation: kasirFloatBounce 1.5s infinite ease-in-out;">
                                        <i class="pe-7s-angle-down fs-5"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Cart Summary & Checkout Footer (Pinned at bottom) -->
                            <div class="p-3 bg-white border-top flex-shrink-0" style="border-color: #f1f5f9 !important;">
                                <div class="kasir-summary-box mb-3">
                                    <div class="d-flex justify-content-between mb-1" style="font-size: 0.75rem; color: #64748b;">
                                        <span>Total Jenis</span>
                                        <span class="fw-bold text-dark" id="kasirSummaryTotalJenis">0 Jenis</span>
                                    </div>
                                    <div class="d-flex justify-content-between pb-2 mb-2" style="font-size: 0.75rem; color: #64748b; border-bottom: 1px dashed #e2e8f0;">
                                        <span>Total Kuantitas</span>
                                        <span class="fw-bold text-dark" id="kasirSummaryTotalQty">0 Ekor</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold text-dark fs-7">Subtotal Akhir</span>
                                        <h5 class="fw-bold text-success mb-0 fs-6" id="kasirGrandTotalText">Rp 0</h5>
                                    </div>
                                </div>

                                <button type="button" id="btnProsesKasirSemua" class="btn-kasir-checkout mt-1">
                                    <i class="pe-7s-check fs-5 fw-bold"></i>
                                    <span>PROSES TRANSAKSI</span>
                                </button>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
