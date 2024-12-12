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
    <div class="w-full flex flex-col justify-center mt-10 z-10">
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
        <x-raffle.prizes-carousel />
    </div>
</div>
