<?php

namespace App\Livewire;

use App\Models\Poll;
use App\Models\Vote;
use Livewire\Component;

class PollVotes extends Component
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
        return view('livewire.poll-votes');
    }
}
