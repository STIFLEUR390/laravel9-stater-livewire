<?php

namespace App\Http\Livewire\Back\App;

use App\Models\User;
use Livewire\Component;
use App\Mail\Maintenance;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;

class SettingComponent extends Component
{
    protected $listeners = ['active' => 'activeMaintenanceMode'];

    public $active;
    public $customCommand;

    public function render()
    {
        $breadcrumbs = [
            ['link' => 'settings', 'name' => __("Settings")]
        ];

        $this->active = app()->isDownForMaintenance();

        return view('livewire.back.app.setting-component')->extends('layouts.contentLayoutMaster', ['breadcrumbs' => $breadcrumbs])->section('content');
    }

    public function confirmCleanBackup()
    {
        $this->emit("swal:confirm", [
            'type'        => 'warning',
            'title'       => __('Are you sure?'),
            'text'        => __("You won't be able to revert this!"),
            'confirmText' => __('Yes, delete!'),
            'method'      => 'cleanbackup'
        ]);
    }

    public function activeMaintenanceMode()
    {
        $secret = Str::uuid();
        $url = url($secret);

        $users = User::whereNot('id', Auth::user()->id)->role('Super Admin', 'web')->pluck('email');
        if (count($users) > 0) {
            Mail::to(Auth::user())->cc($users)->send(new Maintenance($url));
        }
        else {
            Mail::to(Auth::user())->send(new Maintenance($url));
        }

        Artisan::call('down --secret="'.$secret.'" --render="errors::503" --redirect=/');

        return redirect()->route('dashboard');
    }

    public function disableMaintenanceMode()
    {
        Artisan::call('up');

        $this->emit('swal:alert', [
            'icon' => 'success',
            'title' => config('dev-master.name'),
            'text'  => __('Maintenance mode deactivate successfully'),
            'timeout' => 10000
        ]);
    }

    public function symbolicLinks()
    {
        foreach (array_keys(config('filesystems.links')) as $value) {
            if (file_exists($value)) {
                // rmdir($value);
                File::deleteDirectory($value);
            }
        }

        Artisan::call('storage:link');

        $this->emit('swal:alert', [
            'icon' => 'success',
            'title' => config('dev-master.name'),
            'text'  => __('Symbolic links created successfully'),
            'timeout' => 10000
        ]);
    }

    public function translations($type)
    {
        ini_set('max_execution_time', 600); //10 minutes

        Artisan::call('translations:'.$type.'');

        $this->emit('swal:alert', [
            'icon' => 'success',
            'title' => config('dev-master.name'),
            'text'  => __('Operation completed successfully'),
            'timeout' => 10000
        ]);
    }

    public function other($command)
    {
        ini_set('max_execution_time', 600); //10 minutes

        $this->resetErrorBag();
        $this->resetValidation();

        if ($command == 'custom') {
            $this->validate([
                'customCommand' => 'required|string|min:2'
            ]);
            if (strpos($this->customCommand, 'php') === false && strpos($this->customCommand, 'artisan') === false && $this->command_exists($this->customCommand)) {
                Artisan::call(''.$this->customCommand.'');
                $this->emit('swal:alert', [
                    'icon' => 'success',
                    'title' => config('dev-master.name'),
                    'text'  => __('Operation completed successfully'),
                    'timeout' => 10000
                ]);
            } else {
                $this->addError('customCommand',  __('Incorrect command'));
            }
        } else {
            Artisan::call(''.$command.'');
            $this->emit('swal:alert', [
                'icon' => 'success',
                'title' => config('dev-master.name'),
                'text'  => __('Operation completed successfully'),
                'timeout' => 10000
            ]);
        }
    }

    public function command_exists($name)
    {
        return array_key_exists($name, Artisan::all());
    }
}
