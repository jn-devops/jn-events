<?php

use App\Events\DrawRaffle;
use App\Events\SetRafflePrize;
use App\Livewire\LivePopCultureIcon;
use App\Livewire\PollVotes;
use App\Livewire\PopCultureIconVote;
use App\Livewire\RaffleDraw;
use App\Models\Prizes;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/attendance', \App\Livewire\RegistrationForm::class)->name('registration-form');
Route::get('/vote/{poll}', \App\Livewire\VoteForm::class)->name('vote-form');
Route::get('/polls/{poll}/votes', PollVotes::class)->name('poll.votes');
Route::get('/competition/{competition}/{judge}/{judge_name}', \App\Livewire\ScoringPage::class)->name('competition-scoring');
Route::get('/competition-score-board/{competition}', \App\Livewire\ScoreBoard::class);

Route::get('/', function (){
    $current_program = \App\Models\Programs::where('active', 1)->first();
    if ($current_program) {
        switch ($current_program->name) {
            case "Attendance":
                return redirect('/attendance');
                break;
            default:
                return view('welcome');
                break;
        }
    }else{
        return view('welcome');
    }
})->name('welcome');

Route::get('/raffle-draw', RaffleDraw::class);
Route::get('/pop-culture-icon/{poll}', PopCultureIconVote::class);
Route::get('/live-pop-culture-icon/{poll}', LivePopCultureIcon::class);


