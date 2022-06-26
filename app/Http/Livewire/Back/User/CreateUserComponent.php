<?php

namespace App\Http\Livewire\Back\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;

class CreateUserComponent extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $profile_photo_path;

    protected function rules()
    {
        return [
            'name' => 'required|string|min:5|max:150',
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'profile_photo_path' => 'nullable|file|image|max:2048',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        $breadcrumbs = [
            ['link'=>"users.index",'name'=> __('Users list')], ['name'=> __('Create')]
        ];
        return view('livewire.back.user.create-user-component')->extends('layouts.contentLayoutMaster', ['breadcrumbs' => $breadcrumbs])->section('content');
    }

    public function createUser()
    {
        $this->validate();
        // $this->photo->storeAs('photos', 'avatar');

        if ($this->profile_photo_path) {
            $fileName = time().'_'.$this->profile_photo_path->getClientOriginalName();
            $filePath = $this->profile_photo_path->storeAs('uploads/users', $fileName, 'public');

            $path = '/'. $filePath;
        }

        $user = new User();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->password = bcrypt('password');
        if (isset($path)) {
            $user->profile_photo_path = $path;
        }
        $user->save();

        $this->emit('swal:alert', [
            'icon' => 'success',
            'title' => config('dev-master.name'),
            'text'  => __('User created successfully'),
            'timeout' => 10000
        ]);

    }
}
