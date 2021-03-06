<?php

namespace App\Http\Livewire\Back\Permission;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class PermissionComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['delete' => 'deletePermission'];

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $breadcrumbs = [
            ['link' => 'permissions.index', 'name' => __('Permissions')]
        ];

        if (!empty($this->search)) {
            $permissions = Permission::where('name', 'like', '%'.$this->search.'%')->orderBy('name')->paginate(7);
        } else {
            $permissions = Permission::orderBy('name')->paginate(7);
        }
        return view('livewire.back.permission.permission-component', compact('permissions'))->extends('layouts.contentLayoutMaster', ['breadcrumbs' => $breadcrumbs])->section('content');
    }

    public function confirmDeletion($id)
    {
        $this->emit("swal:confirm", [
            'type'        => 'warning',
            'title'       => __('Are you sure?'),
            'text'        => __("You won't be able to revert this!"),
            'confirmText' => __('Yes, delete!'),
            'method'      => 'delete',
            'params'      => $id, // optional, send params to success confirmation
            'callback'    => '', // optional, fire event if no confirmed
        ]);
    }

    public function deletePermission($id)
    {
        $permission = Permission::findById($id);
        $permission->delete();

        $this->emit('swal:alert', [
            'icon' => 'success',
            'title' => config('dev-master.name'),
            'text'  => __('Permission successfully deleted'),
            'timeout' => 10000
        ]);
    }
}
