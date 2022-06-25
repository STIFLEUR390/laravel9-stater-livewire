<?php

namespace App\Http\Livewire\Back\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['delete' => 'deleteUser'];

    public $search = '';
    public $role = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingRole()
    {
        $this->resetPage();
    }


    public function render()
    {
        $breadcrumbs = [
            ['link' => "users.index", 'name' => __('Users list')]
        ];


        if (!empty($this->search) && !empty($this->role)) {
            $users = User::withTrashed()->role($this->role)->Where(function($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                      ->orWhere('email', 'like', '%'.$this->search.'%');
            })->paginate(7);
        } else if (!empty($this->search)) {
            $users = User::withTrashed()->Where(function($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                      ->orWhere('email', 'like', '%'.$this->search.'%');
            })->paginate(7);
        } else if (!empty($this->role)) {
            $users = User::withTrashed()->role($this->role)->paginate(7);
        }
        else {
            $users = User::withTrashed()->paginate(7);
        }


        $user_count = User::withTrashed()->count();
        $active_users = User::withTrashed()->whereNull("deleted_at")->count();
        $pending_users = $user_count - $active_users;
        $roles = Role::all();
        return view('livewire.back.user.user-component', compact('roles', 'users', 'user_count', 'active_users', 'pending_users'))->extends('layouts.contentLayoutMaster', ['breadcrumbs' => $breadcrumbs])->section('content');
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

    public function disableUser($id)
    {
        $user = User::find($id);
        if (Auth::user()->id != $user->id && !$user->hasRole('Super Admin')) {
            $user->delete();
            $this->emit('swal:alert', [
                'icon' => 'success',
                'title' => config('dev-master.name'),
                'text'  => __('The user has been successfully deactivated'),
                'timeout' => 10000
            ]);

            return;
        }

        $this->emit('swal:alert', [
            'icon' => 'warning',
            'title' => config('dev-master.name'),
            'text'  => __('Cannot deactivate this user'),
            'timeout' => 10000
        ]);
    }

    public function restoreUser($id)
    {
        User::withTrashed()->whereId($id)->firstOrFail()->restore();

        $this->emit('swal:alert', [
            'icon' => 'success',
            'title' => config('dev-master.name'),
            'text'  => __('User has been successfully activated'),
            'timeout' => 10000
        ]);
    }

    public function deleteUser($id)
    {
        User::withTrashed()->whereId($id)->firstOrFail()->forceDelete();

        $this->emit('swal:alert', [
            'icon' => 'success',
            'title' => config('dev-master.name'),
            'text'  => __('User has been successfully deleted'),
            'timeout' => 10000
        ]);
    }
}
