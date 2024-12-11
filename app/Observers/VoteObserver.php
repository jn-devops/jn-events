<?php

namespace App\Observers;

use App\Events\VoteUpdated;
use App\Models\Vote;
use Livewire\Livewire;

class VoteObserver
{
    /**
     * Handle the Vote "created" event.
     */
    public function created(Vote $vote): void
    {
        // Fetch updated votes for the specific poll
        $votes = Vote::with('pollOption')
            ->where('poll_id', $vote->poll_id)
            ->get();

        // Broadcast the event with votes and poll_id
        broadcast(new VoteUpdated('vote', $vote->poll_id));
//        Livewire::emit('voteUpdated', $vote->poll_id);
    }

    /**
     * Handle the Vote "updated" event.
     */
    public function updated(Vote $vote): void
    {
        //
    }

    /**
     * Handle the Vote "deleted" event.
     */
    public function deleted(Vote $vote): void
    {
        //
    }

    /**
     * Handle the Vote "restored" event.
     */
    public function restored(Vote $vote): void
    {
        //
    }

    /**
     * Handle the Vote "force deleted" event.
     */
    public function forceDeleted(Vote $vote): void
    {
        //
    }
}
