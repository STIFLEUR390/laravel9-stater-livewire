<?php

namespace App\Http\Livewire\Back\User;

use Livewire\Component;

class EditUserComponent extends Component
{
    public function render()
    {
        $breadcrumbs = [
            ['link'=>"users.index",'name'=> __('Users list')], ['name'=> __('Edit')]
        ];
        return view('livewire.back.user.edit-user-component')->extends('layouts.contentLayoutMaster', ['breadcrumbs' => $breadcrumbs])->section('content');
    }
}
