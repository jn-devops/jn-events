<?php

namespace App\Livewire;

use App\Models\Poll;
use Livewire\Component;

class LivePopCultureIcon extends Component
{
    public $poll;
    public $votes = [];

    protected $listeners = ['voteUpdated' => 'fetchVotes'];

    public function mount(Poll $poll)
    {
        $this->poll = $poll;
        $this->fetchVotes();
    }
    public function fetchVotes()
    {
        $this->votes = $this->poll->options
            ->map(function ($option) {
                return [
                    'option' => $option->option,
                    'image' => $option->image ?? null,
                    'count' => $option->votes()->count(),
                ];
            })
            ->sortByDesc('count') // Sort by the count descending
            ->values() // Reset keys after sorting
            ->toArray();
    }
    public function render()
    {
        return view('livewire.live-pop-culture-icon')
            ->layout('components.layouts.appV3');
    }
}
