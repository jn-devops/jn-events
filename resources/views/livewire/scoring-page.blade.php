<div class="container mx-auto">
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
    <div class="flex w-full mt-16 gap-4">
        <div class="basis-1/4">
            <h2 class="text-white font-bold text-2xl font-">{{$competition->name}}</h2>
        </div>
        <div class="basis-2/4 ps-5">
            <div class="flex flex-row gap-4 font-semibold">
                <div wire:click="category_filter('all')" class="cursor-pointer px-3 py-2 border border-[#EC0E52] hover:bg-[#EC0E52] text-white rounded-2xl font-semibold text-xs w-10  @if($currrentCategory == 'all') bg-[#EC0E52] @else bg-transparent @endif">
                    <h2 class="cursor-pointer ">All</h2>
                </div>
                @foreach ($category as $cat)
                    <div wire:click="category_filter('{{$cat}}')" class="cursor-pointer px-3 py-2 border border-[#EC0E52] text-white rounded-2xl font-semibold text-xs w-16 text-center @if($currrentCategory == $cat) bg-[#EC0E52] @else bg-transparent @endif">
                        <h2 class="cursor-pointer">{{$cat}}</h2>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="basis-1/4 text-right">
            {{-- <button class="bg-[#EC0E52] text-white px-7 py-3 rounded-2xl font-semibold text-sm">Submit</button> --}}
            <div class=" text-yellow-400 text-xl mt-2 font-semibold">
                Total: {{$totalScore}}%
            </div>
        </div>
    </div>
    <div class="flex flex-row mt-5 gap-6">
        <div class="basis-2/6">
            <div class="relative rounded-xl shadow-lg shadow-yellow-600" style="background-image: url('{{ Storage::url($currentParticipant->image) }}'); background-size: cover; background-position: center; height: 450px; width: 100%;">
                <div class="absolute bottom-0 w-full bg-black bg-opacity-50 rounded-xl py-2 px-3">
                    <div class="flex flex-row">
                        <div class="basis-9/12 ps-2">
                            <p class=" text-white text-sm w-full font-bold">
                                {{$currentParticipant->name}}
                            </p>
                            <p class="text-[9px] text-neutral-300 italic">🎶 {{$currentParticipant->song}}</p>
                        </div>
                        <div class="basis-3/12">
                            <div class="rounded-full w-10 h-10 bg-black ml-auto text-white flex justify-center items-center">
                                {{$currentParticipant->id}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="basis-4/6">
             <!-- Scoring Section -->
             <div class="p-5" style="
                flex: 1;
                border-radius: 1rem;
                ">
                <!-- Total Score -->
                {{-- <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h3 class="text-white" style="font-size: 1.25rem; font-weight: bold;">Total</h3>
                    <span style="font-size: 2rem; color: #e53e3e; font-weight: bold;">{{ $totalScore }}%</span>
                </div> --}}

                <!-- Score Sliders -->
                @foreach ([
                    ['label' => 'Voice Quality', 'range' => 50, 'key' => 'voice_quality'],
                    ['label' => 'Stage Presence', 'range' => 25, 'key' => 'stage_presence'],
                    ['label' => 'Interpretation', 'range' => 10, 'key' => 'interpretation'],
                    ['label' => 'Audience Impact', 'range' => 15, 'key' => 'audience_impact'],
                ] as $scoreItem)
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; color: gray; margin-bottom: 0.5rem;">{{ $scoreItem['label'] }} - 0-{{ $scoreItem['range'] }}%</label>
                        <input type="range" min="0" max="{{ $scoreItem['range'] }}" step="1" style="width: 100%;"
                                wire:model="score.{{ $scoreItem['key'] }}" wire:input="calculateTotal">
                        <div style="display: flex; justify-content: space-between; color: gray; font-size: 0.875rem; margin-top: 0.25rem;">
                            <span>0</span>
                            <span>{{ $score[$scoreItem['key']] }}%</span>
                            <span>{{ $scoreItem['range'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="flex flex-row justify-center mt-8">
        <div class="slider">
            @foreach ($participants as $participant)
                @if ($currentParticipant->id == $participant->id)
                    <div class="card-container items-center cursor-pointer" wire:click="changeParticipant({{ $participant->id }})">
                        <div class="bg-[#4C43CD] rounded-full px-3 py-2 flex flex-row gap-3 text-left items-center text-white pe-3 w-52 shadow-md shadow-[#4c43cd]">
                            <div class="w-9 h-9 bg-black text-white rounded-full flex justify-center items-center"> {{$participant->id}} </div>
                            <span class="text-sm font-semibold">{{$participant->name}}</span>
                        </div>
                    </div>
                @else
                    <div class="card-container items-center cursor-pointer" wire:click="changeParticipant({{ $participant->id }})">
                        <div class="bg-neutral-400 rounded-full px-3 py-2 flex flex-row gap-3 text-left items-center text-white pe-3 w-52 shadow-md shadow-neutral-400">
                            <div class="w-9 h-9 bg-black text-white rounded-full flex justify-center items-center"> {{$participant->id}} </div>
                            <span class="text-sm font-semibold">{{$participant->name}}</span>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>