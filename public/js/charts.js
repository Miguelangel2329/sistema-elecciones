document.addEventListener("DOMContentLoaded", () => {
    // Gráfico de "Candidatos"
    const candidatosCanvas = document.getElementById("candidatosChart");
    const candidatosData = JSON.parse(candidatosCanvas.dataset.chartData);

    new Chart(candidatosCanvas.getContext("2d"), {
        type: "bar",
        data: {
            labels: candidatosData.labels,
            datasets: [{
                data: candidatosData.values,
                backgroundColor: candidatosData.colors,
                borderColor: "#fff",
                borderWidth: 2
            }]
        },
        options: {
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { color: "#333" }
                },
                x: {
                    ticks: { color: "#333" }
                }
            }
        }
    });

    // Gráficos de "Gráfica de las elecciones"
    const chartIds = ["sinVotarChart", "enBlancoChart", "totalVotadosChart"];
    chartIds.forEach(id => {
        const canvas = document.getElementById(id);
        const chartData = JSON.parse(canvas.dataset.chartData);

        new Chart(canvas.getContext("2d"), {
            type: "doughnut",
            data: {
                labels: [chartData.label, "Restante"],
                datasets: [{
                    data: [chartData.value, 100 - chartData.value],
                    backgroundColor: [chartData.color, "#e0e0e0"],
                    borderColor: "#fff",
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                cutout: "70%",
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                return tooltipItem.label + ": " + tooltipItem.raw + "%";
                            }
                        }
                    }
                }
            }
        });
    });
});
