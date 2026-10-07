<!-- Modal Agenda & Catatan Kalender -->
<div class="modal fade" id="modalKalenderNote" tabindex="-1" aria-labelledby="modalKalenderNoteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-modern modal-dialog-modern-lg">
        <div class="modal-content modal-content-modern">
            <div class="modal-header-modern">
                <div class="d-flex align-items-center gap-2.5">
                    <div class="modal-header-icon">
                        <i class="pe-7s-date"></i>
                    </div>
                    <div>
                        <h5 class="modal-title-text" id="modalKalenderNoteLabel">Agenda & Catatan Kalender</h5>
                        <div class="modal-subtitle-text">Kelola jadwal kegiatan harian dan catatan toko</div>
                    </div>
                </div>
                <button type="button" class="modal-btn-close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">
                    <i class="pe-7s-close"></i>
                </button>
            </div>
            <div class="modal-body-modern">
                <div class="row g-3">
                    <!-- Left Column: Calendar Grid (Continuous FullCalendar Style) -->
                    <div class="col-md-7 border-end pe-md-3">
                        <div class="d-flex justify-content-between align-items-center mb-2.5 px-1">
                            <button type="button" class="modal-btn-secondary py-1 px-2" id="calPrevMonth"><i class="pe-7s-angle-left"></i></button>
                            <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.875rem;" id="calMonthYearTitle">September 2026</h6>
                            <button type="button" class="modal-btn-secondary py-1 px-2" id="calNextMonth"><i class="pe-7s-angle-right"></i></button>
                        </div>

                        <!-- Continuous Table Calendar Grid -->
                        <div class="table-responsive rounded border" style="border-color: #e2e8f0 !important;">
                            <table class="table table-bordered calendar-table mb-0 align-top">
                                <thead>
                                    <tr class="text-center text-secondary fw-bold fs-8 bg-light">
                                        <th style="width: 14.28%;" class="text-danger py-1.5">Sun</th>
                                        <th style="width: 14.28%;" class="py-1.5">Mon</th>
                                        <th style="width: 14.28%;" class="py-1.5">Tue</th>
                                        <th style="width: 14.28%;" class="py-1.5">Wed</th>
                                        <th style="width: 14.28%;" class="py-1.5">Thu</th>
                                        <th style="width: 14.28%;" class="py-1.5">Fri</th>
                                        <th style="width: 14.28%;" class="text-primary py-1.5">Sat</th>
                                    </tr>
                                </thead>
                                <tbody id="calendarGridTableBody">
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Right Column: Note Detail Editor Pane -->
                    <div class="col-md-5 d-flex flex-column justify-content-between p-3 rounded border" style="background: #f8fafc; border-color: #e2e8f0 !important;">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom" style="border-color: #e2e8f0 !important;">
                                <span class="fw-bold text-dark" style="font-size: 0.8125rem;">Catatan Harian</span>
                                <span class="badge bg-secondary" style="font-size: 0.6875rem; font-weight: 600;" id="selectedDateBadge">23/09/2026</span>
                            </div>
                            <div class="mb-2">
                                <label class="modal-label text-muted" style="font-size: 0.75rem;" id="selectedDateText">Selasa, 23 September 2026</label>
                                <textarea class="form-control modal-input" id="calNoteInput" rows="6" placeholder="Ketik catatan agenda di sini..."></textarea>
                            </div>
                        </div>

                        <div class="pt-2.5 d-flex justify-content-between align-items-center border-top mt-2" style="border-color: #e2e8f0 !important;">
                            <button type="button" class="modal-btn-danger py-1 px-2.5" id="btnDeleteCalNote">
                                <i class="pe-7s-trash"></i>
                                <span>Hapus</span>
                            </button>
                            <button type="button" class="modal-btn-primary py-1 px-3" id="btnSaveCalNote">
                                <i class="pe-7s-check"></i>
                                <span>Simpan</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
