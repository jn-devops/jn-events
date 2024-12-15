<?php

namespace App\Livewire;

use App\Models\Checkin;
use App\Models\Prizes;
use App\Models\RafflePrize;
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

    public function setCurrentPrize(RafflePrize $prize){
        $this->chosen_prize = $prize;
        $this->chosen_prize_model = $prize;
    }

    public function draw(RafflePrize $prize){
        if($this->chosen_prize_model==$prize){
            $checkins = Checkin::whereHas('employee', function ($query) use ($prize) {
                $query->whereIn('company', $prize->companies)
                    ->whereIn('unit', $prize->units);
            })->get();
            $this->employee_names = $checkins->pluck('name');
            $this->dispatch('start-draw', $this->employee_names);
//            dd($this->employee_names,$checkins,$prize->companies,$prize->units);

//            $this->employee_names = ['George', 'Samuel', 'Rey', 'Justin'];
//            $this->dispatch('start-draw', $this->employee_names);
        }

    }
}
