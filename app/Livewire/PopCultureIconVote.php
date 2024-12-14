<?php

namespace App\Livewire;

use Livewire\Component;

class PopCultureIconVote extends Component
{
    public function render()
    {
        return view('livewire.pop-culture-icon-vote')
                ->layout('components.layouts.appV3');
    }
}
