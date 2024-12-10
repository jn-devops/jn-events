<?php

namespace Database\Seeders;

use App\Models\Programs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Programs::updateOrCreate([
           'link' =>'/attendance',
        ],['name'=>'Attendance']);
        Programs::updateOrCreate([
            'link' =>'/poll',
        ],['name'=>'Poll']);
        Programs::updateOrCreate([
            'link' =>'/raffle',
        ],['name'=>'Raffle']);
    }
}
