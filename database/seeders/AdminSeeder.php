<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Hash;
use Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            'name'=>'tiểu_nam_phong',
            'email'=>'levietphu171993@gmail.com',   
            'password'=>Hash::make('Aa0107193'),   
            'remember_token'=>Str::random(60),
            "coin"=>10000,
            'role'=>1
        ]);
    }
}
