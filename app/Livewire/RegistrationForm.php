<?php

namespace App\Livewire;

use App\Models\Checkin;
use App\Models\Employees;
use App\Models\Organization;
use Exception;
use Filament\Forms;
// use Filament\Forms\Concerns\InteractsWithForms;
// use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class RegistrationForm extends Component
{
    // use InteractsWithForms;

    public ?array $data = [];
    public String $first_name;
    public String $last_name;
    public String $error = '';
    public $employee;
    public function mount(): void
    {
        $this->first_name = '';
        $this->last_name = '';
        $this->employee = null;
    }

    // public function form(Form $form): Form
    // {
    //     return $form
    //         ->schema([
    //             Forms\Components\TextInput::make('last_name')
    //                 ->label('Last Name')
    //                 ->required(),
    //             Forms\Components\TextInput::make('first_name')
    //                 ->label('First Name')
    //                 ->required(),
    //         ])
    //         ->statePath('data')
    //         ->model(Checkin::class);
    // }

    public function create()
    {
        $this->error = '';
        try {
            // $data = $this->form->getState();

            $employee = Employees::whereRaw('UPPER(last_name) = ?', [strtoupper($this->last_name)])
                ->whereRaw('UPPER(first_name) = ?', [strtoupper($this->first_name)])
                ->first();

            $checkin = Checkin::whereRaw('UPPER(name) = ?', [strtoupper($this->first_name.' '.$this->last_name)])
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
                'employee_id' => $employee->id??'',
                'employee_id_number' => $employee->employee_id??'',
            ]);
            $this->employee = $employee;
            // $this->form->model($record)->saveRelationships();
            $this->dispatch('success-modal', 'Successfully Vote');


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
        return view('livewire.registration-form')
                ->layout('components.layouts.appV3');
    }
}
