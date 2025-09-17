<x-atoms.form.submit submit="updateSubmit">
    <div class="flex flex-col gap-3 overflow-y-auto">
        <h3 class="text-lg font-medium text-gray-900 mb-6">Phân quyền người dùng</h3>
        <x-atoms.form.radio live="roleId" :options="$options" key="id" value="display_name"
            :keyDefault="$roleId" />
        <div class="flex justify-end">
            <x-atoms.form.button type="submit" label="Cập nhật" />
        </div>
    </div>
</x-atoms.form.submit>
