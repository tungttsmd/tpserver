@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Tìm kiếm -->
    <div class="mb-3">
        <div class="input-group shadow-sm">
            <span class="input-group-text bg-white">
                <i class="fas fa-search text-muted"></i>
            </span>
            <input type="text" id="searchInput" class="form-control" placeholder="Tìm kiếm linh kiện...">
        </div>
    </div>


    <!-- Bảng dữ liệu -->
    <div class="table-responsive rounded shadow-sm">
        <table
            class="fixed-table table table-bordered text-center align-middle bg-primary-subtle text-dark rounded custom-table">
            <thead class="bg-primary text-white">
                <tr>
                    <th class="sortable" data-column="0" style="width: 20%;">Tạo lúc <i class="fas fa-sort ms-1"></i></th>
                    <th class="sortable" data-column="1" style="width: 20%;">Người thực hiện <i class="fas fa-sort ms-1"></i></th>
                    <th class="sortable" data-column="2" style="width: 20%;">Hành động <i class="fas fa-sort ms-1"></i></th>
                    <th class="sortable" data-column="3" style="width: 40%;">Nội dung <i class="fas fa-sort ms-1"></i></th>
                </tr>
            </thead>
            <tbody id="componentTable">
                @foreach ($logs as $log)
                <tr>
                    <td class="text-left">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                    <td class="text-left">{{ $log->user }}</td>
                    <td class="text-left">{{ $log->action }}</td>
                    <td class="text-left">{{ $log->note }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- CSS -->
<style>
    .sortable {
        cursor: pointer;
        user-select: none;
    }

    .custom-table td,
    .custom-table th {
        vertical-align: middle;
        background-color: #f0f4ff !important;
        /* Giữ nền nhạt xanh-tím */
    }

    .custom-table tr:hover td {
        background-color: #f0f4ff !important;
        /* Không đổi màu khi hover */
    }

    .custom-table thead th {
        background-color: #4b6cb7 !important;
        /* Màu tím xanh đậm */
        color: white !important;
    }

    .fixed-table {
        table-layout: fixed;
        width: 100%;
        margin-bottom: 0 !important;

    }

    .fixed-table th,
    .fixed-table td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .table thead tr:hover th {
        background-color: inherit !important;
    }

    .table tbody tr:hover td {
        background-color: #e8f0ff !important;
    }
</style>

<!-- JS tìm kiếm + sắp xếp -->
<script>
    const searchInput = document.getElementById('searchInput');
    const tableBody = document.getElementById('componentTable');
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
