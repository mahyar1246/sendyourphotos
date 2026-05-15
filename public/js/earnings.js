// public/js/earnings.js
document.addEventListener("DOMContentLoaded", function () {
    // 1. Ambil data yang "dilempar" dari file Blade
    const config = window.earningsConfig;

    if (!config) return; // Cegah error jika data kosong

    const ctx = document.getElementById("earningsChart").getContext("2d");

    // 2. Buat Gradient berdasarkan warna tema
    let gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, config.accent + "4D"); // 30% opacity
    gradient.addColorStop(1, config.accent + "00"); // 0% opacity

    // 3. Render Chart
    new Chart(ctx, {
        type: "line",
        data: {
            labels: config.labels,
            datasets: [
                {
                    label: "Daily Revenue (Rp)",
                    data: config.data,
                    borderColor: config.accent,
                    backgroundColor: gradient,
                    borderWidth: 4,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: config.primary,
                    pointBorderColor: "#ffffff",
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: config.secondary,
                    titleFont: {
                        family: "'Plus Jakarta Sans', sans-serif",
                        size: 13,
                    },
                    bodyFont: {
                        family: "'Plus Jakarta Sans', sans-serif",
                        size: 14,
                        weight: "bold",
                    },
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        label: function (context) {
                            return new Intl.NumberFormat("id-ID", {
                                style: "currency",
                                currency: "IDR",
                                minimumFractionDigits: 0,
                            }).format(context.parsed.y);
                        },
                    },
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: "rgba(0,0,0,0.04)", drawBorder: false },
                    ticks: {
                        font: {
                            family: "'Plus Jakarta Sans', sans-serif",
                            size: 12,
                            color: "#9CA3AF",
                        },
                        callback: function (value) {
                            return "Rp " + value / 1000 + "k";
                        },
                    },
                },
                x: {
                    grid: { display: false, drawBorder: false },
                    ticks: {
                        font: {
                            family: "'Plus Jakarta Sans', sans-serif",
                            weight: "600",
                            color: "#6B7280",
                        },
                    },
                },
            },
        },
    });
});
