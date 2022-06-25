<?php

namespace App\Http\Livewire\Back\User;

use Livewire\Component;

class ShowUserComponent extends Component
{
    public function render()
    {
        return view('livewire.back.user.show-user-component')->extends('layouts.contentLayoutMaster', ['breadcrumbs' => $breadcrumbs])->section('content');
    }
}
