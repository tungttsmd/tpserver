        <div class="py-4 w-full">

            <table class="min-w-full border border-gray-300 text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-3 py-2 border">#</th>
                        <th class="px-3 py-2 border">Linh kiện ID</th>
                        <th class="px-3 py-2 border">Người dùng</th>
                        <th class="px-3 py-2 border">Hành động</th>
                        <th class="px-3 py-2 border">Ghi chú</th>
                        <th class="px-3 py-2 border">Ngày xuất kho</th>
                        <th class="px-3 py-2 border">Tạo lúc</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['componentLogs'] as $index => $log)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 border text-center">{{ $log->component->name ?? '---' }}</td>
                            <td class="px-3 py-2 border text-center">{{ $log->user->name ?? '---' }}</td>
                            <td class="px-3 py-2 border text-center">{{ $log->action->note ?? '---' }}</td>
                            <td class="px-3 py-2 border text-center">{{ $log->vendor->name ?? '---' }}</td>
                            <td class="px-3 py-2 border text-center">{{ $log->customer->name ?? '---' }}</td>
                            <td class="px-3 py-2 border text-center">{{ $log->location->name ?? '---' }}</td>
                            <td class="px-3 py-2 border text-center">{{ $log->note ?? '---' }}</td>
                            <td class="px-3 py-2 border">{{ $log->note }}</td>
                            <td class="px-3 py-2 border text-center">
                                {{ \Carbon\Carbon::parse($log->stockout_at)->format('d/m/Y') }}</td>
                            <td class="px-3 py-2 border text-center">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
