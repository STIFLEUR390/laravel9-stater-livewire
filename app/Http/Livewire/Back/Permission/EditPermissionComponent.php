<?php

namespace App\Http\Livewire\Back\Permission;

use Livewire\Component;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class EditPermissionComponent extends Component
{
    public $name;
    public $role_name;
    public $permission_id;

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'min:3', Rule::unique('permissions', 'name')->ignore($this->permission_id)],
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount($id)
    {
        $permission = Permission::findById($id);
        $this->name = $permission->name;
        $this->permission_id = $permission->id;
    }

    public function render()
    {
        $breadcrumbs = [
            ['link' => 'permission', 'name' => __('Permissions')], ['name' => __('Edit')]
        ];
        $roles = Role::all();
        $permission = Permission::findById($this->permission_id);
        return view('livewire.back.permission.edit-permission-component', compact('roles', 'permission'))->extends('layouts.contentLayoutMaster', ['breadcrumbs' => $breadcrumbs])->section('content');
    }

    public function updatePermission()
    {
        $this->validate();

        $permission = Permission::findById($this->permission_id);
        $permission->name = $this->name;
        $permission->save();

        $this->emit('swal:alert', [
            'icon' => 'success',
            'title' => config('dev-master.name'),
            'text'  => __('Permission successfully updated'),
            'timeout' => 10000
        ]);
    }

    public function assignRole()
    {
        $this->validate([
            'role_name' => 'required',
        ]);
        $permission = Permission::findByName($this->name);

        if ($permission->hasRole($this->role_name)) {
            $this->addError('email', __('The role has already been given to :permision permision', ['permision' => $permission->name]));
            $this->emit('swal:alert', [
                'icon' => 'warning',
                'title' => config('dev-master.name'),
                'text'  => __('The role has already been given to :permision permision', ['permision' => $permission->name]),
                'timeout' => 10000
            ]);

            return;
        }

        $permission->assignRole($this->role_name);

        $this->emit('swal:alert', [
            'icon' => 'success',
            'title' => config('dev-master.name'),
            'text'  => __('The role was successfully granted to :permision permision', ['permision' => $permission->name]),
            'timeout' => 10000
        ]);
    }

    public function removeRole($role_id)
    {
        $permission = Permission::findById($this->permission_id);
        $role = Role::findById($role_id);

        if (!$permission->hasRole($role)) {
            $this->emit('swal:alert', [
                'icon' => 'warning',
                'title' => config('dev-master.name'),
                'text'  => __('The :permision permision has not been granted to the role :role', ['permision' => $permission->name, 'role' => $role->name]),
                'timeout' => 10000
            ]);

            return;
        }

        $permission->removeRole($role);

        $this->emit('swal:alert', [
            'icon' => 'success',
            'title' => config('dev-master.name'),
            'text'  => __('The role was successfully remove to :permision permision', ['permision' => $permission->name]),
            'timeout' => 10000
        ]);
    }
}
