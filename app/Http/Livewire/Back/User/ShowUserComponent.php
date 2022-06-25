<?php

namespace App\Http\Livewire\Back\User;

use App\Models\User;
use Livewire\Component;

class ShowUserComponent extends Component
{
    public $user_id;

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
        return view('livewire.back.user.show-user-component')->extends('layouts.contentLayoutMaster', ['breadcrumbs' => $breadcrumbs])->section('content');
    }
}
