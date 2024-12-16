<div>
    <style>
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
    </style>
    <x-background />
   <div class="flex flex-col justify-center items-center mt-10 text-white text-3xl font-bold mb-5">
        <img src="{{asset('img/christmas_party_logo.png')}}" class="w-40" alt="">
        <div>
            LEADERBOARD
        </div>
   </div>
   <div class="flex justify-center mt-5 text-white text-xl font-bold mb-5">
        {{$competition->name}}
   </div>
   <div class="flex justify-center">
    @foreach ($category_winners as $winner)
        @if ($winner['category'] == $current_category)
            <div class="relative rounded-xl shadow-lg shadow-yellow-600 w-[250px] h-[350px]" style="background-image: url('{{ Storage::url($current_participant->image) }}'); background-size: cover; background-position: center; ">
                <div class="absolute bottom-0 w-full bg-black bg-opacity-50 rounded-xl py-2 px-3">
                    <div class="flex flex-row">
                        <div class="basis-9/12 ps-2">
                            <p class=" text-white text-sm w-full font-bold">
                                {{ $current_participant->name ?? '' }}
                            </p>
                            <p class="text-[9px] text-neutral-300 italic">🎶 {{ $current_participant->song ?? '' }}</p>
                        </div>
                        <div class="basis-3/12">
                            <div class="rounded-full w-10 h-10 bg-black ml-auto text-white text-xs flex justify-center items-center">
                                {{$winner['total_score']}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
   </div>
   <div class="flex flex-row justify-center mt-8 " style="perspective:700px;">
        <div class="slider">
            @foreach ($categories as $category)
                @if ($category == $current_category)
                    <div class="card-container items-center cursor-pointer" >
                        <div wire:click='change_category("{{$category}}")' class="bg-[#4C43CD] rounded-full flex flex-row gap-3 justify-center text-center items-center text-white px-5 py-2 shadow-md shadow-[#4c43cd]">
                            <span class="text-sm font-semibold">{{$category}}</span>
                        </div>
                    </div>
                @else
                    <div class="card-container items-center cursor-pointer" >
                        <div wire:click='change_category("{{$category}}")' class="bg-neutral-500 rounded-full flex flex-row gap-3 justify-center text-center items-center text-white px-5 py-2 shadow-md shadow-neutral-500">
                            <span class="text-sm font-semibold">{{$category}}</span>
                        </div>
                    </div>
                @endif
            @endforeach
            {{-- <div class="card-container items-center cursor-pointer" >
                <div class="bg-neutral-500 rounded-full px-3 py-2 flex flex-row gap-3 text-left items-center text-white pe-3 w-52 shadow-md shadow-neutral-500">
                    <div class="w-9 h-9 bg-black text-white rounded-full flex justify-center items-center"> 1 </div>
                    <span class="text-sm font-semibold">Test</span>
                </div>
            </div> --}}
        </div>
    </div>
</div>
