<?php

namespace App\Http\Livewire\Back\User;

use Livewire\Component;

class CreateUserComponent extends Component
{
    public function render()
    {
        $breadcrumbs = [
            ['link'=>"users.index",'name'=> __('Users list')], ['name'=> __('Create')]
        ];
        return view('livewire.back.user.create-user-component')->extends('layouts.contentLayoutMaster', ['breadcrumbs' => $breadcrumbs])->section('content');
    }
}
