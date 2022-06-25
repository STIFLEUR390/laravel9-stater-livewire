<?php

namespace App\Http\Livewire\Back\Role;

use Livewire\Component;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class EditRoleComponent extends Component
{
    public $name;
    public $role_id;
    public $permission_name;

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'min:3', Rule::unique('roles', 'name')->ignore($this->role_id),],
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount($id)
    {
        $role = Role::findById($id);
        $this->name = $role->name;
        $this->role_id = $role->id;
    }

    public function render()
    {
        $breadcrumbs = [
            ['link' => 'roles.index', 'name' => __('Role')], ['name' => __('Edit')]
        ];
        $permissions = Permission::orderBy('name')->get();
        $role = Role::findById($this->role_id);
        return view('livewire.back.role.edit-role-component', compact('permissions', 'role'))->extends('layouts.contentLayoutMaster', ['breadcrumbs' => $breadcrumbs])->section('content');
    }

    public function editRole()
    {
        $this->validate();

        $role = Role::findById($this->role_id);
        $role->name = $this->name;
        $role->save();

        $this->emit('swal:alert', [
            'icon' => 'success',
            'title' => config('dev-master.name'),
            'text'  => __('Role successfully updated'),
            'timeout' => 10000
        ]);
    }

    public function givePermission()
    {
        $role = Role::findById($this->role_id);
        if ($role->hasPermissionTo($this->permission_name)) {
            $this->addError('give_ermission', __('Permission has already been given to role :role', ['role' => $role->name]));
            $this->emit('swal:alert', [
                'icon' => 'warning',
                'title' => config('dev-master.name'),
                'text'  => __('Permission has already been given to role :role', ['role' => $role->name]),
                'timeout' => 10000
            ]);

            return;
        }

        $role->givePermissionTo($this->permission_name);

        $this->emit('swal:alert', [
            'icon' => 'success',
            'title' => config('dev-master.name'),
            'text'  => __('Permision was successfully granted to the :role role', ['role'=> $role->name]),
            'timeout' => 10000
        ]);
    }

    public function revokePermission($permission_id)
    {
        $role = Role::findById($this->role_id);
        $permission = Permission::findById($permission_id);

        if (!$role->hasPermissionTo($permission)) {
            $this->emit('swal:alert', [
                'icon' => 'warning',
                'title' => config('dev-master.name'),
                'text'  => __('The role :role does not have permision to :permision', ['role' => $role->name, 'permision' => $permission->name]),
                'timeout' => 10000
            ]);
            return ;
        }

        $role->revokePermissionTo($permission);

        $this->emit('swal:alert', [
            'icon' => 'success',
            'title' => config('dev-master.name'),
            'text'  => __('Permision was successfully revoked to the :role role', ['role'=> $role->name]),
            'timeout' => 10000
        ]);
    }
}
