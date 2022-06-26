<?php

namespace App\Http\Livewire\Back\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;

class EditUserComponent extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $profile_photo_path;
    public $photo_path;
    public $user_id;

    protected function rules()
    {
        return [
            'name' => 'required|string|min:5|max:150',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->user_id)],
            'profile_photo_path' => 'nullable|file|image|max:2048',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $user->id;
        $this->email = $user->email;
        $this->photo_path = $user->profile_photo_url;
        $this->name = $user->name;
    }

    public function render()
    {
        $breadcrumbs = [
            ['link'=>"users.index",'name'=> __('Users list')], ['name'=> __('Edit')]
        ];
        return view('livewire.back.user.edit-user-component')->extends('layouts.contentLayoutMaster', ['breadcrumbs' => $breadcrumbs])->section('content');
    }

    public function updateUser()
    {
        $this->validate();

        if ($this->profile_photo_path) {
            $fileName = time().'_'.$this->profile_photo_path->getClientOriginalName();
            $filePath = $this->profile_photo_path->storeAs('uploads/users', $fileName, 'public');

            $path = '/'. $filePath;
        }

        $user = User::findOrFail($this->user_id);
        $user->name = $this->name;
        $user->email = $this->email;
        $user->password = bcrypt('password');
        if (isset($path)) {
            File::delete('storage'.$user->profile_photo_path);
            $user->profile_photo_path = $path;
        }
        $user->save();

        $this->emit('swal:alert', [
            'icon' => 'success',
            'title' => config('dev-master.name'),
            'text'  => __('User updated successfully'),
            'timeout' => 10000
        ]);
    }
}
