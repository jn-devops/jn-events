<?php

namespace App\Livewire;

use App\Models\Competition;
use App\Models\CompetitionJudge;
use App\Models\Participant;
use App\Models\Score;
use Livewire\Component;
use Illuminate\Support\Collection;

class ScoreBoard extends Component
{
    public $competition;
    public $totalScore;
    public $category_winners;
    public $categories;
    
    public function mount(Competition $competition)
    {
        $this->$competition = $competition;
        // Get total scores per participant for a specific competition using pluck
        $this->totalScore = Score::where('competition_id', $this->competition->id)
            ->select('participant_id', \DB::raw('SUM(score) as total_score'))
            ->groupBy('participant_id')
            ->pluck('total_score', 'participant_id')->map(function ($totalScore, $participantId) {
                return [
                    'participant_id' => $participantId,
                    'total_score' => $totalScore,
                    'category'=> Participant::find($participantId)->category,
                ];
            });
        // Find top score per category
        $this->category_winners = $this->totalScore
            ->groupBy('category') // Group by category
            ->map(function (Collection $group) {
                // Get the participant with the highest score in each category
                return $group->sortByDesc('total_score')->first();
            });

        $this->categories = $competition->participants()
            ->select('category')
            ->distinct()
            ->pluck('category');
    }

    public function render()
    {
        return view('livewire.score-board')
            ->layout('components.layouts.appV3');
    }
}
