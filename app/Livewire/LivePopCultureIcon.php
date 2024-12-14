<?php

namespace App\Livewire;

use App\Models\Poll;
use App\Models\Vote;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class LivePopCultureIcon extends Component
{
    public $poll;
    public $votes = [];

    public function mount(Poll $poll)
    {
        $this->poll = $poll;
        $this->fetchVotes();
    }
    public function fetchVotes()
    {
        $votes = $this->poll->options
            ->map(function ($option) {
                return [
                    'option' => $option->option,
                    'image' => Storage::url($option->image ?? ''),
                    'icon' => Storage::url($option->icon_image ?? ''),
                    'count' => $option->votes()->count(),
                ];
            })
            ->sortByDesc('count') // Sort by the count descending
            ->values() // Reset keys after sorting
            ->toArray();
            $this->votes = $this->sort_votes($votes);
    }

    public function render()
    {
        return view('livewire.live-pop-culture-icon')
            ->layout('components.layouts.appV3');
    }

    public function recordVote($vote, $poll){
        $this->fetchVotes();
    }

    function sort_votes($list){
        $array = $list;
        // Sort the array by the 'count' value in descending order
        usort($array, function($a, $b) {
            return $b['count'] - $a['count'];
        });

        // Swap the first and second elements
        $temp = $array[0];
        $array[0] = $array[1];
        $array[1] = $temp;
        return array_slice($array, 0, 3);
    }
}
