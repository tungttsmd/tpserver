@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <!-- Tìm kiếm -->
        <div class="mb-3">
            <div class="input-group shadow-sm">
                <span class="input-group-text bg-white">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" id="searchInput" class="form-control" placeholder="Tìm kiếm...">
            </div>
        </div>

        <!-- Bảng dữ liệu -->
        <div class="table-responsive rounded shadow-sm">
            <table class="table table-bordered text-center align-middle custom-table">
                <thead class="bg-primary text-white">
                    <tr>
                        <th class="sortable" data-column="0" style="width: 5%;">ID <i class="fas fa-sort ms-1"></i></th>
                        <th class="sortable" data-column="1" style="width: 15%;">User ID <i class="fas fa-sort ms-1"></i>
                        </th>
                        <th class="sortable" data-column="2" style="width: 20%;">Serial Number <i
                                class="fas fa-sort ms-1"></i></th>
                        <th class="sortable" data-column="3" style="width: 25%;">Recall Reason <i
                                class="fas fa-sort ms-1"></i></th>
                        <th class="sortable" data-column="4" style="width: 20%;">Created At <i class="fas fa-sort ms-1"></i>
                        </th>
                    </tr>
                </thead>
                <tbody id="logTable">
                    @foreach ($logs as $log)
                        <tr>
                            <td>{{ $log->id }}</td>
                            <td>{{ $log->user_id }}</td>
                            <td>{{ $log->serial_number }}</td>
                            <td>{{ $log->export_reason }}</td>
                            <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- CSS & JS giống như bạn đã có cho sắp xếp & tìm kiếm -->

    <script>
        const searchInput = document.getElementById('searchInput');
        const tableBody = document.getElementById('logTable');
        const headers = document.querySelectorAll('th.sortable');
        let sortDirection = {};

        searchInput.addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            const rows = tableBody.querySelectorAll('tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });

        headers.forEach(header => {
            header.addEventListener('click', function() {
                const column = this.getAttribute('data-column');
                const rowsArray = Array.from(tableBody.querySelectorAll('tr'));
                sortDirection[column] = !sortDirection[column];

                rowsArray.sort((a, b) => {
                    const aText = a.children[column].textContent.trim().toLowerCase();
                    const bText = b.children[column].textContent.trim().toLowerCase();

                    if (!isNaN(Date.parse(aText)) && !isNaN(Date.parse(bText))) {
                        return sortDirection[column] ?
                            new Date(aText) - new Date(bText) :
                            new Date(bText) - new Date(aText);
                    } else if (!isNaN(aText) && !isNaN(bText)) {
                        return sortDirection[column] ?
                            aText - bText :
                            bText - aText;
                    } else {
                        return sortDirection[column] ?
                            aText.localeCompare(bText) :
                            bText.localeCompare(aText);
                    }
                });

                tableBody.innerHTML = '';
                rowsArray.forEach(row => tableBody.appendChild(row));

                headers.forEach(h => h.innerHTML = h.textContent.trim() +
                    ' <i class="fas fa-sort ms-1"></i>');
                this.innerHTML = this.textContent.trim() + (
                    sortDirection[column] ?
                    ' <i class="fas fa-sort-amount-up ms-1"></i>' :
                    ' <i class="fas fa-sort-amount-down ms-1"></i>'
                );
            });
        });
    </script>
@endsection
