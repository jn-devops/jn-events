<?php

namespace App\Livewire;

use App\Models\Checkin;
use App\Models\Organization;
use Exception;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class RegistrationForm extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public String $error = '';
    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('employee_id')
                ->label('Employee ID')
                ->unique('checkins', 'employee_id',ignoreRecord: true)
                ->required(),
                Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->required(),
            ])
            ->statePath('data')
            ->model(Checkin::class);
    }

    public function create(): void
    {
        try {
            $data = $this->form->getState();

            $record = Checkin::create($data);

            $this->form->model($record)->saveRelationships();
            $this->dispatch('open-modal', id: 'success-modal');

        }catch (Exception $e) {
            if($e->getMessage() == "The employee ID has already been taken."){
                $this->error="This Employee ID has already been checked-in.";
            }else{
                $this->error=$e->getMessage();
            }
            $this->dispatch('open-modal', id: 'error-modal');
        }
    }
    public function closeModal()
    {
        $this->data =[];
    }
    public function render(): View
    {
        return view('livewire.registration-form');
    }
}
