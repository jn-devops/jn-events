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
            <div class="logo_container mt-7 mb-7">
                <img src="{{asset('img/popcultureicon.png')}}" alt="">
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4 md:grid-cols-4 px-4 pb-5">
            <div class="grid gap-4">
              <div class="modal-open">
                <img
                  class="h-auto max-w-full rounded-lg object-cover object-center"
                  src="https://images.unsplash.com/photo-1432462770865-65b70566d673?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1950&amp;q=80"
                  alt="gallery-photo"
                />
              </div>
              <div class="modal-open">
                <img
                  class="h-auto max-w-full rounded-lg object-cover object-center "
                  src="https://images.unsplash.com/photo-1629367494173-c78a56567877?ixlib=rb-4.0.3&amp;ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;auto=format&amp;fit=crop&amp;w=927&amp;q=80"
                  alt="gallery-photo"
                />
              </div>
              <div class="modal-open">
                <img
                  class="h-auto max-w-full rounded-lg object-cover object-center"
                  src="https://images.unsplash.com/photo-1493246507139-91e8fad9978e?ixlib=rb-4.0.3&amp;ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;auto=format&amp;fit=crop&amp;w=2940&amp;q=80"
                  alt="gallery-photo"
                />
              </div>
            </div>
            <div class="grid gap-4">
              <div class="modal-open">
                <img
                  class="h-auto max-w-full rounded-lg object-cover object-center"
                  src="https://images.unsplash.com/photo-1552960562-daf630e9278b?ixlib=rb-4.0.3&amp;ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;auto=format&amp;fit=crop&amp;w=687&amp;q=80"
                  alt="gallery-photo"
                />
              </div>
              <div class="modal-open">
                <img
                  class="h-auto max-w-full rounded-lg object-cover object-center"
                  src="https://images.unsplash.com/photo-1540553016722-983e48a2cd10?ixlib=rb-1.2.1&amp;ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;auto=format&amp;fit=crop&amp;w=800&amp;q=80"
                  alt="gallery-photo"
                />
              </div>
              <div class="modal-open">
                <img
                  class="h-auto max-w-full rounded-lg object-cover object-center "
                  src="https://docs.material-tailwind.com/img/team-3.jpg"
                  alt="gallery-photo"
                />
              </div>
            </div>
            <div class="grid gap-4">
              <div class="modal-open">
                <img
                  class="h-auto max-w-full rounded-lg object-cover object-center"
                  src="https://images.unsplash.com/photo-1493246507139-91e8fad9978e?ixlib=rb-4.0.3&amp;ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;auto=format&amp;fit=crop&amp;w=2940&amp;q=80"
                  alt="gallery-photo"
                />
              </div>
              <div class="modal-open">
                <img
                  class="h-auto max-w-full rounded-lg object-cover object-center "
                  src="https://docs.material-tailwind.com/img/team-3.jpg"
                  alt="gallery-photo"
                />
              </div>
              <div class="modal-open">
                <img
                  class="h-auto max-w-full rounded-lg object-cover object-center"
                  src="https://images.unsplash.com/photo-1552960562-daf630e9278b?ixlib=rb-4.0.3&amp;ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;auto=format&amp;fit=crop&amp;w=687&amp;q=80"
                  alt="gallery-photo"
                />
              </div>
            </div>
            <div class="grid gap-4">
              <div class="modal-open">
                <img
                  class="h-auto max-w-full rounded-lg object-cover object-center"
                  src="https://images.unsplash.com/photo-1552960562-daf630e9278b?ixlib=rb-4.0.3&amp;ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;auto=format&amp;fit=crop&amp;w=687&amp;q=80"
                  alt="gallery-photo"
                />
              </div>
              <div class="modal-open">
                <img
                  class="h-auto max-w-full rounded-lg object-cover object-center"
                  src="https://images.unsplash.com/photo-1629367494173-c78a56567877?ixlib=rb-4.0.3&amp;ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;auto=format&amp;fit=crop&amp;w=927&amp;q=80"
                  alt="gallery-photo"
                />
              </div>
            </div>
        </div>
    </div>

    
    <!--Modal-->
    <div class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
        <div class="modal-overlay absolute w-full h-full bg-[#0d1d31]"></div>

        <div class="modal-container fixed w-full h-full z-50 overflow-y-auto ">
            
            <div class="modal-close absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 text-white text-sm z-50">
                <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                    <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                </svg>
            </div>

            <!-- Add margin if you want to see grey behind the modal-->
            <div class="modal-content container mx-auto h-auto text-left p-4">
                
                <div class="logo_container mt-7 mb-7">
                    <img src="{{asset('img/popcultureicon.png')}}" alt="">
                </div>
                <div class="text-white text-center my-5">Tap photo to reveal Inspiration</div>
                <div class="h-full w-full flex justify-center">
                    <button class="view-card w-[300px] h-[430px]">
                        <div class="view-card-front object-cover">
                            <img
                                class="object-cover rounded-lg"
                                src="https://images.unsplash.com/photo-1552960562-daf630e9278b?ixlib=rb-4.0.3&amp;ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;auto=format&amp;fit=crop&amp;w=687&amp;q=80"
                                alt="gallery-photo"
                            />
                        </div>
                        <div class="view-card-back object-cover">
                            <img
                            class="object-cover rounded-lg"
                            src="https://images.unsplash.com/photo-1552960562-daf630e9278b?ixlib=rb-4.0.3&amp;ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;auto=format&amp;fit=crop&amp;w=687&amp;q=80"
                            alt="gallery-photo"
                        />
                        </div>
                    </button>
                </div>
                <div class="flex flex-row justify-center items-center mt-4 gap-3">
                    <div class="relative mb-3 text-white" data-twe-input-wrapper-init>
                        <input
                          type="text"
                          class="peer block min-h-[auto] w-full rounded border-b-slate-100 border-t-0 border-x-0 border-1 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-black data-[twe-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none  [&:not([data-twe-input-placeholder-active])]:placeholder:opacity-0"
                          id="exampleFormControlInputText"
                          placeholder="Example label" />
                        <label
                          for="exampleFormControlInputText"
                          class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-200 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[twe-input-state-active]:-translate-y-[0.9rem] peer-data-[twe-input-state-active]:scale-[0.8] motion-reduce:transition-none "
                          >First Name
                        </label>
                    </div>
                    <div class="relative mb-3 text-white" data-twe-input-wrapper-init>
                        <input
                          type="text"
                          class="peer block min-h-[auto] w-full rounded border-b-slate-100 border-t-0 border-x-0 border-1 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-black data-[twe-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none  [&:not([data-twe-input-placeholder-active])]:placeholder:opacity-0"
                          id="exampleFormControlInputText"
                          placeholder="Example label" />
                        <label
                          for="exampleFormControlInputText"
                          class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-200 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[twe-input-state-active]:-translate-y-[0.9rem] peer-data-[twe-input-state-active]:scale-[0.8] motion-reduce:transition-none "
                          >Last Name
                        </label>
                    </div>
                </div>

                <div class="flex justify-center mt-6">
                    <button id="choose-winner" class="rgb-button mb-5 text-white w-64 cursor-pointer font-bold py-4 px-8 rounded-full shadow-lg transform duration-1000 hover:scale-105 transition-all ease-in-out">
                        <div id="grand_winner" wire:ignore> VOTE </div>
                    </button>
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

    </script>



</div>
