<?php

namespace App\Http\Livewire\Back\Role;

use Livewire\Component;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class CreateRoleComponent extends Component
{
    public $name;

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'min:3', Rule::unique('roles', 'name')],
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        $breadcrumbs = [
            ['link' => 'roles.index', 'name' => __('Role')], ['name' => __('Create')]
        ];
        return view('livewire.back.role.create-role-component')->extends('layouts.contentLayoutMaster', ['breadcrumbs' => $breadcrumbs])->section('content');
    }

    public function createRole()
    {
        $this->validate();

        $role = Role::create(['name' => $this->name, 'guard_name' => 'web']);

        $role->givePermissionTo('base');

        $this->emit('swal:alert', [
            'icon' => 'success',
            'title' => config('dev-master.name'),
            'text'  => __('Role successfully created'),
            'timeout' => 10000
        ]);
    }
}
