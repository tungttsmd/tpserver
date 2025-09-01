<div class="border rounded m-2 p-4">
    <h2 class="text-xl font-bold mb-4">Thống kê linh kiện theo ngày</h2>

    <!-- Bộ lọc thời gian -->
    <div class="flex gap-4 mb-4">
        <div>
            <label for="startDate" class="block text-sm font-medium">Từ ngày:</label>
            <input type="date" id="startDate" class="border rounded px-2 py-1">
        </div>
        <div>
            <label for="endDate" class="block text-sm font-medium">Đến ngày:</label>
            <input type="date" id="endDate" class="border rounded px-2 py-1">
        </div>
        <button id="filterBtn" class="bg-blue-500 text-white px-3 py-1 rounded mt-auto">
            Lọc
        </button>
    </div>

    <canvas id="componentChart" class="max-h-[200vh]"></canvas>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/luxon@3"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@1"></script>

    <script>
        // Đăng ký plugin
        Chart.register(ChartDataLabels);

        const ctx = document.getElementById('componentChart');
        const allData = @json($componentLogs);

        console.log(allData);


        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                datasets: [{
                    label: 'Số lượng linh kiện',
                    data: allData,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 0,
                    barThickness: 6,
                    maxBarThickness: 12
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                min: 0, // bắt đầu từ 0
                afterDataLimits(scale) {
                    if (scale.max < 100) {
                        scale.max = 100;
                    }
                },
                suggestedMax: 100, // Đây là điểm then chốt
                scales: {
                    y: {
                        type: 'time',
                        time: {
                            unit: 'week',
                            tooltipFormat: 'dd/MM/yyyy'
                        },
                        title: {
                            display: true,
                            text: 'Ngày'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Số lượng'
                        }
                    }
                },
                plugins: {
                    datalabels: {
                        anchor: 'end',
                        align: 'end',
                        formatter: function(value) {
                            return value.x; // hiển thị số lượng trên đỉnh cột
                        },
                        font: {
                            weight: 'bold'
                        },
                        color: '#000'
                    }
                }
            }
        });
    </script>
    <canvas id="componentChart" height="100"></canvas>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/luxon@3"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@1"></script>
    
    <script>
      Chart.register(ChartDataLabels);
    
      const ctx = document.getElementById('componentChart');
    
      // Dữ liệu mẫu
      const allData = [
        { x: 9, y: '2025-08-01' },
        { x: 15, y: '2025-08-08' },
      ];
    
      const chart = new Chart(ctx, {
        type: 'bar',
        data: {
          datasets: [{
            label: 'Số lượng linh kiện',
            data: allData,
            backgroundColor: 'rgba(54, 162, 235, 0.7)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1,
            barThickness: 6,
            maxBarThickness: 12
          }]
        },
        options: {
          indexAxis: 'y',
          responsive: true,
          scales: {
            x: {
              min: 0,
              afterDataLimits(scale) {
                if (scale.max < 100) {
                  scale.max = 100;
                }
              },
              title: {
                display: true,
                text: 'Số lượng'
              }
            },
            y: {
              type: 'time',
              time: {
                unit: 'week',
                tooltipFormat: 'dd/MM/yyyy'
              },
              title: {
                display: true,
                text: 'Ngày'
              }
            }
          },
          plugins: {
            datalabels: {
              anchor: 'end',
              align: 'end',
              formatter: value => value.x,
              font: { weight: 'bold' },
              color: '#000'
            }
          }
        },
        plugins: [ChartDataLabels]
      });
    </script>
    
</div>