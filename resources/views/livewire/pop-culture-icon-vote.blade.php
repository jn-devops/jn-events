<div>
  @if ($poll->active)
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

        .view-card {
            cursor: pointer;
            /* height: 320px;
            width: 200px; */
            perspective: 1000px;
            position: relative;
            transform-style: preserve-3d;
            transition: rotate 500ms linear;
        }

        .view-card.show {
            rotate: y 180deg;
        }

        .view-card-front,
        .view-card-back {
            backface-visibility: hidden;
            /* border: 5px solid #000000; */
            display: grid;
            inset: 0;
            padding: 0.5em;
            place-content: center;
            position: absolute;
        }

        .view-card-front {
            /* background-color: pink; */
        }

        .view-card-back {
            /* background-color: aliceblue; */
            rotate: y 180deg;
        }
    </style>
    {{-- <x-background /> --}}
    <div class="w-full flex flex-col justify-center">
        <div class=" w-full flex justify-center">
            <div class="logo_container mt-7">
                <img src="{{asset('img/popcultureicon.png')}}" alt="">
            </div>
        </div>
        <h3 class="text-center mt-2 mb-7 text-2xl text-white font-bold">Choose your Winner 😎</h3>
        <div class="grid grid-cols-2 gap-4 md:grid-cols-4 px-4 pb-5">
          @php
              $cntr = 0;
          @endphp
            @foreach ($poll_options as $option)
              @php
                  $cntr++;
              @endphp
              <div class="grid gap-4">
                <div class="modal-open" wire:click="open_card({{$option}})">
                  @if ($cntr % 3 == 1)
                    <img
                      class="h-auto w-full rounded-lg object-cover object-center"
                      src="{{Illuminate\Support\Facades\Storage::url($option->image)}}"
                      alt="gallery-photo"
                    />
                  @endif
                </div>
                <div class="modal-open" wire:click="open_card({{$option}})">
                  @if ($cntr % 3 == 2)
                    <img
                      class="h-auto w-full rounded-lg object-cover object-center"
                      src="{{Illuminate\Support\Facades\Storage::url($option->image)}}"
                      alt="gallery-photo"
                    />
                  @endif
                </div>
                <div class="modal-open" wire:click="open_card({{$option}})">
                  @if ($cntr % 3 == 0)
                    <img
                      class="h-auto w-full rounded-lg object-cover object-center"
                      src="{{Illuminate\Support\Facades\Storage::url($option->image)}}"
                      alt="gallery-photo"
                    />
                  @endif
                </div>
              </div>
            @endforeach
        </div>
    </div>


    <!--Vote Modal-->
    <div wire:ignore.self class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
        <div class="modal-overlay absolute w-full h-full bg-[#0d1d31]"></div>

        <div class="modal-container fixed w-full h-full z-50 overflow-y-auto ">

            <div id="main_modal" class="modal-close absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 text-white text-sm z-50">
                <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                    <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                </svg>
            </div>

            <!-- Add margin if you want to see grey behind the modal-->
            <div class="modal-content container mx-auto h-auto text-left p-4">

                <div class=" mt-7 mb-7 w-16 mx-auto">
                    <img src="{{asset('img/popcultureicon.png')}}" alt="">
                </div>
                <div class="text-white text-center my-5">Tap photo to reveal Inspiration</div>
                <div class="h-full w-full flex justify-center">
                    <button class="view-card w-[300px] h-[430px]">
                        <div class="view-card-front object-cover">
                            <img
                                class="object-cover rounded-lg"
                                src="{{$image}}"
                                alt="gallery-photo"
                            />
                        </div>
                        <div class="view-card-back object-cover">
                            <img
                            class="object-cover rounded-lg"
                            src="{{$icon}}"
                            alt="gallery-photo"
                        />
                        </div>
                    </button>
                </div>
                <div class="flex justify-center text-white font-semibold">
                  {{$option_name}}
                </div>
                @if ($error)
                  <div class="w-full text-center text-red-500 italic mt-5">
                    {{$error}}
                  </div>
                @endif
                <div class="flex flex-row justify-center items-center mt-4 gap-3">
                    <div class="max-w-sm min-w-[200px] text-white ps-5">
                      <input  wire:model.live="first_name" class="w-full bg-transparent placeholder:text-slate-400 text-white text-sm border border-b-slate-100 border-t-0 border-x-0 border-1 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow" placeholder="First Name" />
                    </div>
                    <div class="max-w-sm min-w-[200px] text-white pe-5">
                      <input  wire:model.live="last_name" class="w-full bg-transparent placeholder:text-slate-400 text-white text-sm border border-b-slate-100 border-t-0 border-x-0 border-1 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow" placeholder="Last Name" />
                    </div>
                </div>

                <div class="flex justify-center mt-6">
                    <button id="choose-winner" wire:click="vote" class="rgb-button mb-5 text-white w-64 cursor-pointer font-bold py-4 px-8 rounded-full shadow-lg transform duration-1000 hover:scale-105 transition-all ease-in-out">
                        <div id="grand_winner" wire:ignore> VOTE </div>
                    </button>
                </div>

            </div>
        </div>
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
                  {!! $suucess_message !!}
                </div>

            </div>
        </div>
    </div>

    <script>
        // const Swal = require('sweetalert2');
        var openmodal = document.querySelectorAll('.modal-open')
        for (var i = 0; i < openmodal.length; i++) {
          openmodal[i].addEventListener('click', function(event){
            event.preventDefault()
            toggleModal()
          })
        }

        const overlay = document.querySelector('.modal-overlay')
        overlay.addEventListener('click', toggleModal)

        var closemodal = document.querySelectorAll('.modal-close')
        for (var i = 0; i < closemodal.length; i++) {
          closemodal[i].addEventListener('click', toggleModal)
        }

        document.onkeydown = function(evt) {
          evt = evt || window.event
          var isEscape = false
          if ("key" in evt) {
            isEscape = (evt.key === "Escape" || evt.key === "Esc")
          } else {
            isEscape = (evt.keyCode === 27)
          }
          if (isEscape && document.body.classList.contains('modal-active')) {
            toggleModal()
          }
        };


        function toggleModal () {
          const body = document.querySelector('body')
          const modal = document.querySelector('.modal')
          modal.classList.toggle('opacity-0')
          modal.classList.toggle('pointer-events-none')
          body.classList.toggle('modal-active')
        }


        const card = document.querySelector(".view-card");

        card.addEventListener("click", function () {
            card.classList.toggle("show");
        });

        var successclosemodal = document.querySelectorAll('.success-modal-close')
        for (var i = 0; i < successclosemodal.length; i++) {
          successclosemodal[i].addEventListener('click', toggleSuccess)
        }

        function toggleSuccess(){
          const body = document.querySelector('body')
          const modal = document.querySelector('.success-modal')
          modal.classList.toggle('opacity-0')
          modal.classList.toggle('pointer-events-none')
          body.classList.toggle('modal-active')
        }

        window.addEventListener('success-modal', event => {
          toggleModal();
          toggleSuccess();
        });

    </script>

  @else
    <div class="flex justify-center text-white pt-10">
        Voting is not yet started/already done
    </div>
  @endif

</div>
