<?php

namespace App\Livewire;

use App\Models\Checkin;
use App\Models\Employees;
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
                Forms\Components\TextInput::make('last_name')
                    ->label('Last Name')
                    ->required(),
                Forms\Components\TextInput::make('first_name')
                    ->label('First Name')
                    ->required(),
            ])
            ->statePath('data')
            ->model(Checkin::class);
    }

    public function create()
    {
        try {
            $data = $this->form->getState();

            $employee = Employees::whereRaw('UPPER(last_name) = ?', [strtoupper($data['last_name'])])
                ->whereRaw('UPPER(first_name) = ?', [strtoupper($data['first_name'])])
                ->first();

            $checkin = Checkin::whereRaw('UPPER(name) = ?', [strtoupper($data['first_name'].' '.$data['last_name'])])
                ->whereDate('created_at', now()->toDateString()) // Ensure the check-in is for today
                ->first();

            if (!$employee) {
                $this->error = 'Employee didnt match our records';
                $this->dispatch('open-modal', id: 'error-modal');
                return;
            }elseif ($checkin) {
                $this->error = 'This Employee has already been checked-in.';
                $this->dispatch('open-modal', id: 'error-modal');
                return;
            }

            $this->data=[
                'employee_id' => $employee->id??'',
                'name' => $employee->first_name.' '.$employee->last_name,
                'company' => $employee->company,
                'department' => $employee->department,
                'unit_group' => $employee->unit_group,
                'unit' => $employee->unit,
            ];

            $record = Checkin::create([
                'name' => $employee->first_name.' '.$employee->last_name,
            ]);

            $this->form->model($record)->saveRelationships();
            $this->dispatch('open-modal', id: 'success-modal');

        }catch (Exception $e) {
            if($e->getMessage() == "The employee ID has already been taken."){
                $this->error="This Employee has already been checked-in.";
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
