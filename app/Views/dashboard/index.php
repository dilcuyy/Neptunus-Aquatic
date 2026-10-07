<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<!-- Summary Stat Cards -->
<style>
.stat-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 1.15rem 1.25rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    height: 100%;
    box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
}
.stat-icon {
    width: 44px;
    height: 44px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
}
.stat-label {
    font-size: 0.8125rem;
    font-weight: 500;
    color: #64748b;
    margin-bottom: 0.25rem;
    line-height: 1.2;
}
.stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: #0f172a;
    line-height: 1.1;
    letter-spacing: -0.02em;
}
.stat-subtext {
    font-size: 0.75rem;
    color: #94a3b8;
    margin-top: 0.25rem;
}
.chart-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
    height: 100%;
    display: flex;
    flex-direction: column;
}
.chart-card-header {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.chart-card-title {
    font-size: 0.9375rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
    letter-spacing: -0.01em;
}
.chart-card-desc {
    font-size: 0.75rem;
    color: #64748b;
    margin: 0;
}
.chart-card-body {
    padding: 1.25rem;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
</style>
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div>
                <div class="stat-label">Total Stok Ikan</div>
                <div class="stat-value"><?= number_format($stats['total_stok']) ?></div>
                <div class="stat-subtext">Seluruh kategori</div>
            </div>
            <div class="stat-icon" style="background: #f1f5f9; color: #334155;">
                <i class="pe-7s-box2"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div>
                <div class="stat-label">Ikan Masuk (IN)</div>
                <div class="stat-value text-success">+<?= number_format($stats['ikan_masuk']) ?></div>
                <div class="stat-subtext">Akumulasi mutasi masuk</div>
            </div>
            <div class="stat-icon" style="background: #f0fdf4; color: #16a34a;">
                <i class="pe-7s-bottom-arrow"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div>
                <div class="stat-label">Ikan Keluar (OUT)</div>
                <div class="stat-value text-danger">-<?= number_format($stats['ikan_keluar']) ?></div>
                <div class="stat-subtext">Akumulasi mutasi keluar</div>
            </div>
            <div class="stat-icon" style="background: #fef2f2; color: #dc2626;">
                <i class="pe-7s-up-arrow"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div>
                <div class="stat-label">Jenis Ikan</div>
                <div class="stat-value text-primary"><?= number_format($stats['total_jenis']) ?></div>
                <div class="stat-subtext">Katalog aktif</div>
            </div>
            <div class="stat-icon" style="background: #eff6ff; color: #2563eb;">
                <i class="pe-7s-ticket"></i>
            </div>
        </div>
    </div>
</div>

<!-- Primary Section: Tren Mutasi & Distribusi Kategori -->
<div class="row g-3 mb-4">
    <!-- Chart 1 (Prioritas Utama): Tren Mutasi Masuk vs Keluar -->
    <div class="col-12 col-xl-8">
        <div class="chart-card">
            <div class="chart-card-header">
                <div>
                    <h2 class="chart-card-title">Tren Mutasi Stok</h2>
                    <p class="chart-card-desc">Perbandingan volume ikan masuk (IN) vs ikan keluar (OUT)</p>
                </div>
            </div>
            <div class="chart-card-body">
                <div style="position: relative; height: 280px; width: 100%;">
                    <canvas id="canvasMutasi"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart 2: Proporsi Stok per Kategori -->
    <div class="col-12 col-xl-4">
        <div class="chart-card">
            <div class="chart-card-header">
                <div>
                    <h2 class="chart-card-title">Proporsi Kategori</h2>
                    <p class="chart-card-desc">Komposisi stok berdasarkan kategori ikan</p>
                </div>
            </div>
            <div class="chart-card-body">
                <div style="position: relative; height: 280px; width: 100%;">
                    <canvas id="canvasKategori"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Secondary Section: Top 5 Stok & Pola Jam Aktivitas -->
<div class="row g-3 mb-4">
    <!-- Chart 3: Top 5 Stok Terbanyak -->
    <div class="col-12 col-lg-6">
        <div class="chart-card">
            <div class="chart-card-header">
                <div>
                    <h2 class="chart-card-title">Top 5 Stok Terbanyak</h2>
                    <p class="chart-card-desc">Katalog ikan dengan ketersediaan tertinggi</p>
                </div>
            </div>
            <div class="chart-card-body">
                <div style="position: relative; height: 240px; width: 100%;">
                    <canvas id="canvasTopFish"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart 4: Jam Tren Aktivitas (Secondary Insight) -->
    <div class="col-12 col-lg-6">
        <div class="chart-card">
            <div class="chart-card-header">
                <div>
                    <h2 class="chart-card-title">Aktivitas 24 Jam</h2>
                    <p class="chart-card-desc">Distribusi transaksi mutasi berdasarkan waktu</p>
                </div>
                <span class="badge bg-light text-dark border px-2 py-1" style="font-weight: 600; font-size: 0.75rem;">
                    Puncak: <?= esc($peakHourText) ?>
                </span>
            </div>
            <div class="chart-card-body">
                <div style="position: relative; height: 240px; width: 100%;">
                    <canvas id="canvasHourly"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script Integration -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Shared Chart Style Defaults
    Chart.defaults.font.family = '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif';
    Chart.defaults.font.size = 11;
    Chart.defaults.color = '#64748b';

    // 1. Chart Mutasi (Grouped Bar)
    const mutasiLabels = <?= $chartMutasiLabels ?>;
    const mutasiIn     = <?= $chartMutasiIn ?>;
    const mutasiOut    = <?= $chartMutasiOut ?>;

    const ctxMutasi = document.getElementById('canvasMutasi').getContext('2d');
    new Chart(ctxMutasi, {
        type: 'bar',
        data: {
            labels: mutasiLabels.length ? mutasiLabels : ['Belum Ada Data'],
            datasets: [
                {
                    label: 'Masuk (IN)',
                    data: mutasiIn.length ? mutasiIn : [0],
                    backgroundColor: '#10b981',
                    borderRadius: 4,
                    barPercentage: 0.7,
                    categoryPercentage: 0.6
                },
                {
                    label: 'Keluar (OUT)',
                    data: mutasiOut.length ? mutasiOut : [0],
                    backgroundColor: '#ef4444',
                    borderRadius: 4,
                    barPercentage: 0.7,
                    categoryPercentage: 0.6
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    align: 'end',
                    labels: { boxWidth: 10, boxHeight: 10, usePointStyle: true, pointStyle: 'circle' }
                },
                tooltip: { padding: 10, cornerRadius: 6 }
            },
            scales: {
                x: { grid: { display: false } },
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 },
                    grid: { color: '#f1f5f9' },
                    border: { dash: [4, 4] }
                }
            }
        }
    });

    // 2. Chart Kategori (Doughnut)
    const kategoriLabels = <?= $chartKategoriLabels ?>;
    const kategoriData   = <?= $chartKategoriData ?>;

    const ctxKategori = document.getElementById('canvasKategori').getContext('2d');
    new Chart(ctxKategori, {
        type: 'doughnut',
        data: {
            labels: kategoriLabels.length ? kategoriLabels : ['Tidak Ada Data'],
            datasets: [{
                data: kategoriData.length ? kategoriData : [1],
                backgroundColor: [
                    '#3b82f6',
                    '#10b981',
                    '#f59e0b',
                    '#8b5cf6',
                    '#06b6d4',
                    '#94a3b8'
                ],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '72%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { boxWidth: 8, boxHeight: 8, usePointStyle: true, pointStyle: 'circle', padding: 12 }
                },
                tooltip: { padding: 10, cornerRadius: 6 }
            }
        }
    });

    // 3. Chart Top Fish (Horizontal Bar)
    const topFishLabels = <?= $chartTopFishLabels ?>;
    const topFishData   = <?= $chartTopFishData ?>;

    const ctxTopFish = document.getElementById('canvasTopFish').getContext('2d');
    new Chart(ctxTopFish, {
        type: 'bar',
        data: {
            labels: topFishLabels.length ? topFishLabels : ['Tidak Ada Data'],
            datasets: [{
                data: topFishData.length ? topFishData : [0],
                backgroundColor: '#3b82f6',
                borderRadius: 4,
                barPercentage: 0.65
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function (ctx) {
                            return ' ' + ctx.raw.toLocaleString() + ' ekor';
                        }
                    },
                    padding: 10,
                    cornerRadius: 6
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: { precision: 0 },
                    grid: { color: '#f1f5f9' },
                    border: { dash: [4, 4] }
                },
                y: { grid: { display: false } }
            }
        }
    });

    // 4. Chart Jam Tren Aktivitas (Line Chart)
    const hourlyLabels = <?= $chartHourlyLabels ?>;
    const hourlyTrx    = <?= $chartHourlyTrx ?>;

    const ctxHourly = document.getElementById('canvasHourly').getContext('2d');
    new Chart(ctxHourly, {
        type: 'line',
        data: {
            labels: hourlyLabels,
            datasets: [{
                label: 'Transaksi',
                data: hourlyTrx,
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99, 102, 241, 0.08)',
                fill: true,
                tension: 0.35,
                borderWidth: 2,
                pointRadius: 2,
                pointHoverRadius: 5,
                pointBackgroundColor: '#6366f1'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: { padding: 10, cornerRadius: 6 }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: {
                        callback: function (val, idx) {
                            return idx % 4 === 0 ? this.getLabelForValue(val) : '';
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 },
                    grid: { color: '#f1f5f9' },
                    border: { dash: [4, 4] }
                }
            }
        }
    });
});
</script>
<?= $this->endSection() ?>
