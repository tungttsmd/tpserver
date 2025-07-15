<form class="grow inline-flex w-full hv-opacity" method="POST" action="{{ route('components.scanpost') }}">
    @csrf
    {{-- SERIAL NUMBER tách riêng để thêm autofocus --}}
    <div class="scan-box w-full">
        <div class="input-group flex-nowrap w-full">
            <button type="submit" style="border-top-right-radius: 0px; border-bottom-right-radius: 0px"
                class="align-items-center inline-flex flex-nowrap text-main btn bg-white btn-hover">
                <i class="fas fa-qrcode mr-2"></i> Scan
            </button>
            <input type="text" name="serial_number" id="serial_number"
                class="flex-nowrap inline-flex form-control input-hover" value="{{ old('serial_number') }}" required
                placeholder="Scan linh kiện..." autofocus>
        </div>
    </div>
</form>