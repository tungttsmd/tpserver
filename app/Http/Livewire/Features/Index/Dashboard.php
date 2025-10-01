<?php

namespace App\Http\Livewire\Features\Index;

use Livewire\Component;
use App\Models\Component as ComponentModel;
use App\Models\LogComponent;
use App\Models\Category;
use Carbon\Carbon;

class Dashboard extends Component
{
    public $stats = [
        'total_components' => 0,
        'available_components' => 0,
        'stockout_components' => 0,
        'total_categories' => 0,
    ];

    public $recentActivities = [];

    public function mount()
    {
        $this->loadStats();
        $this->loadRecentActivities();
    }

    protected function loadStats()
    {
        $this->stats = [
            'total_components' => ComponentModel::count(),
            'available_components' => ComponentModel::where('status_id', 1)->count(),
            'stockout_components' => ComponentModel::where('status_id', 2)->count(),
            'total_categories' => Category::count(),
        ];
    }

    protected function loadRecentActivities()
    {
        $this->recentActivities = LogComponent::with(['component', 'user', 'action'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($log) {
                return [
                    'id' => $log->id,
                    'action' => $log->action ? $log->action->name : 'Unknown Action',
                    'component' => $log->component ? $log->component->name : 'Unknown Component',
                    'user' => $log->user->alias,
                    'username' => $log->user->username,
                    'note' => $log->action->note,
                    'time_ago' => $log->created_at ? $log->created_at->diffForHumans() : 'Just now',
                    'icon' => $this->getActionIcon($log->action ? $log->action->name : ''),
                ];
            });
    }

    protected function getActionIcon($actionName)
    {
        $icons = [
            'create' => 'M12 6v6m0 0v6m0-6h6m-6 0H6',
            'update' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z',
            'delete' => 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16',
            'checkout' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
            'checkin' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01',
            'default' => 'M12 6v6m0 0v6m0-6h6m-6 0H6'
        ];

        $action = strtolower($actionName);
        $icon = $icons['default'];

        if (str_contains($action, 'create') || str_contains($action, 'thêm')) {
            $icon = $icons['create'];
        } elseif (str_contains($action, 'update') || str_contains($action, 'cập nhật')) {
            $icon = $icons['update'];
        } elseif (str_contains($action, 'delete') || str_contains($action, 'xóa')) {
            $icon = $icons['delete'];
        } elseif (str_contains($action, 'checkout') || str_contains($action, 'xuất')) {
            $icon = $icons['checkout'];
        } elseif (str_contains($action, 'checkin') || str_contains($action, 'nhập')) {
            $icon = $icons['checkin'];
        }

        return $icon;
    }

    public function render()
    {
        return view('livewire.features.index.dashboard', [
            'stats' => $this->stats,
            'recentActivities' => $this->recentActivities
        ]);
    }
}
