<?php

namespace App\Http\Livewire\Back\Role;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class RoleComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['delete' => 'deleteRole'];

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $breadcrumbs = [
            ['link' => 'roles.index', 'name' => __('Role')]
        ];

        if (!empty($this->search)) {
            $roles = Role::where('name', 'like', '%'.$this->search.'%')->orderBy('name')->paginate(7);
        } else {
            $roles = Role::orderBy('name')->paginate(7);
        }
        return view('livewire.back.role.role-component', compact('roles'))->extends('layouts.contentLayoutMaster', ['breadcrumbs' => $breadcrumbs])->section('content');
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

    public function deleteRole($id)
    {
        $role = Role::findById($id);

        if ($role->name == 'Super Admin') {
            $this->emit('swal:alert', [
                'icon' => 'warning',
                'title' => config('dev-master.name'),
                'text'  => __('The role cannot be deleted'),
                'timeout' => 10000
            ]);
            return;
        }
        $role->delete();

        $this->emit('swal:alert', [
            'icon' => 'success',
            'title' => config('dev-master.name'),
            'text'  => __('Role successfully deleted'),
            'timeout' => 10000
        ]);
    }
}
