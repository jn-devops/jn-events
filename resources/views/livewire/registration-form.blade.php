<div>
    <style>
        .modal {
            transition: opacity 0.25s ease;
        }
        .rgb-button {
            background: linear-gradient(45deg, #ff0000, #00ff00, #0000ff);
            background-size: 600% 600%;
        }
        .rgb-button.zoom {
            transform: scale(1.5);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    </style>
    <x-background />
    <div class="flex justify-center mt-32">
        <div class="logo_container">
            <img src="{{asset('img/christmas_party_logo.png')}}" alt="JN Logo" class="mt-5 w-52">
        </div>
    </div>
    <div class="flex justify-center text-white font-bold text-2xl mt-3 mb-9">
        REGISTRATION FORM
    </div>
    <div class="form_container gap-4">
        <div class="max-w-sm min-w-[200px] text-white ps-5">
            <input  wire:model.live="first_name" class="w-full bg-transparent placeholder:text-slate-400 text-white text-sm border border-b-slate-100 border-t-0 border-x-0 border-1 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow" placeholder="First Name" />
        </div>
        <div class="max-w-sm min-w-[200px] text-white pe-5">
            <input  wire:model.live="last_name" class="w-full bg-transparent placeholder:text-slate-400 text-white text-sm border border-b-slate-100 border-t-0 border-x-0 border-1 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow" placeholder="Last Name" />
        </div>
    </div>
    <div class="flex justify-center italic text-red-500" wire:ignore.self>
        {{$error}}
    </div>
    <div class="flex justify-center mt-6">
        <button id="choose-winner" wire:click="create" class="rgb-button mb-5 text-white w-44 cursor-pointer font-bold py-4 px-8 rounded-full shadow-lg transform duration-1000 hover:scale-105 transition-all ease-in-out">
            <div id="grand_winner"> Register </div>
        </button>
    </div>

    <!--Success Modal-->
    <div wire:ignore.self class="success-modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
        <div class="modal-overlay absolute w-full h-full bg-gradient-to-b from-[#0d1d31] via-[#0d1d31] to-transparent"></div>

        <div class="modal-container fixed w-full h-full z-50 overflow-y-auto ">

            <div id="success_modal" class="success-modal-close absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 text-white text-sm z-50">
                <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                    <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                </svg>
            </div>

            <!-- Add margin if you want to see grey behind the modal-->
            <div class="modal-content container mx-auto h-auto text-left p-4">
                <div class="flex items-center justify-center">
                  <div class="logo_container mt-7 mb-7 w-48">
                      <img class="w-full" src="{{asset('img/popcultureicon.png')}}" alt="">
                  </div>
                </div>
                <div class="text-3xl text-white font-bold text-center">
                  Successfully Registered
                  @if ($employee)
                  <div class="w-full px-12 mt-10">
                      <table class="text-base w-full">
                        <tr>
                            <td class="text-left">Table</td>
                            <td class="text-left">{{$employee->table_number}}</td>
                        </tr>
                        <tr>
                            <td class="text-left">Employee Name</td>
                            <td class="text-left">{{$employee->first_name}} {{$employee->last_name}}</td>
                        </tr>
                        <tr>
                            <td class="text-left">Company</td>
                            <td class="text-left">{{$employee->company}}</td>
                        </tr>
                        <tr>
                            <td class="text-left">Unit Group</td>
                            <td class="text-left">{{$employee->unit}}</td>
                        </tr>
                      </table>
                  </div>
                  @endif
                </div>

            </div>
        </div>
    </div>


    <script>
        function toggleSuccess(){
          const body = document.querySelector('body')
          const modal = document.querySelector('.success-modal')
          modal.classList.toggle('opacity-0')
          modal.classList.toggle('pointer-events-none')
          body.classList.toggle('modal-active')
        }

        window.addEventListener('success-modal', event => {
          toggleSuccess();
        });
    </script>
</div>
