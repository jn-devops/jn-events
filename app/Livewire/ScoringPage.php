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

    public $score = [
        'voice_quality' => 0,
        'style_performance' => 0,
        'audience_poll' => 0,
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
            'criteria' => 'style_performance',
        ],[
            'score' => $this->score['style_performance'],
        ]);
        Score::updateOrCreate([
            'competition_id' => $this->competition->id,
            'judge_id' => $this->judge->id,
            'participant_id' => $this->currentParticipant->id,
            'criteria' => 'audience_poll',
        ],[
            'score' => $this->score['audience_poll'],
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
            'criteria' => 'style_performance',
        ],[
            'score' => 0,
        ]);
        Score::updateOrCreate([
            'competition_id' => $this->competition->id,
            'judge_id' => $this->judge->id,
            'participant_id' => $this->currentParticipant->id,
            'criteria' => 'audience_poll',
        ],[
            'score' => 0,
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
        $this->$competition = $competition;
        $this->judge = $judge;
        $this->participants = $competition->participants;
        $this->currentParticipant=$this->participants->first();
        $current_score=$this->currentParticipant->scores;
        if($current_score->count()==0){
            $this->score = [
                'voice_quality' => 0,
                'style_performance' => 0,
                'audience_poll' => 0,
            ];
        }else{
            $this->score = [
                'voice_quality' => $current_score->where('criteria','voice_quality')->first()->score??0,
                'style_performance' => $current_score->where('criteria','style_performance')->first()->score??0,
                'audience_poll' => $current_score->where('criteria','audience_poll')->first()->score??0,
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
                'style_performance' => 0,
                'audience_poll' => 0,
            ];
        }else{
            $this->score = [
                'voice_quality' => $current_score->where('criteria','voice_quality')->first()->score??0,
                'style_performance' => $current_score->where('criteria','style_performance')->first()->score??0,
                'audience_poll' => $current_score->where('criteria','audience_poll')->first()->score??0,
            ];
        }
        $this->calculateTotal();
    }
    public function render()
    {
        return view('livewire.scoring-page');
    }
}
