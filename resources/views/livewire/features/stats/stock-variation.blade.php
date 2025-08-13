<div class="p-4">
    <div class="flex flex-wrap gap-6 items-center mt-2">
        <span class="font-medium">Lọc theo năm:</span>
        <div id="yearFilterButtons" class="flex gap-2 flex-wrap">
            <div id="yearFilterButtons">
                @foreach ($componentLogs->pluck('year')->unique()->sortDesc() as $year)
                    <button type="button"
                        class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-indigo-500 transition"
                        onclick="selectYear({{ $year }})">
                        {{ $year }}
                    </button>
                @endforeach
            </div>

            
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const newestYear = {{ $componentLogs->max('year') }};
                selectYear(newestYear);
            });
        </script>
        <span id="monthRangeLabel">Tháng 1 - Tháng 12</span>
        <div class="pt-1" style="width: 300px; margin-left: 10px;">
            <div id="monthRangeSlider"></div>
        </div>

    </div>

    <canvas id="componentChart" class="max-w-[100%] max-h-[86vh] "></canvas>

    <!-- Thư viện -->
    <link href="https://cdn.jsdelivr.net/npm/nouislider@15.7.0/dist/nouislider.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/nouislider@15.7.0/dist/nouislider.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/luxon@3"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@1"></script>

    <script>
        let chartType = 'bar';
        const ctx = document.getElementById('componentChart');
        let chart;

        const rawData = @json($componentLogs);
        const years = [...new Set(rawData.map(item => item.year))].sort((a, b) => b - a);
        const yearFilterContainer = document.getElementById('yearFilterButtons');
        let selectedYear = {{ $componentLogs->max('year') ?? 'null' }};
        let selectedMonthRange = [1, 12];
        const monthSelect = document.getElementById('monthSelect');

        const maxXuatKho = Math.max(...rawData.map(item => item.xuat_kho));
        const maxNhapKho = Math.max(...rawData.map(item => item.nhap_kho));
        const maxThuHoi = Math.max(...rawData.map(item => item.thu_hoi));
        const MAX_VALUE = Math.ceil(Math.max(maxXuatKho, maxNhapKho, maxThuHoi) * 1.2);

        Chart.register(ChartDataLabels);


        function setActiveYearButton(activeBtn) {
            const buttons = yearFilterContainer.querySelectorAll('button');
            buttons.forEach(btn => {
                btn.classList.remove('bg-indigo-600', 'text-white', 'border-indigo-600', 'hover:bg-indigo-700');
                btn.classList.add('bg-white', 'text-gray-700', 'border-gray-300', 'hover:bg-gray-50');
            });
            activeBtn.classList.remove('bg-white', 'text-gray-700', 'border-gray-300', 'hover:bg-gray-50');
            activeBtn.classList.add('bg-indigo-600', 'text-white', 'border-indigo-600', 'hover:bg-indigo-700');
        }

        // Slider tháng
        const slider = document.getElementById('monthRangeSlider');
        noUiSlider.create(slider, {
            start: [1, 12],
            connect: true,
            step: 1,
            range: {
                min: 1,
                max: 12
            },
            format: {
                to: v => Math.round(v),
                from: v => Number(v)
            }
        });

        const monthRangeLabel = document.getElementById('monthRangeLabel');
        slider.noUiSlider.on('update', (values) => {
            selectedMonthRange = values.map(v => parseInt(v));
            monthRangeLabel.textContent = `Tháng ${selectedMonthRange[0]} - Tháng ${selectedMonthRange[1]}`;
            if (chartType === 'bar') updateChart();
        });


        document.getElementById('barChartBtn').addEventListener('click', () => {
            chartType = 'bar';
            slider.parentElement.style.display = 'block';
            updateChart();
        });

        function filterData() {
            return rawData.filter(item => {
                const month = Number(item.month);
                if (selectedYear && Number(item.year) !== selectedYear) return false;
                if (month < selectedMonthRange[0] || month > selectedMonthRange[1]) return false;
                return true;
            });
        }

        function selectYear(year) {
            selectedYear = year;

            // Update active button
            document.querySelectorAll('#yearFilterButtons button').forEach(btn => {
                btn.classList.remove('bg-indigo-600', 'text-white', 'border-indigo-600', 'hover:bg-indigo-700');
                btn.classList.add('bg-white', 'text-gray-700', 'border-gray-300', 'hover:bg-gray-50');
            });

            const activeBtn = [...document.querySelectorAll('#yearFilterButtons button')]
                .find(btn => btn.textContent == year);
            if (activeBtn) {
                activeBtn.classList.remove('bg-white', 'text-gray-700', 'border-gray-300', 'hover:bg-gray-50');
                activeBtn.classList.add('bg-indigo-600', 'text-white', 'border-indigo-600', 'hover:bg-indigo-700');
            }

            updateChart();
        }

        function updateChart() {
            const filtered = filterData();

            const datasets = [{
                    label: 'Xuất kho',
                    key: 'xuat_kho',
                    color: 'rgba(96,165,250,0.7)'
                },
                {
                    label: 'Nhập kho',
                    key: 'nhap_kho',
                    color: 'rgba(74,222,128,0.7)'
                },
                {
                    label: 'Thu hồi',
                    key: 'thu_hoi',
                    color: 'rgba(252,165,165,0.7)'
                },
                {
                    label: 'Biến động tồn kho',
                    key: 'ton_kho',
                    color: 'rgba(134,139,172,0.7)'
                }
            ];

            // Nếu không có dữ liệu, tạo placeholder
            const chartData = filtered.length ? filtered : [{
                date: new Date().toISOString().slice(0, 10),
                xuat_kho: 0,
                nhap_kho: 0,
                thu_hoi: 0,
                ton_kho: 0
            }];

            if (!chart) {
                chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        datasets: datasets.map(ds => ({
                            label: ds.label,
                            data: chartData.map(i => ({
                                y: i.date,
                                x: i[ds.key]
                            })),
                            backgroundColor: ds.color,
                            hoverBackgroundColor: ds.color.replace('0.7', '0.4'),
                            borderRadius: 2,
                            minBarLength: 6
                        }))
                    },
                    options: {
                        responsive: true,
                        indexAxis: 'y',
                        scales: {
                            y: {
                                type: 'time',
                                time: {
                                    parser: 'yyyy-MM-dd',
                                    unit: 'month',
                                    tooltipFormat: 'dd/MM/yyyy'
                                },
                                ticks: {
                                    callback: v => `Tháng ${new Date(v).getMonth()+1}`
                                }
                            },
                            x: {
                                beginAtZero: true,
                                max: MAX_VALUE,
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
                                formatter: val => Math.round(val.x),
                                color: '#000',
                                font: {
                                    weight: 'bold',
                                    size: 12
                                },
                                offset: 4
                            },
                            legend: {
                                position: 'top',
                                align: 'end',
                                labels: {
                                    padding: 20,
                                    boxWidth: 20,
                                    font: {
                                        size: 14
                                    }
                                }
                            },
                            title: {
                                display: true,
                                position: 'bottom',
                                text: 'Biểu đồ thanh: dữ liệu biến động tồn kho linh kiện theo tháng',
                                font: {
                                    size: 18,
                                    weight: 'bold'
                                },
                                padding: {
                                    top: 10,
                                    bottom: 20
                                }
                            }
                        }
                    }
                });
            } else {
                // chỉ cập nhật dữ liệu
                chart.data.datasets.forEach(ds => {
                    const config = datasets.find(c => c.label === ds.label);
                    ds.data = chartData.map(i => ({
                        y: i.date,
                        x: i[config.key]
                    }));
                });
                chart.update();
            }
        }


        document.addEventListener('DOMContentLoaded', () => {

            updateChart();
        });
    </script>
</div>
