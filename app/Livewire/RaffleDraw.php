<?php

namespace App\Livewire;

use App\Models\Checkin;
use App\Models\Prizes;
use App\Models\RafflePrize;
use App\Models\RaffleWinner;
use Livewire\Component;

class RaffleDraw extends Component
{
    public $prizes;
    public $chosen_prize;
    public $chosen_prize_model;
    public $employee_names;
    public $sample;

    public $winner;
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
                    ->whereIn('unit', $prize->units)
                    ->whereNotIn('employee_id', RaffleWinner::where('raffle_prize_id', $prize->id)
                        ->where('raffle_id', $prize->raffle->id)
                        ->pluck('employee_id'));
            })
                ->get();
            $this->employee_names = $checkins->pluck('name');
            // dd($checkins);
            $this->dispatch('start-draw', $this->employee_names);
        //    dd($this->employee_names,$checkins,$prize->companies,$prize->units);
//            $this->employee_names = ['George', 'Samuel', 'Rey', 'Justin'];
//            $this->dispatch('start-draw', $this->employee_names);
        }
    }
    public function setWinner(RafflePrize $prize){
        if($this->chosen_prize_model==$prize) {
            RaffleWinner::create([
                'employee_id' => Checkin::where('name', $this->winner)->first()->employee_id,
                'raffle_id' => $this->chosen_prize_model->raffle_id,
                'raffle_prize_id' => $this->chosen_prize_model->id,
            ]);
        }
    }
}
