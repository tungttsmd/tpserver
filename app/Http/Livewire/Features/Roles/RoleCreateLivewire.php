<?php

namespace App\Http\Livewire\Features\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoleCreateLivewire extends Component
{
    public $name = '';
    public $displayName = '';
    public $description = '';
    public $selectedPermissions = [];
    public $permissionGroups = [];

    // Permission group arrays for checkboxes
    public $permission_user = [];
    public $permission_role = [];
    public $permission_component = [];
    public $permission_export = [];
    public $permission_recall = [];
    public $permission_location = [];
    public $permission_vendor = [];
    public $permission_customer = [];
    public $permission_log = [];
    public $permission_profile = [];
    public $permission_item = [];
    public $permission_stock = [];
    public $permission_scan = [];

    protected $listeners = ['routeRefreshCall' => '$refresh', 'createSubmit' => 'createSubmit'];
    public function mount()
    {
        $this->loadPermissionGroups();
    }
    protected function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-z0-9_-]+$/',
                'unique:roles,name'
            ],
            'displayName' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ];
    }

    protected $messages = [
        'name.regex' => 'Tên vai trò chỉ được chứa chữ thường, số, gạch dưới và gạch ngang.',
        'name.unique' => 'Tên vai trò đã tồn tại.',
    ];

    protected function loadPermissionGroups()
    {
        // Get all permissions grouped by their prefix
        $permissions = Permission::orderBy('name')->get();
        $groups = [];

        foreach ($permissions as $permission) {
            $group = Str::before($permission->name, '.');
            $action = Str::after($permission->name, '.');

            // Initialize group if not exists
            if (!isset($groups[$group])) {
                $groups[$group] = [];
            }

            $groups[$group][] = [
                'name' => $permission->name,
                'display_name' => $permission->display_name ?? $this->formatPermissionName($action),
                'group' => $group,
                'action' => $action
            ];

            // Initialize permission group arrays for checkboxes
            $property = 'permission_' . $group;
            if (property_exists($this, $property)) {
                $this->{$property} = [];
            }
        }

        ksort($groups);
        $this->permissionGroups = $groups;
    }

    protected function formatPermissionName($action)
    {
        $actionMap = [
            'view' => 'Xem',
            'create' => 'Thêm mới',
            'edit' => 'Sửa',
            'delete' => 'Xóa',
            'import' => 'Nhập',
            'export' => 'Xuất',
            'restore' => 'Khôi phục',
            'forceDelete' => 'Xóa vĩnh viễn',
        ];

        return $actionMap[$action] ?? ucfirst(str_replace('_', ' ', $action));
    }

    public function updated($property, $value)
    {
        // Handle permission group checkboxes
        if (Str::startsWith($property, 'permission_') && Str::endsWith($property, '_all')) {
            $group = Str::before(Str::after($property, 'permission_'), '_all');
            $this->toggleAllPermissions($group, (bool)$value);
        }
    }

    protected function toggleAllPermissions($group, $checked)
    {
        $property = 'permission_' . $group;
        if (property_exists($this, $property)) {
            if ($checked) {
                // Add all permissions of this group
                $this->selectedPermissions = array_unique(array_merge(
                    $this->selectedPermissions,
                    collect($this->permissionGroups[$group] ?? [])->pluck('name')->toArray()
                ));
            } else {
                // Remove all permissions of this group
                $this->selectedPermissions = array_diff(
                    $this->selectedPermissions,
                    collect($this->permissionGroups[$group] ?? [])->pluck('name')->toArray()
                );
            }
            $this->syncPermissionGroups();
        }
    }

    protected function syncPermissionGroups()
    {
        // Update individual permission group arrays based on selected permissions
        foreach ($this->permissionGroups as $group => $permissions) {
            $property = 'permission_' . $group;
            if (property_exists($this, $property)) {
                $this->$property = array_intersect(
                    $this->selectedPermissions,
                    collect($permissions)->pluck('name')->toArray()
                );
            }
        }
    }

    public function createSubmit()
    {
        try {
            $this->validate();

            DB::beginTransaction();

            // Create the role
            $role = Role::create([
                'name' => $this->name,
                'display_name' => $this->displayName,
                'description' => $this->description,
                'guard_name' => 'web'
            ]);

            // Sync permissions
            if (!empty($this->selectedPermissions)) {
                $role->syncPermissions($this->selectedPermissions);
            }

            DB::commit();

            session()->flash('success', 'Tạo vai trò thành công!');
            return redirect()->route('role.index');
        } catch (ValidationException $e) {
            DB::rollBack();
            $errors = $e->validator->errors()->toArray();
            $messages = collect($errors)->flatten()->implode(' ');

            $this->dispatchBrowserEvent('danger-alert', [
                'message' => 'Dữ liệu không hợp lệ, vui lòng kiểm tra lại!',
                'errors' => $errors,
                'messages' => $messages,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Có lỗi xảy ra khi tạo vai trò: ' . $e->getMessage());
            Log::error('Role creation error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function resetForm()
    {
        $this->reset([
            'name',
            'displayName',
            'description',
            'selectedPermissions',
            'permission_user',
            'permission_role',
            'permission_component',
            'permission_export',
            'permission_recall',
            'permission_location',
            'permission_vendor',
            'permission_customer',
            'permission_log',
            'permission_profile',
            'permission_item',
            'permission_stock',
            'permission_scan',
        ]);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.features.roles.create');
    }
}
