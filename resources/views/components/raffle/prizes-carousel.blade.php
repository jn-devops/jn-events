<div class="z-10">
    <div class="container">
        <div class = "raffle-cont">
            <div class="text-center">
                <div class="flex justify-center mb-10">
                    <img src="{{asset('img/car.png')}}" alt="" class="w-[600px]">
                </div>
                {{-- <select class="select select-bordered w-full max-w-xs text-black my-5">
                    <option disabled selected>Who shot first?</option>
                    <option>Han Solo</option>
                    <option>Greedo</option>
                </select> --}}
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
                var participants = ['Denver Novencido' , 'Mark Velasco' , 'Ben Dela Cruz','Juan Tamad', 'Kaye Abad' , 'Jeremy Mique'];
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
                } , rand(350 , 25000)); // Adjust the timer for picking the winner


            }
        })(document);

        // window.Echo.channel('draw')
        // .listen('DrawRaffle', (e) => {
        //     alert("Broadcast Received: ");
        // });
	</script>

</div>