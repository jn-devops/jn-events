<?php

namespace App\Livewire;

use App\Models\Competition;
use App\Models\CompetitionJudge;
use Livewire\Component;

class ScoringPage extends Component
{
    public $competition;
    public $judge;
    public $participants;
    public $currentParticipant;

    public $score = [
        'voice_quality' => 0,
        'style_performance' => 0,
        'audience_poll' => 0,
    ];
    public $totalScore = 0;
    public function calculateTotal()
    {
        $this->totalScore = array_sum($this->score);
    }

    public function resetScores()
    {
        $this->score = [
            'voice_quality' => 0,
            'style_performance' => 0,
            'audience_poll' => 0,
        ];
        $this->calculateTotal();
    }

    public function mount(Competition $competition,CompetitionJudge $judge)
    {
        $this->$competition = $competition;
        $this->participants = $competition->participants;
        $this->currentParticipant=$this->participants->first();
    }

    public function changeParticipant($participantId)
    {
        $this->currentParticipant = $this->participants->firstWhere('id', $participantId);
    }
    public function render()
    {
        return view('livewire.scoring-page');
    }
}
