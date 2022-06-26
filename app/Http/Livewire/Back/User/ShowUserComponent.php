<?php

namespace App\Http\Livewire\Back\User;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class ShowUserComponent extends Component
{
    public $user_id;
    public $role_name;
    public $permission_name;

    public function mount($id)
    {
        $this->user_id = $id;
    }

    public function render()
    {
        $user = User::findOrFail($this->user_id);
        $breadcrumbs = [
            ['link'=>"users.index",'name'=> __('Users list')], ['name'=> $user->name]
        ];

        $permissions = Permission::orderBy('name')->get();
        $roles = Role::orderBy('name')->get();
        return view('livewire.back.user.show-user-component', compact('user', 'permissions', 'roles'))->extends('layouts.contentLayoutMaster', ['breadcrumbs' => $breadcrumbs])->section('content');
    }

    public function diseableUser()
    {
        $user = User::find($this->user_id);
        if (Auth::user()->id != $user->id && !$user->hasRole('Super Admin')) {
            $user->delete();

            $notification = array(
                'message' => __('The user has been successfully deactivated'),
                'alert-type' => 'success',
                'type' => 'toast',
            );
            return redirect()->route('users.index')->with($notification);
        }


        $this->emit('swal:alert', [
            'icon' => 'warning',
            'title' => config('dev-master.name'),
            'text'  => __('Cannot deactivate this user'),
            'timeout' => 10000
        ]);
    }

    public function assignRole()
    {
        $user = User::findOrFail($this->user_id);
        if ($user->hasRole($this->role_name)){
            $this->addError('assign_role', __('This role has already been assigned to the user'));

            $this->emit('swal:alert', [
                'icon' => 'warning',
                'title' => config('dev-master.name'),
                'text'  => __('This role has already been assigned to the user'),
                'timeout' => 10000
            ]);
            return;
        }
        $user->assignRole($this->role_name);

        $this->emit('swal:alert', [
            'icon' => 'success',
            'title' => config('dev-master.name'),
            'text'  => __('Role successfully assigned'),
            'timeout' => 10000
        ]);
    }

    public function removeRole($name)
    {
        $user = User::findOrFail($this->user_id);

        if ($user->hasRole($name)){
            $role = Role::findByName($name);

            $user->removeRole($role);

            $this->emit('swal:alert', [
                'icon' => 'success',
                'title' => config('dev-master.name'),
                'text'  => __('The role was successfully removed from the user'),
                'timeout' => 10000
            ]);
            return;
        }

        $this->emit('swal:alert', [
            'icon' => 'warning',
            'title' => config('dev-master.name'),
            'text'  => __('This role has not been assigned to the user'),
            'timeout' => 10000
        ]);
    }

    public function givePermission()
    {
        $user = User::findOrFail($this->user_id);

        if ($user->hasPermissionTo($this->permission_name)) {
            $this->addError('give_permission', __('This permission has already been given to the user'));

            $this->emit('swal:alert', [
                'icon' => 'warning',
                'title' => config('dev-master.name'),
                'text'  => __('This permission has already been given to the user'),
                'timeout' => 10000
            ]);
            return;

        }
        $user->givePermissionTo($this->permission_name);

        $this->emit('swal:alert', [
            'icon' => 'success',
            'title' => config('dev-master.name'),
            'text'  => __('Permission give successfully'),
            'timeout' => 10000
        ]);
    }

    public function revokePermission($name)
    {
        $user = User::findOrFail($this->user_id);

        if ($user->hasPermissionTo($name)){
            $permission = Permission::findByName($name);
            $user->revokePermissionTo($permission);

            $this->emit('swal:alert', [
                'icon' => 'success',
                'title' => config('dev-master.name'),
                'text'  =>  __('The permission was successfully removed from the user'),
                'timeout' => 10000
            ]);
            return;
        }

        $this->emit('swal:alert', [
            'icon' => 'warning',
            'title' => config('dev-master.name'),
            'text'  => __('The permission has not been given to the user'),
            'timeout' => 10000
        ]);
    }
}
