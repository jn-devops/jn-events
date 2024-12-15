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

        $array[3]['highest'] = false; 
        $array[3]['cntr'] = '4<sup class="pt-4">th</sup>'; 
        $array[1]['highest'] = false; 
        $array[1]['cntr'] = '2<sup class="pt-4">nd</sup>'; 
        $array[0]['highest'] = true;
        $array[0]['cntr'] = '1<sup class="pt-4">st</sup>';
        $array[2]['highest'] = false;
        $array[2]['cntr'] = '3<sup class="pt-4">rd</sup>';
        $array[4]['highest'] = false;
        $array[4]['cntr'] = '5<sup class="pt-4">th</sup>';

        $rearranged = [
            $array[3],
            $array[1],
            $array[0],
            $array[2],
            $array[4],
        ];
        return $rearranged;
    }
}
