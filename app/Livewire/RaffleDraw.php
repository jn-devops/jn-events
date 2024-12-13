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

    public function mount(){
        $this->prizes = Prizes::all();
        $this->employee_names = [];
    }
    public function render()
    {
        return view('livewire.raffle-draw')
            ->layout('components.layouts.appV2');
    }

    public function updated($property)
    {
 
        if ($property === 'chosen_prize') {
            $this->chosen_prize_model = Prizes::find($this->chosen_prize);
            $this->employee_names = Prizes::find($this->chosen_prize)->employee_names;
        }
    }
}
