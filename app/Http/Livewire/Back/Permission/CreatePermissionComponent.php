<?php

namespace App\Http\Livewire\Back\Permission;

use Livewire\Component;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;

class CreatePermissionComponent extends Component
{
    public $name;

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'min:3', Rule::unique('permissions', 'name')],
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        $breadcrumbs = [
            ['link' => 'permission', 'name' => __('Permissions')], ['name' => __('Create')]
        ];
        return view('livewire.back.permission.create-permission-component')->extends('layouts.contentLayoutMaster', ['breadcrumbs' => $breadcrumbs])->section('content');
    }

    public function createPermission()
    {
        $this->validate();

        Permission::create(['name' => $this->name, 'guard_name' => 'web']);

        $this->emit('swal:alert', [
            'icon' => 'success',
            'title' => config('dev-master.name'),
            'text'  => __('Permission successfully created'),
            'timeout' => 10000
        ]);
    }
}
