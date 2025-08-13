<div class="">
    <div class="space-y-6">
        <div>
            <label class="font-medium text-gray-700">Chọn trạng thái:</label>
            <select id="statusFilter" class="border rounded px-2 py-1">
                <option value="all">Tất cả</option>
                <option value="ton_kho">Đang tồn kho</option>
                <option value="da_xuat_kho">Đã xuất kho</option>
                <option value="con_bao_hanh">Còn bảo hành</option>
                <option value="het_bao_hanh">Hết bảo hành</option>
            </select>
        </div>
        <div class="flex flex-wrap gap-4 items-center mb-4">
            <div>
                <label class="font-medium text-gray-700">Chọn năm:</label>
                <select id="yearFilter" class="border rounded px-2 py-1">
                    <option value="all">Tất cả</option>
                    @foreach ($components->pluck('year')->unique() as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="font-medium text-gray-700">Chọn phân loại:</label>
                <select id="categoryFilter" class="border rounded px-2 py-1">
                    <option value="all">Tất cả</option>
                    @foreach ($categories as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        {{-- Tiêu đề --}}
        <h1 class="text-2xl font-bold text-gray-800">Thống kê linh kiện</h1>

        {{-- Chart --}}
        <div class="bg-white p-4 rounded-lg shadow">
            <canvas id="componentsChart" class="w-full h-[20vh]"></canvas>
        </div>

        {{-- Bảng thống kê --}}
        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left font-medium text-gray-700">Phân loại</th>
                        <th class="px-4 py-2 text-left font-medium text-gray-700">Năm</th>
                        <th class="px-4 py-2 text-left font-medium text-gray-700">Tháng</th>
                        <th class="px-4 py-2 text-left font-medium text-gray-700">Tổng</th>
                        <th class="px-4 py-2 text-left font-medium text-gray-700">Tồn kho</th>
                        <th class="px-4 py-2 text-left font-medium text-gray-700">Đã xuất kho</th>
                        <th class="px-4 py-2 text-left font-medium text-gray-700">Còn bảo hành</th>
                        <th class="px-4 py-2 text-left font-medium text-gray-700">Hết bảo hành</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($components as $row)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $categories[$row['category_id']] ?? 'Không rõ' }}</td>
                            <td class="px-4 py-2">{{ $row['year'] }}</td>
                            <td class="px-4 py-2">{{ $row['month'] }}</td>
                            <td class="px-4 py-2">{{ $row['total'] }}</td>
                            <td class="px-4 py-2">{{ $row['ton_kho'] }}</td>
                            <td class="px-4 py-2">{{ $row['da_xuat_kho'] }}</td>
                            <td class="px-4 py-2">{{ $row['con_bao_hanh'] }}</td>
                            <td class="px-4 py-2">{{ $row['het_bao_hanh'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>


    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const components = @json($components);
            const categories = @json($categories);
            const ctx = document.getElementById('componentsChart').getContext('2d');
            let chart;

            const today = new Date(); // dùng ngày hiện tại để so sánh bảo hành

            function updateChart() {
                const selectedYear = document.getElementById('yearFilter').value;
                const selectedCategory = document.getElementById('categoryFilter').value;
                const selectedStatus = document.getElementById('statusFilter').value;

                let filteredComponents = components.filter(i =>
                    (selectedYear === 'all' || i.year == selectedYear) &&
                    (selectedCategory === 'all' || i.category_id == selectedCategory)
                );

                // Lọc trạng thái
                filteredComponents = filteredComponents.filter(i => {
                    if (selectedStatus === 'ton_kho') return i.ton_kho > 0;
                    if (selectedStatus === 'da_xuat_kho') return i.da_xuat_kho > 0;
                    if (selectedStatus === 'con_bao_hanh') return i.con_bao_hanh > 0 && new Date(i
                        .bao_hanh_den) >= today;
                    if (selectedStatus === 'het_bao_hanh') return i.het_bao_hanh > 0 || new Date(i
                        .bao_hanh_den) < today;
                    return true; // all
                });

                const labels = [...new Set(filteredComponents.map(i => categories[i.category_id] ?? 'Không rõ'))];
                const tonKhoData = [];
                const xuatKhoData = [];
                const conBaoHanhData = [];

                labels.forEach(category => {
                    const items = filteredComponents.filter(i => (categories[i.category_id] ??
                        'Không rõ') === category);
                    tonKhoData.push(items.reduce((sum, item) => sum + item.ton_kho, 0));
                    xuatKhoData.push(items.reduce((sum, item) => sum + item.da_xuat_kho, 0));
                    conBaoHanhData.push(items.reduce((sum, item) => sum + item.con_bao_hanh, 0));
                });

                if (chart) chart.destroy();

                chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels,
                        datasets: [{
                                label: 'Tồn kho',
                                data: tonKhoData,
                                backgroundColor: 'rgba(54, 162, 235, 0.7)'
                            },
                            {
                                label: 'Đã xuất kho',
                                data: xuatKhoData,
                                backgroundColor: 'rgba(255, 99, 132, 0.7)'
                            },
                            {
                                label: 'Còn bảo hành',
                                data: conBaoHanhData,
                                backgroundColor: 'rgba(75, 192, 192, 0.7)'
                            },
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            }

            // Bắt sự kiện change
            document.getElementById('yearFilter').addEventListener('change', updateChart);
            document.getElementById('categoryFilter').addEventListener('change', updateChart);
            document.getElementById('statusFilter').addEventListener('change', updateChart);

            // Khởi tạo chart lần đầu
            updateChart();
        });
    </script>
</div>
