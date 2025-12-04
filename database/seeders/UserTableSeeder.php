<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'name' => 'Systems Admin',
            'email' => 'a@a.com',
            'password' => Hash::make('root'),
            'slug' => Str::slug('Systems Admin'),
            'role' =>'system'
        ]);
        User::create([
            'name' => 'Abbey',
            'email' => 'b@b.com',
            'password' => Hash::make('root'),
            'slug' => Str::slug('abbey'),
            'role' => 'owner'
        ]);
        User::create([
            'name' => 'Seller',
            'email' => 'c@c.com',
            'password' => Hash::make('root'),
            'slug' => Str::slug('seller'),
            'role' => 'seller'
        ]);
     
    }
}
