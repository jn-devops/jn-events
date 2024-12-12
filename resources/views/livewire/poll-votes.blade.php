<div>
    <div class="max-w-lg mx-auto bg-white shadow-md rounded-lg p-6">
        <h1 class="text-xl font-semibold mb-4">{{ $poll->title }}</h1>
        <p class="text-sm text-gray-600 mb-4">{{ $poll->description }}</p>

        <div> {{-- Polling every 1 second for updates --}}
            @if (empty($votes))
                <div class="text-center text-gray-500">No votes yet</div>
            @else
                @php
                    $totalVotes = array_sum(array_column($votes, 'count'));
                @endphp

                @if ($totalVotes === 0)
                    <div class="text-center text-gray-500">No votes yet</div>
                @else
                    @foreach ($votes as $vote)
                        <div class="mb-4"
                             style="transition: transform 0.5s ease, opacity 0.5s ease;"
                             wire:key="vote-{{ $vote['option'] }}">
                            <div class="flex items-center space-x-4">
                                @if (!empty($vote['image']))
                                    <img src="{{ Storage::url($vote['image']) }}" alt="{{ $vote['option'] }}"
                                         class="w-12 h-12 rounded-md object-cover">
                                @endif
                                <div class="w-full">
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium">{{ $vote['option'] }}</span>
                                        <span class="text-sm text-gray-600">
                                            {{ round(($vote['count'] / $totalVotes) * 100, 1) }}%
                                        </span>
                                    </div>
                                    <div class="w-full bg-gray-200 h-4 rounded-lg overflow-hidden">
                                        <div class="bg-blue-600 h-4"
                                             style="width: {{ round(($vote['count'] / $totalVotes) * 100, 1) }}%; transition: width 0.5s ease;">
                                        </div>
                                    </div>
                                    <span class="text-sm text-gray-600">{{ $vote['count'] }} votes</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            @endif
        </div>
    </div>
</div>
