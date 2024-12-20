<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(['email' => 'cmbeltran@joy-nostalg.com'], ['name' => 'Admin','password'=>Hash::make('weneverknow')]);
        User::updateOrCreate(['email' => 'renzo.carianga@gmail.com'], ['name' => 'Admin','password'=>Hash::make('weneverknow')]);
        User::updateOrCreate(['email' => 'devops@joy-nostalg.com'], ['name' => 'Dev Ops','password'=>Hash::make('weneverknow')]);
    }
}
