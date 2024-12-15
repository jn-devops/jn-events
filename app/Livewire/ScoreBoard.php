<?php

namespace App\Livewire;

use App\Models\Competition;
use App\Models\CompetitionJudge;
use Livewire\Component;

class ScoreBoard extends Component
{
    public $competition;
    public function mount(Competition $competition)
    {
        $this->$competition = $competition;
    }

    public function render()
    {
        return view('livewire.score-board')
            ->layout('components.layouts.appV3');
    }
}
