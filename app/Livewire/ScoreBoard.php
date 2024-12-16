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
    public $current_participant;
    public $current_category;
    public $reveal;

    public function mount(Competition $competition)
    {
        $this->reveal = false;
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
            ->pluck('category');;

        $this->current_category = $this->categories[0];
        foreach ($this->category_winners as $winner){
            if($winner['category'] == $this->current_category){
                $this->setCurrentParticipant($winner['participant_id']);
            }
        }
        
        // dd($this->current_participant);

            // dd($this->category_winners);
    }

    public function render()
    {
        return view('livewire.score-board')
            ->layout('components.layouts.appV3');
    }

    public function change_category($cat){
        $this->current_category = $cat;
        foreach ($this->category_winners as $winner){
            if($winner['category'] == $this->current_category){
                $this->setCurrentParticipant($winner['participant_id']);
            }
        }
        $this->reveal = false;
    }

    public function setCurrentParticipant($id){
        $this->current_participant =  Participant::find($id);
    }

    public function toggleReveal(){
        $this->reveal = !$this->reveal;
    }
}
