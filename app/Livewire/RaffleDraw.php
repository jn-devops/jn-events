<?php

namespace App\Livewire;

use App\Models\Prizes;
use Livewire\Component;

class RaffleDraw extends Component
{
    public $prizes;
    public $chosen_prize;
    public $chosen_prize_model;
    public $employee_names;
    public $sample;

    public function mount(){
        $this->prizes = Prizes::all();
        $this->employee_names = [];
    }
    public function render()
    {
        return view('livewire.raffle-draw')
            ->layout('components.layouts.appV3');
    }

    public function updated($property)
    {
        if ($property === 'chosen_prize') {

        }
    }

    public function draw(){
        $this->employee_names = ['George', 'Samuel', 'Rey', 'Justin'];
        $this->dispatch('start-draw', $this->employee_names);
    }
}
