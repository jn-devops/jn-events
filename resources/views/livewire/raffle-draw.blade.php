<div class="">
    <style>
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
    <div class="w-full flex flex-col justify-center z-10">
        <div class=" w-full flex justify-center z-10">
            <div class="logo_container mb-10">
                <img src="{{asset('img/joynostalglogo.png')}}" alt="JN Logo" class="my-5 w-44">
                <h1 class="main_text1">
                    <span>CHRISTMAS</span>
                    <span>CHRISTMAS</span>
                </h1>
                <h2 class="sub_text1">Raffle Draw</h2>
            </div>
        </div>
        <div class="z-10">
            <div class="container">
                <div class = "raffle-cont">
                    <div class="text-center">
                        <div class="flex flex-col justify-center items-center mb-10">
                            @if ($chosen_prize_model)
                                <img src="{{Illuminate\Support\Facades\Storage::url($chosen_prize_model->image)}}" alt="" class="h-[300px]">
                            @endif
                            <div>
                                <div class="mt-2 grid grid-cols-1">
                                    <select wire:model.live="chosen_prize" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                        <option>Choose Prize</option>
                                        @foreach ($prizes as $prize)
                                            <option value={{$prize->id}}>{{$prize->description}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button id="choose-winner" class="rgb-button mb-5 text-white w-64 cursor-pointer font-bold py-4 px-8 rounded-full shadow-lg transform duration-1000 hover:scale-105 transition-all ease-in-out">
                            <div id="grand_winner"> Reveal the Winner </div>
                        </button>
                    </div>
                </div>
            </div>
            
            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
            <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/jquery-ui.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@tsparticles/confetti@3.0.3/tsparticles.confetti.bundle.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.10.1/echo.min.js"></script>
            <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
            <script type="text/javascript">
                var snd = new Audio("sounds/DrumRoll.mp3");
                var winnersnd = new Audio("sounds/Winner.mp3")
                var clapping = new Audio("sounds/Clapping.mp3")
        
                const defaults = {
                    spread: 360,
                    ticks: 50,
                    gravity: 0,
                    decay: 0.94,
                    startVelocity: 30,
                    shapes: ["star"],
                    colors: ["FFE400", "FFBD00", "E89400", "FFCA6C", "FDFFB8"],
                };
        
                function shoot() {
                    confetti({
                        ...defaults,
                        particleCount: 40,
                        scalar: 1.2,
                        shapes: ["star"],
                    });
        
                    confetti({
                        ...defaults,
                        particleCount: 10,
                        scalar: 0.75,
                        shapes: ["circle"],
                    });
                }
        
        
                function rand(min,max){
                    return Math.floor(Math.random() * (max-min+1)) + min;
                }
        
                (function(document,undefined){
                    $("#confetti").css("display", "none");
                    var grand_winner = document.querySelector('#grand_winner'),
                        choose_btn = document.getElementById('choose-winner'),
                        last_winner;
        
                    choose_btn.addEventListener('click' , function(){
                        $('#winner span').removeClass("winner");
                        var participants = @this.employee_names;
                        get_winner(participants);
                        // $('#choose-winner').hide();
                        // choose_btn.classList.toggle('w-80')
                        // choose_btn.classList.toggle('h-24')
                        choose_btn.classList.add('zoom');
                        
                    } , false);
        
                    function get_winner(names){
                        var index = -1 , looper;
                        (function __cycle(){
                            var name = names[++index % names.length];
                            grand_winner.textContent = name;
                            looper = setTimeout(__cycle,70);
                            snd.play();
                        })();
                        setTimeout(function(){
                            clearTimeout(looper);
                            do{
                                name = names[rand(0, names.length - 1)];
                            }while(name == last_winner)
                            grand_winner.textContent = name;
                            $('#winner span').addClass("winner");
                            $('#choose-winner').show();
                            setTimeout(shoot, 0);
                            setTimeout(shoot, 100);
                            setTimeout(shoot, 200);
                            setTimeout(shoot, 200);
                            setTimeout(shoot, 200);
                            setTimeout(shoot, 200);
                            setTimeout(shoot, 200);
                            setTimeout(shoot, 200);
                            snd.pause();    
                            winnersnd.play();
                            clapping.play();
                        } , 300); // Adjust the timer for picking the winner
                        // } , rand(350 , 25000)); // Adjust the timer for picking the winner
        
        
                    }
                })(document);
        
                Pusher.logToConsole = true;
        
                var pusher = new Pusher('72090a5cd35fbf591321', {
                    cluster: 'ap1'
                });
        
                var channel = pusher.subscribe('draw-channel');
                channel.bind('draw-raffle', function(data) {
                    alert(JSON.stringify(data));
                });
        
                // window.Echo.channel('draw-channel')
                // .listen('draw-raffle', (e) => {
                //     alert("Broadcast Received: ");
                // });
            </script>
        
        </div>
    </div>
</div>
