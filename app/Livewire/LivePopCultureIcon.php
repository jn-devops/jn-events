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

        $array[3]['rank'] = 4; 
        $array[3]['cntr'] = '4<sup class="pt-4">th</sup>'; 
        $array[3]['option'] = (empty($array[3]['option']) ? '' : $array[3]['option']); 
        $array[3]['image'] = (empty($array[3]['image']) ? '' : $array[3]['image']); 
        $array[3]['icon'] = (empty($array[3]['icon']) ? '' : $array[3]['icon']); 
        $array[3]['count'] = (empty($array[3]['count']) ? '' : $array[3]['count']); 
        
        $array[1]['rank'] = 2; 
        $array[1]['cntr'] = '2<sup class="pt-4">nd</sup>'; 
        $array[1]['option'] = (empty($array[1]['option']) ? '' : $array[1]['option']); 
        $array[1]['image'] = (empty($array[1]['image']) ? '' : $array[1]['image']); 
        $array[1]['icon'] = (empty($array[1]['icon']) ? '' : $array[1]['icon']); 
        $array[1]['count'] = (empty($array[1]['count']) ? '' : $array[1]['count']); 
        
        $array[0]['rank'] = 1;
        $array[0]['cntr'] = '1<sup class="pt-4">st</sup>';
        $array[0]['option'] = (empty($array[0]['option']) ? '' : $array[0]['option']); 
        $array[0]['image'] = (empty($array[0]['image']) ? '' : $array[0]['image']); 
        $array[0]['icon'] = (empty($array[0]['icon']) ? '' : $array[0]['icon']); 
        $array[0]['count'] = (empty($array[0]['count']) ? '' : $array[0]['count']); 
        
        $array[2]['rank'] = 3;
        $array[2]['cntr'] = '3<sup class="pt-4">rd</sup>';
        $array[2]['option'] = (empty($array[2]['option']) ? '' : $array[2]['option']); 
        $array[2]['image'] = (empty($array[2]['image']) ? '' : $array[2]['image']); 
        $array[2]['icon'] = (empty($array[2]['icon']) ? '' : $array[2]['icon']); 
        $array[2]['count'] = (empty($array[2]['count']) ? '' : $array[2]['count']); 
        
        $array[4]['rank'] = 5;
        $array[4]['cntr'] = '5<sup class="pt-4">th</sup>';
        $array[4]['option'] = (empty($array[4]['option']) ? '' : $array[4]['option']); 
        $array[4]['image'] = (empty($array[4]['image']) ? '' : $array[4]['image']); 
        $array[4]['icon'] = (empty($array[4]['icon']) ? '' : $array[4]['icon']); 
        $array[4]['count'] = (empty($array[4]['count']) ? '' : $array[4]['count']); 

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
