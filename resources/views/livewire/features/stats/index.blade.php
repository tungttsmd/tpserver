<div class="p-4">
    {{-- Filter năm/tháng --}}
    <div class="flex flex-wrap gap-4 mb-4 items-center">
        <span>Năm:</span>
        <select id="yearFilter" class="border rounded px-2 py-1">
            <!-- option sẽ được tạo JS -->
        </select>

        <span>Tháng:</span>
        <select id="monthFilter" class="border rounded px-2 py-1">
            <option value="0">Tất cả</option>
            @for ($m = 1; $m <= 12; $m++)
                <option value="{{ $m }}">Tháng {{ $m }}</option>
            @endfor
        </select>

        {{-- Select bảo hành --}}
        <span>Bảo hành:</span>
        <select id="warrantyFilter" class="border rounded px-2 py-1">
            <option value="all" selected>Tất cả</option>
            <option value="yes">Còn bảo hành</option>
            <option value="no">Hết bảo hành</option>
        </select>
    </div>
    {{-- Chart --}}
    <canvas id="componentChart" class="max-w-[100%] max-h-[86vh] "></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

<script>
    const components = @json($components);
    const categories = @json($categories);

    const categoryIds = [...new Set(components.map(c => c.category_id))];
    const categoryNames = categoryIds.map(id => categories[id] || '--');

    const ctx = document.getElementById('componentChart').getContext('2d');
    Chart.register(ChartDataLabels);

    let selectedYear = 0;
    let selectedMonth = 0;
    let filterWarrantyYes = true;
    let filterWarrantyNo = true;

    // Tạo danh sách năm
    const years = [...new Set(components.map(c => c.year))].sort((a, b) => b - a);
    const yearFilter = document.getElementById('yearFilter');
    years.forEach(y => {
        const opt = document.createElement('option');
        opt.value = y;
        opt.textContent = y;
        yearFilter.appendChild(opt);
    });
    yearFilter.value = years[0];
    selectedYear = Number(yearFilter.value);

    const monthFilter = document.getElementById('monthFilter');

    let selectedWarranty = 'all'; // mặc định full

    const warrantyFilter = document.getElementById('warrantyFilter');
    warrantyFilter.addEventListener('change', e => {
        selectedWarranty = e.target.value;
        updateChart();
    });

    function filterData() {
        return components.filter(c => {
            if (selectedYear && c.year != selectedYear) return false;
            if (selectedMonth && c.month != selectedMonth) return false;

            if (selectedWarranty === 'yes' && c.con_bao_hanh == 0) return false;
            if (selectedWarranty === 'no' && c.con_bao_hanh > 0) return false;

            return true;
        });
    }

    function updateChart() {
        const filtered = filterData();

        const stockData = categoryIds.map(id => {
            return filtered
                .filter(c => c.category_id == id)
                .reduce((acc, curr) => acc + Number(curr.ton_kho), 0);
        });

        const exportedData = categoryIds.map(id => {
            return filtered
                .filter(c => c.category_id == id)
                .reduce((acc, curr) => acc + Number(curr.da_xuat_kho), 0);
        });

        const maxVal = Math.max(...stockData, ...exportedData, 1);
        const suggestedMax = Math.ceil(maxVal * 1.2);

        if (chart) {
            chart.data.datasets[0].data = stockData;
            chart.data.datasets[1].data = exportedData;
            chart.options.scales.x.max = suggestedMax;
            chart.update();
        }
    }

    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: categoryNames,
            datasets: [{
                    label: 'Tồn kho',
                    data: [],
                    backgroundColor: '#60A5FA',
                    borderRadius: 2,
                    minBarLength: 6
                },
                {
                    label: 'Đã xuất kho',
                    data: [],
                    backgroundColor: '#FBBF24',
                    borderRadius: 2,
                    minBarLength: 6
                }
            ]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                datalabels: {
                    anchor: 'end',
                    align: 'end',
                    color: '#000',
                    font: {
                        weight: 'bold'
                    }
                },
                title: {
                    display: true,
                    position: 'bottom',
                    text: 'Biểu đồ thanh: thống kê linh kiện theo phân loại',
                    font: {
                        size: 18,
                        weight: 'bold'
                    },
                    padding: {
                        top: 10,
                        bottom: 20
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                },
                x: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    });

    // Event chọn năm/tháng
    yearFilter.addEventListener('change', e => {
        selectedYear = Number(e.target.value);
        updateChart();
    });
    monthFilter.addEventListener('change', e => {
        selectedMonth = Number(e.target.value);
        updateChart();
    });

    updateChart();
</script>
