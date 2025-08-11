@props([
    'name' => '',
    'phone' => '',
    'email' => '',
    'address' => '',
    'avatar_url' => '',
    'note' => '',
])

<div class="flex flex-col md:flex-row gap-8 p-4 w-full">
    {{-- Cột phải: Avatar + Thông tin xem trước --}}
    <div class="md:w-1/2 flex flex-col gap-12 p-4">
        {{-- Avatar --}}
        <div class="flex items-center justify-center border-2 border-dashed border-gray-300 rounded-2xl p-4 min-h-[150px]">
            <img
                id="avatarPreview"
                src="{{ $avatar_url ?: 'https://via.placeholder.com/150' }}"
                alt="Avatar"
                class="mr-12 max-w-[70%] max-h-[70%] object-contain rounded-full"
            />
            @unless ($avatar_url)
                <p class="text-sm text-gray-500 mr-16">Ảnh đại diện sẽ hiển thị tại đây</p>
            @endunless
        </div>

        {{-- Thông tin xem trước --}}
        <div class="flex-1 overflow-y-auto bg-white border rounded-xl p-4 max-h-[300px]">
            <h5 class="text-green-600 font-semibold mb-3 flex items-center">
                <i class="fas fa-info-circle mr-2"></i> Thông tin khách hàng
            </h5>
            <ul class="text-sm divide-y divide-gray-200">
                <li class="py-2"><strong>Tên:</strong> <span id="previewName">{{ $name ?: '-' }}</span></li>
                <li class="py-2"><strong>Điện thoại:</strong> <span id="previewPhone">{{ $phone ?: '-' }}</span></li>
                <li class="py-2"><strong>Email:</strong> <span id="previewEmail">{{ $email ?: '-' }}</span></li>
                <li class="py-2"><strong>Địa chỉ:</strong> <span id="previewAddress">{{ $address ?: '-' }}</span></li>
                <li class="py-2"><strong>Ghi chú:</strong> <span id="previewNote">{{ $note ?: '-' }}</span></li>
            </ul>
        </div>
    </div>

    {{-- Cột trái: Form nhập --}}
    <div class="md:w-1/2 border-l pl-8">
        <form id="customerForm" class="space-y-6">
            @php
                $inputClass = "w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent";
            @endphp

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Tên <span class="text-red-500">*</span></label>
                <input id="name" name="name" type="text" required class="{{ $inputClass }}" value="{{ $name }}">
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Điện thoại <span class="text-red-500">*</span></label>
                <input id="phone" name="phone" type="tel" required class="{{ $inputClass }}" value="{{ $phone }}">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                <input id="email" name="email" type="email" required class="{{ $inputClass }}" value="{{ $email }}">
            </div>

            <div>
                <label for="address" class="block text-sm font-medium text-gray-700">Địa chỉ</label>
                <input id="address" name="address" type="text" class="{{ $inputClass }}" value="{{ $address }}">
            </div>

            <div>
                <label for="avatar_url" class="block text-sm font-medium text-gray-700">Ảnh đại diện (URL)</label>
                <input id="avatar_url" name="avatar_url" type="url" class="{{ $inputClass }}" placeholder="Dán link ảnh để xem trước" value="{{ $avatar_url }}">
            </div>

            <div>
                <label for="note" class="block text-sm font-medium text-gray-700">Ghi chú</label>
                <textarea id="note" name="note" rows="3" class="{{ $inputClass }}">{{ $note }}</textarea>
            </div>

            <button type="submit"
                class="inline-flex items-center justify-center rounded bg-green-600 px-4 py-2 text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2">
                <i class="fas fa-save mr-2"></i> Lưu thông tin
            </button>
        </form>
    </div>
</div>

<script>
    const form = document.getElementById('customerForm');
    const avatarPreview = document.getElementById('avatarPreview');

    form.addEventListener('input', () => {
        document.getElementById('previewName').textContent = form.name.value || '-';
        document.getElementById('previewPhone').textContent = form.phone.value || '-';
        document.getElementById('previewEmail').textContent = form.email.value || '-';
        document.getElementById('previewAddress').textContent = form.address.value || '-';
        document.getElementById('previewNote').textContent = form.note.value || '-';

        if (form.avatar_url.value) {
            avatarPreview.src = form.avatar_url.value;
        } else {
            avatarPreview.src = 'https://via.placeholder.com/150';
        }
    });
</script>
