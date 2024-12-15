<?php

namespace App\Livewire;

use App\Models\Competition;
use App\Models\CompetitionJudge;
use App\Models\Score;
use Livewire\Component;

class ScoringPage extends Component
{
    public $competition;
    public $judge;
    public $participants;
    public $currentParticipant;
    public $category;
    public $currrentCategory;

    public $score = [
        'voice_quality' => 0,
        'stage_presence' => 0,
        'interpretation' => 0,
        'audience_impact' => 0,
    ];
    public $totalScore = 0;
    public function calculateTotal()
    {
        $this->totalScore = array_sum($this->score);

        Score::updateOrCreate([
            'competition_id' => $this->competition->id,
            'judge_id' => $this->judge->id,
            'participant_id' => $this->currentParticipant->id,
            'criteria' => 'voice_quality',
        ],[
            'score' => $this->score['voice_quality'],
        ]);
        Score::updateOrCreate([
            'competition_id' => $this->competition->id,
            'judge_id' => $this->judge->id,
            'participant_id' => $this->currentParticipant->id,
            'criteria' => 'stage_presence',
        ],[
            'score' => $this->score['stage_presence'],
        ]);
        Score::updateOrCreate([
            'competition_id' => $this->competition->id,
            'judge_id' => $this->judge->id,
            'participant_id' => $this->currentParticipant->id,
            'criteria' => 'interpretation',
        ],[
            'score' => $this->score['interpretation'],
        ]);
        Score::updateOrCreate([
            'competition_id' => $this->competition->id,
            'judge_id' => $this->judge->id,
            'participant_id' => $this->currentParticipant->id,
            'criteria' => 'audience_impact',
        ],[
            'score' => $this->score['audience_impact'],
        ]);
    }

    public function resetScores()
    {
        Score::updateOrCreate([
            'competition_id' => $this->competition->id,
            'judge_id' => $this->judge->id,
            'participant_id' => $this->currentParticipant->id,
            'criteria' => 'voice_quality',
        ],[
            'score' => 0,
        ]);
        Score::updateOrCreate([
            'competition_id' => $this->competition->id,
            'judge_id' => $this->judge->id,
            'participant_id' => $this->currentParticipant->id,
            'criteria' => 'stage_presence',
        ],[
            'score' => $this->score['stage_presence'],
        ]);
        Score::updateOrCreate([
            'competition_id' => $this->competition->id,
            'judge_id' => $this->judge->id,
            'participant_id' => $this->currentParticipant->id,
            'criteria' => 'interpretation',
        ],[
            'score' => $this->score['interpretation'],
        ]);
        Score::updateOrCreate([
            'competition_id' => $this->competition->id,
            'judge_id' => $this->judge->id,
            'participant_id' => $this->currentParticipant->id,
            'criteria' => 'audience_impact',
        ],[
            'score' => $this->score['audience_impact'],
        ]);
        $this->score = [
            'voice_quality' => 0,
            'style_performance' => 0,
            'audience_poll' => 0,
        ];
        $this->calculateTotal();
    }

    public function mount(Competition $competition,CompetitionJudge $judge)
    {
        $this->competition = $competition;
        $this->category = $competition->participants()
                        ->select('category')
                        ->distinct()
                        ->pluck('category');
        $this->judge = $judge;
        $this->participants = $competition->participants;
        $this->currentParticipant=$this->participants->first();
        $this->currrentCategory = 'all';
        $current_score=$this->currentParticipant->scores;
        if($current_score->count()==0){
            $this->score = [
                'voice_quality' => 0,
                'stage_presence' => 0,
                'interpretation' => 0,
                'audience_impact' => 0,
            ];
        }else{
            $this->score = [
                'voice_quality' => $current_score->where('criteria','voice_quality')->first()->score??0,
                'stage_presence' => $current_score->where('criteria','stage_presence')->first()->score??0,
                'interpretation' => $current_score->where('criteria','interpretation')->first()->score??0,
                'audience_impact' => $current_score->where('criteria','audience_impact')->first()->score??0,
            ];
        }
        $this->calculateTotal();
    }

    public function changeParticipant($participantId)
    {
        $this->currentParticipant = $this->participants->firstWhere('id', $participantId);
        $current_score=$this->currentParticipant->scores;
        if($current_score->count()==0){
            $this->score = [
                'voice_quality' => 0,
                'stage_presence' => 0,
                'interpretation' => 0,
                'audience_impact' => 0,
            ];
        }else{
            $this->score = [
                'voice_quality' => $current_score->where('criteria','voice_quality')->first()->score??0,
                'stage_presence' => $current_score->where('criteria','stage_presence')->first()->score??0,
                'interpretation' => $current_score->where('criteria','interpretation')->first()->score??0,
                'audience_impact' => $current_score->where('criteria','audience_impact')->first()->score??0,
            ];
        }
        $this->calculateTotal();
    }
    public function render()
    {
        return view('livewire.scoring-page')
        ->layout('components.layouts.appV3');
    }

    public function category_filter($category){
        if($category != 'all'){
            $this->participants = $this->competition->participants()->where('category', $category)->get();
        }else{
            $this->participants = $this->competition->participants;
        }
        $this->changeParticipant($this->participants[0]->id);
        $this->currrentCategory = $category;
    }
}
