<div>
    <style>

        .top-icon {
            width: 50px;
            height: 50px;
        }

        .slider {
            display: flex;
            overflow-x: auto;
            gap: 20px;
            padding: 20px;
            scroll-snap-type: x mandatory;
        }
        .card {
          position: relative;
          width: 300px;
          height: 400px;
          background-color: #fff;
          border-radius: 10px;
          box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
          perspective: 1000px;
          scroll-snap-align: center;
          flex-shrink: 0;
          overflow: hidden;
          border: 5px solid transparent;
          animation: borderGlow 3s infinite, preFlip 1s infinite;
        }
        .winner_card {
          position: relative;
          width: 400px;
          height: 500px;
          background-color: #fff;
          border-radius: 10px;
          box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
          perspective: 1000px;
          scroll-snap-align: center;
          flex-shrink: 0;
          overflow: hidden;
          border: 5px solid transparent;
          animation: borderGlow 3s infinite, preFlip 1s infinite;
        }

        @keyframes borderGlow {
        0% {
            border-color: #ff5733;
            box-shadow: 0 0 10px #ff5733;
        }
        33% {
            border-color: #33ff57;
            box-shadow: 0 0 10px #33ff57;
        }
        66% {
            border-color: #3357ff;
            box-shadow: 0 0 10px #3357ff;
        }
        100% {
            border-color: #ff5733;
            box-shadow: 0 0 10px #ff5733;
        }
    }

    @keyframes preFlip {
        0%, 100% {
            transform: rotateY(0deg);
        }
        50% {
            transform: rotateY(15deg);
        }
    }



    .card-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 20px;
        justify-items: center;
    }

    .circle-info {
        display: flex;
        align-items: center;
        margin-top: 10px;
    }

    .circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: #007bff;
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 18px;
        font-weight: bold;
        margin-right: 10px;
    }

    .name {
        font-size: 16px;
        color: white;
        font-weight: bold;
    }


        .card-inner {
          position: relative;
          width: 100%;
          height: 100%;
          transform-style: preserve-3d;
          transition: transform 0.6s;
        }
        .card-inner.flipped {
            transform: rotateY(180deg);
        }
        .card-front, .card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border-radius: 10px;
        }
        .card-front {
            background-color: #007bff;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
        }
        .card-back {
            background-color: #28a745;
            color: white;
            transform: rotateY(180deg);
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
        }
        .vote-button {
            margin-top: 10px;
            display: flex;
            justify-content: center;
        }
        .vote-button button {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .vote-button button:hover {
            background-color: #0056b3;
        }

        @media (max-width: 768px) {
            .slider {
                gap: 10px;
                padding: 10px;
            }
            .card {
                width: 250px;
                height: 350px;
            }
            .card-front, .card-back {
                font-size: 20px;
            }
            .vote-button button {
                padding: 8px 16px;
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .slider {
                gap: 5px;
                padding: 5px;
            }
            .card {
                width: 200px;
                height: 300px;
            }
            .card-front, .card-back {
                font-size: 16px;
            }
            .vote-button button {
                padding: 6px 12px;
                font-size: 12px;
            }

        }
    </style>
    <x-background />
    <div class="flex justify-center mt-14">
        <img class="" src="{{asset('img/popcultureicon.png')}}" alt="">
    </div>
    <div class="flex justify-center text-white text-3xl font-bold mt-3">
        LEADERBOARD
    </div>
    <div class="flex justify-center">
        <div class="slider">
            @php
                $cntr = 1;
            @endphp
            @foreach ($votes as $item)
                @if ($item['highest'] == true) {{-- Winner--}}
                    <div class="card-container items-center">
                        <div class="winner_card">
                            <div class="card-inner" onclick="toggleFlip(this)" id="winner">
                                <div class="card-front"><img class="object-cover w-full h-full" src="{{$item['image']}}" alt=""></div>
                                <div class="card-back"><img class="object-cover w-full h-full" src="{{$item['icon']}}" alt=""></div>
                            </div>
                        </div>
                        <div class="circle-info">
                            <div class="circle">{!! $item['cntr'] !!}</div>
                            <div class="name">
                                {{$item['option']}} <br> 
                                <span class="text-sm font-normal text-yellow-500 flex items-center justify-center gap-2">
                                    Votes: <span class="font-bold text-base">{{$item['count']}}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card-container">
                        <div class="card">
                            <div class="card-inner" onclick="toggleFlip(this)">
                                <div class="card-front"><img class="object-cover w-full h-full" src="{{$item['image']}}" alt=""></div>
                                <div class="card-back"><img class="object-cover w-full h-full" src="{{$item['icon']}}" alt=""></div>
                            </div>
                        </div>
                        <div class="circle-info">
                            <div class="circle">
                                {!! $item['cntr'] !!}
                            </div>
                            <div class="name">
                                {{$item['option']}} <br> 
                                <span class="text-sm font-normal text-yellow-500 flex items-center justify-center gap-2">
                                    Votes: <span class="font-bold text-base">{{$item['count']}}</span>
                                </span>
                            </div>
                        </div>
                    </div>

                @endif
                @php
                    $cntr++;
                @endphp
            @endforeach
            {{-- <div class="card-container">
                <div class="card">
                    <div class="card-inner" onclick="toggleFlip(this)">
                        <div class="card-front">Front 1</div>
                        <div class="card-back">Back 1</div>
                    </div>
                </div>
                <div class="circle-info">
                    <div class="circle">1</div>
                    <div class="name">John Doe</div>
                </div>
            </div>
            <div class="card-container">
                <div class="card">
                    <div class="card-inner" onclick="toggleFlip(this)">
                        <div class="card-front">Front 2</div>
                        <div class="card-back">Back 2</div>
                    </div>
                </div>
                <div class="circle-info">
                    <div class="circle">2</div>
                    <div class="name">Jane Smith</div>
                </div>
            </div>
            <div class="card-container">
                <div class="card">
                    <div class="card-inner" onclick="toggleFlip(this)">
                        <div class="card-front">Front 3</div>
                        <div class="card-back">Back 3</div>
                    </div>
                </div>
                <div class="circle-info">
                    <div class="circle">3</div>
                    <div class="name">Alex Brown</div>
                </div>
            </div> --}}
        </div>
    </div>

  <script>
        function toggleFlip(cardInner) {
            cardInner.classList.toggle('flipped');
        }
        setInterval(() => {
            document.getElementById('winner').click();
        }, 5000);

      document.addEventListener('DOMContentLoaded', function () {
        console.log('loaded');
        
        window.Echo.private('pop-culture-icon')
        .listen('.vote.pop.icon', (event) => {
            console.log(event);
            
            @this.call('recordVote', event.votes, event.poll_id)
        });
    });
  </script>
    
</div>
