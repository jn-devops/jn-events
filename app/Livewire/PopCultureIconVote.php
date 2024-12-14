<?php

namespace App\Livewire;

use App\Events\VotePopCultureIcon;
use App\Events\VoteUpdated;
use App\Models\Employees;
use App\Models\Poll;
use App\Models\PollOptions;
use App\Models\User;
use App\Models\Vote;
use Exception;
use Illuminate\Support\Str;;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class PopCultureIconVote extends Component
{
    public string $first_name;
    public string $last_name;
    public $poll;
    public $poll_option_id;
    public string $error;
    public string $image;
    public string $icon;
    public string $suucess_message;


    public function render()
    {
        return view('livewire.pop-culture-icon-vote')
                ->layout('components.layouts.appV3');
    }

    public function mount(Poll $poll): void
    {
        $this->poll = $poll;
        $this->first_name = '';
        $this->last_name = '';
        $this->poll_option_id = '361b9691-fe35-4a61-a82f-c8b3fbfc48f5'; // TODO: change this
        $this->image = 'https://images.unsplash.com/photo-1552960562-daf630e9278b?ixlib=rb-4.0.3&amp;ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;auto=format&amp;fit=crop&amp;w=687&amp;q=80';
        $this->icon = 'https://images.unsplash.com/photo-1552960562-daf630e9278b?ixlib=rb-4.0.3&amp;ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;auto=format&amp;fit=crop&amp;w=687&amp;q=80';
        $this->suucess_message = 'Successfully Voted';
    }

    public function vote(){
        $this->create();
    }

    public function create()
    {
        try {
            if (!$this->poll) {
                $this->error = 'Please select a poll option';
                $this->dispatch('open-modal', id: 'error-modal');
                return;
            }
            $employee = Employees::whereRaw('UPPER(last_name) = ?', [strtoupper($this->last_name)])
                ->whereRaw('UPPER(first_name) = ?', [strtoupper($this->first_name)])
                ->first();

            if ($employee) {
                $vote_exist = Vote::where('employee_id', $employee->id)
                    ->whereHas('pollOption', function ($query) {
                        $query->where('poll_id', $this->poll->id);
                    })
                    ->first();
                if($vote_exist){
                    $this->error = 'Employee already voted for this poll'; // TODO
                    $this->dispatch('open-modal', id: 'error-modal');
                    return;
                }
            }else{
                $this->error = 'Employee doesnt match our records'; // TODO
                $this->dispatch('open-modal', id: 'error-modal');
                return;
            }

            $record = Vote::create([
                'id'=>(string) Str::uuid(),
                'poll_id' => $this->poll->id,
                'employee_id' => $employee->id,
                'poll_option_id'=>$this->poll_option_id,
            ]);
            // $this->form->model($record)->saveRelationships();
            broadcast(new VotePopCultureIcon($record->id, $this->poll->id));
            // $pollOption = PollOptions::find($this->data['poll_option_id']);
            // foreach (User::all() as $recipient) {
            //     Notification::make()
            //         ->title("Vote: {$this->poll->title}")
            //         ->body("Employee {$employee->first_name} {$employee->last_name} (ID: {$employee->employee_id}) has voted for '{$pollOption->option}' in the poll titled '{$this->poll->title}'.")
            //         ->broadcast($recipient)
            //         ->sendToDatabase($recipient, isEventDispatched: true);
            // }
            $option = PollOptions::find($this->poll_option_id);
            $this->suucess_message = "Thank you for voting! <br> <span class='text-base'>You voted for ".$option->option."</span>";
            $this->dispatch('success-modal', 'Successfully Vote');


        }catch (Exception $e) {
            if($e->getMessage() == "The employee ID has already been taken."){
                $this->error="This Employee ID has already been checked-in.";
            }else{
                $this->error=$e->getMessage();
            }
            $this->dispatch('open-modal', id: 'error-modal');

        }

    }

    public function open_card($option){
        $this->image = Storage::url($option['image']);
        $this->icon = Storage::url($option['icon_image']);

    }
}
