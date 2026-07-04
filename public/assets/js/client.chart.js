if (typeof Chart !== 'undefined') {
    const chart_json = document.getElementById('chart_data').innerText
    const chart_data = JSON.parse(chart_json)
    const ctx = document.getElementById('clientTaskChart');

    if (ctx && chart_data) {
        new Chart(ctx, {
            type: 'line',
            data: chart_data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        borderColor: 'rgba(255, 255, 255, 0.12)',
                        borderWidth: 1,
                        titleColor: '#f8fafc',
                        bodyColor: '#cbd5e1',
                        cornerRadius: 8,
                        displayColors: true,
                        padding: 12
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#64748b',
                            font: {
                                size: 11
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(148, 163, 184, 0.2)'
                        },
                        ticks: {
                            color: '#64748b',
                            font: {
                                size: 11
                            }
                        }
                    }
                }
            }
        });
    }
}
