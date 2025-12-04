<?php

namespace App\Livewire\Setup;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class UserSetupLivewire extends Component
{

    use LivewireAlert;


    public $checking = true;
    public $dbConnected = false;
    public $usersTableExists = false;
    public $hasOwner = false;
    public $form = false;
    public $name,$email,$password;


    public function open(){
        $this->form = true;
    }



    public function mount()
    {
        $this->runChecks();
    }

    public function store(){

        $user = User::where('role','system')->first();
        if(empty($user)){
            $user = new User();
            $user->name = 'Systems Admin';
            $user->email = 'a@a.com';
            $user->role = 'system';
            $user->password = Hash::make('root');
            $user->save();
        }

        $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        User::create([
            'name' => $this->name,
            'role' => 'owner',
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        $this->alert('success', 'User successfully added!');




    }


    public function cancel(){
        $this->reset(['name','email','password','form']);
    }





    public function runChecks()
    {
        $this->checking = true;
        sleep(1);
        // simulate loading animation

        // --- 1. Check database connection ---
        try {
            DB::connection()->getPdo();
            $this->dbConnected = true;
        } catch (\Exception $e) {
            $this->dbConnected = false;
            $this->checking = false;
            return;
        }

        // --- 2. Check if users table exists ---
        try {
            $this->usersTableExists = DB::getSchemaBuilder()->hasTable('users');
        } catch (\Exception $e) {
            $this->usersTableExists = false;
        }

        if (!$this->usersTableExists) {
            $this->checking = false;
            return;
        }

        // --- 3. Check if owner exists ---
        $this->hasOwner = User::where('role', 'owner')->exists();

        $this->checking = false;
    }

    public function render()
    {
        return view('livewire.setup.user-setup-livewire')
            ->layout('layouts.blank');
    }
}
