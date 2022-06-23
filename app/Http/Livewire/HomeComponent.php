<?php

namespace App\Http\Livewire;

use Livewire\Component;

class HomeComponent extends Component
{
    public function render()
    {
        $breadcrumbs = [
            ['link'=>"/dashboard",'name'=> __('Dashboard')]
        ];
        return view('livewire.home-component')->extends('layouts.contentLayoutMaster', ['breadcrumbs' => $breadcrumbs])->section('content');
    }
}
